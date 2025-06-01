<?php
require "../db.php";
$stmt = $db->prepare("
  INSERT INTO reservations (name, start, end, room_id, status, paid)
  VALUES (?, ?, ?, ?, 'New', 0)
");
// $_
$stmt->execute([$_POST['name'], $_POST['start'], $_POST['end'], $_POST['room']]);
echo json_encode(['id' => $db->lastInsertId()]);