<?php

session_start([
  'cookie_httponly' => true,
  'cookie_secure'   => true,
  'cookie_samesite' => 'Strict',
]);

require_once __DIR__ . '/../api/load_env.php';
define('ADMIN_PASS_HASH', getenv('ADMIN_PASS_HASH'));
define('ADMIN_USERNAME',  getenv('ADMIN_USERNAME'));

function requireAuth() {
  if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit;
  }
}

function getRateLimitFile($ip) {
  $safe = md5(preg_replace('/[^a-f0-9:.]/', '', strtolower($ip)));
  return sys_get_temp_dir() . '/dvf_login_' . $safe . '.json';
}

function checkRateLimit($ip) {
  $file = getRateLimitFile($ip);
  if (!file_exists($file)) return true;
  $data = json_decode(file_get_contents($file), true);
  if (!$data || time() - $data['since'] > 3600) {
    @unlink($file);
    return true;
  }
  return ($data['attempts'] < 3);
}

function recordFailedAttempt($ip) {
  $file = getRateLimitFile($ip);
  $data = ['since' => time(), 'attempts' => 1];
  if (file_exists($file)) {
    $prev = json_decode(file_get_contents($file), true);
    if ($prev && time() - $prev['since'] <= 3600) {
      $data = ['since' => $prev['since'], 'attempts' => $prev['attempts'] + 1];
    }
  }
  file_put_contents($file, json_encode($data), LOCK_EX);
}

function clearRateLimit($ip) {
  $file = getRateLimitFile($ip);
  if (file_exists($file)) @unlink($file);
}

function gcRateLimits() {
  foreach (glob(sys_get_temp_dir() . '/dvf_login_*.json') as $file) {
    $data = json_decode(@file_get_contents($file), true);
    if (!$data || time() - $data['since'] > 3600) @unlink($file);
  }
}

function attemptLogin($username, $password) {
  $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
  if (random_int(1, 20) === 1) gcRateLimits();
  if (!checkRateLimit($ip)) return false;
  if (password_verify($password, ADMIN_PASS_HASH) && $username === ADMIN_USERNAME) {
    clearRateLimit($ip);
    $_SESSION['admin'] = true;
    return true;
  }
  recordFailedAttempt($ip);
  return false;
}

function logout() {
  $_SESSION = [];
  session_destroy();
  header('Location: index.php');
  exit;
}

function csrfToken() {
  if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
  }
  return $_SESSION['csrf_token'];
}

function verifyCsrf() {
  $token = $_POST['csrf_token'] ?? '';
  if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
    http_response_code(403);
    die('Invalid CSRF token.');
  }
}

