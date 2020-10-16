<?php
require "conf/connect.php";
require "conf/session.php";
$pageName = "Atualizar projeto";
$pclient = filter_var($_GET['id'], FILTER_VALIDATE_INT);
$editProject = $pdo->prepare("SELECT * FROM portfolio WHERE id = :id");
$editProject->bindParam(":id", $pclient, PDO::PARAM_INT);
$editProject->execute();
$projectInfo = $editProject->fetch(PDO::FETCH_OBJ);
if ($editProject->rowCount()) {
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

                            $attProject = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRIPPED);
                            if ($attProject) {

                                if (empty($attProject['name']) || empty($attProject['subtitle']) || empty($attProject['description']) || empty($attProject['cover']) || empty($attProject['client']) || empty($attProject['author']) || empty($attProject['category'])) {
                                    echo "<p class='trigger warning'>Todos os campos são obrigatórios, exceto Website</p>";
                                } elseif (!empty($attProject['website']) && !filter_var($attProject['website'], FILTER_VALIDATE_URL)) {
                                    echo "<p class='trigger warning'>Url de Website inválida</p>";
                                } else {
                                    try {
                                        $convertEmail = $pdo->prepare("SELECT id FROM clients WHERE email = :email");
                                        $convertEmail->bindParam(":email", $attProject['client'], PDO::PARAM_STR);
                                        $convertEmail->execute();
                                        if ($convertEmail->rowCount()) {
                                            $userId = $convertEmail->fetch(PDO::FETCH_OBJ);

                                            $saveClient = $pdo->prepare("UPDATE portfolio SET name = :name, subtitle = :subtitle, description = :description,
                                                                  cover = :cover, website = :website, author_id = :author, category_id = :category, client_id = :client  WHERE id = :id");
                                            $saveClient->bindParam(":name", $attProject['name'], PDO::PARAM_STR);
                                            $saveClient->bindParam(":subtitle", $attProject['subtitle'], PDO::PARAM_STR);
                                            $saveClient->bindParam(":description", $attProject['description'], PDO::PARAM_STR);
                                            $saveClient->bindParam(":cover", $attProject['cover'], PDO::PARAM_STR);
                                            $saveClient->bindParam(":website", $attProject['website'], PDO::PARAM_STR);
                                            $saveClient->bindParam(":client", $userId->id, PDO::PARAM_INT);
                                            $saveClient->bindParam(":author", $attProject['author'], PDO::PARAM_STR);
                                            $saveClient->bindParam(":category", $attProject['category'], PDO::PARAM_INT);
                                            $saveClient->bindParam(":id", $pclient, PDO::PARAM_INT);
                                            $saveClient->execute();
                                            echo "<p class='trigger success' >Projeto atualizado com sucesso!</p>";
                                        } else {
                                            echo "<p class='trigger error'>Nenhum cliente cadastrado com esse e-mail</p>";
                                        }
                                    } catch (PDOException $exception) {
                                        echo "<p class='trigger error'>{$exception->getMessage()}</p>";
                                    }
                                }
                            }
                            ?>
                            <p>Nome:</p>
                            <input type="text" id="name" name="name"
                                   value="<?= $attProject['name'] ?? $projectInfo->name ?>"/>
                            <p>Subtítulo:</p>
                            <input type="text" id="subtitle" name="subtitle"
                                   value="<?= $attProject['subtitle'] ?? $projectInfo->subtitle ?>"/>
                            <p>Descrição:</p>
                            <input type="text" id="description" name="description"
                                   value="<?= $attProject['description'] ?? $projectInfo->description ?>"/>
                            <p>Capa:</p>
                            <input type="text" id="cover" name="cover"
                                   value="<?= $attProject['cover'] ?? $projectInfo->cover ?>"/>
                            <p>Website:</p>
                            <input type="url" id="website" name="website"
                                   value="<?= $attProject['website'] ?? $projectInfo->website ?>"/>
                            <p>E-mail do Cliente:</p>
                            <?php
                            $convertId = $pdo->prepare("SELECT email FROM clients WHERE id = :client_id");
                            $convertId->bindParam(":client_id", $projectInfo->client_id, PDO::PARAM_STR);
                            $convertId->execute();
                            $userEmail = $convertId->fetch(PDO::FETCH_OBJ);
                            ?>
                            <input type="email" id="client" name="client"
                                   value="<?= $attProject['client'] ?? $userEmail->email ?>"/>
                            <p>Responsável pelo projeto:</p>
                            <select id="author" name="author">
                                <option value="">Selecione</option>
                                <?php
                                $administrators = $pdo->prepare("SELECT * FROM administrators");
                                $administrators->execute();
                                foreach ($administrators->fetchAll(PDO::FETCH_OBJ) as $administrator) {
                                    if (!empty($attProject['author'])) {
                                        if ($attProject['author'] == $administrator->id) {
                                            ?>
                                            <option value="<?= $attProject['author'] ?>"
                                                    selected><?= $administrator->name ?></option>
                                            <?php
                                        } else {
                                            ?>
                                            <option value="<?= $administrator->id ?>"><?= $administrator->name ?></option>
                                            <?php
                                        }

                                    } else { ?>
                                        <option value="<?= $administrator->id ?>" <?= ($projectInfo->author_id == $administrator->id ? "selected" : null) ?>><?= $administrator->name ?></option>
                                    <?php }
                                }
                                ?>
                            </select>
                            <p>Categoria do projeto:</p>
                            <select id="category" name="category">
                                <option value="">Selecione</option>
                                <?php
                                $categories = $pdo->prepare("SELECT * FROM categories");
                                $categories->execute();
                                foreach ($categories->fetchAll(PDO::FETCH_OBJ) as $category) {
                                    if (!empty($attProject['category'])) {
                                        if ($attProject['category'] == $category->id) {
                                            ?>
                                            <option value="<?= $attProject['category'] ?>"
                                                    selected><?= $category->name ?></option>
                                            <?php
                                        } else {
                                            ?>
                                            <option value="<?= $category->id ?>"><?= $category->name ?></option>
                                            <?php
                                        }

                                    } else { ?>
                                        <option value="<?= $category->id ?>" <?= ($projectInfo->category_id == $category->id ? "selected" : null) ?>><?= $category->name ?></option>
                                    <?php }
                                }
                                ?>
                            </select>
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
    header("Location: portfolio.php");
}