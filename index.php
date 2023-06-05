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
require "srv/database/Store.php"; //database
$databaseDirectory = __DIR__ . "/data";
$configuration = [
	"timeout" => false
  ];
$data = new \SleekDB\Store("data_info", $databaseDirectory, $configuration);

//Core SRV
require "srv/srv.php";

//GET CUSTOMIZED COMPANY - Otherwise default values
if (isset($result))
{
	$logo = $result['logo'];
	$name = $result['name'];
	$background = $result['background'];
	$api = urldecode($result['api']);
	$option = $result['option'];
}
else //default values
{
	$name = "Postman";
	$logo = "/images/postman/logo.png";
	$background = "/images/postman/intro.svg";
	$api = "n/a";
	$option = "no_option";
}
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
				<h1><img src="<?php echo $logo; ?>" height="43px" style="margin-top:2px"/></h1>
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
					$url = $_SERVER['SERVER_NAME']."/".$name;
					echo "<a href=https://".$url." />https://".$url."</a>";
					echo '<img src="https://chart.googleapis.com/chart?chs=500x500&cht=qr&chl=https%3A%2F%2F'.$url.'"%2F&choe=UTF-8" width="100%">';
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
					<br>
					<label for="company_logo">Company Logo</label>
					<input type="text" name="company_logo"  id="company_logo" value="<?php echo $logo; ?>"><br>
					<label for="company_background">Company Background</label>
					<input type="text" name="company_background" id="company_background" value="<?php echo $background; ?>"><br>
					<label for="company_api">API</label>
					<input type="text" name="company_api" id="company_api" value="<?php echo $api; ?>"><br>
						<select name="company_option" id="company_option">
						<option value="no_option" <?php if ($option == "no_option") echo 'selected="selected"' ?>>Options (optionnal)</option>
						<option value="chatgpt_option" <?php if ($option == "chatgpt_option") echo 'selected="selected"' ?>>chatGPT</option>
						</select>
					<input type="hidden" name="client_ip" id="client_ip" value=""><br>
					<input type="submit" value="Save">
					</form></p>
					<!-- END -->
				</div>
				<!-- <a href="#work" class="button style2 down anchored">Next</a>-->
			</section>

		<!-- Work 
			<section id="work" class="main style3 primary">
				<div class="content">
					<header>
						<h2>Play with us!</h2>
						<p>Your App can be smart thanks to your APIs.</p>
					</header>

					
						<div>
							<article id="game01">
								<h3 onclick="GetApiResult01('<?php echo urlencode($api); ?>')"><img src="images/sync.png" width="80px"></h3>
								<div id="game01-result"></div>
							</article>
						</div>

				</div>
			</section>
-->
		<!-- Contact
			<section id="contact" class="main style3 secondary">
				<div class="content">
					<header>
						<h2>Say Hello.</h2>
						<p>Lorem ipsum dolor sit amet et sapien sed elementum egestas dolore condimentum.</p>
					</header>
					<div class="box">
						<form method="post" action="#">
							<div class="fields">
								<div class="field half"><input type="text" name="name" placeholder="Name" /></div>
								<div class="field half"><input type="email" name="email" placeholder="Email" /></div>
								<div class="field"><textarea name="message" placeholder="Message" rows="6"></textarea></div>
							</div>
							<ul class="actions special">
								<li><input type="submit" value="Send Message" /></li>
							</ul>
						</form>
					</div>
				</div>
			</section>
 -->
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
		<!-- Customize the Page -->
			<script src="assets/js/srv.js"></script>
	</body>
</html>