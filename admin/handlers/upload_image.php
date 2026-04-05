<?php
defined('ADMIN_PANEL') or die('Direct access not permitted.');

// Ensure base content directories exist
foreach (['projects', 'posts'] as $t) {
  $base = __DIR__ . '/../../img/content/' . $t;
  if (!is_dir($base)) mkdir($base, 0755, true);
}

function validateImageTarget($type, $id) {
  if (!in_array($type, ['projects', 'posts'], true)) return false;
  if (!preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $id)) return false;
  return true;
}

if ($_POST['action'] === 'upload_image') {
  header('Content-Type: application/json');

  $type = $_POST['type'] ?? '';
  $id   = $_POST['id']   ?? '';

  if (!validateImageTarget($type, $id)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid target']);
    exit;
  }

  $file = $_FILES['image'] ?? null;
  if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(['error' => 'Upload failed']);
    exit;
  }

  $imageInfo = getimagesize($file['tmp_name']);
  if (!$imageInfo || strpos($imageInfo['mime'], 'image/') !== 0) {
    http_response_code(400);
    echo json_encode(['error' => 'File is not an image']);
    exit;
  }

  $dir = realpath(__DIR__ . '/../../img') . DIRECTORY_SEPARATOR . 'content' . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR . $id;
  if (!is_dir($dir)) mkdir($dir, 0755, true);

  $ext      = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
  $filename = uniqid() . '.' . $ext;

  if (!move_uploaded_file($file['tmp_name'], $dir . '/' . $filename)) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to save file']);
    exit;
  }

  echo json_encode(['path' => '/img/content/' . $type . '/' . $id . '/' . $filename]);
  exit;
}

if ($_POST['action'] === 'delete_image_dir') {
  $type = $_POST['type'] ?? '';
  $id   = $_POST['id']   ?? '';

  if (validateImageTarget($type, $id)) {
    $contentBase = realpath(__DIR__ . '/../../img/content');
    $dir         = __DIR__ . '/../../img/content/' . $type . '/' . $id;
    $realDir     = realpath($dir);

    // Ensure the resolved path is under the content base — blocks path traversal
    if ($realDir && $contentBase && strpos($realDir, $contentBase) === 0 && $realDir !== $contentBase) {
      foreach (glob($realDir . '/*') as $f) unlink($f);
      rmdir($realDir);
    }
  }

  header('Location: ' . $_SERVER['PHP_SELF']);
  exit;
}
