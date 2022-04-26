<?php
namespace App\api\views;

?>

<style>
    <?php echo file_get_contents(__DIR__ . "/../styles/tasks.css", true); ?>
</style>

<div class="tasks">
    <div class="container">
        <div aria-hidden="true" id="taskModal" class="modal task-modal">
            <div class="modal-content">
                <!-- close modal -->
                <div class="modal-close d-flex justify-content-end">
                    <span class="modal-close-icon">
                        <i class="fas fa-times"></i>
                    </span>
                </div>
                <div id="taskModalTask">
                    <form>
                        <div class="input-field mb-2">
                            <label for="taskCompleted">Completed</label>
                            <input type="checkbox" id="taskCompleted" name="taskCompleted" class="filled-in" />
                        </div>
                        <div class="input-field mb-2">
                            <label for="taskId">Task ID</label>
                            <input id="taskId" type="text" name="taskId" class="validate">
                        </div>
                        <div class="input-field mb-2">
                            <label for="taskTitle">Title</label>
                            <input id="taskTitle" type="text" name="taskTitle" class="validate">
                        </div>
                        <div class="input-field mb-2"">
                            <label for="taskDescription">Description</label>
                            <input id="taskDescription" type="text" name="taskDescription" class="validate">
                        </div>
                        <div class="input-field mb-2"">
                            <label for="taskDueDate">Due Date</label>
                            <input id="taskDueDate" type="text" name="taskDueDate" class="datepicker">
                        </div>
                        <div class="input-field mb-4"">
                            <label for="taskTimeToComplete">Time to Complete</label>
                            <input id="taskTimeToComplete" type="text" name="taskTimeToComplete" class="validate">
                        </div>
                        <div class="d-flex justify-content-end">
                            <button data-state="edit" id="saveEditTaskButton" class="mr-3"><i class="fa-solid fa-pen-to-square mr-2"></i>Edit</button>
                            <button id="deleteTaskButton" class="danger"><i class="fa-solid fa-trash-can mr-2"></i>Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div aria-hidden="true" id="createTaskModal" class="modal create-task-modal">
            <div class="modal-content">
                <!-- close modal -->
                <div class="modal-close d-flex justify-content-end">
                    <span class="modal-close-icon">
                        <i class="fas fa-times"></i>
                    </span>
                </div>

                <div class="title text-center mb-2">Create Task</div>
                <form>
                    <div class="input-field mb-2">
                        <label for="taskTitle">Title</label>
                        <input name="taskTitle" id="taskTitle" type="text" class="validate">
                    </div>
                    <div class="input-field mb-2"">
                        <label for="taskDescription">Description</label>
                        <input name="taskDescription" id="taskDescription" type="text" class="validate">
                    </div>
                    <div class="input-field mb-2"">
                        <label for="taskDueDate">Due Date</label>
                        <input name="taskDueDate" id="taskDueDate" type="text" class="create-task-datepicker datepicker">
                    </div>
                    <div class="input-field mb-4"">
                        <label for="taskTimeToComplete">Time to Complete</label>
                        <input name="taskTimeToComplete" id="taskTimeToComplete" type="text" class="validate">
                    </div>
                    <button>Submit</button>
                </form>
            </div>
        </div>

        <div class="controls-wrapper">
            <div class="controls-inner my-4 d-flex align-items-center">
                <div class="mr-3">
                    <button id="createTaskButton"><i class="fa-solid fa-circle-plus mr-2"></i>Create</button>
                </div>

                <div class="mr-3">
                    <div class="select-wrapper">
                        <select id="filterDropdown" class="dropdown-selector filter">
                            <option class="option" value="ALL">All</option>
                            <option class="option" value="INCOMPLETE">Incomplete</option>
                            <option class="option" value="COMPLETE">Complete</option>
                        </select>
                        <i class="ml-2 fa-solid fa-filter"></i>
                    </div>
                </div>

                <div class="mr-3">
                    <div class="select-wrapper">
                        <select aria-toggle="false" name="sorts" id="sortDropdown" class="dropdown-selector sort">
                            <option class="option" value="ASC">Ascending</div>
                            <option class="option" value="DESC">Descending</div>
                        </select>
                        <i class="ml-2 fa-solid fa-sort"></i>
                    </div>
                </div>

            </div>
        </div>

        <div class="task-list-wrapper">
            <table>
                <thead>
                    <tr>
                        <td class="task-complete"><i class="fa-solid fa-circle-check mr-2"></i>Complete</td>
                        <td class="task-title"><i class="fa-solid fa-t mr-2"></i>Title</td>
                        <td class="task-due-date"><i class="fa-solid fa-clock mr-2"></i>Due Date</td>
                    </tr>
                </thead>
                <tbody id="taskList">

                    <tr>
                        <td>loading...</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>loading...</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>loading...</td>
                        <td></td>
                        <td></td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    <?php echo file_get_contents(__DIR__ . "/../scripts/tasks.js", true); ?>
</script>