<?php
include('functions.php');
$play = $_GET['playepisode'];

?>
<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Watch DBS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">


<link rel="Shortcut Icon" href="resources/js/dragonball.ico" type="image/x-icon">
<meta name="keywords" content="">
<meta name="description" content="">

    <!-- Bootstrap starts -->
<link type="text/css" rel="stylesheet" href="resources/js/bootstrap.min.css">
<!-- Bootstrap ends -->

<!-- Jquery UI CSS Files Starts -->
<link type="text/css" rel="stylesheet" href="resources/js/jquery-ui.css">
<!-- Jquery UI CSS Files Ends -->

<!-- Main site layout and styles Starts -->
<link type="text/css" rel="stylesheet" href="./resources/js/layout.css">
<link type="text/css" rel="stylesheet" href="./resources/js/styles.css">
<!-- Main site layout and styles Ends -->
<link type="text/css" rel="stylesheet" href="./resources/js/prettify.min.css">


  <body>
      <div class="container">
        <div class="navbar-fixed-top">

<nav class="navbar navbar-default">
  <div class="container">
    <ul class="nav navbar-nav">
      <li class="active"><a href="index.php?">Home</a></li>
      <li><a href="community/">Forums</a></li>
  </div>
</nav>


    </div>
    <div class="container content">
        <div class="row status">
            <div class="span12" style="margin: 10px auto">

            <!-- Body -->
<p>
    <?php

      if (!isset($_GET['playepisode']) || empty($_GET['playepisode'])) {
		$files = glob('resources/media/*.mp4');
		natsort($files);
		/*echo "<p>This website was made for DBS - Future Trunks Arc (47-67), but we're adding them all.<br /><br />We currently have ";
		echo episodeCount();
		echo " episodes, and are actively adding more. The site is built for iOS devices but also is compatable with the Chromecast.<br/><br/>If you find something wrong with the site, please use the email link at the bottom of the page to report it.</p><p class='bg-primary'><strong>We are currently updating the site. Some episodes may be unavailable.</strong></p><hr/>";*/
          foreach ($files as $file => $value) {
            $short = substr($value, 16, -4);
            $play = $short;
			if(($short >= 1) && ($short <= 14))			{
				echo "<p class='text-justify'><strong>BOTG</strong> - Episode: ".$short." <a href='index.php?playepisode=$short'>Click Here To Play</a><br /></p>";
			} elseif(($short >= 15) && ($short <= 27))			{
				echo "<p class='text-justify'><strong>Ressurection F</strong> - Episode: ".$short." <a href='index.php?playepisode=$short'>Click Here To Play</a><br /></p>";
			} else if(($short >= 28) && ($short <= 41))			{
				echo "<p class='text-justify'><strong>Universe 6</strong> - Episode: ".$short." <a href='index.php?playepisode=$short'>Click Here To Play</a><br /></p>";
			} else if(($short >= 42) && ($short <= 46))			{
				echo "<p class='text-justify'><strong>Potaufeu</strong> - Episode: ".$short." <a href='index.php?playepisode=$short'>Click Here To Play</a><br /></p>";
			} else if(($short >= 47) && ($short <= 67))			{
				echo "<p class='text-justify'><strong>Future Trunks</strong> - Episode: ".$short." <a href='index.php?playepisode=$short'>Click Here To Play</a><br /></p>";
			} else if ($short > 67){
				echo "<p class='bg-success'><strong>Hit and Saiyaman</strong> - Episode: ".$short." <a href='index.php?playepisode=$short'>Click Here To Play</a><br /></p>";
			} else {
				echo "<p class='text-justify'>Episode: ".$short." <a href='index.php?playepisode=$short'>Click Here To Play</a><br /></p>";
			}
          }
      }
	  

      if (!empty($_GET['playepisode']) && isset($_GET['playepisode'])) {
            echo "<br /><br /><br /><video controls='' preload='auto' src='resources/media/".$play.".mp4' type='video/mp4' width='100%'></video>";
			echo "<p>". episodeSynop($play) . "</p>";

      }



    ?>
</p>
</div>
        </div>
        <div class="row">
            <hr>
            <footer>
              <div class="container">
    <div class="row">
        <div class="col-md-offset-*">
            Email Us What You Think:<a href="mailto:webmaster@teamhierro.com?subject=DBS Website Feedback" class="btn btn-link">Team Hierro Webmaster</a>
        </div>

        <div class="col-md-6">

        </div>
    </div>
    <div class="clear"></div>
    </div>


            </footer>
        </div>
    </div>
      </div>



</body></html>
