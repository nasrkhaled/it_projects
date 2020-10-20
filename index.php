<?php
  ob_start();
  session_start();  
 
    if (isset($_GET['lang']))
    {
      if (($_GET['lang'])=='ar')
       {
         $pageTitle= " الرئيسيه ";
       }
       else
       {
            $pageTitle="Home";
       }
    }
    else if (isset($_COOKIE['lang']))
      {
       if (($_COOKIE['lang'])=='ar')
       {
         $pageTitle= " الرئيسيه ";
       }
       else
       {
            $pageTitle="Home";
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


       if (isset($_GET['page_no']) && $_GET['page_no']!="") {
                  $page_no = $_GET['page_no'];
        } 
        else
         {
           $page_no = 1;
          }

          $total_records_per_page = 12;
          $offset = ($page_no-1) * $total_records_per_page;
          $previous_page = $page_no - 1;
          $next_page = $page_no + 1;
          $adjacents = "2";
          $total_records = countItems ('*','items');
          $total_no_of_pages = ceil($total_records / 
            $total_records_per_page);
          $second_last = $total_no_of_pages - 1;                   

          $limt = 'LIMIT '.$offset.','.$total_records_per_page;



   $items = get_All("*",'items','WHERE Approve=1','','ID','DESC',$limt);
        
           if (!empty($items))
           {
            include "includes/temp/nav.php";
              if ($lang=='ar')
               {
                 echo "<div class='row row1 row1_ar'>";
               }
               else
               {
                echo "<div class='row row1 row1_en'>";
               }
            
                 echo"<h1 class='text-center item_head'>"
                 .langs('LatestAds')."</h1>";

            
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
            ?>
            <div class="col-sm-12">
            <nav aria-label="Page navigation example" class="text-center">
               <ul class="pagination">
            <?php if($page_no > 1){
            echo "<li><a href='?page_no=1'>".langs('First')."</a></li>";
            } ?>
                
            <li <?php if($page_no <= 1){ echo "class='disabled'"; } ?>>
            <a <?php if($page_no > 1){
            echo "href='?page_no=$previous_page'";
            } ?>><?php echo langs('Previous')?></a>
            </li>
                
            <li <?php if($page_no >= $total_no_of_pages){
            echo "class='disabled'";
            } ?>>
            <a <?php if($page_no < $total_no_of_pages) {
            echo "href='?page_no=$next_page'";
            } ?>><?php echo langs('Next')?></a>
            </li>
             
            <?php if($page_no < $total_no_of_pages){
            echo "<li><a href='?page_no=$total_no_of_pages'>".langs('Last')."</a></li>";
            } ?>
            </ul>
          </nav>
         </div>
            <?php
             echo"</div></div>";
         }
          else  if (empty($items))
           {
            echo "<div class='container alert alert-info'>".
            langs('NO_ADS')."</div>";
            header("refresh:2;url=index.php");
           }
         
        else
        {
          header("location:login.php");
        }
    include $tpl."footer.php";
     ob_end_flush();
 ?>
