<?php
// 2026-11-10d — The AI Prompts plugin is now core (users/ai/, overrides in
// usersc/ai/). Copy the plugin's custom prompts into usersc/ai/ when there are
// any. Files already in usersc/ai/ are kept, so running it again changes nothing.
$countE = 0;

require_once $abs_us_root . $us_url_root . 'users/helpers/ai_prompts.php';
if (usAiPluginCustomPromptsDir() !== null) {
    $copied = usAiImportPluginPrompts();
    if ($copied > 0) {
        logger(1, 'System Updates', "2026-11-10d: copied $copied custom prompt(s) from the AI Prompts plugin into usersc/ai/");
    }
}

include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
