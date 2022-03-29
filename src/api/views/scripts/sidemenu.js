const storage = new LocalStorage();

const logout = () => {
  storage.remove("jwt");
  window.location.href = "/public/index.php/app/login";
};

document.addEventListener("DOMContentLoaded", () => {
  const logoutButton = document.getElementById("logoutButton");
  logoutButton.addEventListener("click", logout);
});
