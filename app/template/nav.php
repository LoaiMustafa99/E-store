<nav class="main_navigation <?= (isset($_COOKIE['menu_opened']) && $_COOKIE['menu_opened'] == 'true') ? 'opened no_animation' : '' ?>">
    <div class="employee_info">
        <div class="profile_picture">
            <img src="img/user.png" alt="User Profile Picture">
        </div>
        <span class="name">لؤي مصطفى </span>
        <span class="privilege"><?= $text_app_manager ?></span>
    </div>
    <ul class="app_navigation">
        <li><a href="/"><i class="fa fa-dashboard"></i> <?= $text_general_statistics ?></a></li>
        <li><a href="/employee"><i class="fa fa-users"></i> <?= $text_employees ?></a></li>
        <li><a href="/language"><i class="fa fa-users"></i> <?= $text_change_language ?></a></li>
        <li><a href="/"><i class="fa fa-sign-out"></i> <?= $text_log_out ?></a></li>
    </ul>
</nav>
<div class="action_view <?= (isset($_COOKIE['menu_opened']) && $_COOKIE['menu_opened'] == 'true') ? 'collapsed no_animation' : '' ?>">