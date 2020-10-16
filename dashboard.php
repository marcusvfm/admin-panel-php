<?php
require "conf/connect.php";
require "conf/session.php";
$pageName = "Dashboard";
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
        <div class="main_cards">
            <div class="main_card">
                <?php
                $countClients = $pdo->prepare("SELECT * FROM clients");
                $countClients->execute();
                ?>
                <i class="fa fa-users"></i> <span><?= $countClients->rowCount() ?> cliente(s) no sistema</span>
            </div>
            <div class="main_card">
                <?php
                $countProjects = $pdo->prepare("SELECT * FROM portfolio WHERE delivered = 1");
                $countProjects->execute();
                ?>
                <i class="fa fa-check-circle"></i><span><?= $countProjects->rowCount() ?> projeto(s) entregue(s)</span>
            </div>
            <div class="main_card">
                <?php
                $countDepoiments = $pdo->prepare("SELECT * FROM clients WHERE depoiment != '' AND depoiment IS NOT NULL");
                $countDepoiments->execute();
                ?>
                <i class="fa fa-comment-dots"></i><span><?= $countDepoiments->rowCount() ?> depoimento(s) recebidos</span>
            </div>
            <div class="main_card">
                <i class="fa fa-envelope"></i><span>15 newsletter(s) cadastrado(s)</span>
            </div>
        </div>
        <div class="main_container_left">
        <?php include "inc/navigation.php"; ?>
        </div>
        <div class="main_container_right">
            <div class="box">
                <div class="box_title"><i class="fa fa-users"></i> <?= $pageName ?></div>
                <div class="box_client">
                    <div class="box_client_legend">
                        <div class="box_client_legend_actions">
                            <i class="fa fa-exclamation-circle"></i> Ações
                        </div>
                        <div class="box_client_legend_name">
                            <i class="fa fa-address-card"></i> Nome
                        </div>
                        <div class="box_client_legend_email">
                            <i class="fa fa-envelope"></i> E-mail
                        </div>
                    </div>
                    <?php
                    $listClients = $pdo->prepare("SELECT * FROM clients");
                    $listClients->execute();
                    if ($listClients->rowCount()) {
                        foreach ($listClients->fetchAll(PDO::FETCH_OBJ) as $user) {
                            ?>
                            <div class="box_client_view">
                                <div class="box_client_view_button_view">
                                    <a href="viewclient.php?id=<?= $user->id ?>"><i class="fa fa-eye"></i>Ver</a>
                                </div>
                                <div class="box_client_view_button_edit">
                                    <a href="editclient.php?id=<?= $user->id ?>"><i
                                                class="fa fa-user-edit"></i>Editar</a>
                                </div>
                                <div class="box_client_view_name">
                                    <?= $user->name ?>
                                </div>
                                <div class="box_client_view_email">
                                    <?= $user->email ?>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo "<p>Não foram encontrados resultados</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>