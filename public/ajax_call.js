fetch('update_contact_type.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: `contact_id=${contactId}&type=Sales`
})
.then(response => response.text())
.then(data => console.log(data));
 
