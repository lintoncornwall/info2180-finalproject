document.addEventListener("DOMContentLoaded", () => {
    const filterButtons = document.querySelectorAll(".filter-bar button");
    const tableBody = document.querySelector("tbody");

    // Mock contact data (replace later with AJAX response)
    const contacts = [
        { id: 1, name: "Mr. Michael Scott", email: "michael.scott@paper.co", company: "The Paper Company", type: "SALES LEAD", badge: "sales", assigned: true },
        { id: 2, name: "Mr. Dwight Schrute", email: "dwight@paper.co", company: "The Paper Company", type: "SUPPORT", badge: "support", assigned: false },
        { id: 3, name: "Ms. Pam Beesley", email: "pam@dunder.co", company: "Dunder Mifflin", type: "SALES LEAD", badge: "sales", assigned: true },
        { id: 4, name: "Ms. Angela Martin", email: "angela@vance.co", company: "Vance Refrigeration", type: "SALES LEAD", badge: "sales", assigned: false },
        { id: 5, name: "Ms. Kelly Kapoor", email: "kelly@vance.co", company: "Vance Refrigeration", type: "SUPPORT", badge: "support", assigned: false },
        { id: 6, name: "Mr. Jim Halpert", email: "jim@dunder.co", company: "Dunder Mifflin", type: "SALES LEAD", badge: "sales", assigned: true }
    ];

    function renderTable(list) {
        tableBody.innerHTML = "";

        if(list.length === 0){
            tableBody.innerHTML = `<tr><td colspan="5" style="text-align:center;">No Contacts Found</td></tr>`;
            return;
        }

        list.forEach(c => {
            tableBody.innerHTML += `
            <tr>
                <td>${c.name}</td>
                <td>${c.email}</td>
                <td>${c.company}</td>
                <td><span class="badge ${c.badge}">${c.type}</span></td>
                <td><a href="contact.php?id=${c.id}">View</a></td>
            </tr>`;
        });
    }

    // Default load
    renderTable(contacts);

    filterButtons.forEach(btn => {
        btn.addEventListener("click", () => {
            document.querySelector(".filter-bar button.active")?.classList.remove("active");
            btn.classList.add("active");

            const filter = btn.textContent.trim();

            if(filter === "All"){
                renderTable(contacts);
            }
            else if(filter === "Sales Leads"){
                renderTable(contacts.filter(c => c.type === "SALES LEAD"));
            }
            else if(filter === "Support"){
                renderTable(contacts.filter(c => c.type === "SUPPORT"));
            }
            else if(filter === "Assigned to me"){
                renderTable(contacts.filter(c => c.assigned));
            }
        });
    });

    // Add contact button
    document.querySelector(".add-btn").onclick = () => {
        window.location.href = "new_contact.php";
    };
});
