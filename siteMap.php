<?php 
  ob_start();
  session_start();  
  $pageTitle="Site Map";
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
                 echo "<div class='row row1 row1_ar' style='padding-bottom:40px;'>";
               }
               else
               {
                echo "<div class='row row1 row1_en' style='padding-bottom:40px;'>";
               }
 ?>
    
     	<center>
     		<h3 class="item_head"><?php echo langs('siteMap') ?></h3>
        </center>
        <?php 
        $stmt = $con->prepare("SELECT * FROM catogories WHERE Parent=0");
              $stmt ->execute(); 
              $rows = $stmt->fetchAll();
              foreach ($rows as $row) {
              $stmt1 = $con->prepare("SELECT * FROM catogories WHERE Parent!=0");
              $stmt1->execute(); 
              $rows1 = $stmt1->fetchAll();
                $catgName = $lang=='ar'?$row['Name_arbaic']:$row['Name'];
                echo "<div class='col-sm-4'>";
                echo "<h3><a class='anchor'><span><i class='fa ".$row['icon']."'></i>  </span>".$catgName."</a></h3>";
                 foreach ($rows1 as $row1) {
                  $subCatg  =$lang=='ar'?$row1['Name_arbaic']:$row1['Name'];
                  if ($row['ID']==$row1['Parent'])
                  {
                  echo"<h5><a class='anchor ' href='categories.php?catgid="
                  .$row1['ID']."&pageid=".$row1['ID']."&pagename=".str_replace(" ","_",$row1['Name'])."'>"
                  .$subCatg."</a></h5>";
                }
                }
                echo "</div>";
              }
        ?>

   </div>
</div>
<?php include $tpl."footer.php";
   ob_end_flush();
?>