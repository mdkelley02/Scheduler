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
<!DOCTYPE html>
<html lang="en">
    <!-- template header -->
    <?php require_once 'TemplateHeader.php';?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- home styles -->
    <style>
        <?php echo file_get_contents(__DIR__ . "/../styles/home.css", true); ?>
    </style>
    <?php require_once __DIR__ . "/../components/SiteHeader.php"?>
    <body class="home-page">
        <div class="row g-0">
            <div class="col-xl-2 col-lg-3">
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
            </div>
            <div class="col-xl-10 col-lg-9">
                <?php require_once __DIR__ . "/../components/Tasks.php"?>
            </div>
        </div>

    </body>

    <!-- home.js -->
    <script>
        <?php echo file_get_contents(__DIR__ . "/../scripts/home.js", true); ?>
    </script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://uicdn.toast.com/tui.code-snippet/v1.5.2/tui-code-snippet.min.js"></script>
    <script src="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.min.js"></script>
    <script src="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.min.js"></script>
</html>
