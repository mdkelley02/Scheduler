<?php
namespace App\api\views;

?>

<style>
    <?php echo file_get_contents(__DIR__ . "/../styles/homeaside.css", true); ?>
</style>

<div class="home-aside">
    <div id="homeAside" class="home-aside-card">
        <div class="d-flex mb-3">
            <button class="mr-3"><i class="fa-solid fa-pen-to-square mr-2"></i>Edit</button>
            <button class="danger"><i class="fa-solid fa-trash-can mr-2"></i>Delete</button>
        </div>
        <div class="task-field">
            <div class="task-field-key">Title</div>
            <div class="task-field-value">
                <input type="text" id="title" placeholder="Title">
            </div>
        </div>
        <div class="task-field">
            <div class="task-field-key">Description</div>
            <div class="task-field-value">
                <input type="text" id="description" placeholder="Description">
            </div>
        </div>
        <div class="task-field">
            <div class="task-field-key">Due Date</div>
            <div class="task-field-value">
                <input type="text" id="dueDate" placeholder="Due Date">
            </div>
        </div>
        <div class="task-field">
            <div class="task-field-key">Time Remaining</div>
            <div class="task-field-value">
                <input type="text" id="timeRemaining" placeholder="Time Remaining">
            </div>
        </div>
        <div class="task-field">
            <div class="task-field-key">Time to Complete</div>
            <div class="task-field-value">
                <input type="text" id="timeToComplete" placeholder="Time to Complete">
            </div>
        </div>

    </div>
</div>
