<?php
header('Content-Type: application/json; charset=utf-8');
$account = $_POST['account'] ?? '';
$password = $_POST['password'] ?? '';
$validAccount = 'admin';
$validPassword = 'srg2026';
$success = ($account === $validAccount && $password === $validPassword);
echo json_encode(['success' => $success]);