<?php 
  ob_start();
  session_start();  
  $pageTitle="Login";
  if (isset($_SESSION["username"]))//check if found $_SESSION["User"]) in site
  {
  	header("location:index.php"); //convert to page dashbard.php
  }
  include  "intial.php";
   if ($_SERVER["REQUEST_METHOD"]=="POST")
   {
   	if (isset($_POST['login']))
   	{

	  	$username   = $_POST["username"];
	  	$password   = $_POST["pass"];
	  	$hashpass   = sha1($password);
	  	$remember   = isset($_POST['remember']);
        $formErrors1= array();
   
			 if (strlen($username)<3)
			 {
			 	$formErrors1[] = langs('usernameValidate');
			 }


			if (strlen($password)<4)
		    {
		   	  $formErrors1[] = langs('passwordValidate');
		    }
		   if (empty($formErrors1))
		   {
		   	//check If The User Exists In Database
			  	 $stmt = $con->prepare("SELECT UserID, Username ,Password FROM users where Username =? AND Password =?");
			      $stmt->execute(array($username , $hashpass));
			      $rows = $stmt->fetch();
			      $count = $stmt->rowCount();

			    if ($count>0)
			    {
			       $_SESSION["username"] = $username;
			       $_SESSION["userid"]   = $rows['UserID'];
			       if(isset($_POST["remember"]))
             {
             if($_POST["remember"]=='1')
                    {
                    $hour = time() + 3600;
                        setcookie('username', $username, $hour);
                         setcookie('password', $password, $hour);
                         
                    }
                }
			        header("location:index.php"); 
			          exit();
			     }
			   if ($count==0)
	           {
	             $formErrors1[] = langs('errorInUSer');
		       }
		   }
	 }
	else if (isset($_POST['signup']))
	{
		$user       = $_POST['username'];
		$pass1		= $_POST['pass'];
		$pass2      = $_POST['pass1'];
		$full       = $_POST['full'];
		$email      = $_POST['email'];
		$formErrors = array();
		if (isset($user))
		{
			$filteruser =  filter_var($user,FILTER_SANITIZE_STRING);
			 if (strlen($filteruser)<3)
			 {
			 	$formErrors[] =langs('usernameValidate');
			 }
		}  
		if (isset($pass1)&&isset($pass2))
		{
			if (strlen($pass1)>=3 && strlen($pass2)>=3)
		       {  $hashpass  = sha1($pass1);
 				  $hashpass1 = sha1($pass2);

				 if($hashpass!==$hashpass1)
				 {
				 	$formErrors[] = langs('errorInPassword');
				 }
		       }  
		    elseif (strlen($pass1)<3 && strlen($pass2)<3)
		    {
		   	  $formErrors[] = langs('passwordValidate');
		    }

	    }
	    if (isset($email))
		{
			$filteremail =  filter_var($email,FILTER_SANITIZE_EMAIL);
			 if (filter_var($filteremail,FILTER_VALIDATE_EMAIL)!=true)
			 {
			 	$formErrors[] = langs('emailValidate');
			 }
		} 		
	  if (empty($formErrors)) 
	   {

		   	  $check  = checkItemInDB("Username" , "users" , $user);
          $check1 = checkItemInDB("Email" , "users" , $email);
          // echo $check."         ".$check1;
          if($check == 0 and $check1 ==0)
           {
		   	   				   	//insert user in database
				     $stmt = $con->prepare("INSERT INTO users (Username,
				                                               Password,
				                                           	   Email,
				                                           	   FullName,
				                                           	   RegStatus,
				                                           	   Data)
				                                 VALUES (:zuser,
				                                         :zpass,
				                                         :zemail,
				                                         :zfull,
				                                          0,
				                                         now())");
				       $stmt->execute(array(':zuser'  =>$user,
				                            ':zpass'  =>sha1($pass1),
				                            ':zemail' =>$email,
				                            ':zfull'   =>$full
				                        ));
				       $success = langs('registerDone');

                }
           if ($check>0)
           {
              $formErrors[] =langs('userIsExsit');
           }
          if ($check1>0)
          {
            $formErrors[] =langs('emailIsExsit');
          }
      }
	}
  }
  if ($lang=="ar")
  {
    echo '<div class="container" style="direction: rtl;">';
  }
  else
  {
   echo '<div class="container" style="direction:ltr;">'; 
  }
 ?>

    <div class="loginPage login_form">

    <h2 class="text-center ">
            <span id="login">
              <?php echo langs('myaccount'); ?></span>
            <span>|</span>
            <span id="signup">
              <?php echo langs('newaccount'); ?></span>
    </h2>
    <!--start login form-->
   <div>
      <div class="text-center errors">
     <?php
       if (!empty($formErrors))
       {
        foreach ($formErrors as $error )
         {
          echo  "<strong>" . $error . "</strong>";

         }
       }
       if (!empty($formErrors1))
       {
        foreach ($formErrors1 as $error )
         {
          echo  "<strong>" . $error . "</strong>";
         }
       }
       if(isset($success))
       {
        echo  "<strong class='success'>" . $success . "</strong>";

       }
      // echo $check."       ".$check1;
     ?>
   </div>
 <form class="login " id="login-page" 
       action="<?php echo $_SERVER['PHP_SELF']?>"method="POST">
   <center><p><?php echo langs('welcome'); ?></p></center>
   <div class="input">
    <input class="form-control"
           type="text"
           name="username"
           <?php
           	if (isset($_COOKIE['username']))
           	{
           		echo "value='".$_COOKIE['username']."'";
           	}
           ?>
           pattern=".{3,10}"
	       title="UserName Must Between 3 To 10  Characters"
           placeholder="<?php echo langs('enteruser') ?>" 
           autocomplete="off"
           required <?php  if ($lang=="ar")
               {echo 'asterikar=asterikar';}
              ?>
         />
   </div>
   <div class="input">
    <input class="form-control"
          id="mypass"
           type="password"
           name="pass"
           onkeypress="showeyes('eye')"
            <?php
           	if (isset($_COOKIE['password']))
           	{
           		echo "value='".$_COOKIE['password']."'";
           	}
           ?>
           minlength="3"
	       maxlength="15"
           placeholder="<?php echo langs('enterpass') ?>" 
    	   autocomplete="new-password"
    	   required <?php  if ($lang=="ar")
               {echo 'asterikar=asterikar';}
              ?>
			/>
      <?php  if ($lang=="ar")
               {
                ?>
                <i class='fa fa-eye customeyear' 
                    id='eye' style='display: none;'
                    onclick='showPass("mypass")'></i>
  <?php
    }
    ?>
    <?php  if ($lang=="en")
               {
                ?>
                <i class='fa fa-eye customeyeen' 
                    id='eye' style='display: none;'
                    onclick='showPass("mypass")'></i>
          <?php
               }
    ?>
   </div>
    <div class="input checkbox_func">
    		<input type="checkbox" name="remember" id="checkbox_id"
    			 value="1">
			<label for="checkbox_id"  style="font-size: 14px;">
       <?php echo langs('remember'); ?>   
      </label> 
    </div>
    <input class="btn btn-primary btn-block" 
           type="submit"
           name="login"
           value="<?php echo langs('myaccount'); ?>"
           style="font-size: 17px;
                  font-weight: 600;"/>
    <!--end login form-->
    <!--start signup form-->
    <a href="forgetPassword.php"><?php echo langs('forget'); ?></a>
    <br><br>
    <center>
     <small><?php echo langs('use_condition1');?></small>
     <small><a href="termUs.php"><?php echo langs('terms');?></a></small>
     <small><?php echo langs('use_condition2');?></small>
    </center>
    <br>
   </form>

</div>
   <form class="signup " id="signup-page" 
         action="<?php $_SERVER['PHP_SELF']?>" method="POST">
<center><p><?php echo langs('createa_ccount');?></p></center>
      <div class="input">
	    <input class="form-control"
	           type="text"
	           pattern=".{3,10}"
	           title="UserName Must Between 3 To 10  Characters"
	           name="username"
	           placeholder="<?php echo langs('enteruser') ?>" 
	           autocomplete="off"
	           required <?php  if ($lang=="ar")
               {echo 'asterikar=asterikar';}?>

	           />
	  </div>
	 <div class="input">
      <input class="form-control"
           type="password"
        id="passtrgister"
       onkeypress="showeyes('eye1')"
 		   minlength="3"
 		   maxlength="15" 
	       name="pass"
           placeholder="<?php echo langs('enterpass') ?>" 
    	   autocomplete="new-password"
    	   required <?php  if ($lang=="ar")
               {echo 'asterikar=asterikar';}?>
    	    />
          <?php  if ($lang=="ar")
               {
                ?>
                <i class='fa fa-eye customeyear' 
                    id='eye1' style='display: none;'
                    onclick='showPass("passtrgister")'></i>
              <?php
               }
    ?>
    <?php  if ($lang=="en")
               {
              ?>
                <i class='fa fa-eye customeyeen' 
                    id='eye1' style='display: none;'
                    onclick='showPass("passtrgister")'></i>
              <?php
               }
        ?>
    </div>
   <div class="input">
     <input class="form-control"
           type="password"
           id="reenterpass"
          onkeypress="showeyes('eye2')"
	       minlength="3"
	       maxlength="15" 
           name="pass1"
           placeholder="<?php echo langs('reenterpass') ?>" 
    	   autocomplete="new-password"
    	   required <?php  if ($lang=="ar")
               {echo 'asterikar=asterikar';}?>
    	   />
         <?php  if ($lang=="ar")
               {
                ?>
                <i class='fa fa-eye customeyear' 
                    id='eye2' style='display: none;'
                    onclick='showPass("reenterpass")'></i>
               <?php
               }
    ?>
    <?php  if ($lang=="en")
               {
                ?>
                <i class='fa fa-eye customeyeen' 
                    id='eye2' style='display: none;'
                    onclick='showPass("reenterpass")'></i>
              <?php
               }
              ?>
    </div>
    <div class="input">
     <input class="form-control"
           type="text"
           name="full"
           placeholder="<?php echo langs('fullname') ?>"
           />
    <div class="input">
     <input class="form-control"
           type="email"
           name="email"
           placeholder="<?php echo langs('mail') ?>" 
    	   autocomplete="off"
    	   required  <?php  if ($lang=="ar")
               {echo 'asterikar=asterikar';}?>
    	   />
    </div>
    <input class="btn btn-success btn-block"
           type="submit"
           name="signup"
           value="<?php echo langs('createnewacount')?>"
           style="font-size:17px;font-weight:bold"/>
   </form>
   <!--end signup form-->
 </div>
<?php include $tpl."footer.php";
   ob_end_flush();
?>