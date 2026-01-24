document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    if (searchInput) {
        searchInput.addEventListener("input", function () {
            const filter = this.value.toLowerCase();
            const rows = document.querySelectorAll("#userTable tbody tr");

            rows.forEach(row => {
                const name = row.children[1]?.textContent.toLowerCase() || "";
                const phone = row.children[2]?.textContent.toLowerCase() || "";

                if (name.includes(filter) || phone.includes(filter)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });
    }
});
