<?php

  require_once 'libs/Fernet.php';

  use Fernet\Fernet;

  $key = Fernet::generateKey();

  echo $key

?>
