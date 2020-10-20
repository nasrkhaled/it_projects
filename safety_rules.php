<?php 
  ob_start();
  session_start();  
  $pageTitle="Safty rule";
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
 ?>

     	<center>
     		<h2 class="item_head"><?php echo langs('sftyRules') ?></h2>
     		<h4 class=""><?php echo langs('sftytips') ?></h4>
        </center>
        <section>
        	<div class="row">
        		<div class="col-sm-3">
        		<img src="layout/image/coramax130100423 (1).jpg" 
        			 alt="not_found..." />
        		</div>
        	<div class="col-sm-9">
			<div class="div-bottom-arrow">
			   <h4 class="content">
			   	<i class="fa fa-shield" aria-hidden="true"></i>
				<?php echo langs('sftysell')?></h4>
			   <ul>
			   	<li><?php echo langs('sftysell1')?></li>
			   	<li><?php echo langs('sftysell2')?></li>
			   	<li><?php echo langs('sftysell3')?></li>
			   	<li><?php echo langs('sftysell4')?></li>
			   	<li><?php echo langs('sftysell5')?></li>
			   </ul>
			</div>
			</div>
		 </div>
       </section>
       <section>
        	<div class="row">
        		<div class="col-sm-3">
        		<img src="layout/image/agreement-8457118.jpg" 
        			 alt="not_found..." />
        		</div>
        	<div class="col-sm-9">
			<div class="div-bottom-arrow">
			   <h4 class="content">
			   	<i class="fa fa-shield" aria-hidden="true"></i>
				<?php echo langs('sftybuy')?></h4>
			   <ul>
			   	<li><?php echo langs('sftybuy1')?></li>
			   	<li><?php echo langs('sftybuy2')?></li>
			   	<li><?php echo langs('sftybuy3')?></li>
			   	<li><?php echo langs('sftybuy4')?></li>
			   	<li><?php echo langs('sftybuy5')?></li>
			    <li><?php echo langs('sftybuy6')?></li>
			    <li><?php echo langs('sftybuy7')?></li>
			   </ul>
			</div>
			</div>
		 </div>
       </section>
       <section>
        	<div class="row">
        		<div class="col-sm-3">
        		<img src="layout/image/images (2).jpg" 
        			 alt="not_found..." />
        		</div>
        	<div class="col-sm-9">
			<div class="div-bottom-arrow">
			   <h4 class="content">
			   	<i class="fa fa-shield" aria-hidden="true"></i>
				<?php echo langs('sftypolice')?></h4>
			   <ul>
			<p id="content"><?php echo langs('sftypolice1')?></p>
			   	<li><?php echo langs('sftypolice2')?></li>
			   	<li><?php echo langs('sftypolice3')?></li>
			   	<li><?php echo langs('sftypolice4')?></li>
			   </ul>
			</div>
			</div>
		 </div>
       </section>
         <section>
        	<div class="row">
        		<div class="col-sm-3">
        		<img src="layout/image/3d-policeman-arresting-thief-against-white-background_58466-1984.jpg" 
        			 alt="not_found..." />
        		</div>
        	<div class="col-sm-9" style="margin-bottom:30px;">
			<div class="div-bottom-arrow">
			   <h4 class="content">
			   	<i class="fa fa-shield" aria-hidden="true"></i>
				<?php echo langs('sftysuspect')?></h4>
			   <ul>
			<p id="content"><?php echo langs('sftysuspect1')?></p>
			   </ul>
			</div>
			</div>
		 </div>
       </section>
   </div>
</div>
<?php include $tpl."footer.php";
   ob_end_flush();
?>