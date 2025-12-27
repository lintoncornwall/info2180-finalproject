const modal = document.getElementById("addContactModal");

document.getElementById("openAddContact").onclick = () =>
  modal.classList.remove("hidden");

document.getElementById("closeModal").onclick = () =>
  modal.classList.add("hidden");

document.getElementById("addContactForm").addEventListener("submit", e => {
  e.preventDefault();

  const formData = new FormData(e.target);
  const xhr = new XMLHttpRequest();

  xhr.open("POST", "api/contacts.php", true);
  xhr.onload = () => {
    modal.classList.add("hidden");
    loadContacts("all");
  };

  xhr.send(formData);
});
