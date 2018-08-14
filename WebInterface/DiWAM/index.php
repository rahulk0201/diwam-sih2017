<?php include "/core/login.php" ?>
<html>
<head>
	<title>
		DIWAM | Digital WQ Assessment and Management
	</title>
  <link rel="shortcut icon" type="image/x-icon" href="dist/img/logo_hero" />
	<link rel="stylesheet" type="text/css" href="dist/css/home.css" media="screen" />
</head>
<body> <!--bg redundant-->
<div>
	<img class="topleft" src="dist/img/shieldlogo.png"/>
		<img class="topcenter" src="dist/img/logo_hero.png"/>
		<img class="topright" src="dist/img/sih_logo.png"/>
</div>

<br>
<br><br>

<div class="left_col">
		<!--<img src="head_img.png" width="1180px" height="220px" />-->
		<p style="font-family: Helvetica; font-size: 40; color: #000000; margin-top: 40px;">Welcome to <span style="color: #00bcd4;">DiWAM</span></p>
			<p style="font-family: Helvetica; width: 350px;font-size: 20; color: #000000; margin-top: 0px; text-align: right;"><span style="color: #00bcd4;">Di</span>gital <span style="color: #00bcd4;">W</span>ater Quality Management <span style="color: #00bcd4;">A</span>ssessment and <span style="color: #00bcd4;">M</span>onitoring</p>

</div>

	  
<div class="right_col">
  <form class="form-signin" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      <input type="text" class="form-control" placeholder="Username" required="" name="email"/>
      <br>
      <input type="password" class="form-control" placeholder="Password" required="" name="password"/>
      <button class="buttoncss_login" type="submit" name="action">Log in</button>
    <span class="error" style="color:red"><?php echo $Err; ?></span>
  </form>
</div>

</body>
</html>