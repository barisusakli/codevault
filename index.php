<?php

?>
<!doctype html>
<html lang=en>
<head>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/libs/shjs-0.6/sh_main.js"></script>
	<script type="text/javascript" src="js/libs/json2.min.js"></script>
	<script type="text/javascript" src="js/libs/json2.min.js"></script>
	<script type="text/javascript" data-main="js/main" src="js/libs/require.js"></script>
	<script type="text/javascript" src="js/libs/tabIndent.js"></script>
	
	<link type="text/css" rel="stylesheet" href="js/libs/shjs-0.6/sh_style.css">
	<link rel="stylesheet" type="text/css" href="css/overcast/jquery-ui-1.8.23.custom.css">
	
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/codeform.css">

	<script src="http://use.edgefonts.net/source-sans-pro.js"></script>
	<script src="http://use.edgefonts.net/source-code-pro.js"></script>
</head>

<body>
	<div id='container'>

		<div id='top-bar'>
			<div id='top-bar-content'>
				<div class="top-bar-nav">
					<a href="index.php?page=newpost">New Post</a> |
					<a href="#">Profile</a> |
					<a href="?page=about">About</a> |
					<a href="?page=faq">Faq</a>
					<input id="search" placeholder='search'/>
				</div>
				<a href="index.php" class="logo">CODEVAULT</a>
			</div>
		</div>

		<div id='content-wrapper'>
			<div id='content'>
				<div id='page-wrapper'>
					<?php
						if(isset($_GET['page'])){
							if(file_exists('php/pages/'.$_GET['page'].'.php'))
								include('php/pages/'.$_GET['page'].'.php');
							$moduled_pages = array('newpost');
							if (in_array($_GET['page'], $moduled_pages)) {
								echo "
									<script>
										require(['" . $_GET['page'] . "'], function(module) {
											module.init();
										});
									</script>
								";
							}
						}
						else if(isset($_GET['post'])) {
					?><script>
						require(['main'], function() {
							codespaz.loadPost(<?php echo $_GET['post']?>);
						});
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
				<a href="?page=legal">Legal</a> | <a href="#">Contact</a> | <a href="#">Terms</a> 
			</div>
		</div>
	</div>


</body>
</html>