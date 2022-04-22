class TasksModel {
  FILTERS = {
    ALL: "ALL",
    COMPLETE: "COMPLETE",
    INCOMPLETE: "INCOMPLETE",
  };
  SORT = {
    DATE_ASC: "ASC",
    DATE_DESC: "DESC",
  };
  constructor() {
    this.taskSpace = [];
    this.tasks = [];
    this.currentTask = null;
    this.filter = this.FILTERS.ALL;
    this.sort = this.SORT.DATE_DESC;
  }
  filterTasks = () => {
    if (this.filter === this.FILTERS.ALL) {
      this.tasks = this.taskSpace;
    } else if (this.filter === this.FILTERS.COMPLETE) {
      this.tasks = this.taskSpace.filter((task) => task.completed);
    } else if (this.filter === this.FILTERS.INCOMPLETE) {
      this.tasks = this.taskSpace.filter((task) => !task.completed);
    }
  };
  sortTasks = () => {
    if (this.sort === this.SORT.DATE_ASC) {
      this.tasks = this.taskSpace.sort((a, b) => {
        return new Date(a.due_date) - new Date(b.due_date);
      });
    } else if (this.sort === this.SORT.DATE_DESC) {
      this.tasks = this.taskSpace.sort((a, b) => {
        return new Date(b.due_date) - new Date(a.due_date);
      });
    }
  };
}

class TasksView {
  constructor() {
    this.taskList = document.getElementById("taskList");
    this.sortDropdown = document.getElementById("sortDropdown");
    this.filterDropdown = document.getElementById("filterDropdown");
    this.createTaskButton = document.getElementById("createTaskButton");
    this.taskModal = document.getElementById("taskModal");
    this.createTaskModal = document.getElementById("createTaskModal");
    this.init();
  }
  // task modal --------------------------------------------------------------
  bindCreateTaskButton = (handler) => {
    this.createTaskButton.addEventListener("click", handler);
  };
  toggleTaskModal = () => {
    let isHidden = this.taskModal.getAttribute("aria-hidden") === "true";
    this.taskModal.setAttribute("aria-hidden", !isHidden);
    const saveEditButton = document.getElementById("saveEditTaskButton");
    saveEditButton.innerHTML =
      '<i class="fa-solid fa-pen-to-square mr-2"></i>Edit';
    saveEditButton.setAttribute("data-state", "edit");
  };
  setTaskModalContent = (task) => {
    const completed = this.taskModal.querySelector("#taskCompleted");
    const taskId = this.taskModal.querySelector("#taskId");
    const title = this.taskModal.querySelector("#taskTitle");
    const description = this.taskModal.querySelector("#taskDescription");
    const dueDate = this.taskModal.querySelector("#taskModalTask #taskDueDate");
    const timeToComplete = this.taskModal.querySelector("#taskTimeToComplete");
    completed.value = task.completed;
    taskId.value = task.task_id;
    title.value = task.title;
    description.value = task.description;
    dueDate.value = task.due_date;
    timeToComplete.value = task.time_to_complete;
    const fields = [
      completed,
      taskId,
      title,
      description,
      dueDate,
      timeToComplete,
    ];
    fields.forEach((field) => {
      console.log(field);
      //   debugger;
      if (field.type === "checkbox") {
        field.disabled = "disabled";
      } else {
        field.readOnly = true;
      }
    });
  };

  bindTaskClick = (handler) => {
    this.taskList.addEventListener("click", (event) => {
      const task = event.target.closest(".task");
      if (task) {
        handler(event);
      }
    });
  };

  bindDeleteTaskButton = (handler) => {
    this.taskModal
      .querySelector("#deleteTaskButton")
      .addEventListener("click", handler);
  };

  // create task modal -------------------------------------------------------
  toggleCreateTaskModal = () => {
    let isHidden = this.createTaskModal.getAttribute("aria-hidden") === "true";
    this.createTaskModal.setAttribute("aria-hidden", !isHidden);
    this.createTaskModal.querySelector("#taskDueDate").readonly = false;
  };

  // dropdowns ------------------------------------------------------------------
  bindFilterSelectChange = (handler) => {
    this.filterDropdown.addEventListener("change", (e) => {
      handler(e);
    });
  };
  bindSortSelectChange = (handler) => {
    this.sortDropdown.addEventListener("change", (e) => {
      handler(e);
    });
  };
  bindCreateTaskFormSubmit = (handler) => {
    this.createTaskModal.addEventListener("submit", (e) => {
      e.preventDefault();
      handler(e);
    });
  };

  // task list ---------------------------------------------------------------
  renderTasks = (tasks) => {
    this.taskList.innerHTML = "";
    let taskHtmlString = "";
    tasks.forEach((task) => {
      taskHtmlString += this.buildTask(task);
    });
    this.taskList.innerHTML = taskHtmlString;
  };
  buildTask = (task) => {
    const dateString = new Date(task.due_date).toLocaleDateString();
    return `
        <tr class="task" data-task-id=${task.task_id}>
            <td>${task.completed ? "True" : "False"}</td>
            <td>${task.title}</td>
            <td>${dateString}</td>
        </tr>
    `;
  };

  initDatepickers = () => {
    document.querySelectorAll(".datepicker").forEach((el) => {
      flatpickr(el, {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
      });
    });
  };
  initModalClose = () => {
    const modals = [this.taskModal, this.createTaskModal];
    modals.forEach((modal) => {
      const closeButton = modal.querySelector(".modal-close-icon");
      closeButton.addEventListener("click", () => {
        if (modal.id === "taskModal") {
          this.toggleTaskModal();
        } else {
          this.toggleCreateTaskModal();
        }
      });
    });
  };
  bindSaveEditTaskButton = (handler) => {
    const saveEditButton = this.taskModal.querySelector("#saveEditTaskButton");
    saveEditButton.addEventListener("click", (e) => {
      e.preventDefault();
      handler(e);
    });
  };

  init = () => {
    this.initDatepickers();
    this.initModalClose();
  };
}

class TasksController {
  constructor(model, view) {
    this.localStorage = new LocalStorage();
    this.apiClient = new SchedulerApiClient(this.localStorage.get("jwt"));
    this.model = model;
    this.view = view;
    // init controller ---------------------------------------------------------
    this.view.bindFilterSelectChange(this.handleSelectChange);
    this.view.bindSortSelectChange(this.handleSelectChange);
    this.view.bindCreateTaskButton(this.handleCreateTaskButton);
    this.view.bindTaskClick(this.handleTaskClick);
    this.view.bindCreateTaskFormSubmit(this.handleCreateTaskFormSubmit);
    this.view.bindDeleteTaskButton(this.handleDeleteTaskButton);
    this.view.bindSaveEditTaskButton(this.handleSaveEditTaskButton);
    this.fetchTasks();
  }
  handleTaskUpdateFormSubmit = (event) => {
    const form = event.target;
    const formData = new FormData(form);
    const task = {
      task_id: formData.get("taskId"),
      title: formData.get("title"),
      description: formData.get("description"),
      due_date: formData.get("dueDate"),
      time_to_complete: formData.get("timeToComplete"),
      completed: formData.get("completed") === "on",
    };
    this.apiClient.updateTask(task).then((response) => {
      this.fetchTasks();
    });
  };
  handleSelectChange = (event) => {
    if (event.target.id === "filterDropdown") {
      this.model.filter = event.target.value;
      this.model.filterTasks();
      this.view.renderTasks(this.model.tasks);
    }
    if (event.target.id === "sortDropdown") {
      this.model.sort = event.target.value;
      this.model.sortTasks();
      this.view.renderTasks(this.model.tasks);
    }
  };
  handleTaskClick = (event) => {
    event.preventDefault();
    const taskId = event.target.closest(".task").dataset.taskId;
    const task = this.model.taskSpace.find((task) => task.task_id == taskId);
    this.view.setTaskModalContent(task);
    this.view.toggleTaskModal();
  };
  handleCreateTaskButton = (event) => {
    this.view.toggleCreateTaskModal();
    const form = this.view.createTaskModal.querySelector("form");
    console.log(form);
  };
  handleDeleteTaskButton = (event) => {
    // prevent default
    event.preventDefault();
    const form = event.target.closest("form");
    const taskId = form.querySelector("input#taskId").value;
    this.apiClient.deleteTask(taskId).then((response) => {
      this.fetchTasks();
      this.model.filterTasks();
      this.model.sortTasks();
      this.view.renderTasks(this.model.tasks);
      this.view.toggleTaskModal();
    });
  };
  handleSaveEditTaskButton = (event) => {
    // test
    const saveEditButton = event.target;
    const fields = [
      this.view.taskModal.querySelector("#taskCompleted"),
      this.view.taskModal.querySelector("#taskTitle"),
      this.view.taskModal.querySelector("#taskDescription"),
      this.view.taskModal.querySelector("#taskDueDate"),
      this.view.taskModal.querySelector("#taskTimeToComplete"),
    ];
    if (saveEditButton.getAttribute("data-state") === "edit") {
      saveEditButton.innerHTML =
        '<i class="fa-solid fa-floppy-disk mr-2"></i>Save';
      saveEditButton.setAttribute("data-state", "save");
      fields.forEach((field) => {
        if (field.type === "checkbox") {
          field.disabled = false;
        } else {
          field.readOnly = false;
        }
      });
    } else {
      const form = event.target.closest("form");
      const formData = new FormData(form);
      const task = {
        task_id: formData.get("taskId"),
        title: formData.get("taskTitle"),
        description: formData.get("taskDescription"),
        due_date: formData.get("taskDueDate"),
        time_to_complete: formData.get("taskTimeToComplete"),
        completed: this.view.taskModal.querySelector("#taskCompleted").checked
          ? true
          : false,
      };
      this.apiClient.updateTask(task).then((response) => {
        this.fetchTasks();
        this.model.filterTasks();
        this.model.sortTasks();
        this.view.renderTasks(this.model.tasks);
        this.view.toggleTaskModal();
      });
    }
  };
  handleCreateTaskFormSubmit = (event) => {
    const form = event.target;
    const formData = new FormData(form);
    const task = {
      title: formData.get("taskTitle"),
      description: formData.get("taskDescription"),
      dueDate: formData.get("taskDueDate"),
      timeToComplete: formData.get("taskTimeToComplete"),
    };
    this.apiClient
      .createTask(
        task.title,
        task.description,
        task.dueDate,
        task.timeToComplete
      )
      .then((data) => {
        this.fetchTasks();
        this.view.toggleCreateTaskModal();
      });
  };
  fetchTasks = async () => {
    const response = await this.apiClient.getAllTasks();
    this.model.taskSpace = response["data"]["tasks"];
    this.model.filterTasks();
    this.view.renderTasks(this.model.tasks);
  };
}

document.addEventListener("DOMContentLoaded", () => {
  const model = new TasksModel();
  const view = new TasksView();
  new TasksController(model, view);
});
