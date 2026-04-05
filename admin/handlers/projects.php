<?php
defined('ADMIN_PANEL') or die('Direct access not permitted.');

if ($_POST['action'] === 'save_project') {
  // Handle thumbnail — uploaded file takes priority over URL
  $thumbnail = $_POST['thumbnail_url'] ?? '';

  if (!empty($_FILES['thumbnail_file']['size'])) {
    $allowedMimes = ['image/jpeg' => 'jpg', 'image/png' => 'png'];
    $imageInfo    = getimagesize($_FILES['thumbnail_file']['tmp_name']);
    $mime         = $imageInfo ? $imageInfo['mime'] : '';
    if (!isset($allowedMimes[$mime])) {
      die('Invalid thumbnail type — only JPEG and PNG are accepted.');
    }
    $uploadDir = realpath(__DIR__ . '/../../img') . DIRECTORY_SEPARATOR . 'projects';
    if (!is_dir($uploadDir)) {
      mkdir($uploadDir, 0755, true);
    }
    $ext      = $allowedMimes[$mime];
    $filename = uniqid('project_') . '.' . $ext;
    move_uploaded_file($_FILES['thumbnail_file']['tmp_name'], $uploadDir . DIRECTORY_SEPARATOR . $filename);
    $thumbnail = '/img/projects/' . $filename;
    $thumbnail = '/img/projects/' . $filename;
  }

  // Convert "tag1, tag2" → ["tag1","tag2"] for DB storage
  $tags     = array_filter(array_map('trim', explode(',', $_POST['tags'] ?? '')));
  $tagsJson = json_encode(array_values($tags));

  if ($_POST['project_id'] === 'new') {
    $stmt = db()->prepare('INSERT INTO projects (title, slug, description, tags, github_url, live_url, thumbnail, featured, year, order_index) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$_POST['title'], $_POST['slug'], $_POST['description'], $tagsJson, $_POST['github_url'], $_POST['live_url'], $thumbnail, $_POST['featured'], $_POST['year'], $_POST['order_index']]);
    $newId = db()->query("SELECT id FROM projects WHERE slug = " . db()->quote($_POST['slug']))->fetchColumn();
    if ($newId) mkdir(__DIR__ . '/../../img/content/projects/' . $newId, 0755, true);
  } else {
    $stmt = db()->prepare('UPDATE projects SET title=?, slug=?, description=?, tags=?, github_url=?, live_url=?, thumbnail=?, featured=?, year=?, order_index=? WHERE id=?');
    $stmt->execute([$_POST['title'], $_POST['slug'], $_POST['description'], $tagsJson, $_POST['github_url'], $_POST['live_url'], $thumbnail, $_POST['featured'], $_POST['year'], $_POST['order_index'], $_POST['project_id']]);
  }
}

if ($_POST['action'] === 'delete_project') {
  $stmt = db()->prepare('DELETE FROM projects WHERE id = ?');
  $stmt->execute([$_POST['project_id']]);
}
