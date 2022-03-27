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
    <div class="p-4">
        <div>
            <a href="/app/">
                <div class="menu-item <?php isCurrent("/app/")?>">
                    <i class="fa-solid fa-house mr-3"></i>Home
                </div>
            </a>
            <a href="/app/calendar">
                <div class="menu-item <?php isCurrent("/app/calendar")?>">
                    <i class="fas fa-calendar mr-3"></i>Calendar
                </div>
            </a>
            <a href="/app/create-task">
                <div class="menu-item <?php isCurrent("/app/create-task")?>">
                    <i class="fa-solid fa-plus mr-3"></i>Create Task
                </div>
            </a>
            <div class="menu-item"><i class="fas fa-user mr-3"></i>Matthew Kelley</div>
        </div>
        <div>
            <div class="menu-item"><i class="fas fa-sign-out-alt mr-3"></i>Logout</div>
        </div>
    </div>
</div>
