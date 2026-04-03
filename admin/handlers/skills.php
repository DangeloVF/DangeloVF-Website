<?php
defined('ADMIN_PANEL') or die('Direct access not permitted.');

if ($_POST['action'] === 'save_skill') {
  if ($_POST['skill_id'] === 'new') {
    $stmt = db()->prepare('INSERT INTO skills (name, category, proficiency, order_index) VALUES (?, ?, ?, ?)');
    $stmt->execute([$_POST['name'], $_POST['category'], $_POST['proficiency'], $_POST['order_index']]);
  } else {
    $stmt = db()->prepare('UPDATE skills SET name=?, category=?, proficiency=?, order_index=? WHERE id=?');
    $stmt->execute([$_POST['name'], $_POST['category'], $_POST['proficiency'], $_POST['order_index'], $_POST['skill_id']]);
  }
}

if ($_POST['action'] === 'delete_skill') {
  $stmt = db()->prepare('DELETE FROM skills WHERE id = ?');
  $stmt->execute([$_POST['skill_id']]);
}
