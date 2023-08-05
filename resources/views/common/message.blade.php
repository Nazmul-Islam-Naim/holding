@if(Session::has('flash_message'))
  	<div class="alert alert-{{ session('status_color')!=null?session('status_color'):'warning' }} alert-dismissible fade show" role="alert">
		{!! session('flash_message') !!}
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>
@endif

@if ($errors->any())
    @foreach ($errors->all() as $error)
		<div class="alert alert-{{ session('status_color')!=null?session('status_color'):'warning' }} alert-dismissible fade show" role="alert">
			{{$error}}
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
    @endforeach

@endif