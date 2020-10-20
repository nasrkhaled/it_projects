<?php
 ob_start();
  session_start();
  //error_reporting(E_ALL ^ E_WARNING); 
//error_reporting(0); 
  $pageTitle=str_replace('_',' ',$_GET['pagename']);
    include  "intial.php";
   // print_r($_POST);
 if(isset($_GET["pageid"]) && is_numeric($_GET["pageid"]))
   {
   
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
            
              $catid = $_GET["pageid"]; 
              $where = "where Cat_ID =". $_GET['pageid'] ;
              $brand = "" ;
              $status= "" ;
              $orderBy = "";
              $orderFailed ="ID";
              $orderWay = "DESC";
              if($_POST['brandsOption']!=-1)
              {
                $brand = $_POST['brandsOption'];
              }
              if ($_POST['status']!=-1)
              {
                 $status = $_POST['status'];
              }
              if ($_POST['orderBy']!=-1)
              {
                $orderBy = $_POST['orderBy'];
                if ($orderBy=="recent")
                {
                 $orderFailed ="ID";
                 $orderWay ="DESC";
                }
                if ($orderBy=="least")
                {
                   $orderFailed ="Price";
                   $orderWay ="ASC";
                }
                 if ($orderBy=="highest")
                {
                   $orderFailed ="Price";
                   $orderWay ="DESC";
                }
              }
              
            $ANDALL = "";
            $and1   = "";
            $and2   = ""; 
            $and3   = " AND Approve=1 ";
      if($_POST['brandsOption'] != -1 and !empty($_POST['brandsOption']))
            {
              $and1 = " AND Brand LIKE '%$brand%'  ";
            }
     if($_POST['status']!= -1 and !empty($_POST['status']))
            {
              $and2 = " AND Status=".$status." ";
            }
            $ANDALL = $and1.$and2.$and3;
            // echo $ANDALL;
           // echo $and1." ".$and2." ".$orderFailed." ".$orderWay;
     $items = get_All("*",'items',$where,$ANDALL,$orderFailed,$orderWay);
     $WHERE1 = "WHERE ID=".$_GET['pageid'];
     $categrioes = get_All("*",'catogories',$WHERE1,'','ID','DESC');
     $BrandsType = $lang=='ar'?'Brands_arbaic':'Brands';
     $BrandsArr  = explode(",",$categrioes[0][$BrandsType]);
     
       // echo $myBrand;
      // print_r($_GET);
               if (!empty($items))
               {
           $dir ;
           $dir1;
           if ($lang == 'en')
           {
            
            $dir = 'pull-left';
            $dir1 = "pull-right";
           }
            if ($lang == 'ar')
           {
          
             $dir = 'pull-right';
             $dir1 = "pull-left";
           }
               
                echo "<div class='col-sm-12 filter'>
                  <form action='' method='POST'>";
                  // echo  count($BrandsArr);
                  if (count($BrandsArr)!==1)
                 {
                     echo "<div class='col-sm-4 ".$dir."'>
                      <select name='brandsOption'>
                      <option value='-1'>".langs('TypeADS')."</option>";
                  foreach ($BrandsArr as $brand ) {
                    echo "<option value='".$brand."'";
                    if($myBrand==$brand)
                    {
                    echo "selected";
                  }
                  echo ">".$brand."</option>";
                }
                echo "</select></div>";
              }
                      echo '<div class="col-sm-3 '.$dir.'">';?>
                     <select name="status" required>
                  <option value="-1">
                    <?php echo langs('Status_ADS')?></option>
                           <option value="1" <?php 
                           if($myStatus==1)
                              {
                                echo "selected";
                              }?>>
                              <?php echo langs('status_new')?>
                              </option>
                           <option value="2" <?php 
                           if($myStatus==2)
                              {
                                echo "selected";
                              }?>>
                           <?php echo langs('status_likenew')?>
                          </option>
                           <option value="3" <?php 
                           if($myStatus==3)
                              {
                                echo "selected";
                              }?>>
                            <?php echo langs('status_used')?>
                            </option>
                           <option value="4" <?php 
                           if($myStatus==4)
                              {
                                echo "selected";
                              }?>>
                              <?php echo langs('status_old')?>
                            </option>
                         </select>
                        </div>
                   <div class="col-sm-3 <?php echo $dir?>">
                   <select name="orderBy">
                    <option value="-1">
                     <?php echo langs('Order_ADS')?></option>
                    <option value="recent">
                      <?php echo langs('Order_ADS1')?>
                      </option>
                    <option value="least">
                       <?php echo langs('Order_ADS2')?>
                    </option>
                    <option value="highest">
                        <?php echo langs('Order_ADS3')?>                
                    </option>
               </select>
              </div>
                  <div class="col-sm-2 <?php echo $dir1?>">
                       <button class="btn btn-primary">
                         <i class="fa fa-filter"></i>
                         <?php echo langs('filter_ADS')?>
                      </button>
                      </div>
                    </form>
                    </div>
                    
            <h1 class="text-center item_head">
              <?php 
               if(isset($_GET["pagename"]))
                {
                   $Where1 = "WHERE ID=".$_GET['catgid'];
                   $categrioes1 = get_All("*",'catogories',$Where1,'','ID','DESC');
                   $catgName1   = $categrioes1[0]['Name'];
                   $catgName_ar1= $categrioes1[0]['Name_arbaic'];
                   echo $lang=='ar'?$catgName_ar1:$catgName1;
                }
               else
               {
                header("refresh:1;url=index.php");
                exit();
               }
                
              echo "</h1>";
               
                foreach ($items as $item) 
                {
                  
                   $display = $lang=='ar'?'pull-right':'pull-left';
              echo "<div class='col-sm-4 ".$display."'>";
                echo "<div class='thumbnail item-box'>";
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
                   echo "</div>";
                  echo "</div>";
                
                    echo"</div>";
                }
                
             }
              else  if (empty($items))
               {
                echo "<br><br><br><br><br><br><br><br><br><br><br><div class=' alert alert-info'><strong><center>"
                .langs('noAds')
            ."</center></strong></div><br><br><br><br><br><br><br><br>";
                header("refresh:3;url=index.php");
               }
             ?>
           </div>
      </div>
    <?php
     }
    else
     {
        echo "<br><br><br><br><br><br><br><br><br><br><br><div class=' alert alert-info'><strong><center>"
                .langs('NOID')
            ."</center></strong></div><br><br><br><br><br><br><br><br>";
                header("refresh:0;url=index.php");
     }
include $tpl."footer.php";
   ob_end_flush();
?>
