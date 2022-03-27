<?php
namespace App\api\views;

?>

<style>
    <?php echo file_get_contents(__DIR__ . "/../styles/calendarheader.css", true); ?>
</style>

<div class="home-header">
    <div class="py-4">
        <div class="m-0 d-flex flex-wrap align-items-center">
            <div class="header-item">
                <a href="/app/create-task"><button><i class="fa-solid fa-plus mr-2"></i>Create Task</button></a>
            </div>
            <div class="header-item">
                <button class="date-picker-button">
                    March 25, 2022<i class="ml-2 fa-solid fa-chevron-down"></i>
                </button>
            </div>
            <div class="header-item"><i class="fa-solid fa-arrow-left-long"></i></div>
            <div class="header-item"><i class="fa-solid fa-arrow-right-long"></i></div>
        </div>
    </div>
</div>
