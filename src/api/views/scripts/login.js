class View {
  constructor() {
    this.email = document.getElementById("email");
    this.password = document.getElementById("password");
    this.errorDialog = document.getElementById("errorDialog");
    this.errorMessage = document.getElementById("errorMessage");
    this.loginButton = document.getElementById("loginButton");
  }
  setErrorMessage = (message) => {
    this.errorDialog.style.opacity = 1;
    this.errorMessage.innerHTML = message;
  };
  clearErrorMessage = () => {
    this.errorDialog.style.opacity = 0;
    this.errorMessage.innerHTML = "";
  };
  bindLoginButton = (handler) => {
    this.loginButton.addEventListener("click", handler);
  };
}

class Controller {
  constructor(view) {
    this.view = view;
    this.view.bindLoginButton(this.handleLogin);
    this.apiClient = new SchedulerApiClient();
    this.localStorage = new LocalStorage();
  }

  handleLogin = () => {
    if (!this.validate()) {
      return;
    }
    this.view.clearErrorMessage();
    const email = this.view.email.value;
    const password = this.view.password.value;
    this.apiClient
      .login(email, password)
      .then((response) => {
        return response.json();
      })
      .then((data) => {
        if (data["data"]["error"]) {
          this.view.setErrorMessage(data["data"]["error"]);
          return;
        } else {
          this.localStorage.set("jwt", data["data"]["jwt"]);
          window.location.href = "/public/index.php/app/";
        }
      })
      .catch((error) => {
        console.error(error);
      });
  };

  validate = () => {
    if (this.view.email.value === "") {
      this.view.setErrorMessage("Email is required");
      return false;
    }
    if (this.view.password.value === "") {
      this.view.setErrorMessage("Password is required");
      return false;
    }
    return true;
  };
}

document.addEventListener("DOMContentLoaded", () => {
  const view = new View();
  new Controller(view);
});
