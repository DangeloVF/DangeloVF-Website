<?php

require_once __DIR__.'/config.php';

$rows = db()->query("SELECT * FROM qualifications ORDER BY order_index ASC")->fetchAll();

jsonResponse($rows);