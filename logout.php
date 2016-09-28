<?php

require_once 'configs.php';

$usuario_uuid = usuario_logado();
if ($usuario_uuid) {
	session_destroy();
  $logger->logInfo("Usuario {$usuario_uuid} Deslogado com Sucesso");
  redirect('/login.php');
}

 ?>
