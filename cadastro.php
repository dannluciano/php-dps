<?php

  require_once 'configs.php';

  if ($_POST) {
    $nome  = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $uuid  = UUID::v4();

    if (empty($senha) == false) {

      $hash_senha = base64_encode(hash('sha512', $senha));
      $bcrypt_senha = password_hash($hash_senha, PASSWORD_BCRYPT, ['cost' => 12]);
      $fernet_senha = $fernet->encode($bcrypt_senha);

      $stmt = $dbh->prepare("INSERT INTO usuarios (nome, email, senha, uuid) VALUES (:nome, :email, :senha, :uuid)");
      $stmt->bindParam(':nome',  $nome);
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':senha', $fernet_senha);
      $stmt->bindParam(':uuid',  $uuid);
      $stmt->execute();

      // $id = $dbh->lastInsertId("usuarios");

      $logger->logInfo("Usuario ($uuid) Cadastrado com Sucesso.");

      $_SESSION['message'] = "Usuario Cadastrado com Sucesso";

      redirect('/login.php');
    }
  }

?>
<!DOCTYPE html>
<html>
<head>
  <title>Cadastro</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <?php include 'nav.php' ?>

  <form action="/cadastro.php" method="post">
    <div>
      <label for="usuario">Nome:</label>
      <input type="text" name="nome" placeholder="joao">
    </div>
    <div>
      <label for="email">E-mail:</label>
      <input type="email" name="email" placeholder="joao@ifpi.edu.br">
    </div>
    <div>
      <label for="senha">Senha:</label>
      <input type="password" name="senha">
    </div>
    <div>
      <button type="submit">Cadastrar</button>
    </div>
  </form>
</body>
</html>
