<?php
if (!isset($_GET['cep'])) {
  echo json_encode(['erro' => true]);
  exit;
}

$cep = preg_replace('/[^0-9]/', '', $_GET['cep']);
$data = @file_get_contents("https://viacep.com.br/ws/$cep/json/");

if (!$data) {
  echo json_encode(['erro' => true]);
  exit;
}

echo $data;
