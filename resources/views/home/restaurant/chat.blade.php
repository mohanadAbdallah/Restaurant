<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
<link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">

<section style="background-color: #eee;">
    <div class="container py-5">

        <div class="row d-flex justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-6">

                <form action="{{route('chat.message.send',request('id'))}}" method="post">
                    @csrf
                    <div class="card" id="chat2">
                        <div class="card-header d-flex justify-content-between align-items-center p-3">
                            <h5 class="mb-0">Chat</h5>
                        </div>
                        <div class="card-body" data-mdb-perfect-scrollbar="true"
                             style="position: relative; height: 400px">

                            <div class="d-flex flex-row justify-content-start">
                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3-bg.webp"
                                     alt="avatar 1" style="width: 45px; height: 100%;">
                                <div>
                                    <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">Hi</p>
                                    <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">How are
                                        you ...???
                                    </p>
                                    <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">What are
                                        you doing
                                        tomorrow? Can we come up a bar?</p>
                                    <p class="small ms-3 mb-3 rounded-3 text-muted">23:58</p>
                                </div>
                            </div>

                            <div class="divider d-flex align-items-center mb-4">
                                <p class="text-center mx-3 mb-0" style="color: #a2aab7;">Today</p>
                            </div>

                            <div class="d-flex flex-row justify-content-end mb-4 pt-1">
                                <div>
                                    <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">Hiii, I'm good.</p>
                                    <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">How are you
                                        doing?</p>
                                    <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">Long time no see!
                                        Tomorrow
                                        office. will
                                        be free on sunday.</p>
                                    <p class="small me-3 mb-3 rounded-3 text-muted d-flex justify-content-end">00:06</p>
                                </div>
                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava4-bg.webp"
                                     alt="avatar 1" style="width: 45px; height: 100%;">
                            </div>

                        </div>

                        <div class="card-footer text-muted d-flex justify-content-start align-items-center p-3">
                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3-bg.webp"
                                 alt="avatar 3" style="width: 40px; height: 100%;">
                            <input type="text" class="form-control form-control-lg" id="exampleFormControlInput1"
                                   placeholder="Type message" name="message">

                            <button type="submit" class="ms-3">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <a href="{{route('fetchMessages')}}" class="btn btn-success">Fetch Messages</a>
    </div>
</section>

<style>
    #chat2 .form-control {
        border-color: transparent;
    }

    #chat2 .form-control:focus {
        border-color: transparent;
        box-shadow: inset 0px 0px 0px 1px transparent;
    }

    .divider:after,
    .divider:before {
        content: "";
        flex: 1;
        height: 1px;
        background: #eee;
    }
</style>
