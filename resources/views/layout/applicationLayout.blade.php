<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="GestStock">
  <meta name="author" content="Fatao">
  
  

  <title>gestStock</title>

  <!-- Bootstrap CSS -->
  <link href="{{asset('bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('bootstrap/css/bootstrap-theme.min.css')}}" rel="stylesheet">

  <link href="{{asset('bootstrap/css/bootstrap.css')}}" rel="stylesheet">
  <link href="{{asset('bootstrap/css/bootstrap-theme.css')}}" rel="stylesheet">

  <script type="text/javascript" src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('bootstrap/js/bootstrap.js')}}"></script>
  <script type="text/javascript" src="{{asset('bootstrap/js/main.js')}}"></script>
  <script type="text/javascript" src="{{asset('bootstrap/js/jquery.js')}}"></script>
  <script src="{{ asset('js/app.js') }}"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

</head>

	<body>
		<header>
			<h2><center style="color: red">GESTSTOCK</center></h2>
		</header>
		<div>
			<aside>
		        @yield('menu')
		    </aside>
		    <section id="main-content">
			    <section class="wrapper">
			       @yield('content')
		   		</section>
			</section>
		</div>
	</body>
</html>