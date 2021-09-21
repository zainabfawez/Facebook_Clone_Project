$('#edit_submit').click(function(e) {
    e.preventDefault();
    var fname = $('#first_name').val();
    var lname = $('#last_name').val();
    var email = $('#email').val();
    var pass = $('#password').val();
    var cPass = $('#confirmPassword').val();
    console.log(fname + lname + email + pass + cPass);
    if (pass != cPass) {
        alert("Passwords Mismatch!");
    }
    editUser(fname, lname, email, pass);
})

async function editUserAPI(fname, lname, email, pass) {
    const response = await fetch("http://localhost/facebook/php/edit.php", {
        method: 'POST',
        body: new URLSearchParams({
            "first_name": fname,
            "last_name": lname,
            "email": email,
            "password": pass,
        })
    });
    if (!response.ok) {
        const message = "ERROR OCCURED";
        throw new Error(message);
    }
    const users = await response.json();
    return users;
}

function editUser(fname, lname, email, pass) {
    editUserAPI(fname, lname, email, pass).then(users => {
        window.location.replace("home.html");
    });
}