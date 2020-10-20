<?php
  ob_start();
  session_start();  
  $pageTitle="Profile Page";
    include  "intial.php";
    if ($lang=='ar')
             {
               echo '<div class="container" style="direction:rtl">';
             }
             else
             {
              echo '<div class="container" style="direction:ltr">';
             }

        include "includes/temp/nav.php";

           if ($lang=='ar')
               {
                 echo "<div class='row row1 row1_ar'>";
               }
               else
               {
                echo "<div class='row row1 row1_en'>";
               }
    if (isset($_SESSION['username'])) 
      {
  
      if (isset($_POST['update']))
      {
        $name=$_POST['username'];
        $pass=sha1($_POST['pass']);
        $email = $_POST['email'];
        $fullname=$_POST['full'];
        $username = $_SESSION['username'];
        $infoImg = $_FILES['img'];
                $nameImg          = $infoImg['name'];
                $ex               =explode('.',$nameImg ) ;
                $sizeImg          = $infoImg['size'];
                $typeImg          = $infoImg['type'];
                $tmpImg           = $infoImg['tmp_name'];
                $exTypeAllowed    = array('png','jpg');
                $exImg            = strtolower(end($ex)); 
                // echo $nameImg;
        $formErrors=array();
            if(empty($name))
             {
                $formErrors[] ='username is empty';
             }

             if(strlen($name)<4)
             {
              $formErrors[] ='username must larag than 4 char';
             }

             if(strlen($name)>20)
             {
              $formErrors[] = 'username must less than 4 char';
             }

             if(empty($email))
             {
                    $formErrors[] ='email is empty';
             }

            if(empty($fullname))
             {
                 $formErrors[] =langs('FULLNAME').langs('CANNOT') 
                     .' <strong>'.langs('EMPTY').'</strong>';
             }
            if(!empty($nameImg))
              { 
              if(!in_array($exImg , $exTypeAllowed))
                 
                 {
                   $formErrors[] ='Main Avatar Extension Must Be JPG Or PNG';
                 }
           if($sizeImg > 4194304)
             {
              $formErrors[] ='Main Avatar Size Must Be Less Than 4194304';
             }
           }
           foreach ($formErrors as  $errors) {
              echo '<div class="alert alert-danger">'. $errors.'</div>';
            }
            
        if (empty($formErrors))
                { 
                  $avatar=$_POST['img1'];
             if (!empty($nameImg))
                {
                $avatar = rand(0,1023).'_'.$nameImg;
              move_uploaded_file($tmpImg ,'admin/upload/img/'.$avatar);
                }
                    
                      $stmt = $con->prepare("UPDATE users SET Username=?,Password=?,Email=? , FullName=?,image=? WHERE UserID=?");
                                $stmt->execute(array($name,$pass,$email,
                                $fullname,$avatar,$_SESSION['userid']));
                                $row = $stmt->rowCount();
                          
                                header('location:logout.php');
                                exit();
            if($stmt)
              {
                $success = langs('AdPublis');
              }
      }
    }

        $stmt1 = $con->prepare("SELECT * From users WHERE Username=?");
            $stmt1->execute(array($_SESSION['username']));
            $user= $stmt1->fetchAll();    

    ?>
  <h1 class="text-center item_head"><?php echo langs('editProfilebtn')?></h1>
       <div class="editProfile">
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST"
          enctype="multipart/form-data">
         <div class="input">
      <input class="form-control"
             type="text"
             pattern=".{3,10}"
             title="UserName Must Between 3 To 10  Characters"
             name="username"
             value="<?php echo $user[0]['Username'] ?>"
             placeholder="<?php echo langs('enteruser') ?>" 
             autocomplete="off"
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
         autocomplete="off"
         
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
   
    <div class="input">
     <input class="form-control"
           type="text"
           name="full"
           value="<?php echo $user[0]['FullName'] ?>"
           placeholder="<?php echo langs('fullname') ?>"
           />
    <div class="input">
     <input class="form-control"
           type="email"
           name="email"
           value="<?php echo $user[0]['Email'] ?>"
           placeholder="<?php echo langs('mail') ?>" 
           autocomplete="off"
        
         />
    </div>
    <div class="input">
     <input class="form-control"
           type="file"
           name="img"
           value=""
           placeholder="" 
           autocomplete="off"
           title="Add Avatar" 
         />
    <input type="hidden" name="img1"
           value="<?php echo $user[0]['image'] ?>" />
    </div>
    <input class="btn btn-success btn-block"
           type="submit"
           name="update"
           value="<?php echo langs('save')?>"
           style="font-size:18px;font-weight:bold"/>
   </form>

      </div>
      </div>
    </div>
  </div>
 <?php     
    }
    else
    {
      header('location:login.php');
      exit();
    }
  include $tpl."footer.php";
  ob_end_flush();
 ?>
