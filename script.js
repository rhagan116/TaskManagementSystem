function loadsidebar() {
    fetch("sidebar.php")
    .then(response => response.text())
    .then(data => {
        document.getElementById("sidebar").innerHTML = data;
    })
    .catch(error => console.error("Error loading sidebar:", error));
}