
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <base href="/localhost">
    <title><?= $title ?></title>
    <meta name="description" content="<?= $description ?>"/>
    <meta name="keywords" content="<?= $keywords ?>"/>
    <meta name="author" content="Josef Kotoun">
    <link rel="icon" href="public/uploads/favicon.ico" type="image/ico" sizes="16x16">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/fonts.css">
    <link rel="stylesheet" type="text/css" href="public/css/forms.css">
</head>
<body>
<main>
    <header>
        <div class="container header-layout">
            <div class="logo">
                <a href="/">
                    <h1>Kotounovy listy</h1>
                    <h4>S námi víte vše</h4>
                </a>
            </div>
            <?php if($logged_user==null): ?>
            <div class="header-login-link">
                <a href="/prihlaseni"> Přihlásit se</a>
            </div>
            <?php else: ?>
            <div class="account-header">

                    <img src="public/uploads/profile-pictures/<?=$logged_user['profile_picture']?>" alt="profile-picture">
                    <span class="account-name"><?=$logged_user['first_name']?></span>
                    <i class="user-icon icon-down"></i>

                <ul class="account-menu-toggle">
                    <?php if(UserRoles::logged_user_can('access-administration')): ?>
                        <li><a href="/administrace/clanky">Administrace</a></li>
                    <?php endif;?>
                    <li><a href="uzivatel/<?=$logged_user['profile_url']?>">Profil</a></li>
                    <li><a href="nastaveni">Nastavení</a></li>
                    <li><a href="/logout">Odhlásit se</a></li>
                </ul>
            </div>
            <?php endif?>
        </div>
    </header>
    <div class="container">
        <nav class="navbar navbar-expand-md bg-dark navbar-dark">
            <div class="navbar-buttons">
                <button type="button" class="navbar-toggler user-toggle-menu">
                    <span class="icon-user"></span>
                </button>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNavbar">
                    <span class="icon-menu"></span>
                </button>
            </div>
            <div class="account-menu-small-container">
                <ul class="account-menu-toggle-small">
                    <?php if(UserRoles::logged_user_can('access-administration')): ?>
                        <li><a href="/administrace/clanky">Administrace</a></li>
                    <?php endif;?>
                    <li><a href="uzivatel/<?=$logged_user['profile_url']?>">Profil</a></li>
                    <li><a href="nastaveni">Nastavení</a></li>
                    <li><a href="/logout">Odhlásit se</a></li>
                </ul>
            </div>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="/kategorie/domaci">Z domova</a></li>
                    <li class="nav-item"><a class="nav-link" href="/kategorie/zahranici">Ze zahraničí</a></li>
                    <li class="nav-item"><a class="nav-link" href="/kategorie/ekonomika">Ekonomika</a></li>
                    <li class="nav-item"><a class="nav-link" href="/kategorie/technologie">Technologie</a></li>
                    <li class="nav-item"><a class="nav-link" href="/kategorie/auto">Auto</a></li>
                    <li class="nav-item"><a class="nav-link" href="/kategorie/sport">Sport</a></li>
                </ul>
            </div>
        </nav>
    </div>

    <div class="container">

        <?php
        $this->controller->renderView();
        ?>
    </div>

</main>
<footer>
    <div>Made by Josef Kotoun</div>
</footer>

<?php foreach($scripts as $script):?>
    <script src="public/js/<?=$script?>"></script>
<?php endforeach;?>
</body>
</html>