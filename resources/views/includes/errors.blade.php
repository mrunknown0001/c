@if (count($errors) > 0)
    <div class="alert alert-danger top-space note">
	    <a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif