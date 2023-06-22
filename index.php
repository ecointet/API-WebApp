<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<!DOCTYPE HTML>
<!--
===== Web App To demonstrate tons of APIS
===== Built for demo purposes (by Postman)
===== Author: @ecointet (twitter)
-->
<?php
require "srv/data.php"; //data management

$sql = false;
  
if (getenv("DB_TYPE") && getenv("DB_TYPE") == "SQL")
  $sql = true;

$data = connect($sql);

//Core SRV
require "srv/srv.php";

//GET CUSTOMIZED COMPANY - Otherwise default values
if (isset($result))
{
	$logo = $result['logo'];
	$name = $result['name'];
	$background = $result['background'];
	$api = urldecode($result['api']);
	$option = $result['opt'];
}
else //default values
{
	$name = "Postman";
	$logo = "/images/postman/logo.png";
	$background = "/images/postman/intro.jpg";
	$api = "API-URL";
	$option = "no_option";
}
$url = "https://".$_SERVER['SERVER_NAME']."/".$name;
?>
<html>
	<head>
		<title>Web App - <?php echo $name; ?></title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<link type="image/png" sizes="96x96" rel="icon" href="images/favicon.png">
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
	<body class="is-preload">

		<!-- Header -->
			<header id="header">
				<h1><a href="<?php echo $url; ?>"><img src="<?php echo $logo; ?>" height="43px" style="margin-top:2px"/></a></h1>
				<nav>
					<ul>
						<li><a href="#intro">Home</a></li>
						<li><a href="#one">Share it!</a></li>
						<li><a href="#two">Configuration</a></li>
						<!-- <li><a href="#work">Play</a></li>
						<li><a href="#contact">Contact</a></li> -->
					</ul>
				</nav>
			</header>

		<!-- Intro -->
			<section id="intro" class="main style1 dark fullscreen">
				<div class="content">
					<header>
						<h2 id="title">Hey.</h2>
					</header>
					<p id="description">Welcome to <strong>your Web App</strong>, now you probably need some APIs to make it cool.</p>
					<footer>
					<div id="loading" style="display: none;">Fetching API data...</div>
					<img id="button01" src="images/sync.png" width="80px" onclick="GetApiResult01()"></img>
					</footer>
				</div>
			</section>

		<!-- One -->
			<section id="one" class="main style2 right dark fullscreen">
				<div class="content box style2">
					<header>
						<h2>Share it!</h2>
					</header>
					<p><?php 
					echo "<a href=".$url.">".$url."</a>";
					echo '<img src="https://chart.googleapis.com/chart?chs=500x500&cht=qr&chl='.$url.'"%2F&choe=UTF-8" width="100%">';
					?></p>
				</div>
				<a href="#two" class="button style2 down anchored">Next</a>
			</section>

		<!-- Two -->
			<section id="two" class="main style2 left dark fullscreen">
				<div class="content box style2">
					<header>
						<h2>Configuration</h2>
					</header>
					<p>
					<!-- CONFIG -->	
					
					<form action="/?save" method="post">
					<label for="company_name">Company Name</label>
					<input type="text" autocomplete="off" name="company_name" id="company_name" value="<?php echo $name; ?>">
					<span id="suggestion"></span>
					<img src="/images/config-color.png" width="25px" id="config" />
					<div id="config_advanced" style="display:none;">
						<label for="company_logo">Company Logo</label>
						<input type="text" autocomplete="off" name="company_logo"  id="company_logo" value="<?php echo $logo; ?>"><br>
						<label for="company_background">Company Background</label>
						<input type="text" autocomplete="off" name="company_background" id="company_background" value="<?php echo $background; ?>"><br>
						<label for="company_option">Bonus effects</label>
						<select name="company_option" id="company_option">
						<option value="no_option" <?php if ($option == "no_option") echo 'selected="selected"' ?>>Options (optionnal)</option>
						<option value="chatgpt_option" <?php if ($option == "chatgpt_option") echo 'selected="selected"' ?>>chatGPT</option>
						</select><hr>
					</div>
					<input type="text" autocomplete="off" name="company_api" id="company_api" value="<?php echo $api; ?>">			
					<input type="hidden" name="client_ip" id="client_ip" value="">
					<br>
					<input type="submit" value="Save">
					</form></p>
					<!-- END -->
				</div>
				<!-- <a href="#work" class="button style2 down anchored">Next</a>-->
			</section>

		<!-- Footer -->
			<footer id="footer">

				<!-- Icons -->
					<ul class="icons">
						<li><a href="#" class="icon brands fa-twitter"><span class="label">Twitter</span></a></li>
						<li><a href="#" class="icon brands fa-facebook-f"><span class="label">Facebook</span></a></li>
						<li><a href="#" class="icon brands fa-instagram"><span class="label">Instagram</span></a></li>
						<li><a href="#" class="icon brands fa-linkedin-in"><span class="label">LinkedIn</span></a></li>
						<li><a href="#" class="icon brands fa-dribbble"><span class="label">Dribbble</span></a></li>
						<li><a href="#" class="icon brands fa-pinterest"><span class="label">Pinterest</span></a></li>
					</ul>

				

			</footer>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.poptrox.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>
			<script src="assets/js/srv.js"></script>
		<!-- Plugins -->
			<script src="assets/js/typewriter.js"></script>
	</body>
</html>

<?php
if ($sql) $data -> close();
?>