<?php
require "conf/connect.php";
require "conf/session.php";
$pageName = "Ver cliente";
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

                    <form>
                        <div>
                            <p>ID:</p>
                            <input type="text" id="firstName" name="firstName"
                                   value="<?= $userInfo->id ?>" disabled/>
                            <p>Nome:</p>
                            <input type="text" id="firstName" name="firstName"
                                   value="<?= $userInfo->name ?>" disabled/>
                            <p>E-mail:</p>
                            <input type="email" id="email" name="email"
                                   value="<?= $userInfo->email ?>" disabled/>
                            <p>Foto:</p>
                            <input type="text" id="picture" name="picture"
                                   value="<?= $userInfo->picture ?>" disabled/>
                            <p>Depoimento:</p>
                            <textarea id="depoiment"
                                      name="depoiment" disabled><?= $userInfo->depoiment ?></textarea>
                            <p>Projeto(s):</p>
                            <select>
                            <?php
                            $projectClient = $pdo->prepare("SELECT * FROM portfolio WHERE client_id = :id");
                            $projectClient->bindParam(":id", $userInfo->id, PDO::PARAM_INT);
                            $projectClient->execute();
                            $project = $projectClient->fetchAll(PDO::FETCH_OBJ);
                            foreach ($project as $itemProject) {
                                ?>
                                <option name="project-<?= $itemProject->id?>" id="project-<?= $itemProject->id?>"><?= $itemProject->name?></option>
                            <?php } ?>
                            </select>
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