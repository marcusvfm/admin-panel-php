<header class="main_header">
    <div class="main_header_container">
        <div class="main_header_logo">
            <img src="assets/images/logo.png"/>
        </div>
        <div class="main_header_nav">
            <img class="main_header_nav_pic" src="assets/images/profile/<?= $user->picture ?>"/>
            <div>
                <h1><?= $user->name; ?></h1>
                <p><?= $level ?></p>
            </div>
        </div>
    </div>
</header>
<nav class="main_nav">
    <div class="main_nav_container">
        <ul>
            <li><a href="dashboard.php"><i class="fa fa-home"></i> Página inicial</a></li>
            <li><a href="clients.php"><i class="fa fa-user-friends"></i> Clientes</a></li>
            <li><a href="contact.php"><i class="fa fa-at"></i> Configurações de Contato</a></li>
            <li><a href="portfolio.php"><i class="fa fa-book-open"></i> Portfólio</a></li>
            <li><a href="administrative.php"><i class="fa fa-user"></i> Perfis Administrativos</a></li>
            <li><a href="logout.php" style="color: #d94452;"><i class="fa fa-window-close"></i> Sair</a></li>
        </ul>
    </div>
</nav>