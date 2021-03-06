<?php
namespace App\api\views;

function isCurrent($route)
{
    $currentRoute = $_SERVER['REQUEST_URI'];
    if ($currentRoute === $route) {
        echo "active";
    }
}
?>

<style>
    <?php echo file_get_contents(__DIR__ . "/../styles/sidemenu.css", true); ?>
</style>

<div class="sidemenu">
    <div class="p-xl-4 p-lg-2">
        <div class="d-flex flex-column justify-space-between">
            <div>
                <a href="/public/index.php/app/">
                    <div class="menu-item <?php isCurrent("/public/index.php/app/")?>">
                        <i class="fa-solid fa-house mr-3"></i>Home
                    </div>
                </a>
            </div>
            <div>
                <div class="menu-item"><i class="fas fa-user mr-3"></i><span id="userFullName">...loading</span></div>
                <div id="logoutButton" class="menu-item"><i class="fas fa-sign-out-alt mr-3"></i>Logout</div>
            </div>
        </div>
    </div>
</div>
<script>
    <?php echo file_get_contents(__DIR__ . "/../scripts/sidemenu.js", true); ?>
</script>