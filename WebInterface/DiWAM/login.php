<?php include "core/login.php" ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>DIWAM | Digital WQ Assessment and Management</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- Material Design -->
  <link rel="stylesheet" href="dist/css/bootstrap-material-design.min.css">
  <link rel="stylesheet" href="dist/css/ripples.min.css">
  <link rel="stylesheet" href="dist/css/MaterialAdminLTE.min.css">
  <!-- AdminLTE Skins. We have chosen the skin-black for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect. -->
  <link rel="stylesheet" href="dist/css/skins/skin-black.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style type="text/css">
    body{
        margin: 0px;
        padding: 0px;
        background-color: #4AD5E5;
    }
    #box{
        height: 200px;
        width: 1000px;
        background-color:#2D2D2D;
        border-radius: 5px;
        position: absolute;
        top:50%;
        left: 50%;
        transform: translate(-50%,-50%);
    }
    #main{
        height: 400px;
        width: 450px;
        background-color:white;
        border-radius: 5px;
        position: absolute;
        top:50%;
        left: 70%;
        transform: translate(-50%,-50%);
        z-index: 99;
    }
    #loginform,#signupform{
        position: absolute;
        top:50%;
        left: 70%;
        transform: translate(-50%,-50%);
        z-index: 999;
    }
    #signupform{
        top:45%;
        left: 75%;
        visibility: hidden;
    }
    #loginform h1,#signupform h1{
        font-family: arial;
        font-size: 25px;
        color:#4AD5E5;
    }
    #loginform input,#signupform input{
        height: 40px;
        width: 300px;
        border: 0px;
        outline: none;
        border-bottom: 1px solid black;
        margin: 5px;
    }
    #loginform button,#signupform button{
        height: 35px;
        width: 130px;
        background-color:#4AD5E5;
        font-family: monospace;
        font-size: 16px;
        color:white;
        border: none;
        outline: none;
        border-radius: 5px;
        margin-top: 30px;
        margin-left: 175px;
    }
    #login_btn,#signup_btn{
        height: 35px;
        width: 120px;
        background-color:transparent;
        color:white;
        border:1px solid white;
        border-radius: 5px;
        outline: none;
        position: absolute;
        left: 75%;
        top:65%;
        transform: translate(-50%,-50%);
        transition: all .5s;
    }
    #signup_btn{
        left: 25%;
    }
    #login_btn:hover,#signup_btn:hover{
        background-color:white;
        color:#2d2d2d;
        cursor: pointer;
    }
    #login_msg,#signup_msg{
        font-family: arial;
        font-size: 25px;
        color:white;
        position: absolute;
        top:35%;
        left: 75%;
        transform: translate(-50%,-50%);
        z-index: 1;
    }
    #signup_msg{
        left: 25%;
    }
  </style>
</head>

<body>
  <div id="box">
      <div id="main"></div>
      <form name="login" id="loginform" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
          <h1><b>DiWAM</b> - LOGIN</h1>
          <input type="email" name="email" placeholder="Email"/><br>
          <input type="password" name="password" placeholder="Password"/><br>
          <?php echo $Err; ?>
          <button type="submit" onclick="validate()">LOGIN</button>
      </form>
      
      <div id="signupform"> 
          <h1>SIGN UP</h1>
          <input type="text" placeholder="First Name"/><br>
          <input type="text" placeholder="Last Name"/><br>
          <input type="email" placeholder="Email"/><br>
          <input type="password" placeholder="Password"/><br>
          <button type="submit">SIGN UP</button>
      </div>
      
      <div id="login_msg">Have an account?</div>
      <div id="signup_msg">Don't have an account?</div>
      
      <button id="login_btn">LOGIN</button>
      <button id="signup_btn">SIGN UP</button>
  </div>
</div>
<!-- /.login-box -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Material Design -->
<script src="dist/js/material.min.js"></script>
<script src="dist/js/ripples.min.js"></script>
<script>
    $.material.init();
</script>
<script type="text/javascript">
  $(document).ready(function(){
      $("#signup_btn").click(function(){
          $("#main").animate({left:"22.5%"},400); 
          $("#main").animate({left:"30%"},500); 
          $("#loginform").css("visibility","hidden");
          $("#loginform").animate({left:"25%"},400);
          
          $("#signupform").animate({left:"17%"},400);
          $("#signupform").animate({left:"30%"},500);
          $("#signupform").css("visibility","visible");
      }); 
      
      $("#login_btn").click(function(){
          $("#main").animate({left:"77.5%"},400); 
          $("#main").animate({left:"70%"},500);
          $("#signupform").css("visibility","hidden");
          $("#signupform").animate({left:"75%"},400);
          
          $("#loginform").animate({left:"83.5%"},400);
          $("#loginform").animate({left:"70%"},500);
          $("#loginform").css("visibility","visible");
      });
  });
</script>
<!-- iCheck -->
<!-- <script src="../../plugins/iCheck/icheck.min.js"></script> 
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });-->
</script>
</body>
</html>
