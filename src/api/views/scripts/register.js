class View {
  constructor() {
    this.name = document.getElementById("name");
    this.email = document.getElementById("email");
    this.password = document.getElementById("password");
    this.confirmPassword = document.getElementById("confirmPassword");
    this.errorDialog = document.getElementById("errorDialog");
    this.errorMessage = document.getElementById("errorMessage");
    this.registerButton = document.getElementById("registerButton");
  }
  setErrorMessage = (message) => {
    this.errorDialog.style.opacity = 1;
    this.errorMessage.innerHTML = message;
  };
  clearErrorMessage = () => {
    this.errorDialog.style.opacity = 0;
    this.errorMessage.innerHTML = "";
  };
  bindRegisterButton = (handler) => {
    this.registerButton.addEventListener("click", handler);
  };
}

class Controller {
  constructor(view) {
    this.view = view;
    this.view.bindRegisterButton(this.handleRegister);
    this.apiClient = new SchedulerApiClient();
  }

  handleRegister = () => {
    console.log("register");
    if (!this.validate()) {
      return;
    }
    this.view.clearErrorMessage();
    const name = this.view.name.value;
    const email = this.view.email.value;
    const password = this.view.password.value;
    this.apiClient
      .register(name, email, password)
      .then((response) => {
        return response.json();
      })
      .then((data) => {
        window.location.href = "/public/index.php/app/login";
      })
      .catch((error) => {
        console.error(error);
      });
  };

  validate = () => {
    if (this.view.name.value === "") {
      this.view.setErrorMessage("Name is required");
      return false;
    }
    if (this.view.email.value === "") {
      this.view.setErrorMessage("Email is required");
      return false;
    }
    if (this.view.password.value === "") {
      this.view.setErrorMessage("Password is required");
      return false;
    }
    if (this.view.password.value !== this.view.confirmPassword.value) {
      this.view.setErrorMessage("Passwords do not match");
      return false;
    }
    return true;
  };
}

document.addEventListener("DOMContentLoaded", () => {
  const view = new View();
  new Controller(view);
});
