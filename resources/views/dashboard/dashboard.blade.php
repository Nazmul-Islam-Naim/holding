@extends('layouts.layout')
@section('title', 'Dashboard')
@section('content')
<!-- Content wrapper scroll start -->
<div class="content-wrapper-scroll">

	<!-- Content wrapper start -->
	<div class="content-wrapper">

		<!-- Row start -->
		<div class="row gutters">
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
				<a href="#" target="_blank">
					<div class="stats-tile">
						<div class="sale-icon">
							<img src="{{asset('custom/img/dashboard/workstation.gif')}}" alt="">
						</div>
						<div class="sale-details">
							<h2>{{date('d-m-Y')}}</h2>
							<p>Today</p>
						</div>
						<div class="sale-graph">
							<div id="sparklineLine5"></div>
						</div>
					</div>
				</a>
			</div>
		</div>
		<!-- Row end -->
	</div>
	<!-- Content wrapper end -->
</div>
<!-- Content wrapper scroll end -->
@endsection