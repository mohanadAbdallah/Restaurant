<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                 aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small"
                               placeholder="Search for..." aria-label="Search"
                               aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <!-- Nav Item - Alerts -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>

                <span class="badge badge-danger badge-counter">{{auth()->user()->unreadNotifications()->count()}}</span>
            </a>
            <!-- Dropdown - Alerts -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                 aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                    Alerts Center
                </h6>
                @foreach(auth()->user()->unreadNotifications as $notification)
                <p>New Order : {{$notification->data['order_number'] ?? ''}} was added in {{$notification->created_at->diffForHumans() ?? ''}}</p>
                @endforeach
                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
            </div>
        </li>


        <!-- Nav Item - Messages -->


        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <!-- Counter - Messages -->
                <span class="badge badge-danger badge-counter">7</span>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                 aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                    Message Center
                </h6>


               <div class="messages">

               </div>

                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
            </div>
        </li>


        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{auth()->user()->name}}</span>
                <img class="img-profile rounded-circle"
                src="{{url("storage/images/". auth()->user()->image)}}">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                 aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{route('user.profile')}}">
                    الملف الشخصي
                    <i class="fas fa-person-booth -alt fa-sm fa-fw mr-2 text-gray-400"></i>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    تسجيل خروج
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                </a>
            </div>
        </li>

    </ul>

</nav>

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

<script>
    var pusher = new Pusher('22424c7e721c3213c490', {
        cluster: 'ap3'
    });

    var channel =  pusher.subscribe('App.Models.User.'+"{{ auth()->id() }}")

    channel.bind('chat', function(data) {

        axios.get('/messages',  {
            params:{
                data:data.message
            }
        })
            .then(response => {
                console.log(response)
                let className = 'user_'+data.message.from_user

                if (!$('div.messages').find(`.${className}`).length){
                    $('div.messages').append(
                        `<div class= ${className} >` +
                        '<a class="dropdown-item d-flex align-items-center chat-message-item" last-message='+data.message.message+' user-id='+data.message.from_user+' user-name='+ response.data.user.name +' href="javascript:void(0);">' +
                        '<div class="dropdown-list-image mr-3 rounded-circle" style="background-color: #0a0c0d">' +
                        '<div class="status-indicator bg-success"></div></div>' +
                        '<div class="font-weight-bold">' +
                        '<div class="text-truncate">' + data.message.message + '</div>' +
                        '<div class="small text-gray-500"></div>' + response.data.user.name + ' </div>' +
                        ' </a>' +
                        '</div>'
                )
                }else {
                    $(`.${className}`).html(
                        '<a class="dropdown-item d-flex align-items-center chat-message-item" user-id='+data.message.from_user+' user-name='+ response.data.user.name +' href="javascript:void(0);">' +
                        '<div class="dropdown-list-image mr-3 rounded-circle" style="background-color: #0a0c0d">' +
                        '<div class="status-indicator bg-success"></div></div>' +
                        '<div class="font-weight-bold">' +
                        '<div class="text-truncate">' + data.message.message + '</div>' +
                        '<div class="small text-gray-500"></div>' + response.data.user.name + ' </div>' +
                        '</a>'
                    )
                }
            });

    });

</script>
