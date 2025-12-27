const contactId = new URLSearchParams(window.location.search).get("id");

document.addEventListener("DOMContentLoaded", () => {
  loadNotes();

  document.getElementById("noteForm").addEventListener("submit", e => {
    e.preventDefault();
    addNote();
  });
});

function loadNotes() {
  const xhr = new XMLHttpRequest();
  xhr.open("GET", `api/notes.php?contact_id=${contactId}`, true);

  xhr.onload = () => {
    document.getElementById("notesList").innerHTML =
      xhr.responseText || "<p>No notes yet.</p>";
  };

  xhr.send();
}

function addNote() {
  const text = document.getElementById("noteText").value;

  const xhr = new XMLHttpRequest();
  xhr.open("POST", "api/notes.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = () => {
    document.getElementById("noteText").value = "";
    loadNotes();
  };

  xhr.send(`contact_id=${contactId}&comment=${encodeURIComponent(text)}`);
}
