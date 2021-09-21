$(document).ready(getPending);


async function getPendingAPI() {
    const response = await fetch('http://localhost/facebook/php/pending.php');
    if (!response.ok) {
        const message = "An error occured";
        throw new Error(message);
    }
    const result = await response.json();
    return result;
}


function getPending() {
    getPendingAPI().then(pendingFriends => {

        $.each(pendingFriends, function(index, pendingFriend) {
            console.log(pendingFriend.id);
            var full_name = pendingFriend.first_name + " " + pendingFriend.last_name;
            var $tr = $("<tr id = 'row_" + pendingFriend.id + "'>").append(
                $('<td>').text(full_name),
                $('<td>').append("<button type='button' id='cancel_" + pendingFriend.id + "' class='btn cancelBtn btn-danger'>cancel request</button>"),
            ).appendTo("#pending_table");
        });
        $(".cancelBtn").click(function() {
            var id = $(this).attr("id");
            id = id.split("_");
            id = id[1];
            cancel(id).then(result => {
                //console.log(id);
                $('#row_' + id).hide();
            }).catch(error => {
                console.log(error.message);
            });
        });
    }).catch(error => {
        console.log(error.message);
    });
}

async function cancel(id) {
    const response = await fetch("http://localhost/facebook/php/cancel_request.php?cancel_id=" + id);
    const result = await response.json();
    return result;
}