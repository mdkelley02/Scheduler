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
                    <div class="menu-item <?php isCurrent("/app/")?>">
                        <i class="fa-solid fa-house mr-3"></i>Home
                    </div>
                </a>
                <a href="/public/index.php/app/calendar">
                    <div class="menu-item <?php isCurrent("/app/calendar")?>">
                        <i class="fas fa-calendar mr-3"></i>Calendar
                    </div>
                </a>
                <a href="/public/index.php/app/create-task">
                    <div class="menu-item <?php isCurrent("/app/create-task")?>">
                        <i class="fa-solid fa-plus mr-3"></i>Create Task
                    </div>
                </a>
            </div>
            <div>
                <div class="menu-item"><i class="fas fa-user mr-3"></i>Matthew Kelley</div>
                <div id="logoutButton" class="menu-item"><i class="fas fa-sign-out-alt mr-3"></i>Logout</div>
            </div>
        </div>
    </div>
</div>
<script>
    <?php echo file_get_contents(__DIR__ . "/../scripts/sidemenu.js", true); ?>
</script>
