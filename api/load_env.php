<?php
// Loads .env from the project root into environment variables.
// Only runs if the file exists — on production, real env vars are
// set via the IONOS control panel so this file won't be present.
$_envFile = __DIR__ . '/../.env';
if (file_exists($_envFile)) {
  foreach (file($_envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $_line) {
    if ($_line[0] === '#' || strpos($_line, '=') === false) continue;
    [$_key, $_val] = explode('=', $_line, 2);
    putenv(trim($_key) . '=' . trim($_val));
  }
}
unset($_envFile, $_line, $_key, $_val);
