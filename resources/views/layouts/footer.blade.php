<!-- Scripts -->
<script src="https://unpkg.com/vue"></script>
@if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    <script src="{{ secure_asset('js/app.js') }}"></script>
    <script src="{{ secure_asset('js/scripts.js') }}"></script>
@else
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
@endif
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
