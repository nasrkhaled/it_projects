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
       $stmt = $con->prepare('SELECT * FROM users WHERE Username=?');
       $stmt -> execute(array($sessionUser));
       $rows = $stmt->fetch();

		?>

		    <div class="my-info">
		    <div class="panel panel-primary">

		      <div class="panel-heading">
		      <?php
		       echo langs('myProfile');
		       echo $rows['GroupID']==1?langs('admin'):"";
		      ?>

		      </div>
		      <div class="panel-body">
		      	<ul class="list-unstyled">
		      		<?php if ($rows['image']!==null and $rows['image']!=""){ ?>
		      		<li>
		      			<center>
		      				<img class="img-responsive img-thumbnail img-circle"
                   src="admin/upload/img/<?php echo $rows['image']?>" alt="not-found" style='height :220px;width: 200px'/>
		      			</center>
		      		</li>
		      	    <?php } ?>
			      	<li>
                        <i class="fa fa-unlock-alt fa-fx"></i>
			      		<span><?php echo langs('username')?></span>
			      		<?php echo '  ' . $rows['Username'];?>

			      	</li>
			      	<li>
			      	    <i class="fa fa-envelope-o fa-fx"></i>
			      		<span><?php echo langs('email')?></span>
			      		<?php echo  $rows['Email'];?>
			      	</li>
			      	<li>
			      		<i class="fa fa-user fa-fx"></i>
			      		<span><?php echo langs('full_name')?></span>
			      		<?php echo ' ' .$rows['FullName'];?>
			      	</li>
			      	<li>
			      		<i class="fa fa-calendar fa-fx"></i>
			      		<span><?php echo langs('registerDate')?></span>
			      		<?php echo  $rows['Data'];?>
			      	</li>
			      	<li>
			      		<i class="fa fa-check fa-fx"></i>
			      		<span><?php echo langs('RegStatus');?> </span>
			       <?php 
			  echo $rows['RegStatus']==1?langs('approve'):langs('nonApprove');
			           ?>
			      		
			      	</li>
			      </ul>
			      <div>
				     	
				    <a class="btn btn-success pull-right" 
				    	href="editProfile.php">
				     	   <i class="fa fa-edit"></i>
				     	   <?php echo langs('editProfilebtn') ?>
				     	</a>
			            <a class="btn btn-danger pull-right" 
			               id="deleteProfile" data-toggle="modal"
			               data-target="#myModaldel"  href="#">
				          <i class="fa fa-close"></i>
				          <?php echo langs('deleteProfilebtn') ?>
				      </a>
				  </div>
		      </div>
		    </div>
		  <div  id = "my-ads" class="my-ads">
		    <div class="panel panel-primary">
		      <div class="panel-heading">
		       <?php echo langs('My_Ads') ?>
		      </div>
		      <div class="panel-body">
		      	 <?php
          $userid = $rows['UserID']; 
          $where  ='WHERE Member_ID ='. $userid;
          $items  = get_All('*', 'items' , $where , '' , 'ID' , 'DESC' );
           if (!empty($items))
           {
            foreach ($items as $item) 
            {
                         $display = $lang=='ar'?'pull-right':'pull-left';
              echo "<div class='col-sm-4 ".$display."'>";
             echo "<div class='thumbnail item-box' style='height:650px'>";

                   if($item['Approve']==0)
                       {
                        echo "<strong class='approve'>Waiting Approval From Admin</strong>";
                       }
         $Where = "WHERE ID=".$item['Cat_ID'];
         $categrioes = get_All("*",'catogories',$Where,'','ID','DESC');
         $catgName   = $categrioes[0]['Name'];
         $catgName_ar= $categrioes[0]['Name_arbaic'];
         $catgID     = $categrioes[0]['Parent'];
         $Where1     = "WHERE ID=".$catgID;
         $catgParent =  get_All("*",'catogories',$Where1,'','ID','DESC');
         $catgParentID=$catgParent[0]['ID'];
         $Where2     = "WHERE ID=".$catgParentID;
         $catgParentarr= get_All("*",'catogories',$Where2,'','ID','DESC');
         $catgParentName = $catgParentarr[0]['Name'];
         $catgParentName_ar =$catgParentarr[0]['Name_arbaic'];
         // echo $catgParentName_ar;
                // echo($categrioes[0]['Name']."saaaaaaaaaaaaaa");
              //   foreach ($favItem as $favitem)
              // {
                
              
              //      if($favitem['Item_ID']==$item['ID'])
              //   {

                   
                // }
                // else
                // {
                //    echo "<span class='star-tag' id='".$item['ID']."span'><i class='fa fa-star star' id='".$item['ID']
                //       ."spanstar' aria-hidden='true'></i>
                //         <p  id='".$item['ID']."spanp'>Add to favorite ads</p></span>";
                // }
                //}
                   echo "<img class='img_item'  src='admin/upload/img/".$item['Image']."'  alt='not_found'/>";
                   echo "<div class='caption'>";
                     echo "<h3><a href='item.php?itemid=".$item['ID']."'>".$item['Name'].
                        "</a><span style='display:none;' id='".$item['ID']."spanitemid'>".$item['ID']."</span><span style='display:none;' id='".$item['ID']."spanitemname'>".$item['Name']."</span></h3>";
                    echo "<span class='price-tag'>".$item['Price']." ج.م</span>";

                    if($item['Discussable']!=="")
                    {
                      if($lang=='ar')
                      {
                         echo "<span class='pull-left Discussable1'>".langs('Discussable')."</span>";
                      }
                      else
                      {
                         echo "<span class='pull-right Discussable1'>"
                          .langs('Discussable')."</span>";
                      }
                    }
                $maiCatg = $lang=='ar'?$catgParentName_ar:$catgParentName;
                $subCatg = $lang=='ar'?$catgName_ar:$catgName;
                $Brands = explode(",",$item['Brand']);
                $maiBrand = $lang=='ar'?$Brands[1]:$Brands[0]; 
                $mainArrow = $lang=='ar'?"<i class='arrow left'></i>"
                                        :"<i class='arrow right'></i>";  
                $city = langs('langes')[$item['Location']];
   $area = langs('Neighborhood')[$item['Location']][$item['Neighborhood']];
   $area1=empty($area)?$item['Neighborhood']:$area;

                     echo "<p class='des'><span>"
                          .$maiCatg.
                         $mainArrow.$subCatg.$mainArrow.$maiBrand
                         ."</span>";
                      
                     echo "<hr>";
                     echo "<p class='date'>".$city." - ".$area1."</p>";
                     echo "<p class='date'>".$item['Add_Date']."</p>";
                     echo "<hr>";
                     echo '<a class="btn btn-danger pull-right Delete_AD" 
			               id="'.$item['ID'].'"data-toggle="modal"
			               data-target="#Modaldel1" href="#">
				      <i class="fa fa-close"></i> '.langs('Delete')." </a>";
				    echo ' <a class="btn btn-success pull-left" 
			                href="editAd.php?do=Edit&itemid='.$item['ID']
			                .'"><i class="fa fa-edit"></i>'
			                .langs('Edit').'</a>';
                   echo "</div>";
                  echo "</div>";
                
                    echo"</div>";
            }
           }
         else  if (empty($items))
           {
            echo "<div class='alert alert-info'><h4>"
            			.langs('noAds')."</4></div>";
           }
         ?>
		      </div>
		    </div>
		 </div>
		  <div id="my-comm" class="my-comm">
		    <div class="panel panel-primary">
		      <div class="panel-heading">
		      	 <?php echo langs('My_Comments') ?>
		      </div>
		      <div class="panel-body">
		      	<?php
                $where     = "WHERE Member_ID=" . $userid ; 
                $comments  = get_All('*', 'comment', $where ,'','ID' ,'DESC' );
                 if (!empty($comments ))
                 {
                 	$pull =$lang=='ar'?'pull-left':'pull-right';
                 	foreach ($comments as $comment)
                 	 {
                 		echo "<div style='padding: 20px 0px;'><span>" 
                 		. $comment['Name']; 
                 		echo '</span><a class="btn btn-danger '.$pull
                 		.' Delete_COMM" id="'.$comment['ID'].'" data-toggle="modal"
			               data-target="#myModaldel2"  href="#">
				          <i class="fa fa-close"></i>';
				        echo langs('Delete') ;
				     
                 		echo  " </a></div><hr>";
                 	 }
                 }
                 else  if (empty($comments))
           		 {
            		 echo "<div class='alert alert-info'><h4>"
            			.langs('noComment')."</4></div>";
          		 }
                ?>
		      </div>
		    </div>
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
