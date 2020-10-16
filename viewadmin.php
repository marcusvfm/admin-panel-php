<?php
require "conf/connect.php";
require "conf/session.php";
$pageName = "Ver administrador";
$eclient = filter_var($_GET['id'], FILTER_VALIDATE_INT);
$editClient = $pdo->prepare("SELECT * FROM administrators WHERE id = :id");
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

                    <form>
                        <div>
                            <p>ID:</p>
                            <input type="text" id="firstName" name="firstName"
                                   value="<?= $userInfo->id ?>" disabled/>
                            <p>Nome:</p>
                            <input type="text" id="name" name="name"
                                   value="<?= $userInfo->name ?>" disabled/>
                            <p>E-mail:</p>
                            <input type="email" id="email" name="email"
                                   value="<?= $userInfo->email ?>" disabled/>
                            <p>Foto:</p>
                            <input type="text" id="picture" name="picture"
                                   value="<?= $userInfo->picture ?>" disabled/>
                            <p>Nível administrativo:</p>
                            <input type="number" id="level" name="level"
                                   value="<?= $userInfo->level ?>" disabled/>
                            <?php
                            $countProjects = $pdo->prepare("SELECT * FROM portfolio WHERE author_id = :id AND delivered = :delivered");
                            $countProjects->bindParam(":id", $userInfo->id, PDO::PARAM_INT);
                            $countProjects->bindValue(":delivered", 1, PDO::PARAM_INT);
                            $countProjects->execute();
                            ?>
                            <p>Projetos concluídos:</p>
                            <input type="number" id="level" name="level"
                                   value="<?= $countProjects->rowCount() ?>" disabled/>
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