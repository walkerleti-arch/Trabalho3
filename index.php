<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acesso Administrativo - Depósito</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&family=Barlow+Condensed:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="login-card">
        <div class="logo-area">
            <div class="logo-icone"></div>
            <div class="logo-texto">Depósito Central</div>
            <div class="logo-sub">Painel Administrativo</div>
        </div>

        <?php if (isset($_SESSION['erro_login'])): ?>
            <div class="erro-msg">
                <?= htmlspecialchars($_SESSION['erro_login']) ?>
            </div>
            <?php unset($_SESSION['erro_login']); ?>
        <?php endif; ?>

        <form action="autenticar.php" method="POST">
            <div class="campo">
                <label for="usuario">Usuário</label>
                <input type="text" id="usuario" name="usuario" required autofocus>
            </div>

            <div class="campo">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" required>
            </div>

            <button type="submit" class="btn-entrar">Entrar</button>
        </form>
    </div>

</body>
</html>