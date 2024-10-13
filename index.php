<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<?php
require "srv/data.php"; //data management

$sql = false;
  
if (getenv("DB_TYPE") && getenv("DB_TYPE") == "SQL")
  $sql = true;

$data = connect($sql);

if (!$sql)
	$data_contest = connect_contest($sql);
else
	$data_contest = $data;

//Core SRV
require "srv/srv.php";

//GET CUSTOMIZED COMPANY - Otherwise default values
if (isset($result[0]))
{
	$company_id = $result[0]['_id'];
	$logo = $result[0]['logo'];
	$name = $result[0]['name'];
	$background = $result[0]['background'];
	$api = urldecode($result[0]['api']);
	$option = $result[0]['opt'];
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

require "srv/api.php"; //API MODE
?>

<!DOCTYPE HTML>

<!--
===== Congrats! This is the very first step to win the Postman Contest :)
===== 
===== Challenge #1 : register your name.
-----------------------------------
===== Method: PUT
-->

<html>
	<head>
		<title>Web App - <?php echo $name; ?></title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<link type="image/png" sizes="96x96" rel="icon" href="images/favicon.png">
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
		<link rel="stylesheet" href="assets/css/countdown.css" />
	</head>
	<body class="is-preload">

	<script>
		//CHATBOT
window.embeddedChatbotConfig = {
chatbotId: "jpUedokIOuIYj1iL4tFIF",
domain: "www.chatbase.co"
}
</script>
<script
src="https://www.chatbase.co/embed.min.js"
chatbotId="jpUedokIOuIYj1iL4tFIF"
domain="www.chatbase.co"
defer>
//END CHATBOT
</script>
		<!-- Header -->
			<header id="header">
				<h1><a href="<?php echo $url; ?>"><img src="<?php echo $logo; ?>" height="43px" style="margin-top:2px"/></a></h1>
				<nav>
					<ul>
						<li><a href="#intro">Home</a></li>
						<li><a href="#one">Share it!</a></li>
						<li><a href="#two">Configuration</a></li>
						<li><a href="#contest">Contest</a></li>
						<!-- <li><a href="#work">Play</a></li>
						<li><a href="#contact">Contact</a></li> -->
					</ul>
				</nav>

				<div align="center" class="clock-wrap" style="display:none" id="countdown">
				<div class="clock pro-0">
					<span class="count">0</span>
						</div>
					</div>
			</header>

		<!-- Intro -->
			<section id="intro" class="main style1 dark fullscreen">
				<div class="content content_contest">

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
					echo "<a href=".$url.">".$url."</a><br><br>";
					echo '<img src="https://qrcode.tec-it.com/API/QRCode?data='.$url.'"%2F&choe=UTF-8" width="100%">';
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
					<input type="hidden" name="host_url" id="host_url" value="<?php echo "https://".$_SERVER['SERVER_NAME']; ?>">
					<br>
					<input type="submit" value="Save">
					</form></p>
					<!-- END -->
				</div>
				<a href="#contest" class="button style2 down anchored">Next</a>
				<!-- <a href="#work" class="button style2 down anchored">Next</a>-->
			</section>
			

		<!-- Three (Contest) -->
		<section id="contest" class="main style1 dark fullscreen">
				<div class="content box style2">
					<header>
						<h2>Time to Play!</h2>
					</header>
					<p><a href="/?id=<?php echo $name; ?>&contest=start">|Start|</a><a href="/?id=<?php echo $name; ?>&contest=reset#contest">|Reset|</a></p>
					<div align="center"><label for="max_duration">Countdown</label>
						<input style="width:10%" type="text" autocomplete="off" name="max_duration" id="max_duration" value="60">
</div>
					<div class="content">
        			<!-- Contest Content -->
    			</div>
					<?php
					//Start Contest Mode
					if (isset($company_id))
					{
						if (isset($_GET['contest']) && $_GET['contest'] == "start")
						{
							$file = file_get_contents('./assets/tagcloud/examples/index.html', true);
							echo $file;
						}
					}
					else
						echo "> Specify a Company Name to start the contest."

					//GAME
					?>
				
				</div>
				

					<?php
					//END

					//RESET Contest
					if (isset($_GET['contest']) && $_GET['contest'] == "reset")
					{
						ResetContest($sql, $data_contest, $company_id);
					}
					?>
				</div>
				<a href="#two" class="button style2 down anchored">Next</a>
			</section>


		<!-- Footer -->
			<footer id="footer" style="height:200px">
			<div id="explore_menu" style="display:none;">
						<label for="city_explore">City's name to explore:</label>
						<input type="text" autocomplete="off" name="city_explore"  id="city_explore" value="" style="margin:15px;">
						<img src="images/go.png" width="30px" id="explore_go" style="float:right"/>
			</div>
				<!-- Icons -->
					<ul class="icons">
						<li><img src="images/explore.png" height="40px" id="explore" /></li>
						
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
			<script src="assets/js/srv.js?version=1.13"></script>
		<!-- Plugins -->
			<script src="assets/js/typewriter.js"></script>
			<script src="assets/js/countdown.js"></script>
		<!-- AUTO REFRESH -->
		<script>
		function auto_refresh() {
			return GetApiResult01();
		}

		const refresh = setInterval(auto_refresh, 10000);
	
		
		</script>

	</body>
</html>

<?php
if ($sql) $data -> close();
?>