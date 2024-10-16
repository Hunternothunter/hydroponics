const TIMEOUT_DURATION = 900000; // 15 minutes

let logoutTimer;

function resetLogoutTimer() {
  clearTimeout(logoutTimer);
  logoutTimer = setTimeout(logout, TIMEOUT_DURATION);
}

function logout() {
  alert("You will be logged out due to inactivity.");

  window.location.href = "logout.php";
}

window.addEventListener("mousemove", resetLogoutTimer);
window.addEventListener("keypress", resetLogoutTimer);

resetLogoutTimer();