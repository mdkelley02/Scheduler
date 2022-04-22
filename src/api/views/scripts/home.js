class HomeModel {
  constructor() {
    this.tasks = [];
    this.currentTask = null;
  }
}

class HomeView {}

class HomeController {
  constructor(model, view) {
    this.localStorage = new LocalStorage();
    this.apiClient = new SchedulerApiClient(this.localStorage.get("jwt"));
    this.model = model;
    this.view = view;
  }
}

document.addEventListener("DOMContentLoaded", () => {
  const model = new HomeModel();
  const view = new HomeView();
  new HomeController(model, view);
});
