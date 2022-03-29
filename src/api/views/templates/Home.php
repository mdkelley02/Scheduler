<?php
namespace App\api\views;

?>
<!DOCTYPE html>
<html lang="en">
<?php require_once 'TemplateHeader.php';?>
<style>
    <?php echo file_get_contents(__DIR__ . "/../styles/home.css", true); ?>
</style>
<script>
    <?php echo file_get_contents(__DIR__ . "/../scripts/main.js", true); ?>
</script>
<?php require_once __DIR__ . "/../components/Header.php"?>
<body class="home-page">
    <div class="row">
        <div class="col-xl-3 col-lg-3 col-md-4">
            <?php require_once __DIR__ . "/../components/Sidemenu.php"?>
        </div>
        <div class="col-xl-9 col-lg-9 col-md-8">
            <?php require_once __DIR__ . "/../components/HomeHeader.php"?>
            <div class="tasks-wrapper">
                <?php require_once __DIR__ . "/../components/Tasks.php"?>
            </div>
        </div>
    </div>
</body>
<script>
    <?php echo file_get_contents(__DIR__ . "/../scripts/home.js", true); ?>
</script>
<script src="https://uicdn.toast.com/tui.code-snippet/v1.5.2/tui-code-snippet.min.js"></script>
<script src="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.min.js"></script>
<script src="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.min.js"></script>
<script src="https://uicdn.toast.com/tui-calendar/latest/tui-calendar.js"></script>
</html>
