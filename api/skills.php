<?php

require_once __DIR__.'/config.php';

$rows = db()->query("SELECT * FROM skills ORDER BY order_index ASC")->fetchAll();

jsonResponse($rows);