    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
const path = window.location.pathname.split("/").pop();
if (path === "index.php" || path === "") document.getElementById("nav-home").classList.add("active");
if (path === "agendamentos.php") document.getElementById("nav-appointments").classList.add("active");
if (path === "clients.php") document.getElementById("nav-clients").classList.add("active");
if (path === "services.php") document.getElementById("nav-services").classList.add("active");
    </script>
    </body>

    </html>