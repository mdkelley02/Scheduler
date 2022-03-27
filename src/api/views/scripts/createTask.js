class View {
  constructor() {
    this.errorDialog = document.getElementById("errorDialog");
    this.errorMessage = document.getElementById("errorMessage");
    this.submitButton = document.getElementById("submitButton");
    this.title = document.getElementById("title");
    this.description = document.getElementById("description");
    this.timeToComplete = document.getElementById("timeToComplete");
    this.startTime = document.getElementById("startTime");
    this.endTime = document.getElementById("endTime");
    this.dueDate = document.getElementById("dueDate");
    this.initDatepickers();
  }
  initDatepickers = () => {
    const elements = [this.startTime, this.endTime, this.dueDate];
    elements.forEach((element) => {
      new Datepicker(element, {
        buttonClass: "button",
      });
    });
  };
  bindSubmitButton = (callback) => {
    this.submitButton.addEventListener("click", callback);
  };
}

class Controller {
  constructor(view) {
    this.view = view;
    this.view.bindSubmitButton(this.handleSubmit);
    this.localStorage = new LocalStorage();
    this.apiClient = new SchedulerApiClient(this.localStorage.get("jwt"));
  }
  handleSubmit = () => {
    this.apiClient
      .createTask(
        this.view.title.value,
        this.view.description.value,
        this.view.dueDate.value,
        this.view.startTime.value,
        this.view.endTime.value,
        this.view.timeToComplete.value
      )
      .then((response) => response.json())
      .then((data) => {
        console.log(data);
      })
      .catch((error) => console.error(error));
  };
}

document.addEventListener("DOMContentLoaded", () => {
  const view = new View();
  new Controller(view);
});
