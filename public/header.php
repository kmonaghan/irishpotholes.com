<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Irish Potholes</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="humans.txt">

	<!-- CSS -->
	<link href="/css/bootstrap.css" rel="stylesheet">
	<link href="/css/prettyCheckable.css" rel="stylesheet">
	<link href="/css/datepicker.css" rel="stylesheet">
	<link href="/css/fineuploader-3.3.0.css" rel="stylesheet">
	<link href="/css/bootstrap-responsive.css" rel="stylesheet">
	<link href="/css/pothole.css?v=<?php echo VERSION;?>" rel="stylesheet">
	
	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	<script src="/js/html5shiv.js"></script>
	<![endif]-->

	<!-- Fav and touch icons -->
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="/ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" href="/ico/apple-touch-icon-57-precomposed.png">
	<link rel="shortcut icon" href="/ico/favicon.png">
	</head>

	<body>
	<div id="wrap">
		<div class="navbar navbar-fixed-top">
                	<div class="navbar-inner">
                        	<div class="container">
                                	<a class="brand" href="/">Irish Potholes</a>
                                	<ul class="nav">
                    				<li><a href="/">Add</a></li>
                    				<li><a href="/potholes.php">All</a></li>
                    				<li><a href="/about.php">About</a></li>
                                	</ul>
                        	</div>
                	</div>
       		</div>
		<div id="main" class="container">
<?php
				if (isset($message) && $message)
				{
?>
				<div class="alert alert-<?php echo $type; ?>">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<?php echo $message;?>
				</div>
<?php
				}
?>
