<?php

require_once __DIR__.'/config.php';

if (!empty($_GET['slug'])) {
  $stmt = db()->prepare("SELECT * FROM posts WHERE slug = ? AND published = 1 LIMIT 1");
  $stmt->execute([$_GET['slug']]);
  $post = $stmt->fetch();
  jsonResponse($post ?: null);
} else {
  $rows = db()->query("SELECT * FROM posts WHERE published = 1 ORDER BY published_on DESC")->fetchAll();
  jsonResponse($rows);
}