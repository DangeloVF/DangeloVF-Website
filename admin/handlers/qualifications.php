<?php
defined('ADMIN_PANEL') or die('Direct access not permitted.');

if ($_POST['action'] === 'save_qualification') {
  if ($_POST['qualification_id'] === 'new') {
    $stmt = db()->prepare('INSERT INTO qualifications (institution, qualification, grade, year, order_index) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$_POST['institution'], $_POST['qualification'], $_POST['grade'], $_POST['year'], $_POST['order_index']]);
  } else {
    $stmt = db()->prepare('UPDATE qualifications SET institution=?, qualification=?, grade=?, year=?, order_index=? WHERE id=?');
    $stmt->execute([$_POST['institution'], $_POST['qualification'], $_POST['grade'], $_POST['year'], $_POST['order_index'], $_POST['qualification_id']]);
  }
}

if ($_POST['action'] === 'delete_qualification') {
  $stmt = db()->prepare('DELETE FROM qualifications WHERE id = ?');
  $stmt->execute([$_POST['qualification_id']]);
}
