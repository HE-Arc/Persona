<!-- Scripts -->
<script type="text/javascript">
    window.userid = {{ Auth::user()->id }};
    window.username = "{{ Auth::user()->alias }}";
</script>
<script src="https://unpkg.com/vue"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/scripts.js') }}"></script>
<script src="{{ asset('js/edit.js') }}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
