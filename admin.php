<?php

	require_once 'configs.php';

	if (usuario_logado()) {
		$usuarios = $dbh->query("SELECT * FROM usuarios");
	} else {
		$_SESSION['message'] = "Por Favor Entre no Sistema";
		redirect('/login.php');
	}
 ?>

 <!DOCTYPE html>
 <html lang="pt-BR">
 <head>
 	<title>Admin</title>
 	<link rel="stylesheet" href="style.css">
 	<meta charset="utf-8">
 </head>
 <body>
 	<?php include 'nav.php' ?>

	<h1>Admin</h1>

	<table>
		<thead>
			<tr>
				<th><strong>Nome:</strong></th>
				<th><strong>E-mail:</strong></th>
				<th><strong>Opções:</strong></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($usuarios as $u): ?>
				<tr>
					<td><a href="show.php?id=<?= $u['uuid'] ?>"><?= $u['nome'] ?></a></td>
					<td><?= $u['email'] ?></td>
					<td><a href="editar.php?id=<?= $u['uuid'] ?>">Editar</a></td>
					<td><a href="remover.php?id=<?= $u['uuid'] ?>">Remover</a></td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>

 </body>
 </html>
