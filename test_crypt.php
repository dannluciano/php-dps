<?php
require 'libs/Fernet.php';

use Fernet\Fernet;

$key = Fernet::generateKey();
$fernet = new Fernet($key);

$token = $fernet->encode('fernet string message');

$message = $fernet->decode($token);
if ($message === null) {
    echo "Token is not valid\n";
} else {
  echo "$message \n";
}

require 'libs/AES.php';

use AES\AES;

$key = AES::generateKey();
$aes = new AES($key);

$token = $aes->encrypt('aes string message');

$message = $aes->decrypt($token);
if ($message === null) {
  echo "Token is not valid \n";
} else {
  echo "$message \n";
}

?>
