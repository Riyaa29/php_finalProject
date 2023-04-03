function validateForm() {
    var username = document.forms["myForm"]["username"].value;
    var password = document.forms["myForm"]["password"].value;

    if (username == "") {
        alert("Please enter your username.");
        return false;
    }

    if (password == "") {
        alert("Please enter your password.");
        return false;
    }

    return true;
}

function submitForm() {
    var username = document.forms["myForm"]["username"].value;
    var password = document.forms["myForm"]["password"].value;

    if (validateForm()) {
        // Submit the form data to the server using fetch
        fetch('/login', {
            method: 'POST',
            body: JSON.stringify({
                username: username,
                password: password
            }),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(function(response) {
            if (response.ok) {
                // Handle the server response
                console.log(response);
            } else {
                throw new Error('Something went wrong');
            }
        })
        .catch(function(error) {
            // Handle errors
            console.log(error);
        });
    }
}
