<?php
header('Content-Type: application/json; charset=utf-8');
$dataFile = __DIR__ . '/messages.json';
$maxMessages = 30;  // 最多保留30条，超过则删除最早的（最旧）

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => '仅支持POST请求']);
    exit;
}
$name = trim($_POST['name'] ?? '');
$content = trim($_POST['content'] ?? '');
if (empty($name) || empty($content)) {
    echo json_encode(['success' => false, 'error' => '昵称和内容不能为空']);
    exit;
}
// 简单过滤
$name = htmlspecialchars(substr($name, 0, 20));
$content = htmlspecialchars(substr($content, 0, 200));
$newMessage = [
    'id' => uniqid(),
    'name' => $name,
    'content' => $content,
    'date' => date('Y-m-d H:i:s')
];

$messages = json_decode(file_get_contents($dataFile), true) ?: [];
array_unshift($messages, $newMessage); // 新留言放在开头
// 超过限制则删除末尾（最旧）
if (count($messages) > $maxMessages) {
    $messages = array_slice($messages, 0, $maxMessages);
}
file_put_contents($dataFile, json_encode($messages, JSON_UNESCAPED_UNICODE));
echo json_encode(['success' => true]);