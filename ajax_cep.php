<div class="container">
<link rel="stylesheet" href="assets/css/style.css">
<?php
if (isset($_GET['cep'])) {
  $c = preg_replace('/\D/', '', $_GET['cep']);
  $resp = file_get_contents("https://viacep.com.br/ws/$c/json/");
  header('Content-Type: application/json');
  echo $resp;
}
