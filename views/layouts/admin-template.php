<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <meta name="description" content="<?= $description ?>"/>
    <meta name="keywords" content="<?= $keywords ?>"/>
    <base href="/localhost">
    <link rel="icon" href="public/uploads/favicon.ico" type="image/ico" sizes="32x32">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="public/css/admin.css">
    <link rel="stylesheet" type="text/css" href="public/css/fonts.css">
    <link rel="stylesheet" type="text/css" href="public/css/forms.css">

</head>
<body>
<header>
    <div class="menu-toggle wrapped"><span class="toggle-icon icon-right"></span></div>
        <div class="user">
                <img src="public/uploads/profile-pictures/<?=$logged_user['profile_picture']?>" alt="profile-picture">
                <span class="logged-user-name"><?=$logged_user['first_name']?></span>
                <i class="user-icon icon-down"></i>
            <ul class="account-menu-toggle">
                <li><a href="/">Hlavní stránka</a></li>
                <li><a href="uzivatel/<?=$logged_user['profile_url']?>">Profil</a></li>
                <li><a href="nastaveni">Nastavení</a></li>
                <li><a href="/logout">Odhlásit se</a></li>
            </ul>
        </div>
    </div>
</header>

    <aside class="wrapped">
        <nav class="main-navigation">
            <ul>
                <?php if(UserRoles::logged_user_can('add-articles')):?>
                    <li <?php if($active_menu_li=="new-article"):?>class="active"<?php endif;?>><a href="administrace/novy-clanek"><span class="icon-new menu-icon"></span> <span class="menu-text">Nový příspěvek</span></a></li>
                     <li <?php if($active_menu_li=="articles-management"):?>class="active"<?php endif;?>><a href="administrace/clanky"><span class="icon-article menu-icon"></span> <span class="menu-text">Příspěvky</span></a></li><?php endif;?>
                <?php if(UserRoles::logged_user_can('manage-users')):?>
                    <li <?php if($active_menu_li=="users-management"):?>class="active"<?php endif;?>><a href="administrace/uzivatele "><span class="icon-users menu-icon"></span> <span class="menu-text">Uživatelé</span></a></li>
                <?php endif;?>

            </ul>
        </nav>
    </aside>

<main class="wrapped">
    <div class="container">
        <?php
        $this->controller->renderView();
        ?>
    </div>


</main>
<?php foreach($scripts as $script):?>
    <script src="public/js/<?=$script?>"></script>

<?php endforeach;?>
</body>
</html>