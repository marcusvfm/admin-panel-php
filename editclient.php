<?php
require "conf/connect.php";
require "conf/session.php";
$pageName = "Editar cliente";
$eclient = filter_var($_GET['id'], FILTER_VALIDATE_INT);
$editClient = $pdo->prepare("SELECT * FROM clients WHERE id = :id");
$editClient->bindParam(":id", $eclient, PDO::PARAM_INT);
$editClient->execute();
$userInfo = $editClient->fetch(PDO::FETCH_OBJ);
if ($editClient->rowCount()) {
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
                            $editUser = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRIPPED);
                            if ($editUser) {
                                $cloneEmail = $pdo->prepare("SELECT email FROM clients WHERE email = :email AND id != :id");
                                $cloneEmail->bindParam(":email", $editUser['email'], PDO::PARAM_STR);
                                $cloneEmail->bindParam(":id", $eclient, PDO::PARAM_INT);
                                $cloneEmail->execute();
                                if (empty($editUser['name']) || empty($editUser['email'])) {
                                    echo "<p class='trigger warning'>Nome e e-mail são obrigatórios</p>";
                                } elseif (!filter_var($editUser['email'], FILTER_VALIDATE_EMAIL)) {
                                    echo "<p class='trigger warning'>E-mail inválido</p>";
                                } elseif ($cloneEmail->rowCount()) {
                                    echo "<p class='trigger error'>E-mail <b>{$editUser['email']}</b> já existe no sistema</p>";
                                    $editUser['email'] = null;
                                } else {
                                    try {
                                        $saveClient = $pdo->prepare("UPDATE clients SET name = :name, email = :email, picture = :picture, depoiment = :depoiment WHERE id = :id");
                                        $saveClient->bindParam(":name", $editUser['name'], PDO::PARAM_STR);
                                        $saveClient->bindParam(":email", $editUser['email'], PDO::PARAM_STR);
                                        $saveClient->bindParam(":picture", $editUser['picture'], PDO::PARAM_STR);
                                        $saveClient->bindParam(":depoiment", $editUser['depoiment'], PDO::PARAM_STR);
                                        $saveClient->bindParam(":id", $eclient, PDO::PARAM_INT);
                                        $saveClient->execute();
                                        echo "<p class='trigger success' >Cliente atualizado com sucesso!</p>";
                                    } catch (PDOException $exception) {
                                        echo "<p class='trigger error'>{$exception->getMessage()}</p>";
                                    }
                                }
                            }
                            ?>
                            <p>Nome:</p>
                            <input type="text" id="name" name="name"
                                   value="<?= $editUser['name'] ?? $userInfo->name ?>"/>
                            <p>E-mail:</p>
                            <input type="email" id="email" name="email"
                                   value="<?= $editUser['email'] ?? $userInfo->email ?>"/>
                            <input hidden type="text" id="picture" name="picture"
                                   value="<?= $editUser['picture'] ?? $userInfo->picture ?>" disabled/>
                            <p>Depoimento:</p>
                            <textarea id="depoiment"
                                      name="depoiment"><?= ($editUser['depoiment'] ?? $userInfo->depoiment) ?></textarea>
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
    header("Location: clients.php");
}