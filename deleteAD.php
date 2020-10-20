<?php
  ob_start();
  session_start();  
  $pageTitle="Delete Ad";
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
                 echo "<div class='row row1 row1_ar' style='height:500px'>";
               }
               else
               {
                echo "<div class='row row1 row1_en' style='height:500px'>";
               }
   $itemid = $_GET['ID_AD'];
   $check  = checkItemInDB("ID","items" , $itemid);
             if ($check > 0)
             {
                     $stmt = $con->prepare("DELETE FROM items 
                                                 WHERE ID = :zitemid");
                     $stmt->bindParam(":zitemid",$itemid);
                     $stmt->execute();
                      echo "<div class='alert alert-success'>"
                           .langs('DELETEDITEM')."</div>";
                      header("refresh:3;url=profile.php");
                
               }
             else
             {
                      echo "<div class='alert alert-danger'>".langs('NOID')."</div>";    
                      header("refresh:1;url=profile.php");    
                     
             }
           echo "</div></div>";
     include $tpl."footer.php";
  ob_end_flush();
 ?>
