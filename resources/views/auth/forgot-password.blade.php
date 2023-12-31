@include('partials.head')

<div class="container" style="margin-top: 40px;">

    <form action="{{route('password.email')}}" method="post">
        @csrf
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">
                    {{ $error }}
                </div>
            @endforeach
        @endif
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div class="container">
            <label for="email"><b>Email</b></label>
            <input type="text" placeholder="Enter Email" name="email" required>
        </div>

        <div class="container" style="background-color:#f1f1f1;margin-top: 40px;">
            <a href="javascript:history.back()" style="text-decoration: none;color: white" class="btn btn-danger">Back</a>

            <button type="submit" class="btn btn-primary">Confirm</button>

        </div>
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
        width: 40%;
    }

    /* Full-width inputs */
    input[type=text], input[type=password] {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
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
    .cancel_btn {
        width: auto;
        padding: 10px 18px;
        background-color: #f44336;
    }
    .confirm_btn {
        width: auto;
        padding: 10px 18px;

        background-color: #0066b0;
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
    .container {
        padding: 16px;
    }

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
@include('partials.footer')
