@if (Auth::check())
    <script type="text/javascript">
        window.userid = {{ Auth::user()->id }};
        window.username = "{{ Auth::user()->alias }}";
    </script>
@endif
