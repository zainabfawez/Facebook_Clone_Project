$('#search_submit').click(function() {
    clearTable();
    let search_value = $('#search_input').val();
    searchUsers(search_value);
})

function clearTable() {
    $('#search_table').empty();
}

async function getSearchInputAPI(search_value) {
    const response = await fetch("http://localhost/facebook/php/search.php", {
        method: 'POST',
        body: new URLSearchParams({
            "search": search_value,
        })
    });

    if (!response.ok) {
        const message = "ERROR OCCURED";
        throw new Error(message);
    }

    const users = await response.json();
    return users;
}

function searchUsers(search_value) {
    getSearchInputAPI(search_value).then(users => {
        $.each(users, function(index, user) {

            var full_name = user.first_name + " " + user.last_name;
            var $tr = $("<tr id = 'row_" + user.id + "'>").append(
                $('<td>').text(full_name),
                $('<td>').append("<button type='button' id='add_" + user.id + "' class = 'btn addBtn btn-primary'>Add friend</button>"),
                $('<td>').append("<button type='button' id='block_" + user.id + "' class='btn blockBtn btn-danger'>Block</button>")
            ).appendTo("#search_table");
        });

        $(".addBtn").click(function() {
            //console.log("hi");
            var id = $(this).attr("id");
            id = id.split("_");
            id = id[1];

            addUser(id).then(result => {
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

            blockUser(id).then(result => {
                console.log(id);
                $('#row_' + id).hide();

            }).catch(error => {
                console.log(error.message);
            });
        });

    });
}

async function addUser(id) {
    const response = await fetch("http://localhost/facebook/php/user_add.php?add_id=" + id);
    const result = await response.json();
    return result;
}

async function blockUser(id) {
    const response = await fetch("http://localhost/facebook/php/user_block.php?block_id=" + id);
    const result = await response.json();
    return result;
}