<!DOCTYPE html>

<html lang="en" dir="ltr">

@include('partials.head')

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
        @include('partials.navbar')
        <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">
                @yield('content')
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <script>
            const userId = "{{auth()->user()->id}}"
        </script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Footer -->
    @include('partials.footer')
    <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

    <!-- Sidebar -->
@include('partials.sidebar')
<!-- End of Sidebar -->
</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <form method="post" action="{{route('user.logout')}}">
                    @csrf
                    <button type="submit" class="btn btn-primary">Logout</button>
                </form>

            </div>
        </div>
    </div>
</div>

@include('partials.scripts')

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

</body>
<script>
    var pusher = new Pusher('22424c7e721c3213c490', {
        cluster: 'ap3'
    });
    var channel = pusher.subscribe('App.Models.User.' + "{{ auth()->id() }}")

    var user_id = '';
    $(document).on('keyup','#message-input',function (event) {
        if (event.which == 13 && $(this).val() != '') {
            $('#message-list').append(
                '<div class="me">' +
                '<span>' +
                $(this).val()
                +'</span>' +
                '<br>'
                +'</div>'
            );
            var message = $(this).val();
            $('#message-input').val('')
            $('#message-list').scrollTop($('#message-list')[0]
                .scrollHeight);
            axios.post('/messages/respondToUser/' + user_id, {
                headers: {
                    'X-socket-Id': pusher.connection.socket_id
                },
                message: message
            }).then((response) => {


            });
            return false;

        }
    });
    $(document).on('click','header',function (){
        $('.chat-box').toggleClass('opened');
        $('.close-button').toggleClass('show');
    });

    $(document).on('click','.chat-message-item',function () {
        console.log('hello')
        $('.chat-box').addClass('opened');
        $('.close-button').addClass('show')
        $('.chat-user-name').text($(this).attr('user-name'));
         user_id = $(this).attr('user-id');

         axios.get('/getMessages',{
             params:{
                 user_id
             }
         }).then(response => {
             const userId = $(this).attr('user-id');
             console.log(userId)
             for (let i = 0; i < response.data.messages.length; i++) {
                 // console.log(from_user)
                 $('#message-list').append(
                     `<div class="${(response.data.messages[i].from_user  === parseInt(userId)) ? 'not-me': 'me'}">` +
                     '<span>' +
                     response.data.messages[i].message
                     +'</span>' +
                     '<br>'
                     +'</div>'
                 );
                 $('#message-list').scrollTop($('#message-list')[0].scrollHeight);
             }

         })


        channel.bind('chat', function (data) {
            console.log('chat',data)
            if(data.message.from_user == user_id){
                $('#message-list').append(
                    '<div class="not-me">' +
                    '<span>' +
                    data.message.message
                    +'</span>' +
                    '<br>'
                    +'</div>'
                );
                $('#message-list').scrollTop($('#message-list')[0]
                    .scrollHeight);
            }

        });

        return false;
    })
</script>
</html>
