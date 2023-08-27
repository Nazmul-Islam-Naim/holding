<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Meta -->
        <meta name="description" content="Islamic Foundation">
        <meta name="author" content="ParkerThemes">
        <link rel="shortcut icon" href="{{asset('backend/custom/img/fav.png')}}">

        <!-- Title -->
        <title>@yield('title')</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <!-- Google Font -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;500&display=swap" rel="stylesheet">


        <!-- *************
            ************ Common Css Files *************
        ************ -->
        <!-- Bootstrap css -->
        {!!Html::style('backend/custom/css/bootstrap.min.css')!!}
        
        <!-- Icomoon Font Icons css -->
        {!!Html::style('backend/custom/fonts/style.css')!!}
        <!-- Main css for green -->
        {!!Html::style('backend/custom/css/green-main.css')!!}


        <!-- *************
            ************ Vendor Css Files *************
        ************ -->

        <!-- Mega Menu -->
        {!!Html::style('backend/custom/vendor/megamenu/css/megamenu.css')!!}

        <!-- Search Filter JS -->
        {!!Html::style('backend/custom/vendor/search-filter/search-filter.css')!!}
        {!!Html::style('backend/custom/vendor/search-filter/custom-search-filter.css')!!}

        <!-- Data Tables -->
        {!!Html::style('backend/custom/vendor/datatables/dataTables.bs4.css')!!}
        {!!Html::style('backend/custom/vendor/datatables/dataTables.bs4-custom.css')!!}
        {!!Html::style('backend/custom/vendor/datatables/buttons.bs.css')!!}
        <!-- Date Range CSS -->
        {!!Html::style('backend/custom/vendor/daterange/daterange.css')!!}

        <!-- Bootstrap Select CSS -->
        {!!Html::style('backend/custom/vendor/bs-select/bs-select.css')!!}

        <!-- leaflet Select css -->
        {!!Html::style('backend/custom/leaflet/1.7.1/css/leaflet.min.css')!!}
        <!-- leaflet Select js -->
        {!!Html::script('backend/custom/leaflet/1.7.1/js/leaflet.min.js')!!}
        
		<!-- Summernote CSS -->
        {!!Html::style('backend/custom/vendor/summernote/summernote-bs4.css')!!}
        
		<!-- yajra custom CSS -->
        {!!Html::style('backend/custom/yajraTableJs/custom.css')!!}

        <!----------- print css ------------->
        <link rel="stylesheet" type="text/css" href="{{asset('backend/custom/print/print.css')}}" media="print">
            
		<!--sidebar menu active and deactive CSS -->
        {!!Html::style('backend/custom/css/sidebar.css')!!}
        
    </head>
    <?php
        $baseUrl = URL::to('/');
        $url = Request::path();
    ?>
    <body class="default-sidebar">
        <!-- Loading wrapper start -->
        <div id="loading-wrapper">
            <div class="spinner-border"></div>
        </div>
        <!-- Loading wrapper end -->

        <!-- Page wrapper start -->
        <div class="page-wrapper">
            
            <!-- Sidebar wrapper start -->
            <nav class="sidebar-wrapper">
                
                <!-- Default sidebar wrapper start -->
                <div class="default-sidebar-wrapper">

                    <!-- Sidebar brand starts -->
                    <div class="default-sidebar-brand">
                        <a href="{{URL::to('/dashboard')}}" class="logo">
                            <!-- <img src="{{asset('backend/custom/img/logo.svg')}}" alt="Admin" /> -->
                            <!-- <h5>E-Store</h5><br> -->
                            <h6>{{Auth::user()->name}}</h6>
                        </a>
                    </div>
                    <!-- Sidebar brand starts -->

                    <!-- Sidebar menu starts -->
                    <div class="defaultSidebarMenuScroll">
                        <div class="default-sidebar-menu">
                            <ul>
                                <!-------------- dashboard part ------------>
                                <li>
                                    <a href="{{$baseUrl.'/dashboard'}}"  class="{{($url=='dashboard') ? 'selectedMenue':''}}">
                                        <i class="icon-home2"></i>
                                        <span class="menu-text">Dashboard</span>
                                    </a>
                                </li>
                                <!-------------- account module part ------------>
                                <li class="default-sidebar-dropdown {{(
                                    $url==config('app.account').'/banks' || $url==config('app.account').'/banks/create' || $url==(request()->is(config('app.account').'/banks/*/edit')) ||
                                    $url==config('app.account').'/accountTypes' || $url==config('app.account').'/accountTypes/create' || $url==(request()->is(config('app.account').'/accountTypes/*/edit')) ||
                                    $url==config('app.account').'/bankAccounts' || $url==config('app.account').'/bankAccounts/create' || $url==(request()->is(config('app.account').'/bankAccounts/*/edit')) ||
                                    $url==config('app.account').'/chequeBooks' || $url==config('app.account').'/chequeBooks/create' || $url==(request()->is(config('app.account').'/chequeBooks/*/edit')) ||
                                    $url==config('app.account').'/chequeNumbers' || $url==config('app.account').'/chequeNumbers/create' || $url==(request()->is(config('app.account').'/chequeNumbers/*/edit')) ||
                                    $url==config('app.account').'/transactions') ? 'active':''}}">
                                    <a href="javascript::void(0)">
                                        <i class="icon-store_mall_directory"></i>
                                        <span class="menu-text">Account Managment</span>
                                    </a>
                                    <div class="default-sidebar-submenu">
                                        <ul>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.account').'/banks'}}" class="{{($url==config('app.account').'/banks' || $url==config('app.account').'/banks/create' || $url==(request()->is(config('app.account').'/banks/*/edit'))) ? 'current-page':''}}">Bank</a>
                                            </li>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.account').'/accountTypes'}}" class="{{($url==config('app.account').'/accountTypes' || $url==config('app.account').'/accountTypes/create' || $url==(request()->is(config('app.account').'/accountTypes/*/edit'))) ? 'current-page':''}}">Account Type</a>
                                            </li>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.account').'/bankAccounts'}}" class="{{($url==config('app.account').'/bankAccounts' || $url==config('app.account').'/bankAccounts/create' || $url==(request()->is(config('app.account').'/bankAccounts/*/edit'))) ? 'current-page':''}}">Bank Account</a>
                                            </li>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.account').'/chequeBooks'}}" class="{{($url==config('app.account').'/chequeBooks' || $url==config('app.account').'/chequeBooks/create' || $url==(request()->is(config('app.account').'/chequeBooks/*/edit'))) ? 'current-page':''}}">Cheque Book</a>
                                            </li>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.account').'/chequeNumbers'}}" class="{{($url==config('app.account').'/chequeNumbers' || $url==config('app.account').'/chequeNumbers/create' || $url==(request()->is(config('app.account').'/chequeNumbers/*/edit'))) ? 'current-page':''}}">Cheque Number</a>
                                            </li>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.account').'/transactions'}}" class="{{($url==config('app.account').'/transactions') ? 'current-page':''}}">Transactions</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <!-------------- voucher module part ------------>
                                <li class="default-sidebar-dropdown {{(
                                    $url==config('app.voucher').'/types' || $url==config('app.voucher').'/types/create' || $url==(request()->is(config('app.voucher').'/types/*/edit')) ||
                                    $url==config('app.voucher').'/subTypes' || $url==config('app.voucher').'/subTypes/create' || $url==(request()->is(config('app.voucher').'/subTypes/*/edit')) ||
                                    $url==config('app.voucher').'/vouchers' || $url==config('app.voucher').'/vouchers/create' || $url==(request()->is(config('app.voucher').'/vouchers/*/edit')) ||
                                    $url==config('app.voucher').'/transactions/receiveReport' ||
                                    $url==config('app.voucher').'/transactions/paymentReport') ? 'active':''}}">
                                    <a href="javascript::void(0)">
                                        <i class="icon-book"></i>
                                        <span class="menu-text">Voucher Managment</span>
                                    </a>
                                    <div class="default-sidebar-submenu">
                                        <ul>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.voucher').'/types'}}" class="{{($url==config('app.voucher').'/types' || $url==config('app.voucher').'/types/create' || $url==(request()->is(config('app.voucher').'/types/*/edit'))) ? 'current-page':''}}">Type</a>
                                            </li>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.voucher').'/subTypes'}}" class="{{($url==config('app.voucher').'/subTypes' || $url==config('app.voucher').'/subTypes/create' || $url==(request()->is(config('app.voucher').'/subTypes/*/edit'))) ? 'current-page':''}}">Sub Type</a>
                                            </li>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.voucher').'/vouchers'}}" class="{{($url==config('app.voucher').'/vouchers' || $url==config('app.voucher').'/vouchers/create' || $url==(request()->is(config('app.voucher').'/vouchers/*/edit'))) ? 'current-page':''}}">Voucher</a>
                                            </li>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.voucher').'/transactions/receiveReport'}}" class="{{($url==config('app.voucher').'/transactions/receiveReport') ? 'current-page':''}}">Receive Report</a>
                                            </li>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.voucher').'/transactions/paymentReport'}}" class="{{($url==config('app.voucher').'/transactions/paymentReport') ? 'current-page':''}}">Payment Report</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <!-------------- project module part ------------>
                                <li class="default-sidebar-dropdown {{(
                                    $url==config('app.project').'/projects' || $url==config('app.project').'/projects/create' || $url==(request()->is(config('app.project').'/projects/*/edit')) ||
                                    $url==config('app.project').'/projectLandPayments' || $url==(request()->is(config('app.project').'/projectLandPayments/create/*')) ||
                                    $url==config('app.project').'/projectLandPayments/report') ? 'active':''}}">
                                    <a href="javascript::void(0)">
                                        <i class="icon-layers2"></i>
                                        <span class="menu-text">Project Managment</span>
                                    </a>
                                    <div class="default-sidebar-submenu">
                                        <ul>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.project').'/projects'}}" class="{{($url==config('app.project').'/projects' || $url==config('app.project').'/projects/create' || $url==(request()->is(config('app.project').'/projects/*/edit'))) ? 'current-page':''}}">Project</a>
                                            </li>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.project').'/projectLandPayments'}}" class="{{($url==config('app.project').'/projectLandPayments' || $url==(request()->is(config('app.project').'/projectLandPayments/create/*'))) ? 'current-page':''}}">Land Payment</a>
                                            </li>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.project').'/projectLandPayments/report'}}" class="{{($url==config('app.project').'/projectLandPayments/report') ? 'current-page':''}}">Land Payment Report</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <!-------------- shareholder module part ------------>
                                <li class="default-sidebar-dropdown {{(
                                    $url==config('app.shareholder').'/shareHolders' || $url==config('app.shareholder').'/shareHolders/create' || $url==(request()->is(config('app.shareholder').'/shareHolders/*/edit'))) ? 'active':''}}">
                                    <a href="javascript::void(0)">
                                        <i class="icon-group_add"></i>
                                        <span class="menu-text">Shareholder Managment</span>
                                    </a>
                                    <div class="default-sidebar-submenu">
                                        <ul>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.shareholder').'/shareHolders'}}" class="{{($url==config('app.shareholder').'/shareHolders' || $url==config('app.shareholder').'/shareHolders/create' || $url==(request()->is(config('app.shareholder').'/shareHolders/*/edit'))) ? 'current-page':''}}">Shareholder</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <!-------------- share module part ------------>
                                <li class="default-sidebar-dropdown {{(
                                    $url==config('app.share').'/projectShares' || $url==config('app.share').'/projectShares/create' || $url==(request()->is(config('app.share').'/projectShares/*/edit')) ||
                                    $url==config('app.share').'/billTypes' || $url==config('app.share').'/billTypes/create' || $url==(request()->is(config('app.share').'/billTypes/*/edit')) ||
                                    $url==config('app.share').'/billGenerates' || $url==config('app.share').'/billGenerates/create' || $url==(request()->is(config('app.share').'/billGenerates/*/edit')) ||
                                    $url==config('app.share').'/shareCollections/report') ? 'active':''}}">
                                    <a href="javascript::void(0)">
                                        <i class="icon-call_split"></i>
                                        <span class="menu-text">Share Managment</span>
                                    </a>
                                    <div class="default-sidebar-submenu">
                                        <ul>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.share').'/projectShares'}}" class="{{($url==config('app.share').'/projectShares' || $url==config('app.share').'/projectShares/create' || $url==(request()->is(config('app.share').'/projectShares/*/edit'))) ? 'current-page':''}}">Share Distribution</a>
                                            </li>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.share').'/billTypes'}}" class="{{($url==config('app.share').'/billTypes' || $url==config('app.share').'/billTypes/create' || $url==(request()->is(config('app.share').'/billTypes/*/edit'))) ? 'current-page':''}}">Bill Type</a>
                                            </li>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.share').'/billGenerates'}}" class="{{($url==config('app.share').'/billGenerates' || $url==config('app.share').'/billGenerates/create' || $url==(request()->is(config('app.share').'/billGenerates/*/edit'))) ? 'current-page':''}}">Bill Generate</a>
                                            </li>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.share').'/shareCollections/report'}}" class="{{($url==config('app.share').'/shareCollections/report') ? 'current-page':''}}">Share Collection Report</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <!-------------- product module part ------------>
                                <li class="default-sidebar-dropdown {{(
                                    $url==config('app.product').'/productCategories' || $url==config('app.product').'/productCategories/create' || $url==(request()->is(config('app.product').'/productCategories/*/edit')) ||
                                    $url==config('app.product').'/productUnits' || $url==config('app.product').'/productUnits/create' || $url==(request()->is(config('app.product').'/productUnits/*/edit')) ||
                                    $url==config('app.product').'/productBrands' || $url==config('app.product').'/productBrands/create' || $url==(request()->is(config('app.product').'/productBrands/*/edit')) ||
                                    $url==config('app.product').'/products' || $url==config('app.product').'/products/create' || $url==(request()->is(config('app.product').'/products/*/edit')) ||
                                    $url==config('app.product').'/stocks/project' || $url==(request()->is(config('app.product').'/stocks/project/products/*')) ||
                                    $url==config('app.product').'/stocks/details/products') ? 'active':''}}">
                                    <a href="javascript::void(0)">
                                        <i class="icon-archive1"></i>
                                        <span class="menu-text">Product Managment</span>
                                    </a>
                                    <div class="default-sidebar-submenu">
                                        <ul>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.product').'/productCategories'}}" class="{{($url==config('app.product').'/productCategories' || $url==config('app.product').'/productCategories/create' || $url==(request()->is(config('app.product').'/productCategories/*/edit'))) ? 'current-page':''}}">Product Category</a>
                                            </li>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.product').'/productUnits'}}" class="{{($url==config('app.product').'/productUnits' || $url==config('app.product').'/productUnits/create' || $url==(request()->is(config('app.product').'/productUnits/*/edit'))) ? 'current-page':''}}">Product Unit</a>
                                            </li>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.product').'/productBrands'}}" class="{{($url==config('app.product').'/productBrands' || $url==config('app.product').'/productBrands/create' || $url==(request()->is(config('app.product').'/productBrands/*/edit'))) ? 'current-page':''}}">Product Brand</a>
                                            </li>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.product').'/products'}}" class="{{($url==config('app.product').'/products' || $url==config('app.product').'/products/create' || $url==(request()->is(config('app.product').'/products/*/edit'))) ? 'current-page':''}}">Product</a>
                                            </li>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.product').'/stocks/project'}}" class="{{($url==config('app.product').'/stocks/project' || $url==(request()->is(config('app.product').'/stocks/project/products/*'))) ? 'current-page':''}}">Stock Product</a>
                                            </li>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.product').'/stocks/details/products'}}" class="{{($url==config('app.product').'/stocks/details/products') ? 'current-page':''}}">Stock Details</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <!-------------- purchase module part ------------>
                                <li class="default-sidebar-dropdown {{(
                                    $url==config('app.purchase').'/localSuppliers' || $url==config('app.purchase').'/localSuppliers/create' || $url==(request()->is(config('app.purchase').'/localSuppliers/*/edit')) ||
                                    $url==config('app.purchase').'/payableSuppliers' || $url==(request()->is(config('app.purchase').'/paymentForm/*')) ||
                                    $url==config('app.purchase').'/paymentsReport' ||
                                    $url==config('app.purchase').'/paymentDueReport' ||
                                    $url==config('app.purchase').'/localPurchases' || $url==config('app.purchase').'/localPurchases/create') ? 'active':''}}">
                                    <a href="javascript::void(0)">
                                        <i class="icon-child_friendly"></i>
                                        <span class="menu-text">Purchase Managment</span>
                                    </a>
                                    <div class="default-sidebar-submenu">
                                        <ul>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.purchase').'/localSuppliers'}}" class="{{($url==config('app.purchase').'/localSuppliers' || $url==config('app.purchase').'/localSuppliers/create' || $url==(request()->is(config('app.purchase').'/localSuppliers/*/edit'))) ? 'current-page':''}}">Supplier</a>
                                            </li>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.purchase').'/payableSuppliers'}}" class="{{($url==config('app.purchase').'/payableSuppliers' || $url==(request()->is(config('app.purchase').'/paymentForm/*'))) ? 'current-page':''}}">Payable Supplier</a>
                                            </li>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.purchase').'/paymentsReport'}}" class="{{($url==config('app.purchase').'/paymentsReport') ? 'current-page':''}}">Payment Report</a>
                                            </li>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.purchase').'/paymentDueReport'}}" class="{{($url==config('app.purchase').'/paymentDueReport') ? 'current-page':''}}">Payment Due Report</a>
                                            </li>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.purchase').'/localPurchases'}}" class="{{($url==config('app.purchase').'/localPurchases' || $url==config('app.purchase').'/localPurchases/create') ? 'current-page':''}}">Purchase</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <!-------------- stock out module part ------------>
                                <li class="default-sidebar-dropdown {{(
                                    $url==config('app.product').'/stockOuts' || $url==config('app.product').'/stockOuts/create' || $url==(request()->is(config('app.product').'/stockOuts/*/edit')) ||
                                    $url==config('app.product').'/stockOuts/product/details') ? 'active':''}}">
                                    <a href="javascript::void(0)">
                                        <i class="icon-bar-chart"></i>
                                        <span class="menu-text">Stock Out Managment</span>
                                    </a>
                                    <div class="default-sidebar-submenu">
                                        <ul>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.product').'/stockOuts'}}" class="{{($url==config('app.product').'/stockOuts' || $url==config('app.product').'/stockOuts/create' || $url==(request()->is(config('app.product').'/stockOuts/*/edit'))) ? 'current-page':''}}">Stock Out</a>
                                            </li>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.product').'/stockOuts/product/details'}}" class="{{($url==config('app.product').'/stockOuts/product/details') ? 'current-page':''}}">Stock Out Details</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <!-------------- amendment module part ------------>
                                <li class="default-sidebar-dropdown {{(
                                    $url==config('app.project').'/projectLandPayments/amendment' || $url==(request()->is(config('app.project').'/projectLandPayments/*/edit')) ||
                                    $url==config('app.share').'/shareCollections/amendment' ||  $url==(request()->is(config('app.share').'/shareCollections/*/edit')) ||
                                    $url==config('app.purchase').'/localPurchaseList/amendment' || $url==(request()->is(config('app.purchase').'/localPurchaseList/*/edit'))) ? 'active':''}}">
                                    <a href="javascript::void(0)">
                                        <i class="icon-settings"></i>
                                        <span class="menu-text">Amendment</span>
                                    </a>
                                    <div class="default-sidebar-submenu">
                                        <ul>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.project').'/projectLandPayments/amendment'}}" class="{{($url==config('app.project').'/projectLandPayments/amendment' || $url==(request()->is(config('app.project').'/projectLandPayments/*/edit'))) ? 'current-page':''}}">Land Payment</a>
                                            </li>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.share').'/shareCollections/amendment'}}" class="{{($url==config('app.share').'/shareCollections/amendment' || $url==(request()->is(config('app.share').'/shareCollections/*/edit'))) ? 'current-page':''}}">Share Collection</a>
                                            </li>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.purchase').'/localPurchaseList/amendment'}}" class="{{($url==config('app.purchase').'/localPurchaseList/amendment' || $url==(request()->is(config('app.purchase').'/localPurchaseList/*/edit'))) ? 'current-page':''}}">Purchase</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <!-------------- user part ------------>
                                <li class="default-sidebar-dropdown {{(
                                    $url==config('app.user').'/user-list' || $url==config('app.user').'/user-list/create' || $url==(request()->is(config('app.user').'/user-list/*/edit')) ||
                                    $url==config('app.user').'/user-role' || $url==config('app.user').'/user-role/create' || $url==(request()->is(config('app.user').'/user-role/*/edit'))) ? 'active':''}}">
                                    <a href="javascript::void(0)">
                                        <i class="icon-user"></i>
                                        <span class="menu-text">User Management</span>
                                    </a>
                                    <div class="default-sidebar-submenu">
                                        <ul>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.user').'/user-list'}}" class="{{($url==config('app.user').'/user-list' || $url==config('app.user').'/user-list/create' || $url==(request()->is(config('app.user').'/user-list/*/edit'))) ? 'current-page':''}}">Users</a>
                                            </li>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.user').'/user-role'}}" class="{{($url==config('app.user').'/user-role' || $url==config('app.user').'/user-role/create' || $url==(request()->is(config('app.user').'/user-role/*/edit'))) ? 'current-page':''}}">Roles</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- Sidebar menu ends -->

                </div>
                <!-- Default sidebar wrapper end -->
                
            </nav>
            <!-- Sidebar wrapper end -->

            <!-- *************
                ************ Main container start *************
            ************* -->
            <div class="main-container">

                <!-- Page header starts -->
                <div class="page-header">
                    
                    <!-- Row start -->
                    <div class="row gutters">
                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-6 col-9">

                            <!-- Search container start -->
                            <div class="search-container">

                                <!-- Toggle sidebar start -->
                                <div class="toggle-sidebar" id="toggle-sidebar">
                                    <i class="icon-menu"></i>
                                </div>
                                <!-- Toggle sidebar end -->
                            </div>
                            <!-- Search container end -->

                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-3">

                            <!-- Header actions start -->
                            <ul class="header-actions">
                                <li class="dropdown">
                                    <a href="#" id="userSettings" class="user-settings" data-toggle="dropdown" aria-haspopup="true">
                                        <span class="avatar">
                                            @if (!empty(auth()->user()->avatar))
                                            <img class="profile-user-img img-responsive img-fluid" src="{{asset('storage/'.auth()->user()->avatar)}}" alt="User profile picture">
                                            @else
                                            <img class="profile-user-img img-responsive img-fluid" src="{{asset('backend/custom/images/noImage.png')}}" alt="User profile picture">
                                            @endif
                                        </span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end sm" aria-labelledby="userSettings" style="width: 21rem">
                                        <div class="header-profile-actions">
                                            <a href="{{URL::to('settings')}}"><i class="icon-lock"></i>Change Password</a> 
                                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="icon-log-out1"></i>Logout</a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <!-- Header actions end -->

                        </div>
                    </div>
                    <!-- Row end -->                    

                </div>
                <!-- Page header ends -->
                @yield('content') 
                <!-- App footer start -->
                <div class="app-footer">© BinaryIT <?php echo date('Y')?></div>
                <!-- App footer end -->
            </div>
            <!-- ************************* Main container end ************************** -->

        </div>
        <!-- Page wrapper end -->

        <!-- *************
            ************ Required JavaScript Files *************
        ************* -->
        <!-- Required jQuery first, then Bootstrap Bundle JS -->
        {!!Html::script('backend/custom/js/jquery.min.js')!!}
        {!!Html::script('backend/custom/js/bootstrap.bundle.min.js')!!}
        {!!Html::script('backend/custom/js/modernizr.js')!!}
        {!!Html::script('backend/custom/js/moment.js')!!}
        
        {!!Html::script('backend/custom/js/webcam.min.js')!!}

        <!-- *************
            ************ Vendor Js Files *************
        ************* -->
        
        <!-- Megamenu JS -->
        {!!Html::script('backend/custom/vendor/megamenu/js/megamenu.js')!!}
        {!!Html::script('backend/custom/vendor/megamenu/js/custom.js')!!}

        <!-- Slimscroll JS -->
        {!!Html::script('backend/custom/vendor/slimscroll/slimscroll.min.js')!!}
        {!!Html::script('backend/custom/vendor/slimscroll/custom-scrollbar.js')!!}

        <!-- Search Filter JS -->
        {!!Html::script('backend/custom/vendor/search-filter/search-filter.js')!!}
        {!!Html::script('backend/custom/vendor/search-filter/custom-search-filter.js')!!}

        <!-- Data Tables -->
        {!!Html::script('backend/custom/vendor/datatables/dataTables.min.js')!!}
        {!!Html::script('backend/custom/vendor/datatables/dataTables.bootstrap.min.js')!!}
        
        <!-- Custom Data tables -->
        {!!Html::script('backend/custom/vendor/datatables/custom/custom-datatables.js')!!}

        <!-- Download / CSV / Copy / Print -->
        {!!Html::script('backend/custom/vendor/datatables/buttons.min.js')!!}
        {!!Html::script('backend/custom/vendor/datatables/jszip.min.js')!!}
        {!!Html::script('backend/custom/vendor/datatables/pdfmake.min.js')!!}
        {!!Html::script('backend/custom/vendor/datatables/vfs_fonts.js')!!}
        {!!Html::script('backend/custom/vendor/datatables/html5.min.js')!!}
        {!!Html::script('backend/custom/vendor/datatables/buttons.print.min.js')!!}

        <!-- Apex Charts -->
       <!--  {!!Html::script('backend/custom/vendor/apex/apexcharts.min.js')!!}
        {!!Html::script('backend/custom/vendor/apex/examples/pie/basic-pie-graph.js')!!} -->

        <!-- Circleful Charts -->
        <!-- {!!Html::script('backend/custom/vendor/circliful/circliful.min.js')!!}
        {!!Html::script('backend/custom/vendor/circliful/circliful.custom.js')!!} -->

        <!-- Main Js Required -->
        {!!Html::script('backend/custom/js/main.js')!!}

        <!-- Date Range JS -->
        {!!Html::script('backend/custom/vendor/daterange/daterange.js')!!}
        {!!Html::script('backend/custom/vendor/daterange/custom-daterange.js')!!}

        <!-- Bootstrap Select JS -->
        {!!Html::script('backend/custom/vendor/bs-select/bs-select.min.js')!!}
        {!!Html::script('backend/custom/vendor/bs-select/bs-select-custom.js')!!}

        
        <!-- select2 -->
        {!!Html::script('backend/custom/select2/js/select2.min.js')!!}
        
		<!-- Summernote JS -->
        {!!Html::script('backend/custom/vendor/summernote/summernote-bs4.js')!!}
            
        <script type="text/javascript">
            $(document).ready(function(){
              $('.select2').select2({ width: '100%', height: '100%', placeholder: "Select", allowClear: true });
            });
        </script>

        <!-- Sweet alert -->
        {!!Html::script('backend/custom/sweetalert/sweetalert.min.js')!!}
        <script type="text/javascript">
            $('.confirmdelete').on('click', function (event) {
              event.preventDefault();
                  var $form = $(this).closest('form');
                  swal({
                      title: "Are you sure?",
                      text: $(this).attr('confirm'),
                      type: "warning",
                      icon: "warning",
                      buttons: true,
                      dangerMode: true,
                  })
                  .then((willDelete) => {
                    if (willDelete) {
                      $form.submit();
                    }
                  });
            });

            $(document).ready( function () {
              $('#dataTable').DataTable({
                "paging":   true,
                "ordering": true,
                "info":     true,
              });
            });

            function printReport() {
                //("#print_icon").hide();
                var reportTablePrint=document.getElementById("printReport");
                newWin= window.open();
                var is_chrome = Boolean(newWin.chrome);
                // var top = '<center><img src="{{URL::to("logo/logo.png")}}" width="40px" height="40px"></center>';
                //   top += '<center><h3>Baby Land Park</h3></center>';
                //   top += '<center><p style="margin-top:-10px">Address</p></center>';
                // newWin.document.write(top);
                newWin.document.write(reportTablePrint.innerHTML);
                if (is_chrome) {
                    setTimeout(function () { // wait until all resources loaded 
                    newWin.document.close(); // necessary for IE >= 10
                    newWin.focus(); // necessary for IE >= 10
                    newWin.print();  // change window to winPrint
                    newWin.close();// change window to winPrint
                    }, 250);
                }
                else {
                    newWin.document.close(); // necessary for IE >= 10
                    newWin.focus(); // necessary for IE >= 10

                    newWin.print();
                    newWin.close();
                }
            }
        </script>

        
        @stack("custom_script")  
    </body>
</html>