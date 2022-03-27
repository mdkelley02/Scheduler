<?php
namespace App\api\views;

?>
<!DOCTYPE html>
<html lang="en">
<?php require_once 'TemplateHeader.php';?>
<style>
    <?php echo file_get_contents(__DIR__ . "/../styles/createtask.css", true); ?>
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.2.0/dist/css/datepicker.min.css">
<?php require_once __DIR__ . "/../components/Header.php"?>
<body class="home-page">
    <div class="row">
        <div class="col-xl-2 col-lg-4 col-md-4">
            <?php require_once __DIR__ . "/../components/Sidemenu.php"?>
        </div>
        <div class="col-xl-10 col-lg-8 col-md-8">
            <div class="p-4">
                <div class="container">
                    <div class="create-task-card container-sm">
                        <h2 class="scheduler-logo">Create Task</h2>
                        <div id="errorDialog" class="error-dialog">
                            <div><i class="fa fa-exclamation-triangle"></i><span id="errorMessage"></span></div>
                        </div>
                        <div class="d-flex flex-column">
                            <div>
                                <p>Title</p>
                                <input type="text" id="title" placeholder="Title">
                            </div>
                            <div>
                                <p>Description</p>
                                <input type="text" id="description" placeholder="Description">
                            </div>
                            <div class="row">
                                <div class="col-6"><p>Start Time</p><input type="text" id="startTime" placeholder="Start Time"></div>
                                <div class="col-6"><p>End Time</p><input type="text" id="endTime" placeholder="End Time"></div>
                            </div>
                            <div><p>Due Date</p><input type="text" id="dueDate" placeholder="Due Date"></div>
                            <div><p>Time to Complete</p><input type="text" id="timeToComplete" placeholder="Time to Complete (minutes)"></div>
                            <div class="mt-4"><button id="submitButton">Submit</button></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.2.0/dist/js/datepicker-full.min.js"></script>
<script>
    <?php echo file_get_contents(__DIR__ . "/../scripts/main.js", true); ?>
</script>
<script>
    <?php echo file_get_contents(__DIR__ . "/../scripts/createTask.js", true); ?>
</script>

