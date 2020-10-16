<?php
session_start();
require "conf/connect.php";
if (isset($_SESSION["user_id"])) {
    header("Location: dashboard.php");
    exit;
}
$pageName = "Login";
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>BravoCode - <?= $pageName ?></title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
    <link href="assets/css/style.css" type="text/css" rel="stylesheet"/>
    <link href="assets/css/all.min.css" type="text/css" rel="stylesheet"/>
</head>
<body style="display: flex; align-items: center; justify-content: center; min-height: 100vh;">
<div class="box_login">
    <h1>Administração</h1>
    <?php
    $login = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRIPPED);
    $loginU = (object)$login;
    if ($login) {
        if (in_array("", $login)) {
            echo "<p class='trigger warning'>Preencha todos os campos</p>";
        } elseif (!filter_var($loginU->email, FILTER_VALIDATE_EMAIL)) {
            echo "<p class='trigger warning'>E-mail digitado não é válido</p>";
        } else {
            try {
                $stmt = $pdo->prepare("SELECT * FROM administrators WHERE email = :email");
                $stmt->bindParam(":email", $loginU->email, PDO::PARAM_STR);
                $stmt->execute();
                if ($stmt->rowCount()) {
                    while ($user = $stmt->fetch(PDO::FETCH_OBJ)) {
                        if (password_verify($loginU->password, $user->password)) {
                            $_SESSION["user_id"] = $user->id;
                            header("Location: dashboard.php");
                        } else {
                            echo "<p class='trigger error'>{$user->first_name}, sua senha está incorreta</p>";
                        }
                    }
                } else {
                    echo "<p class='trigger error'>Nenhum usuário cadastrado pelo e-mail informado</p>";
                }
            } catch (PDOException $exception) {
                $exception->getMessage();
            }
        }
    }
    ?>
    <form action="" method="post">
        <p>E-mail</p>
        <input type="text" name="email" name="email" placeholder="E-mail" value="<?= $loginU->email ?? null ?>"/>
        <p>Senha</p>
        <input type="password" name="password" name="password" placeholder="Senha"
               value="<?= $loginU->password ?? null ?>"/>
        <button>Entrar</button>
    </form>
    <div style="text-align: center">
        <a href="#">Recuperar senha</a>
    </div>
</div>
</body>
</html>