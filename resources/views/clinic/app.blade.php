<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>{{ config('app.name', 'Laravel') }}</title>
		<!-- Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
		<link href="{{ asset('assets/css/themes/lite-purple.min.css') }}" rel="stylesheet" />
		<link href="{{ asset('assets/css/plugins/perfect-scrollbar.min.css') }}" rel="stylesheet" />
		<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

		@stack('header_css')
	</head>
	<body class="text-left">
		@yield('content')
		@if(Auth::check())
	   		<div class="app-admin-wrap layout-sidebar-large">
	   			<div class="main-header">
	   				<div class="logo">
	   					<img src="{{ asset('assets/images/logo-2.png') }}" alt="">
	   				</div>
	   				<div class="menu-toggle">
	   					<div></div>
			            <div></div>
			            <div></div>
			        </div>
			        <div class="d-flex align-items-center"></div>
			        <div style="margin: auto"></div>
			        <div class="header-part-right">
			        	<div class="dropdown">
			        		<div class="user col align-self-end">
			        			<img src="{{ asset('assets/images/faces/1.jpg') }}" id="userDropdown" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			        			<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
			        				<div class="dropdown-header">
			        					<i class="i-Lock-User mr-1"></i>
			        				</div>
			        				<a class="dropdown-item">Profile settings</a>
			        				<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> {{ __('Logout') }}</a>
			        				<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
			        					@csrf
			        				</form>
			        			</div>
			        		</div>
			        	</div>
			        </div>
			        <div class="side-content-wrap">
			        	<div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar="" data-suppress-scroll-x="true">
			        		<ul class="navigation-left">
			        			<li class="nav-item">
			        				<a class="nav-item-hold" href="{{route('dashboard')}}"><i class="nav-icon i-File-Horizontal-Text"></i><span class="nav-text">Dashboard</span></a>
			        				<div class="triangle"></div>
			        			</li>
			        		</ul>
			        	</div>
			        	<div class="sidebar-overlay"></div>
			        </div>
			    </div>
				<div class="main-content-wrap sidenav-open d-flex flex-column">
		            <div class="main-content">
		            	<div class="breadcrumb">
	                        <h1><i class="fa fa-home" style="font-size:48px;color:red"></i></h1>
		            		<ul>
		            			<li><a href="{{  route('dashboard') }}">Home</a></li>
		            			<li>{{ isset($title) ? $title :'Dashboard' }}</li>
		            		</ul>
		            	</div>
		            	<div class="separator-breadcrumb border-top"></div>

    					@yield('content-body')
	        @endif
			</div>
      	<script src="{{ asset('assets/js/plugins/jquery-3.3.1.min.js') }}"></script>
      	<script src="{{ asset('assets/js/plugins/bootstrap.bundle.min.js') }}"></script>
      	<script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
      	<script src="{{ asset('assets/js/scripts/script.min.js') }}"></script>
      	<script src="{{ asset('assets/js/scripts/sidebar.large.script.min.js') }}"></script>
      	<script src="{{ asset('assets/js/plugins/validation/jquery.validate.min.js') }}"></script>
      	<script src="{{ asset('assets/js/plugins/validation/additional-methods.js') }}"></script>
      	<script src="{{ asset('assets/js/plugins/sweetalert2.min.js') }}"></script>
      	<script src="{{ asset('assets/js/custom.js') }}"></script>
      	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      	<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
	  	@stack('footer_js')
   </body>
</html>