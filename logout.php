<?php
@session_start();

unset($_SESSION['user_id']);

if (!isset($_SESSION['user_id'])) {
  echo json_encode(['result' => true]);
} else {
  echo json_encode(['result' => false]);
}
