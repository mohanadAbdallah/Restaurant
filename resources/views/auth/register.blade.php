<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

<div class="container" style="margin-top: 40px;">

    <form action="{{route('register')}}" method="post">
        @csrf
        @if($errors->any())
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">
                    {{$error}}
                </div>
            @endforeach
        @endif
        <div class="row">
            <div class="col-md-12">
                <label for="name"><b>Name</b></label>
                <input type="text" placeholder="Enter Name" class="form-control" name="name" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label for="email"><b>Email</b></label>
                <input type="text" placeholder="Enter Email" class="form-control" name="email" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label for="email"><b>Phone</b></label>
                <input type="text" placeholder="Enter Phone" class="form-control" name="phone" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label for="address"><b>address</b></label>
                <input type="text" placeholder="Enter address" class="form-control" name="address" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label for="email"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" class="form-control" name="password" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label for="psw"><b>Confirm Password</b></label>
                <input type="password" placeholder="confirm Password" class="form-control" name="password_confirmation"
                       required>
            </div>
        </div>


        <button type="submit">Register</button>
        <button type="button" class="loginlbtn"><a class="loginlbtn" href="{{route('user.login')}}">Go To Login</a>
        </button>


    </form>
</div>

<style>
    /* Bordered form */
    form {
        border: 3px solid #f1f1f1;
        padding: 30px;
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 50%;
    }

    /* Full-width inputs */
    input[type=text], input[type=password] {
        width: 100%;
        margin: 8px 0;

        border: 1px solid #ccc;
        box-sizing: border-box;
    }

    /* Set a style for all buttons */
    button {
        background-color: #04AA6D;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
    }

    /* Add a hover effect for buttons */
    button:hover {
        opacity: 0.8;
    }

    /* Extra style for the cancel button (red) */

    .loginlbtn {
        width: 100%;
        padding: 10px 18px;
        background-color: #272bcc;
        text-decoration: none;
        color: white;
    }

    /* Center the avatar image inside this container */
    .imgcontainer {
        text-align: center;
        margin: 24px 0 12px 0;
    }

    /* Avatar image */
    img.avatar {
        width: 40%;
        border-radius: 50%;
    }

    /* Add padding to containers */


    /* The "Forgot password" text */
    span.psw {
        float: right;
        padding-top: 16px;
    }

    /* Change styles for span and cancel button on extra small screens */
    @media screen and (max-width: 300px) {
        span.psw {
            display: block;
            float: none;
        }

        .cancelbtn {
            width: 100%;
        }
    }
</style>
