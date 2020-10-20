<?php 
  ob_start();
  session_start();  
  $pageTitle="Forget Password";
  if (isset($_SESSION["username"]))//check if found $_SESSION["User"]) in site
  {
  	header("location:index.php"); //convert to page dashbard.php
  }
  include  "intial.php";
  ?>
  	<div class="container ">
    <div class="loginPage login_form">

    <h2 class="text-center "><?php echo langs('frogetPass')?></h2>
          
    <form  class="login " method="post" action="send_link.php">

      <div class="input">
      <input class="form-control" type="email" name="email"
           required <?php  if ($lang=="ar")
               {echo 'asterikar=asterikar';}
              ?>
       placeholder="<?php echo langs('restLink') ?>"
       title="Enter Valid Email Address"
       style="direction: <?php echo $lang='ar'?'rtl':'ltr'?>">
      </div>
      <input style="background:#33a0ff;
    				padding: 4px;
    				color: #fff;
    				font-size: 17px; 
            border:1px solid #ddd"
    		type="submit" name="submit_email"
    		value="<?php echo langs('restPassword') ?>"
    		>
    </form>
   </div>
<?php include $tpl."footer.php";
   ob_end_flush();
?>
