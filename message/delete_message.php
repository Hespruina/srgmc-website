<?php
header('Content-Type: application/json; charset=utf-8');
$dataFile = __DIR__ . '/messages.json';
$account = $_POST['account'] ?? '';
$password = $_POST['password'] ?? '';
// 预设审查账号和密码（建议修改为复杂值）
$validAccount = 'admin';
$validPassword = 'srgchanloveyou';

if ($account !== $validAccount || $password !== $validPassword) {
    echo json_encode(['success' => false, 'error' => '认证失败']);
    exit;
}
$msgId = $_POST['id'] ?? '';
if (empty($msgId)) {
    echo json_encode(['success' => false, 'error' => '缺少留言ID']);
    exit;
}
$messages = json_decode(file_get_contents($dataFile), true) ?: [];
$newMessages = [];
foreach ($messages as $msg) {
    if ($msg['id'] !== $msgId) $newMessages[] = $msg;
}
if (count($newMessages) === count($messages)) {
    echo json_encode(['success' => false, 'error' => '留言不存在']);
    exit;
}
file_put_contents($dataFile, json_encode($newMessages, JSON_UNESCAPED_UNICODE));
echo json_encode(['success' => true]);