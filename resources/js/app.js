import './bootstrap';

Echo.channel('App.Models.User.' + userId)
    .listen('.chat', (event) => {
        $('.responsive-html5-chat div.messages').append('<div class="message" data-message-id="' + event.message.id + '">' + '<div class="fromThem">' + '<p>' +

            event.message.message + '</p><date>' + event.message.created_at + "</date></div></div>");
        console.log(event)
        $('.responsive-html5-chat')
            .find('.messages')
            .scrollTop($('.responsive-html5-chat .messages')[0].scrollHeight);
    })

//     .listenForWhisper('start-typing', (event) => {
//         $('#whisper').html(`${event.name} is typing .. `);
//     }).listenForWhisper('stop-typing', (event) => {
//     $('#whisper').html(``);
// })
//
// let timer;
// let typing = false;
// $('#message-form-textarea').on('keyup', function (e) {
//     if (!typing) {
//         ch.whisper('start-typing', {
//             name: user.name
//         })
//     }
//     typing = true
//     if (timer) clearTimeout(timer)
//     timer.setTimeout(() => {
//         ch.whisper('stop-typing', {
//             name: user.name
//         });
//         typing = false
//     }, 2000)
// })


