<?php
defined('ADMIN_PANEL') or die('Direct access not permitted.');
if ($_POST['action'] === 'save_bio') {
  $makeActive = isset($_POST['active']) && $_POST['active'] == 1;

  // Only deactivate all versions if this save is marking one as active
  if ($makeActive) {
    db()->query('UPDATE bio SET active = 0');
  }

  if ($_POST['bio_version'] === 'new') {
    $stmt = db()->prepare('INSERT INTO bio (name, headline, about, available, active) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$_POST['name'], $_POST['headline'], $_POST['about'], $_POST['available'], $makeActive ? 1 : 0]);
  } else {
    $stmt = db()->prepare('UPDATE bio SET name=?, headline=?, about=?, available=?, active=? WHERE id=?');
    $stmt->execute([$_POST['name'], $_POST['headline'], $_POST['about'], $_POST['available'], $makeActive ? 1 : 0, $_POST['bio_version']]);
  }
}
