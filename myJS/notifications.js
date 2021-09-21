$(document).ready(getNotifications);


async function getNotificationsAPI() {
    const response = await fetch('http://localhost/facebook/php/notifications.php');
    if (!response.ok) {
        const message = "An error occured";
        throw new Error(message);
    }
    const result = await response.json();
    return result;
}


function getNotifications() {
    getNotificationsAPI().then(notifications => {

        $.each(notifications, function(index, notification) {
            var text = notification.text;
            var $tr = $("<tr id = 'row_" + notification.id + "'>").append(
                $('<td>').text(text),
                // rn : remove notification
                $('<td>').append("<button type='button' id='rn_" + notification.id + "' class='btn rnBtn btn-danger'>Remove</button>")
            ).appendTo("#notifications_table");
        });

        $(".rnBtn").click(function() {
            //console.log("hi");
            var id = $(this).attr("id");
            id = id.split("_");
            id = id[1];
            console.log(id);
            remove_notification(id).then(result => {
                $('#row_' + id).hide();

            }).catch(error => {
                console.log(error.message);
            });
        });

    });
}

async function remove_notification(id) {
    const response = await fetch("http://localhost/facebook/php/notification_remove.php?notification_id=" + id);
    const result = await response.json();
    return result;
}