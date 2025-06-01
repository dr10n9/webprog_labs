<?php
require "../db.php";
// print $_p
$stmt = $db->prepare("
  UPDATE reservations
  SET start = ?, end = ?, paid = ?, status = ?
  WHERE id = ?
");
$stmt->execute([$_POST['start'], $_POST['end'], $_POST['paid'], $_POST['status'], $_POST['id']]);
echo "OK";