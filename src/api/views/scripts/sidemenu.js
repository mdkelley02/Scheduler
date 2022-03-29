const storage = new LocalStorage();

const logout = () => {
  storage.remove("jwt");
  window.location.href = "/app/login";
};

document.addEventListener("DOMContentLoaded", () => {
  const logoutButton = document.getElementById("logoutButton");
  logoutButton.addEventListener("click", logout);
});
