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
            const userId = "{{auth()->id()}}"
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
</body>

</html>
