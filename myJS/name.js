getUserName();
async function userNameAPI() {
    const response = await fetch('php/name.php');
    if (!response.ok) {
        const message = "An Error has occured";
        throw new Error(message);
    }

    const user_name = await response.json();
    return user_name;
}


function getUserName() {
    userNameAPI().then(user_name => {
        $("#userName").html(user_name);
    }).catch(error => {
        console.log(error.message);
    })
}