<?php
require "conf/connect.php";
require "conf/session.php";
$pageName = "Redes Sociais";
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
            <div class="box">
                <div class="box_title"><i class="fa fa-link"></i> Navegação</div>
                <nav>
                    <ul>
                        <li><a href="#"><i class="fa fa-circle"></i> E-mails de Contato</a></li>
                        <li><a href="#"><i class="fa fa-circle"></i> Redes Sociais</a></li>
                    </ul>
                </nav>
            </div>
            <?php include "inc/navigation.php"; ?>
        </div>
        <div class="main_container_right">
            <div class="box">
                <div class="box_title"><i class="fa fa-share-alt"></i> <?= $pageName ?></div>
                <form method="post" action="">
                    <div>
                        <p><i class="fa fa-hashtag"></i> Instagram:</p>
                        <input type="text" id="contactInsta" name="contactInsta" value="@agenciabravocode"/>
                        <p><i class="fa fa-thumbs-up"></i> Facebook:</p>
                        <input type="text" id="contactFace" name="contactFace" value="@agenciabravocode"/>
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