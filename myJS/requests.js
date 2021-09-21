$(document).ready(getRequests);


async function getRequestsAPI() {
    const response = await fetch('http://localhost/facebook/php/requests.php');
    if (!response.ok) {
        const message = "An error occured";
        throw new Error(message);
    }
    const result = await response.json();
    return result;
}


function getRequests() {
    getRequestsAPI().then(requestFriends => {

        $.each(requestFriends, function(index, requestFriend) {
            console.log(requestFriend.id);
            var full_name = requestFriend.first_name + " " + requestFriend.last_name;
            var $tr = $("<tr id = 'row_" + requestFriend.id + "'>").append(
                $('<td>').text(full_name),
                $('<td>').append("<button type='button' id='accept_" + requestFriend.id + "' class='btn acceptBtn btn-primary'>Accept</button>"),
                $('<td>').append("<button type='button' id='decline_" + requestFriend.id + "' class='btn declineBtn btn-danger'>Decline</button>"),
            ).appendTo("#request_table");
        });
        $(".acceptBtn").click(function() {
            //console.log("hi");
            var id = $(this).attr("id");
            id = id.split("_");
            id = id[1];
            console.log(id);
            accept(id).then(result => {
                $('#row_' + id).hide();

            }).catch(error => {
                console.log(error.message);
            });
        });

        $(".declineBtn").click(function() {
            //console.log("hi");
            var id = $(this).attr("id");
            id = id.split("_");
            id = id[1];
            console.log(id);
            decline(id).then(result => {
                $('#row_' + id).hide();

            }).catch(error => {
                console.log(error.message);
            });
        });

    });
}

async function accept(id) {
    const response = await fetch("http://localhost/facebook/php/request_accept.php?request_id=" + id);
    const result = await response.json();
    return result;
}

async function decline(id) {
    const response = await fetch("http://localhost/facebook/php/request_decline.php?request_id=" + id);
    const result = await response.json();
    return result;
}