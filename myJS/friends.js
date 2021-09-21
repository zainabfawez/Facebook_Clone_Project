$(document).ready(getFriends);

async function getFriendsAPI() {
    const response_id = await fetch('http://localhost/facebook/php/friends.php');
    if (!response_id.ok) {
        const message = "An error occured";
        throw new Error(message);
    }
    const result_id = await response_id.json();
    return result_id;
}


function getFriends() {
    getFriendsAPI().then(friends => {

        $.each(friends, function(index, friend) {

            var full_name = friend.first_name + " " + friend.last_name;
            var $tr = $("<tr id = 'row_" + friend.id + "'>").append(
                $('<td>').text(full_name),
                $('<td>').append("<button type='button' id='remove_" + friend.id + "' class = 'btn removeBtn btn-secondary'>Remove</button>"),
                $('<td>').append("<button type='button' id='block_" + friend.id + "' class='btn blockBtn btn-danger'>Block</button>")
            ).appendTo("#friends_table");


        });

        $(".removeBtn").click(function() {
            //console.log("hi");
            var id = $(this).attr("id");
            id = id.split("_");
            id = id[1];

            remove(id).then(result => {
                console.log(id);
                $('#row_' + id).hide();

            }).catch(error => {
                console.log(error.message);
            });
        });

        $(".blockBtn").click(function() {
            //console.log("hi");
            var id = $(this).attr("id");
            id = id.split("_");
            id = id[1];

            block(id).then(result => {
                console.log(id);
                $('#row_' + id).hide();

            }).catch(error => {
                console.log(error.message);
            });
        });

    });
}

async function remove(id) {
    const response = await fetch("http://localhost/facebook/php/friend_remove.php?friend_id=" + id);
    const result = await response.json();
    return result;
}

async function block(id) {
    const response = await fetch("http://localhost/facebook/php/friend_block.php?friend_id=" + id);
    const result = await response.json();
    return result;
}