<?php
// 2026-05-17c — Performance indexes for tag-matching, plugin-hook dispatch,
// and API rate-limiting.
//
// Adds covering indexes that were missing from three hot-path queries:
//   - plg_tags_matches : lookups by (tag_id, user_id) and (tag_name, user_id)
//   - us_plugin_hooks  : the WHERE page=? AND disabled=? hook-dispatch query
//   - plg_api_fails    : IP-based rate-limit lookups (API plugin table)
//
// DB::addIndex is idempotent: it no-ops if the index already exists. Each
// table is guarded with tableExists() so optional plugin tables that are not
// installed on a given site simply skip without erroring.
$countE = 0;

// plg_tags_matches: covers lookups by tag_id+user_id and tag_name+user_id.
if ($db->tableExists('plg_tags_matches')) {
  if (!$db->addIndex('plg_tags_matches', 'ix_tag_user', 'tag_id, user_id')) {
    $countE++;
    $errors[] = 'plg_tags_matches ix_tag_user: ' . $db->errorString();
  }
  if (!$db->addIndex('plg_tags_matches', 'ix_tagname_user', 'tag_name, user_id')) {
    $countE++;
    $errors[] = 'plg_tags_matches ix_tagname_user: ' . $db->errorString();
  }
}

// us_plugin_hooks: covers the WHERE page=? AND disabled=? hook-dispatch query.
if ($db->tableExists('us_plugin_hooks')) {
  if (!$db->addIndex('us_plugin_hooks', 'ix_page_disabled', 'page, disabled')) {
    $countE++;
    $errors[] = 'us_plugin_hooks ix_page_disabled: ' . $db->errorString();
  }
}

// plg_api_fails: covers IP-based rate-limit lookups.
if ($db->tableExists('plg_api_fails')) {
  if (!$db->addIndex('plg_api_fails', 'ix_ip', 'ip')) {
    $countE++;
    $errors[] = 'plg_api_fails ix_ip: ' . $db->errorString();
  }
}

include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
