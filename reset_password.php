<?php
if (isset($_GET['username'])and isset($_GET['auth']))
{
 ob_start();
  session_start(); 
  include  "intial.php";
  $user = $_GET['username'];
  $pass = $_GET['auth'];

	if(isset($_POST["reset-password"])) {
		$newPass = sha1($_POST['member_password']);
		 $stmt = $con->prepare("UPDATE users SET Password=?
                                       WHERE Username=? AND Password=?");
             $stmt->execute(array($newPass,$user,$pass));
             $row = $stmt->rowCount();
          if ($row < 1)
          {
         echo "<div class='container alert alert-danger'>error in your reset password link,try again... </div>";
                 header("Refresh:5;url=forgetPassword.php"); 
          }
         else
         {
         	  echo "<div class='container alert alert-success'>password changed successfully... </div>";
                 header("Refresh:5;url=login.php"); 
          }
         
	}
?>
<script>
function validate_password_reset() {
	if((document.getElementById("member_password").value == "") && (document.getElementById("confirm_password").value == "")) {
		document.getElementById("validation-message").innerHTML = "Please enter new password!"
		document.getElementById("validation-message").className+= "alert alert-danger";
		return false;
	}
	if(document.getElementById("member_password").value  != document.getElementById("confirm_password").value) {
		document.getElementById("validation-message").innerHTML = "Both password should be same!"
		document.getElementById("validation-message").className+= "alert alert-danger";
		return false;
	}
	
	return true;
}
</script>
<div class="container " 
style="direction: <?php echo $lang=='ar'?'rtl':'ltr'?>" >
    <div class="loginPage login_form">

    <h2 class="text-center "><?php echo langs('changePass')?></h2>

<form class="login " name="frmReset" id="frmReset" method="post" onSubmit="return validate_password_reset();">
	
	<div class="success_message"></div>
	

	<div class="field-group">
		<div><label for="Password">
			<?php echo langs('enterpass') ?></label></div>
		<div class="input">
		<input  type="password"  minlength="3"
 		   maxlength="15" name="member_password" id="member_password" class="input-field form-control"
		required <?php  if ($lang=="ar")
               {echo 'asterikar=asterikar';}?>>
             <?php  if ($lang=="ar")
               {
                ?>
                <i class='fa fa-eye customeyear' 
                    id='eye2' style=''
                    onclick='showPass("member_password")'></i>
               <?php
               }
    ?>
    <?php  if ($lang=="en")
               {
                ?>
                <i class='fa fa-eye customeyeen' 
                    id='eye2' style=''
                    onclick='showPass("member_password")'></i>
              <?php
               }
              ?></div>
	</div>
	
	<div class="field-group">
		<div><label for="email">
			<?php echo langs('reenterpass') ?></label></div>
		<div class="input"><input type="password"  minlength="3"
 		   maxlength="15"
 		   name="confirm_password" id="confirm_password" class="input-field form-control"
			required <?php  if ($lang=="ar")
               {echo 'asterikar=asterikar';}?>>
                 <?php  if ($lang=="ar")
               {
                ?>
                <i class='fa fa-eye customeyear' 
                    id='eye2' style=''
                    onclick='showPass("confirm_password")'></i>
               <?php
               }
    ?>
    <?php  if ($lang=="en")
               {
                ?>
                <i class='fa fa-eye customeyeen' 
                    id='eye2' style=''
                    onclick='showPass("confirm_password")'></i>
              <?php
               }
              ?>
           </div>
	</div>
	
	<div class="field-group">
		<div><input type="submit" name="reset-password" id="reset-password" value="<?php echo langs('save')?>" 
			class="form-submit-button"
			style="background:#33a0ff;
    				padding: 5px;
    				color: #fff;
    				font-size: 18px;
            border:1px solid #ddd"
			></div>
	</div>	
</form>
<div id="validation-message" class="">
	</div>
</div>
<?php
}
else
{
 header("location:login.php"); 
}
 include $tpl."footer.php";
   ob_end_flush();
   ?>