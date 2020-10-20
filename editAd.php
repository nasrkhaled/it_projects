<?php
  ob_start();
  session_start();
 $itemid = isset($_GET["itemid"])&& is_numeric($_GET["itemid"])
               ? $_GET["itemid"]:$_POST['itemid'];
    if (isset($_GET['lang']))
    {
      if (($_GET['lang'])=='ar')
       {
         $pageTitle= "تعديل الاعلان";
       }
       else
       {
            $pageTitle="Edit Ad";
       }
    }
    else if (isset($_COOKIE['lang']))
      {
       if (($_COOKIE['lang'])=='ar')
       {
         $pageTitle= "تعديل الاعلان ";
       }
       else
       {
            $pageTitle="Edit Ad";
       }
      }
     
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
            
                 echo"<h2 class='text-center item_head'>"
                 .langs('Edit_Ad')."</h2>";



    if (isset($_SESSION["username"]))
  {  

       if ($_SERVER["REQUEST_METHOD"]=="POST")
         {
           // print_r($_POST);
                $infoImg          = $_FILES['img'];
                $nameImg          = $infoImg['name'];
                $sizeImg          = $infoImg['size'];
                $typeImg          = $infoImg['type'];
                $tmpImg           = $infoImg['tmp_name'];
                $ext              =explode ('.',$nameImg );
                $exTypeAllowed    = array('png','jpg','jpeg');
            $exImg            =  strtolower( end ($ext )); 

             $infoImg1          = $_FILES['avatar1'];
                $nameImg1          = $infoImg1['name'];
                $ex1               =explode('.',$nameImg1 ) ;
                $sizeImg1          = $infoImg1['size'];
                $typeImg1          = $infoImg1['type'];
                $tmpImg1           = $infoImg1['tmp_name'];
                $exTypeAllowed1    = array('png','jpg','jpeg');
                $exImg1            = strtolower(end($ex1));

                $infoImg2          = $_FILES['avatar2'];
                $nameImg2          = $infoImg2['name'];
                $ex2              =explode('.',$nameImg2 ) ;
                $sizeImg2          = $infoImg2['size'];
                $typeImg2          = $infoImg2['type'];
                $tmpImg2           = $infoImg2['tmp_name'];
                $exTypeAllowed2    = array('png','jpg','jpeg');
                $exImg2            = strtolower(end($ex2)); 

                $infoImg3          = $_FILES['avatar3'];
                $nameImg3          = $infoImg3['name'];
                $ex3               =explode('.',$nameImg3) ;
                $sizeImg3          = $infoImg3['size'];
                $typeImg3          = $infoImg3['type'];
                $tmpImg3           = $infoImg3['tmp_name'];
                $exTypeAllowed3    = array('png','jpg','jpeg');
                $exImg3            = strtolower(end($ex3));  



              $id             = $_POST["itemid"];
              $name           = $_POST["name"];
              $description    = $_POST["description"];
              $price          = $_POST["price"];
              $phone          = $_POST['phone'];
              $location       = empty($_POST["location"])?''
                                :$_POST["location"];
              $city           = empty($_POST["neighborhood"])?''
                                :$_POST["neighborhood"];                  
              $member         = $_SESSION['userid'];
              $tags           = $_POST["tags"];
              $status         = $_POST["status"];
              $categroy       = $_POST["categroy"];
              // echo $member.'sdddddddddddddddddddddddd';
              $formErrors     = array();
               //validate form
                 if(empty($name))
                 {
                    $formErrors[] = langs('title_ad').' <strong> '.langs("EMPTY").'</strong>';
                 }
                 if(empty($price))
                 {
                   $formErrors[]=langs('price_ad').' <strong> '.langs("EMPTY").'</strong>';
                 }
                 if($status=="")
                 {
                  $formErrors[] =langs('MUSTCHOOSE') . ' <strong> ' .langs('status_ad')
                       .'</strong>';
                 }
                if(empty($location) or empty($city))
                 {
                  $formErrors[] =langs('MUSTCHOOSE') . ' <strong> ' .langs('location_ad')
                       .'</strong>';
                 }
                if($categroy==0)
                 {
                  $formErrors[] =langs('MUSTCHOOSE') . ' <strong> ' .langs('catg_ad')
                       .'</strong>';
                 }
                 if(!empty($nameImg) && !in_array($exImg , $exTypeAllowed))
                 {
                  $formErrors[] =langs('AVATAREXE').' <strong> ' .langs('ALLOWED').'</strong>';
                 }

                if(!empty($nameImg1) && !in_array($exImg1 , $exTypeAllowed1))
                 {
                  $formErrors[] =langs('AVATAREXE').' <strong> ' .langs('ALLOWED').'</strong>';
                 }
                if(!empty($nameImg2) && !in_array($exImg2 , $exTypeAllowed2))
                 {
                  $formErrors[] =langs('AVATAREXE').' <strong> ' .langs('ALLOWED').'</strong>';
                 }
               if(!empty($nameImg3) && !in_array($exImg3 , $exTypeAllowed3))
                 {
                  $formErrors[] =langs('AVATAREXE').' <strong> ' .langs('ALLOWED').'</strong>';
                 }

             
                 if($sizeImg > 4194304 or $sizeImg1 > 4194304 
                    or $sizeImg2 > 4194304 or $sizeImg3 > 4194304)
                 {
                  $formErrors[] =langs('AVATARSIZE').' <strong> ' .langs('ALLOWED').'</strong>';
                 }
                 //loop into errors array and echo it
              
              if (!empty($formErrors))
              {
                 foreach ($formErrors as  $errors) 
                {
                 echo '<div class="alert alert-danger">'. $errors.'</div>';
                }
                 $theMsg='<div class="alert alert-danger">'.
                         langs('CORECTERROR').'</div>';
                  // echo $theMsg;
                 redirectHome($theMsg ,"back",1);
                    
              }
               else
              {
                $avatar  = $_POST['old_avata'];
                $avatar1 = $_POST['old_avata1'];
                $avatar2 = $_POST['old_avata2'];
                $avatar3 = $_POST['old_avata3'];
                if(!empty($nameImg))
              {
                $avatar = rand(0,1023043).'_'.$nameImg;
                // $avatar1=E;$avatar2=null;$avatar3=null;
                move_uploaded_file($tmpImg ,'admin/upload/img/'.$avatar);
              }
              if(!empty($nameImg1))
              {
                 $avatar1 = rand(0,1023043).'_'.$nameImg1;
             move_uploaded_file($tmpImg1 ,'admin/upload/img/'.$avatar1);
              }
              if(!empty($nameImg2))
              {
               
                $avatar2 = rand(0,1023043).'_'.$nameImg2;
            move_uploaded_file($tmpImg2 ,'admin/upload/img/'.$avatar2);
              }
              if(!empty($nameImg3))
              {
               
                $avatar3 = rand(0,1023043).'_'.$nameImg3;
            move_uploaded_file($tmpImg3 ,'admin/upload/img/'.$avatar3);
              }
                   //update the database with this info 
               $stmt = $con->prepare("UPDATE items SET
                                                           Name=?,
                                                           Description=?,
                                                           Price=?,
                                                           phone=?,
                                                          Location=?,
                                                          Neighborhood=?,
                                                           Tags=?,
                                                           Image=?,
                                                           Image1=?,
                                                           Image2=?,
                                                           Image3=?,
                                                           Status=?,
                                                           Cat_ID=?,
                                                           Member_ID=?
                                                         WHERE 
                                                           ID=?");
                $stmt->execute(array($name,$description,$price,$phone
                       ,$location,$city,$tags,$avatar,$avatar1,$avatar2
                              ,$avatar3,$status,$categroy,$member,$id));
                $row = $stmt->rowCount();
                  //echo message with successful update operation
                  $theMsg = "<div class = 'alert alert-success'>".langs('UPDATEDITEM')."</div>";
                 redirectHome($theMsg,"back",1);

              }
            }

 
      $stmt = $con->prepare("SELECT * FROM items where ID=?");
           //select all data from database 
      $stmt->execute(array($itemid));
         //excute query
      $items   = $stmt->fetch();
        //fetch data from database
     $count = $stmt->rowCount();
        //calc num of row count
        //if found there if show all data in form
         if ($count>0)
         {
          
                              $customclass ="";
                              if ($lang=='ar')
                              {
                                $customclass = 'search2_rtl';
                              }

                              else
                              {
                               $customclass = 'search2_ltr';
                              }
                            ?>
            <form class="form-horizontal Edit_ADD" action="?do=Update"   
                method="POST" enctype="multipart/form-data">
                 <input type="hidden" value="<?php echo $itemid;?>" 
                      name='itemid'/>
               <!--start itemname failed-->
                <div class="form-group form-group-lg">
                  <div   class="col-sm-10 ">
                   <label><?php echo langs('title_ad')?>
                      <span class='asterik-ad'>*</span>
                   </label>
                   <input type="text" 
                     name="name" class="form-control" 
                      value='<?php echo $items["Name"];?>'
                     placeholder="<?php echo langs('title_ad_place')?>"/>
                  </div>
                </div>
              <!--end itemname failed-->
              <!--start description failed-->
              <div class="form-group form-group-lg">
                  <div   class="col-sm-10 ">
                   <label><?php echo langs('des_ad')?>
                      <span class='asterik-ad'>*</span>
                   </label>
                   <input type="text" 
                     name="description" class="form-control" 
                     value='<?php echo $items["Description"];?>'
                     placeholder="<?php echo langs('des_ad_place')?>" />
                  </div>
                </div>
              <!--end description failed-->
              <!--start Price failed-->
                <div class="form-group form-group-lg">
                  <div   class="col-sm-10 ">
                  <label><?php echo langs('price_ad')?>
                     <span class='asterik-ad'>*</span>
                  </label>
                  <input type="text" 
                     name="price" class="form-control" 
                      value='<?php echo $items["Price"];?>'
                     placeholder="<?php echo langs('des_ad_place')?>"/>
                  </div>
                </div>
              <!--end price failed-->
             <!--start phone failed-->
                <div class="form-group form-group-lg">
                  <div   class="col-sm-10 ">
                  <label><?php echo langs('phone_ad');?>
                     <span class='asterik-ad'>*</span>
                  </label>
                   <input type="text" 
                     name="phone" class="form-control" 
                     value='0<?php echo $items["phone"];?>'
                     placeholder="<?php echo langs('phone_ad_place')?>" />
                  </div>
                </div>
              <!--end phone failed-->
              <!--start Location  failed-->
            <div class="form-group form-group-lg">
                  <div   class="col-sm-10 ">
                  <label>
                   <?php echo langs('location_ad')?>
                    <span class='asterik-ad'>*</span>
                  </label>
                   <div>
                      <select class="<?php echo $customclass ?>" 
                              name='location' 
                              id="citiesAd" required>
                        <option disabled selected value="0">
                            <?php echo langs('chooseCity') ?>
                        </option>
                       <?php  
                        foreach (langs('langes') as $key=>$value)
                       {
                        ?>
                        <option class='adLocation' 
                        value="<?php echo $key?>"
                        id="<?php echo $key?>">
                          <?php echo $value?></option>
                        <?php 
                        // echo "<option class='adLocation' id='".$key."'"
                        // ."vlaue='".$key."'>".$value."</option>";
                         } 

                            ?>
                         </select> 
                      
                         <select name='neighborhood'
                                 id="Neighborhood_AD" 
                                class="search <?php echo $customclass ?>" 
                                 style="display: none;"
                                 required>
                         </select>

                         <span id="Neighborhood_ADSpan"
                               style="display: none;">
                                <?php echo langs('ChooseNighborhood') ?>
                         </span>
                          <span id="Neighborhood_ADSpan1"
                               style="display: none;">
                                <?php echo langs('not_Nighborhood') ?>
                         </span>
                         <span id="Neighborhood_ADSpan2"
                               style="display: none;">
                                <?php echo langs('not1_Nighborhood') ?>
                         </span>              
                    </div>
                </div></div>
            <!--end Location   failed-->
            <!--start tags failed-->
            <div class="form-group form-group-lg">
                  <div   class="col-sm-10 ">
                   <label><?php echo langs('tag_ad')?></label>
                   <textarea 
                     name="tags" class="form-control des_add_ad"
                     value='' 
                     placeholder="<?php echo langs('tag_ad_place')?>"
                     ><?php echo $items["Tags"];?></textarea>
                  </div>
                </div>
            <!--end tags failed-->
           <!--start avatar failed-->
            <div class="form-group form-group-lg">
                  <div   class="col-sm-10 ">
                   <label><?php echo langs('ITEMAVATAR');?>
                      <span class='asterik-ad'>*</span>
                   </label>
                   <input type="file" 
                     name="img" class="form-control"/>
                  <input type="hidden" name="old_avata"
                         value="<?php echo $items["Image"];?>">
                  </div>
                </div>
            <!--end  avatar failed-->
              <!--start avatar1 failed-->
            <div class="form-group form-group-lg">
                  <div   class="col-sm-10 ">
                <label><?php echo langs('ITEMS_Sub_AVATAR')." 1 ";?></label>
                   <input type="file" 
                     name="avatar1" class="form-control" 
                  />
                  <input type="hidden" name="old_avata1"
                         value="<?php echo $items["Image1"];?>">
                  </div>
                </div>
            <!--end  avatar1 failed-->
             <!--start avatar2 failed-->
            <div class="form-group form-group-lg">
                  <div   class="col-sm-10 ">
                <label><?php echo langs('ITEMS_Sub_AVATAR')." 2 ";?></label>
                   <input type="file" 
                     name="avatar2" class="form-control" 
                     />
                    <input type="hidden" name="old_avata2"
                         value="<?php echo $items["Image2"];?>">
                  </div>
                </div>
            <!--end  avatar2 failed-->
             <!--start avatar3 failed-->
            <div class="form-group form-group-lg">
                  <div   class="col-sm-10 ">
                <label><?php echo langs('ITEMS_Sub_AVATAR')." 3 ";?></label>
                   <input type="file" 
                     name="avatar3" class="form-control" 
                    />
                    <input type="hidden" name="old_avata3"
                         value="<?php echo $items["Image3"];?>">
                  </div>
                </div>
            <!--end  avatar3 failed-->
           <!--start Status failed-->
            <div class="form-group form-group-lg">
                  <div   class="col-sm-10 ">
                  <label><?php echo langs('status_ad')?>
                     <span class='asterik-ad'>*</span>
                  </label>
                   <select name="status" class="select1" required>
                     <option value="0" disabled>....</option>
                     <option value="1"
                        <?php 
                         if ($items["Status"]==1)
                          {echo 'selected';}
                        ?>
                     > <?php echo langs('status_new')?></option>
                     <option value="2"
                        <?php 
                         if ($items["Status"]==2)
                          {echo 'selected';}
                        ?>
                     > <?php echo langs('status_likenew')?></option>
                     <option value="3"
                        <?php 
                         if ($items["Status"]==3)
                          {echo 'selected';}
                        ?>
                     ><?php echo langs('status_used')?></option>
                     <option value="4"
                       <?php 
                         if ($items["Status"]==4)
                          {echo 'selected';}
                        ?>
                     ><?php echo langs('status_old')?></option>
                   </select>
                  </div>
                </div>
              <!--end Status failed-->
              <!--start Categroy failed-->
               <div class="form-group form-group-lg">
                  <div   class="col-sm-10 ">
                  <label><?php echo langs('catg_ad')?>
                     <span class='asterik-ad'>*</span>
                  </label><br>
                   <select name="categroy" class="<?php echo $customclass ?>" required>
                     <?php
                       $allParent = get_All('*', 'catogories' ,'WHERE Parent=0' , '' ,'ID');
                        foreach (  $allParent as $parent) 
                          {
                $cagName=$lang=='ar'?$parent["Name_arbaic"]:$parent['Name'];
                            echo "<optgroup label='".$cagName."'>";
                           
                          $where = 'WHERE Parent='. $parent["ID"];
                          $allChild = get_All('*', 'catogories' ,
                                               $where , '' ,'ID');
                          foreach ($allChild as $child) 
                          {
                            if ($lang=='ar')
                             {
                             echo "<option value='".$child['ID']."'";
                              if ($items['Cat_ID']==$child['ID'])
                               {
                                echo "selected";
                               }
                        echo ">".$child['Name_arbaic'].  " [ "
                          .langs('SubCategroy_From') . $parent['Name_arbaic'] . " ]"."</option>";
                             }
                             else
                             {
                              echo "<option value='".$child['ID']."'";
                               if ($items['Cat_ID']==$child['ID'])
                               {
                                echo "selected";
                               } 
                           echo ">".$child['Name'].  " [ ".langs('SubCategroy_From'). $parent['Name'] . " ]"."</option>";

                             }
                          }
                          echo "</optgroup>";
                          }  
                    ?>
                   </select>
                  </div>
                </div>
              <!--end Categories failed-->
             <!--start button failed-->
                <div class="form-group form-group-lg">
                  <div   class=" col-sm-10">
                   <input type="submit" value="<?php echo langs("save")?>"
                      class="btn btn-primary btn-sm btn-plus" 
                      style='width: 100px;font-size: 18px;'/>
                  </div>
                </div>
             <!--end button failed-->
</form>



       <?php
        }
      else
      {
        
        $theMsg = "<div class='alert alert-danger'>". langs('NOID') ."</div>";   
        redirectHome($theMsg,"back",1);
  
      }
     
 
             echo"</div></div>";
         }
     include $tpl."footer.php";
  ob_end_flush();
 ?>
