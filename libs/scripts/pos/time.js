let timeDisplay = document.querySelector(".pos__head__time");

function refreshTime() {
    let dateString = new Date().toLocaleString("en-US", { timeZone: "Asia/Manila" });
    let formattedString = dateString.split(',');
    timeDisplay.innerHTML = formattedString[1];
}

setInterval(refreshTime, 1000);