<?php
namespace App\api\views;

?>
<!DOCTYPE html>
<html lang="en">
<?php require_once 'TemplateHeader.php';?>
<style>
    <?php echo file_get_contents(__DIR__ . "/../styles/createtask.css", true); ?>
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<?php require_once __DIR__ . "/../components/Header.php"?>
<body class="home-page">
    <div class="row">
        <div class="col-xl-3 col-lg-4 col-md-4">
            <?php require_once __DIR__ . "/../components/Sidemenu.php"?>
        </div>
        <div class="col-xl-9 col-lg-8 col-md-8">
            <div class="p-4">
                <div class="container">
                    <?php require_once __DIR__ . "/../components/CreateTask.php"?>
                </div>
            </div>
        </div>
    </div>
</body>


