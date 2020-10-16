<?php
require "conf/connect.php";
require "conf/session.php";
$pageName = "Clientes";
$sclient = filter_var($_GET['sclient'], FILTER_SANITIZE_STRIPPED);
if ($sclient) {
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
                <?php
                $search = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRIPPED);
                ?>
                <form class="form_search_user" action="searchclient.php" method="get">
                    <input type="text" name="sclient" id="sclient" placeholder="Digite o nome do cliente"
                           value="<?= $sclient ?>"/>
                    <button><i class="fa fa-search"></i></button>
                </form>
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
                        $listClients = $pdo->prepare("SELECT * FROM clients WHERE name LIKE CONCAT('%', :search, '%')");
                        $listClients->bindParam(":search", $sclient, PDO::PARAM_STR);
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
                            echo "<p>Não foram encontrados resultados para o nome <b>{$sclient}</b></p>";
                        }
                        ?>
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