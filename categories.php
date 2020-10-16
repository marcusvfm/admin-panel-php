<?php
require "conf/connect.php";
require "conf/session.php";
$pageName = "Categoria do Portfólio";
$getUrl = filter_var($_GET['c'], FILTER_SANITIZE_STRIPPED);
if ($getUrl) {
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
                <form class="form_search_user" action="searchproject.php" method="get">
                    <input type="text" name="sproject" id="sproject" placeholder="Digite o nome do projeto"/>
                    <button><i class="fa fa-search"></i></button>
                </form>
                <div class="box">
                    <div class="box_title"><i class="fa fa-link"></i> Categorias</div>
                    <nav>
                        <ul>
                            <?php
                            $searchCategories = $pdo->prepare("SELECT * FROM categories");
                            $searchCategories->execute();
                            foreach ($searchCategories->fetchAll(PDO::FETCH_OBJ) as $category) {
                                ?>
                                <li><a href="categories.php?c=<?= $category->canonical ?>"><i
                                                class="fa fa-circle"></i> <?= $category->name ?></a></li>
                                <?php
                            }
                            ?>
                        </ul>
                    </nav>
                </div>
                <?php include "inc/navigation.php"; ?>
            </div>
            <div class="main_container_right">
                <div class="box">
                    <div class="box_title"><i class="fa fa-book-open"></i> Projetos em <?= $getUrl ?></div>
                    <?php
                    $getIdCategory = $pdo->prepare("SELECT * FROM categories WHERE canonical = :canonical");
                    $getIdCategory->bindParam(":canonical", $getUrl, PDO::PARAM_STR);
                    $getIdCategory->execute();
                    $categoryId = $getIdCategory->fetch(PDO::FETCH_OBJ);
                    $portfolio = $pdo->prepare("SELECT * FROM portfolio WHERE category_id = :category_id");
                    $portfolio->bindParam(":category_id", $categoryId->id, PDO::PARAM_INT);
                    $portfolio->execute();
                    if ($portfolio->rowCount()) {
                        foreach ($portfolio->fetchAll(PDO::FETCH_OBJ) as $portfolioItem) {
                            ?>
                            <div class="box_project">

                                <div class="box_project_cover">
                                    <img src="assets/images/cover/<?= $portfolioItem->cover ?>"/>
                                </div>
                                <div class="box_project_content">
                                    <div class="box_project_description">
                                        <h1><?= $portfolioItem->name ?></h1>
                                        <p><?= str_limit_words($portfolioItem->subtitle, 25) ?></p>
                                            <p>Categoria: <?= $categoryId->name ?></p>
                                    </div>
                                    <div class="box_project_buttons">
                                        <a href="#"><i class="fa fa-eye"></i>Ver</a>
                                        <a href="editproject.php?id=<?= $portfolioItem->id ?>"><i class="fa fa-user-edit"></i>Atualizar</a>
                                        <a href="#"><i class="fa fa-trash"></i>Excluir</a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo "<p>Nada encontrado para essa categoria</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </main>
    </body>
    </html>
    <?php
}
?>