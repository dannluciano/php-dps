<?php

# UUID
require_once 'libs/UUID.php';


# Logger Init
require_once 'libs/KLogger.php';
$logger = new KLogger(__DIR__.'/logs', KLogger::DEBUG);


# Fernet Encrypt
require_once 'libs/Fernet.php';
use Fernet\Fernet;
$key = '7Hf_fYAWWCdiMaxoDvG7CLXERf2LMEDJ0EVou59JM4A=';
$fernet = new Fernet($key);


# Database Conection
$user = $_ENV['DB_USER'] ?: 'root';
$pass = $_ENV['DB_PASS'] ?: '';
$url =  $_ENV['DB_URL']  ?: 'mysql:host=127.0.0.1;dbname=webloggerdb';

$dbh = null;

try {
  $dbh = new PDO($url, $user, $pass);
} catch(PDOException $e) {
  $logger->logFatal('Conexão com o Banco de Dados Falhou: $e->getMessage()');
  die();
}

# Session Start
session_start();

function usuario_logado() {
  return $_SESSION['usuario'];
}


# Redirect Function
function redirect($url = "/") {
  header("Location: $url");
  exit();
}

?>
