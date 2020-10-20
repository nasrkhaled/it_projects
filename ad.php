<?php
  ob_start();
  session_start(); 
error_reporting(E_ALL & ~E_NOTICE);
  if (isset($_GET['lang']))
    {
      if (($_GET['lang'])=='ar')
       {
         $pageTitle= "أضف إعلانًا";
       }
       else
       {
            $pageTitle="Create Ad";
       }
    }
    else if (isset($_COOKIE['lang']))
      {
       if (($_COOKIE['lang'])=='ar')
       {
         $pageTitle= "أضف إعلانًا";
       }
       else
       {
            $pageTitle="Create Ad";
       }
      }
    include  "intial.php";
    if (isset($_SESSION['username'])) 
      {
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
        	// print_r($_POST);
        	$name     = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
        	$des      = filter_var($_POST['description'],FILTER_SANITIZE_STRING);
        	$price    = $_POST['price'];
        	$phone    = $_POST['phone'];
        	$city= filter_var($_POST['city'],FILTER_SANITIZE_STRING);
            $neighborhood=isset($_POST['neighborhood'])?filter_var($_POST['neighborhood'],FILTER_SANITIZE_STRING):"";

           $discussable =empty($_POST['Discussable'])?"":filter_var($_POST['Discussable'],FILTER_SANITIZE_STRING);
        	$tags     = filter_var($_POST['tags'],FILTER_SANITIZE_STRING);
        	$status   = filter_var($_POST['status'],FILTER_SANITIZE_NUMBER_INT);
        	$brands   = empty($_POST['brand'])?"":filter_var(
        		$_POST['brand'],FILTER_SANITIZE_STRING);
        	$categroy = $_POST['categroy'];
            $langNameColm="";
            if($lang=='ar')
            {
              $langNameColm  = "WHERE Name_arbaic='".$_POST['categroy'];
            }
            else
            {
               $langNameColm  = "WHERE Name='".$_POST['categroy'];
            }
        	$where    = $langNameColm."'";
        	$rows   = get_All('*', 'catogories',$where,'', 'ID' ,'ASC' );
        	
        	$CategroyID="" ;
        	   foreach ($rows as $row) {
        	   	// echo $row['ID'];
        	   	$CategroyID = $row['ID'];
        	   }

            // print_r($rows);
        	// $categroy = filter_var($_POST['categroy']
        	// 	,FILTER_SANITIZE_STRING);
        	//filter_var($_POST['categroy'],FILTER_SANITIZE_NUMBER_INT);
        	// $avatar     = filter_var($_POST['avatar'],FILTER_SANITIZE_STRING);
        	// $avatar1     = filter_var($_POST['avatar1'],FILTER_SANITIZE_STRING);
        	// $avatar2     = filter_var($_POST['avatar2'],FILTER_SANITIZE_STRING);
        	// $avatar3     = filter_var($_POST['avatar3'],FILTER_SANITIZE_STRING);
        	$formErrors = array();
        	// print_r($_FILES);
        		$infoImg          = $_FILES['avatar'];
                $nameImg          = $infoImg['name'];
                $ex               =explode('.',$nameImg ) ;
                $sizeImg          = $infoImg['size'];
                $typeImg          = $infoImg['type'];
                $tmpImg           = $infoImg['tmp_name'];
                $exTypeAllowed    = array('png','jpg');
                $exImg            = strtolower(end($ex)); 

                $infoImg1          = $_FILES['avatar1'];
                $nameImg1          = $infoImg1['name'];
                $ex1               =explode('.',$nameImg1 ) ;
                $sizeImg1           = $infoImg1['size'];
                $typeImg1           = $infoImg1['type'];
                $tmpImg1            = $infoImg1['tmp_name'];
                $exTypeAllowed1     = array('png','jpg');
                $exImg1             = strtolower(end($ex1)); 

                $infoImg2          = $_FILES['avatar2'];
                $nameImg2          = $infoImg2['name'];
                $ex2               =explode('.',$nameImg2 ) ;
                $sizeImg2          = $infoImg2['size'];
                $typeImg2          = $infoImg2['type'];
                $tmpImg2           = $infoImg2['tmp_name'];
                $exTypeAllowed2    = array('png','jpg');
                $exImg2            = strtolower(end($ex2)); 

                $infoImg3          = $_FILES['avatar3'];
                $nameImg3          = $infoImg3['name'];
                $ex3               =explode('.',$nameImg3 ) ;
                $sizeImg3          = $infoImg3['size'];
                $typeImg3          = $infoImg3['type'];
                $tmpImg3           = $infoImg3['tmp_name'];
                $exTypeAllowed3    = array('png','jpg');
                $exImg3            = strtolower(end($ex3)); 
                // echo !empty($nameImg3)?  "true": "false";


        	// echo $categroy;

        	if (strlen($name)<3)
        	{
        		$formErrors[] = langs('nameAdError');
        	}
        	if (empty($price))
        	{
        		$formErrors[] = langs('priceAdError');
        	}
        	if (empty($city) or empty($neighborhood))
        	{
        		$formErrors[] = langs('locationAdError');
        	}
        	if (empty($phone))
        	{
        		$formErrors[] = langs('phoneAdError');
        	}
        	if ($status==0)
        	{
                 $formErrors[] = langs('statusAdError');
        	}
        	// if (empty($brands))
        	// {
        	// 	$formErrors[] = 'Type Must Be Not Empty';
        	// }
        	if (empty($categroy))
        	{
        		$formErrors[] = 'Categroy Must Be Not Empty';
        	}
        	if(empty($nameImg))
                 {
                  $formErrors[] =langs('avatarAdError');
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
           if(!empty($nameImg1))
              {	
            	if(!in_array($exImg1 , $exTypeAllowed1))
                 
		             {
		               $formErrors[] =' Avatar1 Extension Must Be JPG Or PNG';
		             }
		       if($sizeImg1 > 4194304)
		           {
		            $formErrors[] ='Avatar1 Size Must Be Less Than 4194304';
		           }
        	 }
        	if(!empty($nameImg2))
              {	
            	if(!in_array($exImg2 , $exTypeAllowed2))
                 
		             {
		               $formErrors[] =' Avatar2 Extension Must Be JPG Or PNG';
		             }
			        if($sizeImg2 > 4194304)
		           {
		            $formErrors[] ='Avatar2 Size Must Be Less Than 4194304';
		           }
        	 }
        	 if(!empty($nameImg3))
              {	
            	if(!in_array($exImg3 , $exTypeAllowed3))
                 
		             {
		               $formErrors[] =' Avatar3 Extension Must Be JPG Or PNG';
		             }
		        if($sizeImg3 > 4194304)
	           {
	            $formErrors[] ='Avatar3 Size Must Be Less Than 4194304';
	           }
        	 }
        		// echo $_POST['brand'];
           
            if (empty($formErrors))
               {
               	$avatar="";$avatar1="";$avatar2="";$avatar3="";
                //insert item in database
               	$avatar = rand(0,1023).'_'.$nameImg;
                move_uploaded_file($tmpImg ,'admin/upload/img/'.$avatar);
                if (!empty($nameImg1))
                {
                $avatar1 = rand(0,1023).'_'.$nameImg1;
              move_uploaded_file($tmpImg1 ,'admin/upload/img/'.$avatar1);
                }
                if(!empty($nameImg2))
                {
                $avatar2 = rand(0,1023).'_'.$nameImg2;
              move_uploaded_file($tmpImg2 ,'admin/upload/img/'.$avatar2);
              	}
              	if(!empty($nameImg3))
              	{
                $avatar3 = rand(0,1023).'_'.$nameImg3;
              move_uploaded_file($tmpImg3 ,'admin/upload/img/'.$avatar3);
              	}



                 $userid = $_SESSION['userid']; 
                 $stmt = $con->prepare("INSERT INTO items (Name,
                                                           Description,
                                                           Price,
                                                           Discussable,
                                                           location,
                                                           Neighborhood,
                                                           phone,
                                                           Tags,
                                                           Status,
                                                           Brand,
                                                           Cat_ID,
                                                           Member_ID,
                                                           Image,
                                                           Image1,
                                                           Image2,
                                                           Image3,
                                                           Add_Date)
                                             VALUES (:zname,
                                                     :zdescription,
                                                     :zprice,
                                                     :zdiscussable,
                                                     :zlocation,
                                                     :zNeighborhood,
                                                     :zphone,
                                                     :ztags,
                                                     :zstatus,
                                                     :zbrand,
                                                     :zcatid,
                                                     :zmemid,
                                                     :zimage,
                                                     :zimage1,
                                                     :zimage2,
                                                     :zimage3,
                                                     now())");
                   $stmt->execute(array(':zname'         =>$name,
                                        ':zdescription'  =>$des,
                                        ':zprice'        =>$price,
                                        ':zdiscussable'	 =>$discussable,
                                        ':zlocation'	   =>$city,
                                        ':zNeighborhood' =>$neighborhood,
                                        ':zphone'		     =>$phone,
                                        ':ztags'         =>$tags,
                                        ':zstatus'       =>$status,
                                        ':zbrand'		     =>$brands,
                                        ':zcatid'        =>$CategroyID,
                                        ':zmemid'        =>$userid,
                                       	':zimage'		     =>$avatar,
                                        ':zimage1'	   	 =>$avatar1,
                                        ':zimage2'		   =>$avatar2,
                                    	  ':zimage3'		    =>$avatar3,));
     					if($stmt)
     					{
     						$success = langs('AdPublis');
     					}
             }
        }

		
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

	      		
     echo '<h1 class="text-center item_head">'.langs('add_ad')."</h1>";
     echo ' <div id="error_reporting" class="alert alert-danger" 
         style="display: none;">'.langs('categroyAdError').'</div>';
                    if (!empty($formErrors))
                    {
                      foreach ($formErrors as $error)
                       {
                        
                        echo "<p class='alert alert-danger'>".$error."</p>";
                       }
                    }
               
         if ($lang=='ar')
               {
                 echo '<div class="col-md-7 pull-right colom8">';
               }
               else
               {
               echo '<div class="col-md-7 pull-left colom8">';
               }     
       
          if(isset($success))
                     {
                   echo  "<div class='text-center alert alert-success'><strong>" . $success 
                           . " </strong></div>";
                    header("refresh:5;url=index.php");
                           // print_r($_POST);
                     }
			         ?>

			            <form class="form-horizontal main-form" 
			                  action="<?php echo $_SERVER['PHP_SELF'];?>"enctype="multipart/form-data"
			                   method="POST" id="add-ad-now">
			               <!--start itemname failed-->
			                <div class="form-group form-group-lg">
			                 <label class="">
                                <?php echo langs('title_ad')?>
                                <span class='asterik-ad'>*</span>
                             </label>
			                   <input type="text" 
			                   	  pattern=".{4,}"
			                      name="name"
			                      class="form-control"
			                      id="live-name" 
			                     placeholder="<?php echo langs('title_ad_place')?>" />
			                  
			                </div>
			              <!--end itemname failed-->
			                 <!--start Categroy failed-->
			               <div class="form-group form-group-lg">
			             <label class="">
                            <?php echo langs('catg_ad')?>
                            <span class='asterik-ad'>*</span>
                          </label>
			                    <a id ="CaterogyAnchor" 
			                       class="btn inputAnchor">
                                <?php
                                 $cutomArrowBtn;
                                 $floatType;
                                 if ($lang=='ar')
                                 {
                                 echo "<i class='arrow down pull-left'
                                    style='margin-top: 10px;padding:2px;border: solid #847c7c; border-width: 0 3px 3px 0;' id='changcatg'></i>";
                                $cutomArrowBtn='<i class="arrow left"></i>';
                                $floatType="pull-left";
                                 }
                                 else
                                 {
                                 echo "<i class='arrow down pull-right'
                                      style='margin-top: 10px;;padding:2px;border: solid #847c7c;border-width: 0 3px 3px 0;' id='changcatg'></i>";
                                $cutomArrowBtn='<i class="arrow right"></i>';
                                 $floatType="pull-right";
                                 }
                                ?>
			                    <span id="mychoose">
                                  <?php echo langs('catg_choose')?>
                                </span>
			                    	<span id="myBtn"></span>
                                    <span id="cutomArrowBtn" 
                                          style="display: none"> 
                                        <?php echo $cutomArrowBtn ?>
                                    </span>
			                    	<span id="myBtn1"></span>
                                    <span id="myBtn2" style="display: none;"
                                     class="<?php echo $floatType?>">
                                        <?php echo langs('edit')?>
                                    </span>
			                    </a>
			                    <input type="hidden"
			                           id="mycategroy" value =" " 
			                           name="categroy">

			                  <input type="hidden" name="brand"
			                         id="mybrand" value="">
			                </div>
			              <!--end Categories failed-->

                             <!--start avatar failed-->
                         <div class="form-group form-group-lg">
                             <label class="">
                            <span><?php echo langs('avatar_ad')?></span>
                             </label>
                           <div   class="other_avatar">
                           <div id="yourBtn" onclick="getFile()">
                              <i class="fa fa-picture-o"></i>
                              <span id="mainMyPhoto">
                              <?php echo langs('avatar_note_ad')?>
                              </span>
                           </div>
                           <div style='height: 0px;width: 0px; overflow:hidden;'><input name="avatar"
                             id="upfile" type="file" value="upload" onchange="sub(this)" /></div>
                                
                        <div class="sub_photo">  
                       <div id="yourBtn1" onclick="getFile1('upfile1')">
                              <i class="fa fa-picture-o"></i>
                           </div>
                           <div style='height: 0px;width: 0px; overflow:hidden;'><input name="avatar1" 
                            id="upfile1" type="file" value="upload" onchange="sub1(this,'yourBtn1')" /></div>
                            

                       <div id="yourBtn2" onclick="getFile1('upfile2')">
                                <i class="fa fa-picture-o"></i>
                             </div>
                           <div style='height: 0px;width: 0px; overflow:hidden;'><input name="avatar2" 
                            id="upfile2" type="file" value="upload" onchange="sub1(this,'yourBtn2')" /></div>
                            

                       <div id="yourBtn3" onclick="getFile1('upfile3')">
                              <i class="fa fa-picture-o"></i>
                            </div>
                            <div style='height: 0px;width: 0px; overflow:hidden;'><input name="avatar3"
                             id="upfile3" type="file" value="upload" onchange="sub1(this,'yourBtn3')" /></div>

                            </div>
                          </div>
                         </div>
            <!--end other avatar failed-->
			               <!--start Status failed-->
                         <?php 
                              $customclass ="";
                              if ($lang=='ar')
                              {
                                $customclass = 'search1_rtl';
                              }

                              else
                              {
                               $customclass = 'search1_ltr';
                              }
                            ?>
			            <div class="form-group form-group-lg">
			              <label class="">
                            <?php echo langs('status_ad')?>
                            <span class='asterik-ad'>*</span>
                            </label>
                        <div>
			                   <select name="status" required 
                                class="<?php echo $customclass?>">
			                   	 <option value="0" disabled selected>
                                <?php echo langs('status_choose')?>
                                 </option>
			                     <option value="1">
                                <?php echo langs('status_new')?>
                                 </option>
			                     <option value="2">
                            <?php echo langs('status_likenew')?>
                                 </option>
			                     <option value="3">
                            <?php echo langs('status_used')?>
                                  </option>
			                     <option value="4">
                            <?php echo langs('status_old')?>
                                 </option>
			                   </select>
                       </div>
			                </div>
			              <!--end Status failed-->
			              <!--start description failed-->
			              <div class="form-group form-group-lg">
                           <label>
                            <?php echo langs('des_ad')?>
                            <span class='asterik-ad'>*</span>
                             </label>
			                   <textarea
			                     name="description"
			                     class="form-control des_add_ad" 
			          placeholder="<?php echo langs('des_ad_place')?>"
			                     ></textarea>
			                </div>
			              <!--end description failed-->
			              <!--start Price failed-->
			                <div class="form-group form-group-lg">
			                  <label class="">
                                <?php echo langs('price_ad')?>
                                <span class='asterik-ad'>*</span>
                              </label>
			                   <div>
			                   <input type="text"
			                     pattern=".{1,10}" 
			                     name="price" 
			                     class="form-control" 
			                     id='live-price'
                                 style="width: 60%;display: inline;"
			                     placeholder="<?php echo langs('price_egp_ad')?>" />

			                     &nbsp;&nbsp;&nbsp;
			                   <input type="checkbox" id="Discussable"
			                    name="Discussable" value="Discussable">
								<label class="" 
								   for="Discussable">
                                   <?php echo langs('Discussable')?>
								</label>
			                  </div>
			                 </div>
			              <!--end price failed-->
			                <!--start Location failed-->
			             <div class="form-group form-group-lg">
                          <label class="">
                                <?php echo langs('location_ad')?>
                                <span class='asterik-ad'>*</span>
                          </label>
                          <div>
                      <select class="<?php echo $customclass ?>" 
                              name='city' 
                              id="citiesAd">
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
                                 style="display: none;">
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
			         </div>     
			              <!--end Ad Location failed-->
			               <!--start phone failed-->
			                <div class="form-group form-group-lg">
			                  <label class="">
                                 <?php echo langs('phone_ad')?>   
                                 <span class='asterik-ad'>*</span> 
                              </label>
			                  
			                   <input type="text" 
			                     name="phone" 
			                     class="form-control" 
			placeholder="<?php echo langs('phone_ad_place')?>" />
			                  
			                </div>
			                
			              <!--end Ad phone failed-->
			             <!--start tags failed-->
				            <div class="form-group form-group-lg">
				              <label class="">
                            <?php echo langs('tag_ad')?>         
                              </label>
				                   <textarea 
				                     name="tags" class="form-control"
				                     value='' 
                                     style="height: 90px"
				                     placeholder="<?php echo langs('tag_ad_place')?>"></textarea>
				                  </div>
            <!--end tags failed-->
            		 

			             <!--start button failed-->
			                <div class="form-group form-group-lg">
			                  <button class="btn btn-primary"
                              style="font-size: 18px;
                                     width:35%">
                             <?php echo langs('save_ad')?>
			                   </button>
			                </div>
			             <!--end button failed-->
			             </form>
			             </div>
			        
		      <div class="col-md-4" style="
                                        margin-right: 20px;
                                        margin-left:40px;
                                        padding:10px;">
		      	  		<h4 class='control-label text-center'>
                         <?php echo langs('preview_ad')?>
		      	  		 </h4>
					<div class='thumbnail item-box'>
		                <img class='img_item' src='layout/image/ads.png' id="main_img" alt='not_found'/>
		                <div class='caption'>
		                   <h3><a id="from-livename">
                            <?php echo langs('title_ad')?>      
                           </a></h3>
		                  <span class='price-tag' id='from-liveprice'>
                            <?php echo langs('price_ad')?>      
                          </span>
		               <p style="margin-top: 18px;color: #000;">
                       <?php $arrow="";
                              $arrow = $lang=='ar'?'left':'right';
                          ?>
                         <span class="des" id='fromcatg'>
                          <?php echo langs('catg')?></span> 
                          
                          <i class="arrow <?php echo $arrow?>"
                            style="margin:0px 5px"></i>

                         <span id="fromType">
                           <?php echo langs('type')?>
                         </span>  
                      </p>
                         
                         <hr>
		                 <p class="date" id="from-livedes">
                           <?php echo langs('location_ad')?>  
                         </p>
		                 <p class="date" id="from-livedes">
                           <?php echo langs('date_ad')?>    
                         </p>
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
