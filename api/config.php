<?php
require_once __DIR__ . '/load_env.php';

function db() {
  static $conn = null;
  try {
    $dsn = "mysql:host=" . getenv('DB_HOST') . ";dbname=" . getenv('DB_NAME') . ";charset=utf8mb4";
    if ($conn === null) {
      $conn = new PDO($dsn, getenv('DB_USER'), getenv('DB_PASS'));
    }
  } catch(PDOException $e) {
    error_log("DB connection failed: " . $e->getMessage());
    die("Service unavailable.");
  }

  return $conn;
}

function jsonResponse($data) {
  header("Content-Type: application/json");
  $allowedOrigin = (strpos($_SERVER['HTTP_HOST'] ?? '', 'localhost') !== false)
    ? '*'
    : 'https://dangelovf.com';
  header("Access-Control-Allow-Origin: $allowedOrigin");
  echo json_encode($data);
  exit;
}
