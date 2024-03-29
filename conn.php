<?php
function connect_db()
{
  $host = 'localhost';
  $db = 'ecommerce';
  $username = 'root';
  $password = '';
  return  new PDO("mysql:host=$host;dbname=$db", $username, $password);
}
