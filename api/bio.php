<?php

require_once __DIR__.'/config.php';

$row = db()->query("SELECT * FROM bio WHERE active = 1 LIMIT 1")->fetch();

jsonResponse($row ?: []);