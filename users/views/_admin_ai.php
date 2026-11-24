<?php
if (count(get_included_files()) == 1) die(); // Direct Access Not Permitted
require_once $abs_us_root . $us_url_root . 'users/helpers/ai_prompts.php';

$self = $us_url_root . 'users/admin.php?view=ai';
$isMaster = in_array($user->data()->id, $master_account);
$rootFiles = ['AGENTS.md', 'CLAUDE.md'];

if (!empty($_POST)) {
  if (!Token::check($_POST['csrf'] ?? '')) {
    usError("Token failed");
    Redirect::to($self);
  }
  if (!$isMaster) {
    usError("Only master accounts can change the project's AI assistant files.");
    Redirect::to($self);
  }

  if (isset($_POST['write_pointer'])) {
    $file = $_POST['write_pointer'];
    if (!in_array($file, $rootFiles, true)) {
      usError("Unknown file.");
    } elseif (!usAiRootFileStatus($file)['writable']) {
      usError("$file is not writable by the web server.");
    } elseif (usAiWriteManagedBlock($file, usAiPointerBlock($file))) {
      usSuccess("$file now points AI assistants at users/ai/. Anything outside the UserSpice markers was left as it was.");
      logger($user->data()->id, 'AI Assistants', "Wrote the UserSpice block in $file");
    } else {
      usError("Could not write $file.");
    }
    unset($_SESSION['us_ai_web_exposure'], $_SESSION['us_ai_web_exposure_root']);
    Redirect::to($self);
  }

  if (isset($_POST['protect_htaccess'])) {
    $status = usAiRootFileStatus('.htaccess');
    if (!$status['writable']) {
      usError(".htaccess is not writable by the web server. Add the rules below by hand.");
    } elseif (usAiWriteManagedBlock('.htaccess', usAiHtaccessBlock(), '# userspice:ai begin', '# userspice:ai end')) {
      usSuccess("Added rules to .htaccess that block web access to AGENTS.md and CLAUDE.md.");
      logger($user->data()->id, 'AI Assistants', 'Added AGENTS.md/CLAUDE.md deny rules to .htaccess');
    } else {
      usError("Could not write .htaccess.");
    }
    unset($_SESSION['us_ai_web_exposure'], $_SESSION['us_ai_web_exposure_root']);
    Redirect::to($self);
  }

  if (isset($_POST['recheck'])) {
    unset($_SESSION['us_ai_web_exposure'], $_SESSION['us_ai_web_exposure_root']);
    Redirect::to($self);
  }

  if (isset($_POST['customize_prompt'])) {
    $name = $_POST['customize_prompt'];
    $source = usAiCoreDir() . $name . '.md.php';
    $target = usAiOverrideDir() . $name . '.md.php';
    if (!usAiValidName($name) || !is_file($source)) {
      usError("Unknown prompt.");
    } elseif (is_file($target)) {
      usError("usersc/ai/$name.md.php already exists.");
    } elseif ((!is_dir(usAiOverrideDir()) && !@mkdir(usAiOverrideDir(), 0755, true)) || !@copy($source, $target)) {
      usError("Could not create usersc/ai/$name.md.php. Check that usersc/ is writable.");
    } else {
      usAiProtectDir(usAiOverrideDir());
      usSuccess("Created usersc/ai/$name.md.php. Edit it there; it now replaces the core prompt, and core updates no longer change it.");
      logger($user->data()->id, 'AI Assistants', "Created override usersc/ai/$name.md.php");
    }
    Redirect::to($self);
  }

  if (isset($_POST['import_plugin_prompts'])) {
    $count = usAiImportPluginPrompts();
    usSuccess("Copied $count prompt(s) from the AI Prompts plugin into usersc/ai/.");
    logger($user->data()->id, 'AI Assistants', "Imported $count plugin prompt(s) into usersc/ai/");
    Redirect::to($self);
  }
}

$prompts = usAiPromptList();
$fileStatus = [];
foreach ($rootFiles as $f) {
  $fileStatus[$f] = usAiRootFileStatus($f);
}
$exposure = usAiWebExposure();
$exposed = array_keys(array_filter($exposure, function ($v) { return $v === 'exposed'; }));
$htaccess = usAiRootFileStatus('.htaccess');
$htaccessHasBlock = is_file($abs_us_root . $us_url_root . '.htaccess') && strpos((string)file_get_contents($abs_us_root . $us_url_root . '.htaccess'), '# userspice:ai begin') !== false;
$pluginPromptsDir = usAiPluginCustomPromptsDir();

$badge = function ($text, $class) {
  return '<span class="badge bg-' . $class . '">' . safeReturn($text) . '</span>';
};
?>

<style nonce="<?= htmlspecialchars($userspice_nonce ?? '') ?>">
  .us-ai-prompt { white-space: pre-wrap; max-height: 24rem; overflow: auto; }
</style>

<div class="row">
  <div class="col-12">
    <div class="d-flex align-items-center mb-3">
      <h2 class="mb-0"><i class="fas fa-robot me-2" aria-hidden="true"></i>AI Assistants</h2>
    </div>
    <p>AI coding assistants (Claude Code, Codex, Cursor and others) read <code>AGENTS.md</code> or <code>CLAUDE.md</code> in the project root at the start of every session. UserSpice adds a short, marked block to those files that points them at the prompts in <code>users/ai/</code>, which teach UserSpice's conventions and are updated with every UserSpice release. Your own instructions in those files are left alone.</p>
  </div>
</div>

<?php if (!empty($exposed)): ?>
<div class="alert alert-danger" role="alert">
  <strong>These files can be downloaded from your website:</strong> <?= safeReturn(implode(', ', $exposed)) ?>.
  Developers often put paths, hostnames or credentials in them. Block them with the rules below, or move anything sensitive out of them.
</div>
<?php endif; ?>

<div class="row">
  <div class="col-lg-7">
    <div class="card mb-4">
      <div class="card-header"><h3 class="h5 mb-0">Project instruction files</h3></div>
      <div class="card-body">
        <table class="table table-sm align-middle mb-2">
          <thead><tr><th scope="col">File</th><th scope="col">UserSpice block</th><th scope="col">On the web</th><th scope="col"><span class="visually-hidden">Action</span></th></tr></thead>
          <tbody>
            <?php foreach ($rootFiles as $f):
              $st = $fileStatus[$f];
              $web = $exposure[$f] ?? 'unknown';
            ?>
              <tr>
                <td><code><?= safeReturn($f) ?></code></td>
                <td>
                  <?php if (!$st['exists']) {
                    echo $badge('File missing', 'secondary');
                  } elseif ($st['current']) {
                    echo $badge('Current', 'success');
                  } elseif ($st['has_block']) {
                    echo $badge('Out of date', 'warning');
                  } else {
                    echo $badge('Not added', 'secondary');
                  } ?>
                </td>
                <td>
                  <?php
                  $webLabels = ['blocked' => ['Blocked', 'success'], 'missing' => ['Not served', 'success'], 'exposed' => ['Downloadable', 'danger'], 'unknown' => ['Not checked', 'secondary']];
                  echo $badge($webLabels[$web][0], $webLabels[$web][1]);
                  ?>
                </td>
                <td class="text-end">
                  <?php if ($isMaster && !$st['current']): ?>
                    <form method="post" class="d-inline">
                      <input type="hidden" name="csrf" value="<?= Token::generate() ?>">
                      <button type="submit" name="write_pointer" value="<?= safeReturn($f) ?>" class="btn btn-sm btn-primary" <?= $st['writable'] ? '' : 'disabled' ?>>
                        <?= !$st['exists'] ? 'Create' : ($st['has_block'] ? 'Update block' : 'Add block') ?>
                      </button>
                    </form>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <p class="small text-body-secondary mb-0">The block sits between <code>&lt;!-- userspice:begin --&gt;</code> and <code>&lt;!-- userspice:end --&gt;</code> markers. Updating it only changes the text between them. <code>CLAUDE.md</code> imports <code>AGENTS.md</code>, so both assistants get the same instructions.<?php if (!$isMaster): ?> Only master accounts can change these files.<?php endif; ?></p>
      </div>
    </div>

    <div class="card mb-4">
      <div class="card-header"><h3 class="h5 mb-0">Prompt library</h3></div>
      <div class="card-body">
        <p class="small">Core prompts are in <code>users/ai/</code> and are replaced by UserSpice updates. To change one, customize it: a copy goes to <code>usersc/ai/</code>, which wins from then on and is never touched by updates. Your own prompts can go in <code>usersc/ai/</code> too.</p>
        <?php if (empty($prompts)): ?>
          <p class="mb-0">No prompts found in <code>users/ai/</code>.</p>
        <?php else: ?>
          <table class="table table-sm align-middle mb-0">
            <thead><tr><th scope="col">Prompt</th><th scope="col">Source</th><th scope="col" class="text-end">Size</th><th scope="col"><span class="visually-hidden">Actions</span></th></tr></thead>
            <tbody>
              <?php foreach ($prompts as $p): ?>
                <tr>
                  <td>
                    <details>
                      <summary><?= safeReturn($p['title']) ?> <small class="text-body-secondary">(<?= safeReturn($p['name']) ?>)</small></summary>
                      <pre class="small mt-2 mb-0 us-ai-prompt" tabindex="0" aria-label="<?= safeReturn($p['title']) ?> prompt text"><?= safeReturn(usAiPromptMarkdown($p['file'])) ?></pre>
                    </details>
                  </td>
                  <td>
                    <?php if ($p['source'] === 'override') {
                      echo $badge('Customized in usersc/ai', 'info');
                    } elseif ($p['source'] === 'site') {
                      echo $badge('Site prompt', 'info');
                    } else {
                      echo $badge('Core', 'secondary');
                    } ?>
                  </td>
                  <td class="text-end small"><?= number_format($p['bytes'] / 1024, 1) ?> KB</td>
                  <td class="text-end">
                    <?php if ($isMaster && $p['source'] === 'core'): ?>
                      <form method="post" class="d-inline" data-us-confirm="Copy this prompt to usersc/ai/ so you can edit it? From then on your copy is used and UserSpice updates no longer change it.">
                        <input type="hidden" name="csrf" value="<?= Token::generate() ?>">
                        <button type="submit" name="customize_prompt" value="<?= safeReturn($p['name']) ?>" class="btn btn-sm btn-outline-secondary">Customize</button>
                      </form>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <div class="col-lg-5">
    <div class="card mb-4">
      <div class="card-header"><h3 class="h5 mb-0">Keep these files off the web</h3></div>
      <div class="card-body small">
        <p>The prompts in <code>users/ai/</code> never serve their content. The root <code>AGENTS.md</code> and <code>CLAUDE.md</code> are plain files, so most servers hand them to anyone who asks.</p>
        <?php if ($htaccessHasBlock): ?>
          <p class="mb-2"><?= $badge('.htaccess rules added', 'success') ?></p>
        <?php elseif ($isMaster): ?>
          <form method="post" class="mb-2" data-us-confirm="Add rules to the .htaccess file in your site root that block web access to AGENTS.md and CLAUDE.md?">
            <input type="hidden" name="csrf" value="<?= Token::generate() ?>">
            <button type="submit" name="protect_htaccess" class="btn btn-sm btn-primary" <?= $htaccess['writable'] ? '' : 'disabled' ?>>Add rules to .htaccess (Apache)</button>
          </form>
        <?php endif; ?>
        <details class="mb-2">
          <summary>Apache rules</summary>
          <pre class="mt-2 mb-0"><?= safeReturn(usAiHtaccessBlock()) ?></pre>
        </details>
        <details class="mb-3">
          <summary>nginx</summary>
          <pre class="mt-2 mb-0">location ~ ^<?= safeReturn(rtrim($us_url_root, '/')) ?>/(AGENTS|CLAUDE)\.md$ { deny all; }</pre>
        </details>
        <form method="post">
          <input type="hidden" name="csrf" value="<?= Token::generate() ?>">
          <button type="submit" name="recheck" class="btn btn-sm btn-outline-secondary">Check again</button>
        </form>
        <p class="text-body-secondary mt-2 mb-0">The check requests these files from this site over HTTP, the way a visitor would.</p>
      </div>
    </div>

    <?php if ($pluginPromptsDir !== null): ?>
      <div class="card mb-4">
        <div class="card-header"><h3 class="h5 mb-0">AI Prompts plugin</h3></div>
        <div class="card-body small">
          <p>The AI Prompts plugin is now part of UserSpice. Its custom prompts can be copied into <code>usersc/ai/</code>; files already there are kept.</p>
          <?php if ($isMaster): ?>
            <form method="post">
              <input type="hidden" name="csrf" value="<?= Token::generate() ?>">
              <button type="submit" name="import_plugin_prompts" class="btn btn-sm btn-primary">Copy custom prompts</button>
            </form>
          <?php endif; ?>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>
