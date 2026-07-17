<?php
header('Content-Type: application/json; charset=utf-8');
$dataFile = __DIR__ . '/messages.json';
if (!file_exists($dataFile)) file_put_contents($dataFile, json_encode([]));
$messages = json_decode(file_get_contents($dataFile), true);
// 按日期倒序（最新在前）
usort($messages, function($a, $b) {
    return strtotime($b['date']) - strtotime($a['date']);
});
echo json_encode(['success' => true, 'messages' => $messages]);