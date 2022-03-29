<?php
namespace App\api\views;

?>

<style>
    <?php echo file_get_contents(__DIR__ . "/../styles/createtask.css", true); ?>
</style>


<div class="create-task-card">
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


<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


<script>
    <?php echo file_get_contents(__DIR__ . "/../scripts/main.js", true); ?>
</script>
<script>
    <?php echo file_get_contents(__DIR__ . "/../scripts/createTask.js", true); ?>
</script>