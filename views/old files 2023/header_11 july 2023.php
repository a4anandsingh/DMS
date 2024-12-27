<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo base_url();?>assets/front/fonts/icomoon/style.css">

    <link rel="stylesheet" href="<?php echo base_url();?>assets/front/css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/front/css/bootstrap.min.css">
    
    <!-- Style -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/front/css/style.css">
 <link rel="stylesheet" href="<?php echo base_url();?>assets/front/css/bootstrap/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DMS</title>
  </head>
  <body>

<div id="divSearch_non">
    <div class="site-mobile-menu site-navbar-target">
        <div class="site-mobile-menu-header">
          <div class="site-mobile-menu-close mt-3">
            <span class="icon-close2 js-menu-toggle"></span>
          </div>
        </div>
        <div class="site-mobile-menu-body"></div>
      </div>
      <header class="site-navbar js-sticky-header site-navbar-target" role="banner">

        <div class="container">
          <div class="row align-items-center position-relative">
<div class="col-12">
        <nav class="site-navigation  ml-auto " role="navigation">

    <ul class="site-menu main-menu js-clone-nav ml-auto d-none d-lg-block sitenv">
    <?php 
     $ct = $this->Dms__frontend__m->allct();
                               
  $sel_menu_array= explode(",",$selmenu["MENU_SELECTED"]);
  foreach($ct as $msn){
       
       if (in_array($msn["ID"], $sel_menu_array))
  {
      $ctin = $this->Dms__frontend__m->allct_in($msn["ID"]);
   ?>
 <li class="has-children">
 <a class="nav-link"><?php echo $msn["CATEGORY_ENG"];?></a>
          <ul class="dropdown arrow-top">
         <?php 
        foreach($ctin as $cb){
   if (in_array($cb["ID"], $sel_menu_array))
  {
      $lvel2 = $this->Dms__frontend__m->allct_in($cb["ID"]);
?>
<li>
<?php if(count($lvel2)>0){?>
<?php }else{ ?>
 <a href="<?php echo base_url().'cat_view/'.str_replace(" ","-",strtolower($cb['HIERARCHY_PATH_TEXT'])).'/'.$cb["SLUG"];?>"><?php echo $cb["CATEGORY_ENG"];?><?php if(count($lvel2)>0){?><?php }?></a>

<?php }?>
 <?php if(count($lvel2)>0){?>
 <li class="has-children">
 <a href="<?php echo base_url().'cat_view/'.str_replace(" ","-",strtolower($cb['HIERARCHY_PATH_TEXT'])).'/'.$cb["SLUG"];?>" ><?php echo $cb["CATEGORY_ENG"];?><?php if(count($lvel2)>0){?><?php }?></a>
 
  <ul class="dropdown">                                              
  <?php         
  foreach($lvel2 as $lvl){   
  
  $lvel23 = $this->Dms__frontend__m->allct_in($lvl["ID"]); 
 ?>
                      
<li><a href="<?php echo base_url().'cat_view/'.str_replace(" ","-",strtolower($cb['HIERARCHY_PATH_TEXT'])).'/'.str_replace(" ","-",strtolower($cb["SLUG"])).'/'.$lvl["SLUG"];?>"><?php echo $lvl["CATEGORY_ENG"];?></a></li>
 <?php 
} ?> 
</ul>
</li>
<?php  }?>
</li>
<?php }
  } ?></ul>
</li>
  <?php }
  } ?>
  </ul>
              </nav>

            
      
            </div>

            <div class="toggle-button d-inline-block d-lg-none"><a href="#" class="site-menu-toggle py-5 js-menu-toggle text-black"><span class="icon-menu h3"></span></a></div>

          </div>
        </div>

      </header>