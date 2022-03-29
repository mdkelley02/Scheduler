<?php
namespace App\api\views;

?>

<style>
    <?php echo file_get_contents(__DIR__ . "/../styles/homeheader.css", true); ?>
</style>

<div class="home-header">
    <div class="py-4">
        <div class="m-0 d-flex flex-wrap align-items-center">
            <div class="header-item">
                <a href="/app/create-task"><button><i class="fa-solid fa-plus mr-2"></i>Create Task</button></a>
            </div>
            <div class="header-item">
                <a href="/app/create-task"><button class="filter-button"><i class="fa-solid fa-chevron-down mr-2"></i>Filter</button></a>
            </div>
            <div class="header-item">
                <a href="/app/create-task"><button class="sort-button"><i class="fa-solid fa-sort mr-2"></i>Sort</button></a>
            </div>
        </div>
    </div>
</div>
