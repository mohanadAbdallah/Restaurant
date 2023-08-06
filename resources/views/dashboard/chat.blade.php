<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

<link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">

<section style="background-color: #eee; ">
    <div class="iphone">
        <div class="border">
            <div class="responsive-html5-chat">
            </div>
        </div>
    </div>
</section>

<script>
    const userId = "{{auth()->user()->id}}"
</script>
@vite(['resources/css/app.css', 'resources/js/app.js'])

<style>
    .border {
        margin: 0px 0px 0px 272px;
        max-width: 40%;
    }

    form.chat * {
        transition: all 0.5s;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
    }

    form.chat {
        margin: 0;
        cursor: default;
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        top: 0;
        -webkit-touch-callout: none; /* iOS Safari */
        -webkit-user-select: none; /* Chrome/Safari/Opera */
        -khtml-user-select: none; /* Konqueror */
        -moz-user-select: none; /* Firefox */
        -ms-user-select: none; /* IE/Edge */
        user-select: none;
    }

    form.chat span.spinner {
        -moz-animation: loading-bar 1s 1;
        -webkit-animation: loading-bar 1s 1;
        animation: loading-bar 1s 1;
        display: block;
        height: 2px;
        background-color: #00e34d;
        transition: width 0.2s;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        z-index: 4;
    }

    form.chat .messages {
        display: block;
        overflow-x: hidden;
        overflow-y: scroll;
        position: relative;
        height: 90%;
        width: 100%;
        padding: 2% 3%;
        border-bottom: 1px solid #ecf0f1;
    }

    form.chat ::-webkit-scrollbar {
        width: 3px;
        height: 1px;
        transition: all 0.5s;
        z-index: 10;
    }

    form.chat ::-webkit-scrollbar-track {
        background-color: white;
    }

    form.chat ::-webkit-scrollbar-thumb {
        background-color: #bec4c8;
        border-radius: 3px;
    }

    form.chat .message {
        display: block;
        width: 100%;
        padding: 0.5%;
    }

    form.chat .message p {
        margin: 0;
    }

    form.chat .myMessage,
    form.chat .fromThem {
        max-width: 100%;
        word-wrap: break-word;
        margin-bottom: 20px;
    }

    form.chat .message:hover .myMessage {
        -webkit-transform: translateX(-130px);
        transform: translateX(-130px);
    }

    form.chat .message:hover .fromThem {
        -webkit-transform: translateX(130px);
        transform: translateX(130px);
    }

    form.chat .message:hover date {
        opacity: 1;
    }

    form.chat .myMessage,
    .fromThem {
        position: relative;
        padding: 10px 20px;
        color: white;
        border-radius: 25px;
        clear: both;
        font: 400 15px "Open Sans", sans-serif;
    }

    form.chat .myMessage {
        background: #00e34d;
        color: white;
        float: right;
        clear: both;
        border-bottom-right-radius: 20px 0px \9;
    }

    form.chat .myMessage:before {
        content: "";
        position: absolute;
        z-index: 1;
        bottom: -2px;
        right: -8px;
        height: 19px;
        border-right: 20px solid #00e34d;
        border-bottom-left-radius: 16px 14px;
        -webkit-transform: translate(0, -2px);
        transform: translate(0, -2px);
        border-bottom-left-radius: 15px 0px \9;
        transform: translate(-1px, -2px) \9;
    }

    form.chat .myMessage:after {
        content: "";
        position: absolute;
        z-index: 1;
        bottom: -2px;
        right: -42px;
        width: 12px;
        height: 20px;
        background: white;
        border-bottom-left-radius: 10px;
        -webkit-transform: translate(-30px, -2px);
        transform: translate(-30px, -2px);
    }

    form.chat .fromThem {
        background: #e5e5ea;
        color: black;
        float: left;
        clear: both;
        border-bottom-left-radius: 30px 0px \9;
    }

    form.chat .fromThem:before {
        content: "";
        position: absolute;
        z-index: 2;
        bottom: -2px;
        left: -7px;
        height: 19px;
        border-left: 20px solid #e5e5ea;
        border-bottom-right-radius: 16px 14px;
        -webkit-transform: translate(0, -2px);
        transform: translate(0, -2px);
        border-bottom-right-radius: 15px 0px \9;
        transform: translate(-1px, -2px) \9;
    }

    form.chat .fromThem:after {
        content: "";
        position: absolute;
        z-index: 3;
        bottom: -2px;
        left: 4px;
        width: 26px;
        height: 20px;
        background: white;
        border-bottom-right-radius: 10px;
        -webkit-transform: translate(-30px, -2px);
        transform: translate(-30px, -2px);
    }

    form.chat date {
        position: absolute;
        top: 10px;
        font-size: 14px;
        white-space: nowrap;
        vertical-align: middle;
        color: #8b8b90;
        opacity: 0;
        z-index: 4;
    }

    form.chat .myMessage date {
        left: 105%;
    }

    form.chat .fromThem date {
        right: 105%;
    }

    form.chat input {
        font: 400 13px "Open Sans", sans-serif;
        border: 0;
        padding: 0 15px;
        height: 10%;
        outline: 0;
    }

    form.chat input[type="text"] {
        width: 73%;
        float: left;
    }

    form.chat input[type="submit"] {
        width: 23%;
        background: transparent;
        color: #00e34d;
        font-weight: 700;
        text-align: right;
        float: right;
    }

    form.chat .myMessage,
    form.chat .fromThem {
        font-size: 12px;
    }

    form.chat .message:hover .myMessage {
        transform: translateY(18px);
        -webkit-transform: translateY(18px);
    }

    form.chat .message:hover .fromThem {
        transform: translateY(18px);
        -webkit-transform: translateY(18px);
    }

    form.chat .myMessage date,
    form.chat .fromThem date {
        top: -20px;
        left: auto;
        right: 0;
        font-size: 12px;
    }

    form.chat .myMessage,
    form.chat .fromThem {
        max-width: 90%;
    }

    @-moz-keyframes loading-bar {
        0% {
            width: 0%;
        }
        90% {
            width: 90%;
        }
        100% {
            width: 100%;
        }
    }

    @-webkit-keyframes loading-bar {
        0% {
            width: 0%;
        }
        90% {
            width: 90%;
        }
        100% {
            width: 100%;
        }
    }

    @keyframes loading-bar {
        0% {
            width: 0%;
        }
        90% {
            width: 90%;
        }
        100% {
            width: 100%;
        }
    }

    /* DEMO */

    .border {
        position: absolute;
        top: 12.3%;
        right: 7%;
        left: 7%;
        bottom: 12%;
        overflow: hidden;
    }

    a.article {
        position: fixed;
        bottom: 15px;
        left: 15px;
        display: table;
        text-decoration: none;
        color: white;
        background-color: #00e34d;
        padding: 10px 20px;
        border-radius: 25px;
        font: 400 15px "Open Sans", sans-serif;
    }

</style>

<script src="https://cresponsiveChatPushdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>

<script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- Core plugin JavaScript-->
<script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

<script>
    var pusher = new Pusher('22424c7e721c3213c490', {
        cluster: 'ap3'
    });
    var channel = pusher.subscribe('App.Models.User.' + "{{ auth()->id() }}");

    function responsiveChat(element) {

        $(element)
            .html('<form class="chat"><span></span><div class="messages"></div>' +
                '<input type="text" id="message" name="message" placeholder="Your message">' +
                '<input type="submit" value="Send">' +
                '</form>');

        function showLatestMessage(element) {
            $('.responsive-html5-chat')
                .find('.messages')
                .scrollTop($('.responsive-html5-chat .messages')[0]
                    .scrollHeight);
        }

        showLatestMessage(element);

        $(element + ' input[type="text"]').keypress(function (event) {
            if (event.which == 13) {
                event.preventDefault();
                $(element + ' input[type="submit"]').click();
            }
        });

        $(element + ' input[type="submit"]').click(function (event) {
            event.preventDefault();
            var message = $(element + ' input[type="text"]').val();

            var d = new Date();
            var clock = d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
            var month = d.getMonth() + 1;
            var day = d.getDate();
            var currentDate =
                (("" + day).length < 2 ? "0" : "") +
                day +
                "." +
                (("" + month).length < 2 ? "0" : "") +
                month +
                "." +
                d.getFullYear() +
                "&nbsp;&nbsp;" +
                clock;

            $(element + ' div.messages').append(
                '<div class="message">' +
                '<div class="myMessage">' +
                '<p>' +
                message +
                "</p><date>" +
                currentDate +
                "</date></div></div>"
            );
            showLatestMessage(element)

            Pusher.logToConsole = true;



            const existingMessageIds = $(element + ' .messages').children('.message').map(function () {
                return $(this).data('message-id');
            }).get();


            if ($(element + ' input[type="text"]').val()) {
                let id = {{request('id')}}
                axios.post('/messages/respondToUser/' + id, {
                    headers: {
                        'X-socket-Id': pusher.connection.socket_id
                    },
                    message: message
                }).then((response) => {
                    $('#message').val('')
                    console.log(response)
                });

                setTimeout(function () {
                    $(element + ' > span').addClass("spinner");
                }, 100);
                setTimeout(function () {
                    $(element + ' > span').removeClass("spinner");
                }, 2000);
            }
            $(element + ' input[type="text"]').val("");
            showLatestMessage(element);
        });
    }

    function responsiveChatPush(element, sender, origin, date, message , messageId) {
        var originClass;
        if (origin == 'me') {
            originClass = 'myMessage';
        } else {
            originClass = 'fromThem';
        }
        $(element + ' .messages')
            .append('<div class="message" data-message-id="' + messageId + '"><div class="' + originClass + '"><p>' + message + '</p><date><b>' + sender + '</b> ' + date + '</date></div></div>');
    }

    /* Activating chatbox on element */
    responsiveChat('.responsive-html5-chat');

    @foreach($messages as $message)
    responsiveChatPush('.chat', 'Kate',
        '{{$message->from_user == auth()->id() ? 'me' : 'you' }}',
        '{{$message->created_at->diffForHumans()}}',
        "{{$message->message}}",
        '{{$message->id}}',
    );
    @endforeach
    setTimeout(function () {
        $('.responsive-html5-chat')
            .find('.messages')
            .scrollTop($('.responsive-html5-chat .messages')[0]
                .scrollHeight);
    },50)
    /* DEMO */
    if (parent == top) {
        $("a.article").show();
    }

</script>
