<?php
require "conf/connect.php";
require "conf/session.php";
$pageName = "Portfólio";
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
                            <li><a href="categories.php?c=<?= $category->canonical ?>"><i class="fa fa-circle"></i> <?= $category->name ?></a></li>
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
                <div class="box_title"><i class="fa fa-book-open"></i> <?= $pageName ?></div>
                <?php
                $portfolio = $pdo->prepare("SELECT * FROM portfolio");
                $portfolio->execute();
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
                                <?php
                                $categoryPortfolio = $pdo->prepare("SELECT * FROM categories WHERE id = :category_id");
                                $categoryPortfolio->bindParam(":category_id", $portfolioItem->category_id, PDO::PARAM_INT);
                                $categoryPortfolio->execute();
                                while ($categoryName = $categoryPortfolio->fetch(PDO::FETCH_OBJ)) {
                                    ?>
                                    <p>Categoria: <?= $categoryName->name ?></p>
                                <?php } ?>
                            </div>
                            <div class="box_project_buttons">
                                <a href=""><i class="fa fa-eye"></i>Ver</a>
                                <a href="editproject.php?id=<?= $portfolioItem->id ?>"><i class="fa fa-user-edit"></i>Atualizar</a>
                                <a href="#"><i class="fa fa-trash"></i>Excluir</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</main>
</body>
</html>