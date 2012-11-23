<?php

?>
<!doctype html>
<html lang=en>
<head>
	
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
	
	
	<script type="text/javascript" src="js/libs/shjs-0.6/sh_main.js"></script>
	<script type="text/javascript" src="js/libs/json2.min.js"></script>
		
	<script src="js/main.js"></script>
	
	<link type="text/css" rel="stylesheet" href="js/libs/shjs-0.6/sh_style.css">
	<link rel="stylesheet" type="text/css" href="css/overcast/jquery-ui-1.8.23.custom.css">
	
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/codeform.css">


</head>

<body onload="codespaz.init()">

	<div id='container'>

		<div id='top-bar'>
			<div id='top-bar-content'>
				<a href="index.php"><span class='ui-widget'>CODEVAULT</span></a>
				<a href="index.php?page=newpost">New Post</a> | <a href="#">Profile</a> | <a href="?page=about">About</a> | <a href="?page=faq">Faq</a>
				
				<input id="search" value='search'/>
			</div>
		</div>
		
		<div id='content-wrapper'>
			<div id='content'>
				<div id='page-wrapper'>
				<?php
					if(isset($_GET['page']))
						include('php/pages/'.$_GET['page'].'.php');
					else if(isset($_GET['post']))
					{?><script>
					codespaz.loadPost(<?php echo $_GET['post']?>);
					</script>
					<?php
					}
					else
						include('php/pages/landing.php');
				?>
				</div>
				
				<div id='side-bar'>

				</div>
				<div class='clear-both'></div>
			</div>
		<div>
		<div id='footer'>
			<div id='footer-content'>
				<a href="?legal.php">Legal</a> | <a href="#">Contact</a> | <a href="#">Terms</a> 
			</div>
		</div>
	</div>


</body>
</html>