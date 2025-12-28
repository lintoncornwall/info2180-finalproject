document.addEventListener("DOMContentLoaded", () => {
    const tableBody = document.querySelector("tbody");


    const contacts = [
        { id: 1, title: "Mr.", firstname: "Michael", lastname: "Scott", email: "michael@paper.co", type: "Sales Lead" },
        { id: 2, title: "Mr.", firstname: "Dwight", lastname: "Schrute", email: "dwight@paper.co", type: "Support" },
        { id: 3, title: "Ms.", firstname: "Pam", lastname: "Beesley", email: "pam@paper.co", type: "Sales Lead" }
    ];

    function renderContacts(list) {
        tableBody.innerHTML = "";

        list.forEach(contact => {
            const row = document.createElement("tr");

            row.innerHTML = `
                <td>${contact.title} ${contact.firstname} ${contact.lastname}</td>
                <td>${contact.email}</td>
                <td>
                    <span class="badge ${contact.type === 'Sales Lead' ? 'sales' : 'support'}">
                        ${contact.type.toUpperCase()}
                    </span>
                </td>
                <td>
                    <a href="contact.php?id=${contact.id}">View</a>
                </td>
            `;

            tableBody.appendChild(row);
        });
    }

    renderContacts(contacts);

    // Add Contact button
    document.querySelector(".add-btn").onclick = () => {
        window.location.href = "new_contact.php";
    };
});
