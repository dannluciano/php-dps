<?php

	require_once 'configs.php';

	$error = false;

	if (usuario_logado()) {
		redirect('/admin.php');
	}

	if ($_POST) {
		$email = $_POST['email'];
		$senha = $_POST['senha'];

		$stmt = $dbh->prepare('SELECT * FROM usuarios WHERE email = :email LIMIT 1');
		$stmt->bindParam(':email', $email);
		$stmt->execute();
		$usuario = $stmt->fetch();

		if ($usuario) {
			$hash_senha = base64_encode(hash('sha512', $senha));
			$fernet_senha = $fernet->decode($usuario['senha']);
			if ($fernet_senha !== null) {
				if (password_verify($hash_senha, $fernet_senha)) {
					$_SESSION['usuario'] = $usuario['uuid'];
					$_SESSION['email'] = $usuario['email'];
					$logger->logInfo("Usuario {$usuario['uuid']} Logado com Sucesso");

					redirect('/admin.php');
				} else {
					$logger->logError("Usuario {$usuario['uuid']} errou a senha!");
					$error = true;
				}
			}
		} else {
			$logger->logError("Usuario com o $email não foi encontrado!");
			$error = true;
		}
	}

 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>

	<?php include 'nav.php' ?>

	<?php if ($_SESSION['message']): ?>
		<p class="message">
			<?= $_SESSION['message'] ?>
			<? unset($_SESSION['message']) ?>
		</p>
	<?php endif ?>

	<form action="/login.php" method="post">

		<?php if ($error): ?>
			<p class="error">
				Usuario ou Senha Invalido!
			</p>
		<?php endif ?>

		<div>
			<label for="email">E-mail:</label>
			<input type="email" name="email" required="required">
		</div>

		<div>
			<label for="senha">Senha:</label>
			<input type="password" name="senha" required="required">
		</div>

		<div>
			<button type="submit">Entrar</button>
		</div>
	</form>

</body>
</html>

