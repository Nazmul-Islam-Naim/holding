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
				<a href="{{route('projects.index')}}" target="_blank">
					<div class="stats-tile">
						<div class="sale-icon">
							<img src="{{asset('custom/img/dashboard/project.gif')}}" alt="">
						</div>
						<div class="sale-details">
							<h4>{{$projects}}</h4>
							<p>Projects</p>
						</div>
						<div class="sale-graph">
							<div id="sparklineLine5"></div>
						</div>
					</div>
				</a>
			</div>
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
				<a href="{{route('shareHolders.index')}}" target="_blank">
					<div class="stats-tile">
						<div class="sale-icon">
							<img src="{{asset('custom/img/dashboard/shareholder.gif')}}" alt="">
						</div>
						<div class="sale-details">
							<h4>{{$sharholders}}</h4>
							<p>Shareholders</p>
						</div>
						<div class="sale-graph">
							<div id="sparklineLine5"></div>
						</div>
					</div>
				</a>
			</div>
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
				<a href="{{route('projects.index')}}" target="_blank">
					<div class="stats-tile">
						<div class="sale-icon">
							<img src="{{asset('custom/img/dashboard/share.gif')}}" alt="">
						</div>
						<div class="sale-details">
							<h4>{{$shares}}</h4>
							<p>Total Share</p>
						</div>
						<div class="sale-graph">
							<div id="sparklineLine5"></div>
						</div>
					</div>
				</a>
			</div>
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
				<a href="{{route('projectShares.index')}}" target="_blank">
					<div class="stats-tile">
						<div class="sale-icon">
							<img src="{{asset('custom/img/dashboard/share.gif')}}" alt="">
						</div>
						<div class="sale-details">
							<h4>{{$projectShares}}</h4>
							<p>Distrubuted Share</p>
						</div>
						<div class="sale-graph">
							<div id="sparklineLine5"></div>
						</div>
					</div>
				</a>
			</div>
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
				<a href="{{route('products.index')}}" target="_blank">
					<div class="stats-tile">
						<div class="sale-icon">
							<img src="{{asset('custom/img/dashboard/product.gif')}}" alt="">
						</div>
						<div class="sale-details">
							<h4>{{$products}}</h4>
							<p>Products</p>
						</div>
						<div class="sale-graph">
							<div id="sparklineLine5"></div>
						</div>
					</div>
				</a>
			</div>
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
				<a href="{{route('stocks.project')}}" target="_blank">
					<div class="stats-tile">
						<div class="sale-icon">
							<img src="{{asset('custom/img/dashboard/stock.gif')}}" alt="">
						</div>
						<div class="sale-details">
							<h4>{{number_format($stocks,2)}}</h4>
							<p>Available Stock</p>
						</div>
						<div class="sale-graph">
							<div id="sparklineLine5"></div>
						</div>
					</div>
				</a>
			</div>
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
				<a href="{{route('projectShares.report')}}" target="_blank">
					<div class="stats-tile">
						<div class="sale-icon">
							<img src="{{asset('custom/img/dashboard/bill.gif')}}" alt="">
						</div>
						<div class="sale-details">
							<h4>{{number_format($shareBills,2)}}</h4>
							<p>Share Bills</p>
						</div>
						<div class="sale-graph">
							<div id="sparklineLine5"></div>
						</div>
					</div>
				</a>
			</div>
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
				<a href="{{route('projectShares.report')}}" target="_blank">
					<div class="stats-tile">
						<div class="sale-icon">
							<img src="{{asset('custom/img/dashboard/collection.gif')}}" alt="">
						</div>
						<div class="sale-details">
							<h4>{{number_format($shareCollecitons,2)}}</h4>
							<p>Share Collections</p>
						</div>
						<div class="sale-graph">
							<div id="sparklineLine5"></div>
						</div>
					</div>
				</a>
			</div>
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
				<a href="{{route('projectShares.report')}}" target="_blank">
					<div class="stats-tile">
						<div class="sale-icon">
							<img src="{{asset('custom/img/dashboard/bill.gif')}}" alt="">
						</div>
						<div class="sale-details">
							<h4>{{number_format($shareDues,2)}}</h4>
							<p>Share Dues</p>
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