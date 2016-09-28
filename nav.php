<nav>
  <ul>
    <li>
      <a href="/index.php">Index</a>
    </li>
    <li>
      <a href="/admin.php">Admin</a>
    </li>
    <li>
      <a href="/cadastro.php">Cadastrar</a>
    </li>
    <?php if (usuario_logado()): ?>
      <li>
        <a href="/logout.php">Sair (<?= $_SESSION['email'] ?>)</a>
      </li>
    <?php else: ?>
      <li>
        <a href="/login.php">Entrar</a>
      </li>
    <?php endif ?>
  </ul>
</nav>
