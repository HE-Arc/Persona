@if(Session::has('status-danger'))
    <div class="alert alert-danger">
        {{ Session::get('status-danger') }}
    </div>
@endif
@if(Session::has('status-success'))
    <div class="alert alert-success">
        {{ Session::get('status-success') }}
    </div>
@endif
