<?php
// Derive this template's folder name automatically so the whole template is
// forkable: copy the folder under any new name and it keeps working with no
// edits. __DIR__ is this file's dir (.../<template>/assets); its parent is the
// template root, and basename() of that is the name UserSpice expects.
$template_override = basename(dirname(__DIR__));