const storage = new LocalStorage();

const logout = () => {
  storage.remove("jwt");
  window.location.href = "/public/index.php/app/login";
};

const populateUserName = () => {
  const userNameElement = document.getElementById("userFullName");
  const jwt = storage.get("jwt");
  const client = new SchedulerApiClient(jwt);
  client.getMe().then((data) => {
    const fullName = data["data"]["user"]["full_name"];
    userNameElement.innerHTML = fullName;
  });
};

document.addEventListener("DOMContentLoaded", () => {
  const logoutButton = document.getElementById("logoutButton");
  logoutButton.addEventListener("click", logout);
  populateUserName();
});
