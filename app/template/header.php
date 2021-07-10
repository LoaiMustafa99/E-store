<header class="main">
    <a href="javascript:;" data-menu-status="<?= (isset($_COOKIE['menu_opened']) && $_COOKIE['menu_opened'] == 'true') ? 'true' : 'false' ?>" class="menu_switch <?= (isset($_COOKIE['menu_opened']) && $_COOKIE['menu_opened'] == 'true') ? 'opened no_animation' : '' ?>"><i class="fa fa-bars"></i></a>
    <h1><?= $text_dashboard ?></h1>
</header>