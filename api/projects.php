<?php

require_once __DIR__.'/config.php';

if (!empty($_GET['slug'])) {
  $stmt = db()->prepare("SELECT * FROM projects WHERE slug = ? LIMIT 1");
  $stmt->execute([$_GET['slug']]);
  $project = $stmt->fetch();
  jsonResponse($project ?: null);
} else {
  $rows = db()->query("SELECT * FROM projects ORDER BY order_index ASC")->fetchAll();
  jsonResponse($rows);
}