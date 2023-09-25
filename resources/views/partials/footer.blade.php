<footer class="sticky-footer bg-white" style="    box-shadow: 10px 10px 10px 10px;">
    <div class="container my-auto">
        <div class="chat-box" >
            <header style="cursor: pointer">
                <h1 class="chat-user-name">Chat</h1>
                <span style="flex:1"></span>
                <span class="close-button">X</span>
            </header>
            <section id="message-list">
            </section>
            <footer>
                <input id="message-input" type="text" placeholder="Type a message...">
            </footer>
        </div>
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; Restaurant 2023</span>
        </div>
    </div>
    <script src="{{asset('vendor/chart.js/Chart.min.js')}}"></script>

    <!-- Page level custom scripts -->
    <script src="{{asset('js/demo/chart-area-demo.js')}}"></script>
    <script src="{{asset('js/demo/chart-pie-demo.js')}}"></script>
    <script src="{{asset('js/demo/chart-bar-demo.js')}}"></script>
</footer>

