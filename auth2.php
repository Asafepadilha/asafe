<?php
function is_logged() {
  return !empty($_SESSION['user_id']);
}
function require_login() {
  if (!is_logged()) {
    header('Location: login.php'); exit;
  }
}
function current_user_id() {
  return $_SESSION['user_id'] ?? null;
}
