<?php
include 'db.php';
$user_id = 1;
$date = $_POST['date'] ?? date('Y-m-d');

// --- スケジュール保存 ---
$pdo->prepare("DELETE FROM schedules WHERE user_id = ? AND schedule_date = ?")->execute([$user_id, $date]);

foreach ($_POST['task'] as $time => $text) {
    if (trim($text) === '') continue;
    $done = isset($_POST['done'][$time]) ? 1 : 0;
    $stmt = $pdo->prepare("INSERT INTO schedules (user_id, schedule_date, time_slot, task, is_done) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $date, $time, $text, $done]);
}

// --- メモ保存 ---
$pdo->prepare("DELETE FROM memos WHERE user_id = ? AND schedule_date = ?")->execute([$user_id, $date]);
if (!empty($_POST['memo'])) {
    $stmt = $pdo->prepare("INSERT INTO memos (user_id, schedule_date, memo) VALUES (?, ?, ?)");
    $stmt->execute([$user_id, $date, $_POST['memo']]);
}

// --- 大事なことリスト 保存 ---
$pdo->prepare("DELETE FROM important_tasks WHERE user_id = ? AND schedule_date = ?")->execute([$user_id, $date]);

if (isset($_POST['important'])) {
    foreach ($_POST['important'] as $i => $text) {
        if (trim($text) === '') continue;
        $done = isset($_POST['important_done'][$i]) ? 1 : 0;
        $stmt = $pdo->prepare("INSERT INTO important_tasks (user_id, schedule_date, item_index, content, is_done) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $date, $i, $text, $done]);
    }
}

// --- やることリスト 保存 ---
$pdo->prepare("DELETE FROM todo_tasks WHERE user_id = ? AND schedule_date = ?")->execute([$user_id, $date]);

if (isset($_POST['todos'])) {
    foreach ($_POST['todos'] as $i => $text) {
        if (trim($text) === '') continue;
        $done = isset($_POST['todos_done'][$i]) ? 1 : 0;
        $stmt = $pdo->prepare("INSERT INTO todo_tasks (user_id, schedule_date, item_index, content, is_done) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $date, $i, $text, $done]);
    }
}

header("Location: index.php?date=$date");
exit;