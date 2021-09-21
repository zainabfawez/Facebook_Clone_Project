$(document).ready(getBlocked);


async function getBlockedAPI() {
    const response = await fetch('http://localhost/facebook/php/blocked.php');
    if (!response.ok) {
        const message = "An error occured";
        throw new Error(message);
    }
    const result = await response.json();
    return result;
}


function getBlocked() {
    getBlockedAPI().then(blockedFriends => {

        $.each(blockedFriends, function(index, blockedFriend) {
            var full_name = blockedFriend.first_name + " " + blockedFriend.last_name;
            var $tr = $("<tr id = 'row_" + blockedFriend.id + "'>").append(
                $('<td>').text(full_name),
                $('<td>').append("<button type='button' id='unBlock_" + blockedFriend.id + "' class='btn unBlockBtn btn-danger'>unBlock</button>")
            ).appendTo("#blocked_table");
        });
        $(".unBlockBtn").click(function() {
            //console.log("hi");
            var id = $(this).attr("id");
            id = id.split("_");
            id = id[1];
            console.log(id);
            unBlock(id).then(result => {
                $('#row_' + id).hide();

            }).catch(error => {
                console.log(error.message);
            });
        });

    });
}

async function unBlock(id) {
    const response = await fetch("http://localhost/facebook/php/friend_unBlock.php?blocked_id=" + id);
    const result = await response.json();
    return result;
}