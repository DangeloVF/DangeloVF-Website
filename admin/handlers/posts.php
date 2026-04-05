<?php
defined('ADMIN_PANEL') or die('Direct access not permitted.');

if ($_POST['action'] === 'save_post') {
  // Handle thumbnail — uploaded file takes priority over URL
  $thumbnail = $_POST['thumbnail_url'] ?? '';

  if (!empty($_FILES['thumbnail_file']['size'])) {
    $allowedMimes = ['image/jpeg' => 'jpg', 'image/png' => 'png'];
    $imageInfo    = getimagesize($_FILES['thumbnail_file']['tmp_name']);
    $mime         = $imageInfo ? $imageInfo['mime'] : '';
    if (!isset($allowedMimes[$mime])) {
      die('Invalid thumbnail type — only JPEG and PNG are accepted.');
    }
    $uploadDir = realpath(__DIR__ . '/../../img') . DIRECTORY_SEPARATOR . 'posts';
    if (!is_dir($uploadDir)) {
      mkdir($uploadDir, 0755, true);
    }
    $ext      = $allowedMimes[$mime];
    $filename = uniqid('post_') . '.' . $ext;
    move_uploaded_file($_FILES['thumbnail_file']['tmp_name'], $uploadDir . '/' . $filename);
    $thumbnail = '/img/posts/' . $filename;
  }

  // Convert "tag1, tag2" → ["tag1","tag2"] for DB storage
  $tags     = array_filter(array_map('trim', explode(',', $_POST['tags'] ?? '')));
  $tagsJson = json_encode(array_values($tags));

  // Convert datetime-local "YYYY-MM-DDTHH:MM" → "YYYY-MM-DD HH:MM:SS" for MySQL
  // If publishing but no date given, default to now
  if (!empty($_POST['published_on'])) {
    $publishedOn = str_replace('T', ' ', $_POST['published_on']) . ':00';
  } else {
    $publishedOn = $_POST['published'] == 1 ? date('Y-m-d H:i:s') : null;
  }

  if ($_POST['post_id'] === 'new') {
    $stmt = db()->prepare('INSERT INTO posts (title, slug, excerpt, body, tags, thumbnail, featured, year, order_index, published, published_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$_POST['title'], $_POST['slug'], $_POST['excerpt'], $_POST['body'], $tagsJson, $thumbnail, $_POST['featured'], $_POST['year'], $_POST['order_index'], $_POST['published'], $publishedOn]);
    $newId = db()->query("SELECT id FROM posts WHERE slug = " . db()->quote($_POST['slug']))->fetchColumn();
    if ($newId) mkdir(__DIR__ . '/../../img/content/posts/' . $newId, 0755, true);
  } else {
    $stmt = db()->prepare('UPDATE posts SET title=?, slug=?, excerpt=?, body=?, tags=?, thumbnail=?, featured=?, year=?, order_index=?, published=?, published_on=? WHERE id=?');
    $stmt->execute([$_POST['title'], $_POST['slug'], $_POST['excerpt'], $_POST['body'], $tagsJson, $thumbnail, $_POST['featured'], $_POST['year'], $_POST['order_index'], $_POST['published'], $publishedOn, $_POST['post_id']]);
  }
}

if ($_POST['action'] === 'delete_post') {
  $stmt = db()->prepare('DELETE FROM posts WHERE id = ?');
  $stmt->execute([$_POST['post_id']]);
}
