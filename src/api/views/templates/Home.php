<?php
namespace App\api\views;

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
            <?php echo __DIR__ ?>
            <div class="col-xl-2 col-lg-3">
                <?php include "/app/src/api/views/components/SideMenu.php"?>
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
