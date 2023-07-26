import './bootstrap';


var channel = Echo.private(`App.Models.User.${userId}`);

channel.listen('.NewMessageNotification ',function(data) {
    console.log(data)
    alert(JSON.stringify(data));
});
