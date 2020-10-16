<?php
require "conf/connect.php";
require "conf/session.php";
$pageName = "Editar administrador";
$eadmin = filter_var($_GET['id'], FILTER_VALIDATE_INT);
$editAdmin = $pdo->prepare("SELECT * FROM administrators WHERE id = :id");
$editAdmin->bindParam(":id", $eadmin, PDO::PARAM_INT);
$editAdmin->execute();
$adminInfo = $editAdmin->fetch(PDO::FETCH_OBJ);
if ($editAdmin->rowCount()) {
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
    <body>
    <?php require 'inc/header.php' ?>
    <main>
        <div class="main_container">
            <div class="main_container_left">
                <?php include "inc/navigation.php"; ?>
            </div>
            <div class="main_container_right">
                <div class="box">
                    <div class="box_title"><i class="fa fa-user-edit"></i> <?= $pageName ?></div>

                    <form method="post" action="">
                        <div>
                            <?php
                            $editAdmin = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRIPPED);
                            if ($editAdmin) {
                                $cloneEmail = $pdo->prepare("SELECT email FROM administrators WHERE email = :email AND id != :id");
                                $cloneEmail->bindParam(":email", $editAdmin['email'], PDO::PARAM_STR);
                                $cloneEmail->bindParam(":id", $eadmin, PDO::PARAM_INT);
                                $cloneEmail->execute();
                                if (empty($editAdmin['name']) || empty($editAdmin['email'])) {
                                    echo "<p class='trigger warning'>Nome e e-mail são obrigatórios</p>";
                                } elseif (!filter_var($editAdmin['email'], FILTER_VALIDATE_EMAIL)) {
                                    echo "<p class='trigger warning'>E-mail inválido</p>";
                                } elseif ($cloneEmail->rowCount()) {
                                    echo "<p class='trigger error'>E-mail <b>{$editAdmin['email']}</b> já existe no sistema</p>";
                                    $editAdmin['email'] = null;
                                } else {
                                    try {
                                        $saveAdmin = $pdo->prepare("UPDATE administrators SET name = :name, email = :email, picture = :picture, level = :level WHERE id = :id");
                                        $saveAdmin->bindParam(":name", $editAdmin['name'], PDO::PARAM_STR);
                                        $saveAdmin->bindParam(":email", $editAdmin['email'], PDO::PARAM_STR);
                                        $saveAdmin->bindParam(":picture", $editAdmin['picture'], PDO::PARAM_STR);
                                        $saveAdmin->bindParam(":level", $editAdmin['level'], PDO::PARAM_INT);
                                        $saveAdmin->bindParam(":id", $eadmin, PDO::PARAM_INT);
                                        $saveAdmin->execute();
                                        echo "<p class='trigger success' >Administrador atualizado com sucesso!</p>";
                                    } catch (PDOException $exception) {
                                        echo "<p class='trigger error'>{$exception->getMessage()}</p>";
                                    }
                                }
                            }
                            ?>
                            <p>Nome:</p>
                            <input type="text" id="name" name="name"
                                   value="<?= $editAdmin['name'] ?? $adminInfo->name ?>"/>
                            <p>E-mail:</p>
                            <input type="email" id="email" name="email"
                                   value="<?= $editAdmin['email'] ?? $adminInfo->email ?>"/>

                            <input hidden type="text" id="picture" name="picture"
                                   value="<?= $editAdmin['picture'] ?? $adminInfo->picture ?>"/>
                            <p>Nível administrativo:</p>
                            <input type="number" id="level" name="level"
                                   value="<?= $editAdmin['level'] ?? $adminInfo->level ?>"/>
                        </div>
                        <hr>
                        <div class="form_button">
                            <button>Salvar <i class="fa fa-check-circle"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </main>
    </body>
    </html>
<?php } else {
    header("Location: administrative.php");
}