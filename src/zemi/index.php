<?php
include 'db.php';
$date = $_GET['date'] ?? date('Y-m-d');
$user_id = 1;

$stmt = $pdo->prepare("SELECT * FROM schedules WHERE user_id = ?");
$stmt->execute([$user_id]);
$schedules = $stmt->fetchAll(PDO::FETCH_UNIQUE | PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT * FROM memos WHERE user_id = ?");
$stmt->execute([$user_id]);
$memo = $stmt->fetchColumn() ?? '';

$important = [''];
$todos = [''];

include 'includes/header.php';
include 'includes/schedule_form.php';
include 'includes/important_form.php';
include 'includes/todo_form.php';
include 'includes/memo_form.php';
include 'includes/footer.php';
