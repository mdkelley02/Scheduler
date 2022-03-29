<?php
namespace App\api\views;

?>

<style>
    <?php echo file_get_contents(__DIR__ . "/../styles/tasks.css", true); ?>
</style>

<div class="tasks">
    <div class="row">
        <div class="col-7">
            <div id="tasksContainer">
            </div>
        </div>

        <div class="col-5">
            <div id="taskPreviewContainer">
            </div>
        </div>

    </div>
</div>

<script>
    <?php echo file_get_contents(__DIR__ . "/../scripts/tasks.js", true); ?>
</script>
