class TaskFetchFactory {
  static FETCH_MODES = {
    ALL: "ALL",
    INCOMPLETE: "INCOMPLETE",
    COMPLETED: "COMPLETED",
  };
  constructor(token) {
    this.apiClient = new SchedulerApiClient(token);
    this.modes = {
      ALL: this.apiClient.getAllTasks(),
      INCOMPLETE: this.apiClient.getIncompleteTasks(),
      COMPLETED: this.apiClient.getCompletedTasks(),
    };
  }
  getTasks = (mode) => {
    return this.modes[mode];
  };
}

class TasksModel {
  constructor() {
    this.tasks = [];
    this.currentTask = null;
  }
  setTasks = (tasks) => {
    const final_tasks = {};
    tasks.forEach((task) => {
      final_tasks[task.task_id] = task;
    });
    this.tasks = final_tasks;
  };
}

class TasksView {
  constructor() {
    this.tasksContainer = document.getElementById("tasksContainer");
    this.taskPreviewContainer = document.getElementById("taskPreviewContainer");
  }

  makeDateString(date) {
    const d = new Date(date);
    return `${d.getMonth()}/${d.getDate()}/${d.getFullYear()}`;
  }

  buildTask(task) {
    return `
      <div data-taskId="${task["task_id"]}" class="task">
        <div class="task-title">${task["title"]}</div>
        <div class="task-due-date">${this.makeDateString(
          task["due_date"]
        )}</div>
      </div>
    `;
  }

  buildTaskPreview(task) {
    return `
    <div data-taskId="${task["task_id"]}" class="task-preview">
      <div class="d-flex align-items-center mb-2">
      <div class="mr-2 task-preview__title">${task["title"]}</div>
      <button class="mr-2 ">Edit</button>
      <button id="deleteTaskButton" class="danger">Delete</button>
      </div>
      <div class="pl-3">
        <div class="task-preview__field">
          <div class="task-preview__label">Due Date</div>
          <div class="task-preview__value task-due-date">${this.makeDateString(
            task["due_date"]
          )}</div>
        </div>

        <div class="task-preview__field">
          <div class="task-preview__label">Description</div>
          <div class="task-preview__value task-description">${
            task["description"]
          }</div>
        </div>

      <div class="task-preview__field">
        <div class="task-preview__label">Time to Complete</div>
        <div class="task-preview__value task-time-to-complete">${
          task["time_to_complete"]
        }</div>
      </div>

      <div class="task-preview__field">
        <div class="task-preview__label">Start Time</div>
        <div class="task-preview__value task-start-time">${this.makeDateString(
          task["start_time"]
        )}</div>
      </div>

      <div class="task-preview__field">
        <div class="task-preview__label">End Time</div>
        <div class="task-preview__value task-end-time">${this.makeDateString(
          task["end_time"]
        )}</div>
      </div>
      </div>
    </div>
    `;
  }

  bindOnTaskClick = (handler) => {
    this.tasksContainer.querySelectorAll(".task").forEach((task) => {
      task.addEventListener("click", (event) => {
        let target = event.target;
        while (!target.classList.contains("task")) {
          target = target.parentNode;
        }
        handler(target);
      });
    });
  };

  bindTaskDeleteButton = (handler) => {
    const deleteButton =
      this.taskPreviewContainer.querySelector("#deleteTaskButton");
    deleteButton.addEventListener("click", (event) => {
      handler(event);
    });
  };

  renderTaskPreview(task, taskDeleteHandler) {
    this.taskPreviewContainer.innerHTML = this.buildTaskPreview(task);
    this.bindTaskDeleteButton(taskDeleteHandler);
  }

  renderTasks(tasks) {
    const taskElements = [];
    for (const task_id in tasks) {
      taskElements.push(this.buildTask(tasks[task_id]));
    }
    this.tasksContainer.innerHTML = taskElements.join("");
  }
}

class TasksController {
  constructor(model, view) {
    this.model = model;
    this.view = view;
    this.storage = new LocalStorage();
    this.fetchMode = TaskFetchFactory.FETCH_MODES.ALL;
    this.taskFetchFactory = new TaskFetchFactory(this.storage.get("jwt"));
    this.init();
  }

  init = () => {
    this.fetchTasks();
  };

  onTaskClickHandler = (target) => {
    console.log(target.dataset.taskid);
    const task = this.model.tasks[target.dataset.taskid];
    if (!task) {
      throw new Error("Task not found");
    }
    this.view.renderTaskPreview(task, this.onTaskDeleteHandler);
    this.model.currentTask = task;
  };

  onTaskDeleteHandler = (target) => {
    const { task_id } = this.model.currentTask;
    console.log(task_id);
    this.taskFetchFactory.apiClient.deleteTask(task_id).then(() => {
      console.log(this.model.tasks);
      // const tasks = this.model.tasks.filter((task) => task.task_id !== task_id);
      // this.model.setTasks();
    });
  };

  setFetchMode = (mode) => {
    if (!mode in TaskFetchFactory.FETCH_MODES) {
      throw new Error("Invalid fetch mode");
    }
    this.fetchMode = mode;
  };

  fetchTasks = () => {
    this.taskFetchFactory.getTasks(this.fetchMode).then((data) => {
      const tasks = data.data.tasks;
      console.log("tasks", tasks);
      this.model.setTasks(tasks);
      this.view.renderTasks(this.model.tasks);
      this.view.bindOnTaskClick(this.onTaskClickHandler);
    });
  };
}

document.addEventListener("DOMContentLoaded", () => {
  const model = new TasksModel();
  const view = new TasksView();
  const controller = new TasksController(model, view);
});
