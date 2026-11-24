<?php
$usPluginHeaderInfo = [];
$usPluginHeaderXmlPath = $abs_us_root . $us_url_root . 'usersc/plugins/' . $plugin . '/info.xml';
if (is_file($usPluginHeaderXmlPath)) {
  $usPluginHeaderPrevErrors = libxml_use_internal_errors(true);
  $usPluginHeaderXml = simplexml_load_file($usPluginHeaderXmlPath, 'SimpleXMLElement', LIBXML_NONET);
  libxml_clear_errors();
  libxml_use_internal_errors($usPluginHeaderPrevErrors);
  if ($usPluginHeaderXml !== false) {
    $usPluginHeaderName = trim((string)$usPluginHeaderXml->name);
    $usPluginHeaderAuthor = trim((string)$usPluginHeaderXml->author);
    $usPluginHeaderVersion = trim((string)$usPluginHeaderXml->version);
    $usPluginHeaderRelease = trim((string)$usPluginHeaderXml->release);
    $usPluginHeaderByline = [];
    if ($usPluginHeaderName !== '') {
      $usPluginHeaderByline[] = '<strong class="text-body">' . safeReturn($usPluginHeaderName, true) . '</strong>';
    }
    if ($usPluginHeaderAuthor !== '') {
      $usPluginHeaderByline[] = 'by ' . safeReturn($usPluginHeaderAuthor, true);
    }
    if ($usPluginHeaderByline) {
      $usPluginHeaderInfo[] = implode(' ', $usPluginHeaderByline);
    }
    if ($usPluginHeaderVersion !== '') {
      $usPluginHeaderInfo[] = '<strong>Version:</strong> ' . safeReturn($usPluginHeaderVersion, true);
    }
    if ($usPluginHeaderRelease !== '') {
      $usPluginHeaderInfo[] = '<strong>Released:</strong> ' . safeReturn($usPluginHeaderRelease, true);
    }
  }
}
if ($usPluginHeaderInfo) { ?>
  <div class="small text-body-secondary text-end"><?= implode(' &middot; ', $usPluginHeaderInfo) ?></div>
<?php }
unset($usPluginHeaderInfo, $usPluginHeaderXmlPath, $usPluginHeaderPrevErrors, $usPluginHeaderXml, $usPluginHeaderName, $usPluginHeaderAuthor, $usPluginHeaderVersion, $usPluginHeaderRelease, $usPluginHeaderByline);
