class LocalStorage {
  constructor() {
    this.storage = window.localStorage;
  }

  get(key) {
    return this.storage.getItem(key);
  }

  set(key, value) {
    this.storage.setItem(key, value);
  }

  remove(key) {
    this.storage.removeItem(key);
  }
}

class SchedulerApiClient {
  constructor(token) {
    this.token = token;
  }
  handleExpiredToken = () => {
    window.location.href = "/public/index.php/app/login";
  };

  login = (email, password) => {
    return fetch("/public/index.php/auth/login", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        email: email,
        password: password,
      }),
    });
  };

  register = (name, email, password) => {
    return fetch("/public/index.php/auth/register", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        full_name: name,
        email: email,
        password: password,
      }),
    });
  };

  getAllTasks = () => {
    return fetch("/public/index.php/tasks", {
      headers: {
        Authorization: `Bearer ${this.token}`,
      },
    }).then((response) => {
      if (response.status === 401) {
        this.handleExpiredToken();
      }
      return response.json();
    });
  };

  getIncompleteTasks = () => {};

  getCompletedTasks = () => {};

  createTask = (
    title,
    description,
    dueDate,
    startTime,
    endTime,
    timeToComplete
  ) => {
    return fetch("/public/index.php/tasks/", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${this.token}`,
      },
      body: JSON.stringify({
        title: title,
        description: description,
        due_date: dueDate,
        start_time: startTime,
        end_time: endTime,
        time_to_complete: timeToComplete,
      }),
    }).then((response) => {
      if (response.status === 401) {
        this.handleExpiredToken();
      }
      return response.json();
    });
  };

  deleteTask = (task_id) => {
    return fetch(`/public/index.php/tasks?task_id=${task_id}`, {
      method: "DELETE",
      headers: {
        Authorization: `Bearer ${this.token}`,
      },
    }).then((response) => {
      if (response.status === 401) {
        this.handleExpiredToken();
      }
      return response.json();
    });
  };

  getMe = () => {
    return fetch("/public/index.php/users/me", {
      headers: {
        Authorization: `Bearer ${this.token}`,
      },
    }).then((response) => {
      if (response.status === 401) {
        this.handleExpiredToken();
      }
      return response.json();
    });
  };
}
