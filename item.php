<?php
  ob_start();
  session_start();  
  if (isset($_GET['lang']))
    {
      if (($_GET['lang'])=='ar')
       {
         $pageTitle= "رؤيه الإعلان";
       }
       else
       {
            $pageTitle="Show  Ad";
       }
    }
    else if (isset($_COOKIE['lang']))
      {
       if (($_COOKIE['lang'])=='ar')
       {
         $pageTitle= "رؤيه الإعلان";
       }
       else
       {
            $pageTitle="Show  Ad";
       }
      }
    include  "intial.php";
    if (isset($_GET["itemid"])&& is_numeric($_GET["itemid"]))
      {
       
         $itemid = $_GET["itemid"];
        $stmt = $con->prepare("SELECT items.*, 
                                          users.UserName As UserName
                                          FROM
                                          items
                                        INNER JOIN
                                         users
                                         ON
                                        users.UserID  = items.Member_ID
                                        WHERE ID =?
                                        AND
                                        Approve = 1
                                        ");
            $stmt->execute(array($itemid));
            $items = $stmt->fetch();
            $count = $stmt->rowCount();



              $stmt1 = $con->prepare("SELECT items.*, 
                                          users.Data As UserDate
                                          FROM
                                          items
                                        INNER JOIN
                                         users
                                         ON
                                        users.UserID  = items.Member_ID
                                        WHERE ID =?
                                        AND
                                        Approve = 1
                                        ");
            $stmt1->execute(array($itemid));
            $items1 = $stmt1->fetch();
            $count1 = $stmt1->rowCount();


            $stmt2 = $con->prepare("SELECT items.*, 
                                          users.image As UserImage
                                          FROM
                                          items
                                        INNER JOIN
                                         users
                                         ON
                                        users.UserID  = items.Member_ID
                                        WHERE ID =?
                                        AND
                                        Approve = 1
                                        ");
            $stmt2->execute(array($itemid));
            $items2 = $stmt2->fetch();
            $count2 = $stmt2->rowCount();






        //calc num of row count
      if ($count>0)
      {
               

        $where = "WHERE ID=" .$items['Cat_ID'];
$arr = get_All('*', 'catogories' ,$where,'',"ID" 
        ,"ASC");
$strCatg ; 
$parentCatg ;

  foreach ($arr as $key) {
                 $strCatg =$lang=='ar'?$key['Name_arbaic']:$key['Name'];
                 $visibility=$key['Allow_Comment'];
                 $parentCatg = $key['Parent'];
                 
               }

// echo $visibility;//Allow Comments Here Or Not!
 $WHERE = "WHERE ID=".$parentCatg;
 $categoryParent = parentCatg($WHERE);
 $categoryNameParent ;

      foreach ($categoryParent as $key) {
        $categoryNameParent =$lang=='ar'?$key['Name_arbaic']:$key['Name'];
                   }


      $date =  $items1['UserDate'];
      $date1 = $items['Add_Date'];
      $d    = date_parse_from_format("Y-m-d", $date);
      $m    =  $d["month"];
      $months = array (1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'May',6=>'Jun',7=>'Jul',8=>'Aug',9=>'Sep',10=>'Oct',11=>'Nov',12=>'Dec');
     $months_AR = array (1 => "يناير ",2 =>" فبراير ", 3 =>" مارس ",
      4 =>" أبريل ", 5 =>" مايو ", 6 =>" يونيو ", 7 =>" يوليو ",
      8 => "أغسطس" ,9 => "سبتمبر" ,10 => "أكتوبر" ,
       11 => "نوفمبر" , 12 => "ديسمبر") ;
      $month = $lang=='ar'?$months_AR[(int)$m]: $months[(int)$m];
      $year  = $d["year"];

      $d1    = date_parse_from_format("Y-m-d", $date1);
      $m1    =  $d1["month"];
      $month1 = $lang=='ar'?$months_AR[(int)$m]: $months[(int)$m];
      $year1  = $d1["year"];
      $day1   = $d1["day"];

       
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
               $pull = $lang=='ar'?'pull-left':'pull-right';
            ?>
          <!--   <div class="links filter">
              <a href="javascript:history.go(-1)" class="goBack">
              &nbsp<span class="arrow">&nbsp<&nbsp&nbsp</span>Go Back </a>
          </div> -->
                
        <h3 class="text-center item_head h1-ad">
          <?php echo $items['Name']?></h3>
          <?php $Discussable =!empty($items['Discussable'])?langs('Discussable'):''?>

              <div class="col-md-12 infoforitem">
              <div class="col-md-4">
              <h2 class='price_item'>
            <?php echo "<span>".$items['Price'].langs('EGY')
                ."</span><br><span id='price_item2'>"
                .$Discussable."</p></span>"?>
              </h2>
              <p class="item-phone"><span id="1one">01XXXXXXXXX</span>
                <span id="2two" style="display: none">0<?php echo $items['phone']?></span>
                <span id="phone" class="<?php echo $pull ?>">
                  <?php echo langs('Show_ph')?></span></p>
                <div class="safety">
                  <h4><?php echo langs('Ad_Saftey')?></h4>
                  <ol>
                    <li><?php echo langs('Ad_Saftey1')?></li>
                    <li><?php echo langs('Ad_Saftey2')?></li>
                    <li><?php echo langs('Ad_Saftey3')?></li>
                    <li><?php echo langs('Ad_Saftey4')?></li>
                  </ol>
                </div>
                <div class="personal">
                  <p> 
                    <?php if ($items2['UserImage']!==null)
                    {
                      ?>
                      <img class="img-responsive img-thumbnail img-circle"
                   src="admin/upload/img/<?php echo $items2['UserImage']?>" alt="not-found" style='height :100px;width:100px'/>
                   <?php 
                    }
                    else
                    {
                    ?>

                    <img class='img-responsive img-thumbnail img-circle' src='layout/image/1.jpg' 
                     alt='not_found' style='height :70px;width: 70px'/>

                    <?php } echo $items['UserName']?>

                  <span><?php
                    echo langs('On_Site'); 
                    echo $month . "  " . $year
                  ?>
                  </span>
                  <br>
                  <span>
                    <?php 
                    echo '<a href="userAd.php?userID='.$items['Member_ID'].'&userName='.$items['UserName'].'">'.
                    langs('User_Ads')."</a>";
                    ?>
                  </span>
                  </p>
                </div>
               </div>
              <div class="col-md-8">
                <div class="item_info">
                      <?php
                  $border=$lang=='ar'?' border-left: 1px solid #ddd;'
                  :' border-right: 1px solid #ddd;';
                  echo "<p style='".$border."'>";
                       $city = langs('langes')[$items['Location']];
 $area = langs('Neighborhood')[$items['Location']][$items['Neighborhood']];
 $area1 =empty($area)?$items['Neighborhood']:'';
                       echo $city.",".$area.$area1;
                       ?>
                      </p>
                  <p <?php echo "style='".$border."'"?>
                  class="date_item">
              <?php echo langs('AD_Add').$day1."  ".$month1."  ".$year1 ?>
                  </p>
                  <p>
                    <?php 
                      echo langs('#_AD').$items['ID'];
                    ?>
                  </p>
                </div>
                <div class="imgBox">
                  <img class="img-responsive img-thumbnail"
                   src="admin/upload/img/<?php echo $items['Image']?>" alt="not-found" style='height :450px'/>
                 </div>
                 <div class="report">
                    <!-- <a href="#" class="pull-left"><span class=""><i class="fa fa-star"></i>
                    <p>Add to favorites</p></span>
                   </a> -->
                   <center>
                   <a href="help.php">
                      <i class="fa fa-exclamation-triangle"></i>
                     <?php echo langs('ADD_REPORT')?>
                   </a>
                   </center>
                 </div>
                 <div class="items_details row">

              <?php
                if (!empty($items['Status']))
                 {
               echo "<div class='col-md-6'><p>".langs('status_ad')."</p>";
                   
                    if ($items['Status']==1)
                    {
                      echo "<span>".langs('status_new')."</span>";
                    }
                    if ($items['Status']==2)
                    {
                      echo "<span>".langs('status_likenew')."</span>";
                    }

                    if ($items['Status']==3)
                    {
                     echo "<span>".langs('status_used')."</span>";
                      }

                    if ($items['Status']==4)
                    {
                      echo "<span>".langs('status_old')."</span>";
                     }
                     echo "</div>";
                   }

                    ?>
                    <div class="col-md-6">
                        <p><?php echo langs('AD_TYPE')?></p>
                        <span><?php echo langs('SELLEING')?></span>
                   </div>
                    <div class="col-md-12">
                      <p><?php echo langs('AD_Classify')?></p>
                      <span>
                        <?php 
                        $Brands = explode(",",$items['Brand']);
                        $arrow = $lang=='ar'?
                      "<i class='arrow left' style='margin:0px 10px'></i>"
                  :"<i class='arrow right'  style='margin:0px 10px'></i>";
                        echo  $categoryNameParent.$arrow.$strCatg .$arrow;
                        echo $lang=='ar'?$Brands[1]:$Brands[0];
                        ?>
                      </span>
                    </div>
                    <div class="col-md-12">
                      <p><?php echo langs('AD_Tags')?></p>
                      <span>
                        <?php
                      $allTags = explode(',', $items['Tags']);
                         foreach ($allTags as $tag)
                          {                            
                            if (!empty($tag))
                            {
                              $tag1 = str_ireplace(" ", "_", $tag);
                              $tag1 = strtolower($tag1);
                              echo "<a href='tags.php?name={$tag1}' class='item-tag'>"
                                              .$tag."  </a>";
                            }
                            else
                            {
                              echo  "<span>".langs('NO_TAGS')."</span>";
                            }
                          }
                    ?>
                      </span>
                    </div>
                    <div class="col-md-12">
                      <?php
                      $ex  = ",";
                   $alldes = explode($ex, $items['Description']);
                      echo "<ol class='desc-items'>";
                      foreach ($alldes as  $value) {
                        echo "<li>".$value."<br></li>";
                      }
                      echo "</ol>";
                      ?>
                    </div>
                    <?php 
                      $image1 = $items['Image1'];
                      $image2 = $items['Image2'];
                      $image3 = $items['Image3'];
                    ?>
                    <div class="col-md-12">
                      <?php
                        if (!empty($image1))
                        {
                          echo "<div class='imgBox'>
                                  <img 
                                  src='admin/upload/img/".$image1
                                  ."' alt='not-found'/>
                              </div>";
                        }
                        if (!empty($image2))
                        {
                          echo "<div class='imgBox'>
                                  <img 
                                  src='admin/upload/img/".$image2
                                  ."' alt='not-found'>
                              </div>";
                        }
                        if (!empty($image3))
                        {
                          echo "<div class='imgBox'>
                                  <img 
                                  src='admin/upload/img/".$image3."' alt='not-found'>
                              </div>";
                        }
                        if (empty($image1)
                          and empty($image2) and empty($image3))
                        {
                          echo "<center><strong>".langs('imgs')
                          ."</center></strong>";
                        }
                       ?>
                       
                      </div>
                    </div>
                 </div>
                </div>
                <!-- <hr class="hr-comm"> -->
                <?php
                  if (isset($_SESSION['username']))
                  {
                    if ($visibility==0)
                  {
                 ?>
                <div class="col-md-12">
                     <div class='commentsforitem'>
                   <center><h2 class="item_head"><i class="fa fa-commenting-o"></i><?php echo langs('AD_comm')?>
                    </h2></center>
                  <div class='col-md-12 comm'>
                   <form 
                      action="<?php echo $_SERVER['PHP_SELF'].'?itemid='.$itemid;?>"
                      method="POST">
                    <textarea name="comment"
                    placeholder="<?php echo langs('AD_comm')?>" required></textarea>
                    <button class="btn btn-primary">
                     <i class="fa fa-paper-plane"></i>
                     <?php echo langs('send')?>
                   </button>
                   </form>
                    <?php
                      if ($_SERVER["REQUEST_METHOD"]=="POST")
                       {
                         if (!empty($_POST['comment']))
                         {
                          $comment =filter_var($_POST['comment'],FILTER_SANITIZE_STRING);
                          $memberid= $_SESSION['userid'];
                          $stmt = $con->prepare("INSERT comment 
                                    (Name,
                                     Status,
                                     Comment_Date,
                             Item_ID,
                                         Member_ID
                                       )
                              VALUES (:zname,
                                     0,
                                     NOW(), 
                                      :zitemid,
                                      :zmemid
                                     )");

                  $stmt->execute(array(':zname'    =>$comment,
                                       ':zitemid'  =>$itemid,
                                       ':zmemid'   =>$memberid
                                )); 
                   if($stmt)
                   {
                    echo "<div class='alert alert-success msg'>".
                          langs('Comment_ADDED')."</div>";
                   }
                         }
                         else
                         {
                           echo "<div class='alert alert-danger msg'>
                            Comment Input Must Be Not Empty.!</div>";
                         }
                       }
                    ?>
                </div>
              </div>
             </div>

               <?php
             }
             else
             {
              echo "<div><h3><center>".langs('notAvailable_Comm')
              ."</div></h3></center><br><br>";
             }
            }
            else
            {
            echo "<div class=''><center><h4><a href='login.php'>".
            langs('login_comm')."</a>".langs('login_comm1')."</h4></center></div><br><br>";
              
            }
            ?>
             
               
                          <?php
                           $stmt = $con->prepare("SELECT
                                                      comment.*,
                                                      users.UserName As UserName,
                                                      users.image As
                                                       UserImage
                                                     FROM
                                                            comment
                                                      INNER JOIN
                                                             users
                                                      ON
                                                          users.UserID = comment.Member_ID
                                                      WHERE Item_ID =?
                                                        AND Status  =1
                                                        ORDER BY ID DESC
                                               ");
                                                                                     
                           $stmt->execute(array($itemid));
                           $comments  = $stmt->fetchAll();
                           $count = $stmt->rowCount();
                             if (!$count==0)
                            {
                              echo '<center>
                              <h2 class="item_head LatestCommh3">
                                    <i class="fa fa-comments"></i>
                                  '.langs('AD_comms').'</h2></center>';
                                foreach ($comments as $comment) 
                              {
                                $src = $comment['UserImage']!==null
                                ?"admin/upload/img/".$comment['UserImage']
                                :"layout/image/1.jpg";

                              echo '<div class ="row show-comm">';
                              
                               echo '<div class="col-md-12 comm1">
                            <img src="'.$src.'" 
                            class="img-responsive img-thumbnail img-circle" alt="notfound"/><strong>'
                                   .$comment['UserName'].'</strong><p class="comments">'
                                   .$comment['Name'].'</p>';
                              echo '<span class="Comment_Date">'
                                   .$comment['Comment_Date'].'</span>';
                              echo "</div></div>";
                             
                             // echo $comment['Comment_Date'].'<br>';
                             // echo $comment['UserName'].'<br>';
                             // echo $comment['Member_ID'].'<br>';
                            }
                          }
                          else
                          {
                        echo "<div><strong><center>".langs('No_comments')
                           ."</center></strong></div><br><br><br><br>";
                          }
                          ?>
          </div>
    <?php
     }
      else
       {

        echo "<div class=' alert-danger'>Waiting Approve From Admin Or No Such Id</div></div>";
      header("refresh:1;url=index.php");
         // $theMsg =  "<div class ='row1 alert alert-danger'>
         //             No Such ID Or This Item Waiting Approval From Admin </div>";
         // redirectHome ($theMsg ,'back',3);
       }
      }
    else
    {
    echo "<div class='alert-danger'>You Must Add Page ID For This Page</div>";
      header("refresh:1;url=index.php");
    }
   echo "</div>";
  include $tpl."footer.php";
 ?>