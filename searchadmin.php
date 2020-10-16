<?php
require "conf/connect.php";
require "conf/session.php";
$pageName = "Administradores do Sistema";
$sadmin = filter_var($_GET['sadmin'], FILTER_SANITIZE_STRIPPED);
if ($sadmin) {
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
                <form class="form_search_user" action="searchadmin.php" method="get">
                    <input type="text" name="sadmin" id="sadmin" placeholder="Digite o nome do administrador" value="<?= $sadmin ?>"/>
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
                        $stmt = $pdo->prepare("SELECT * FROM administrators WHERE name LIKE CONCAT('%', :search, '%')");
                        $stmt->bindParam(":search", $sadmin, PDO::PARAM_STR);
                        $stmt->execute();
                        if ($stmt->rowCount()) {
                            foreach ($stmt->fetchAll(PDO::FETCH_OBJ) as $user) {
                                ?>
                                <div class="box_client_view">
                                    <div class="box_client_view_button_view">
                                        <a href="viewadmin.php?id=<?= $user->id ?>"><i class="fa fa-eye"></i>Ver</a>
                                    </div>
                                    <div class="box_client_view_button_edit">
                                        <a href="editadmin.php?id=<?= $user->id ?>"><i
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
                            echo "<p>Não foram encontrados resultados para o nome <b>{$sadmin}</b></p>";
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
    header("Location: administrative.php");
}