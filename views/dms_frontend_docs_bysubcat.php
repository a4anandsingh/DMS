<style>#dm_cats .dm_row {
    padding: 15px;
}#dm_cats .dm_row {
    padding: 15px;
}
.dm_row {
    background: url(<?php echo base_url();?>assets/bg-gradient.png) repeat-x;
}.modal-dialog {
    max-width: 61%;
    margin: 1.75rem auto;
}.dm_title a {
    font-size: 18px !important;
    margin-left: 0px;
}.dropdown-submenu {
  position: relative;
}
.modal {
    left: 40%;
    bottom: auto;
    right: auto;
    padding: 0;
    top: 70px;
    width: 45%;
    margin-left: -250px;
    background-color: #ffffff;
    border: 1px solid #999999;
    border: 1px solid rgba(0, 0, 0, 0.2);
    border-radius: 6px;
    -webkit-box-shadow: 0 3px 9px rgb(0 0 0 / 50%);
    box-shadow: 0 3px 9px rgb(0 0 0 / 50%);
    background-clip: padding-box;
}
    @import url('https://fonts.googleapis.com/css?family=Roboto');
a:hover,
a:focus {
    text-decoration: none;
    outline: none;
}
body{font-family: 'Roboto', sans-serif;}
/*
1.1 Header Area
***************************************************/
/*Bootstrap Reset*/
.navbar-nav > li > a {
    padding-top: 0;
    padding-bottom: 0;
}.header_area .header_bottom .mainmenu a, .navbar-default .navbar-nav > li > a {
    color: #000 !important;
    font-size: 16px;
    text-transform: capitalize;
    padding: 16px 15px;
    font-family: 'Roboto', sans-serif;
}
.mainmenu {
    background-color: transparent;
    border-color: transparent;
    margin-bottom: 0;
    border: 0px !important;
}
.navbar-nav > li:last-child > a {
    padding-right: 0px;
    margin-right: 0px;
}
.dropdown-menu {
    padding: 0px 0; 
    margin: 0 0 0; 
    border: 0px solid transition !important;
    border: 0px solid rgba(0,0,0,.15);  
    border-radius: 0px;
    -webkit-box-shadow: none !important;
    box-shadow: none !important;

}
/*=-====Main Menu=====*/
.navbar-nav .open .dropdown-menu > li > a {padding: 16px 15px 16px 25px;
}

.header_area .header_bottom .mainmenu a , .navbar-default .navbar-nav > li > a {
    color: #fff;
    font-size: 16px;
    text-transform: capitalize;
    padding: 16px 15px;
    font-family: 'Roboto', sans-serif;
}
.header_area .mainmenu .active a,
.header_area .mainmenu .active a:focus,
.header_area .mainmenu .active a:hover,
.header_area .mainmenu li a:hover,
.header_area .mainmenu li a:focus ,
.navbar-default .navbar-nav>.open>a, .navbar-default .navbar-nav>.open>a:focus, .navbar-default .navbar-nav>.open>a:hover{
    color: #0071ba;
    background: #54c6d4;
    outline: 0;
}
/*-----./ Main Menu-----*/

.navbar-default .navbar-toggle { border-color: #fff } /*Toggle Button*/
.navbar-default .navbar-toggle .icon-bar { background-color: #fff } /*Toggle Button*/

/*==========Sub Menu=v==========*/
.mainmenu .collapse ul > li:hover > a{background: #54c6d4;}
.mainmenu .collapse ul ul > li:hover > a, .navbar-default .navbar-nav .open .dropdown-menu > li > a:focus, .navbar-default .navbar-nav .open .dropdown-menu > li > a:hover{background: #CBEAF0;}
.mainmenu .collapse ul ul ul > li:hover > a{background: #CBEAF0;}

.mainmenu .collapse ul ul, .mainmenu .collapse ul ul.dropdown-menu{background:#98D7E1;}
.mainmenu .collapse ul ul ul, .mainmenu .collapse ul ul ul.dropdown-menu{background:#98D7E1}
.mainmenu .collapse ul ul ul ul, .mainmenu .collapse ul ul ul ul.dropdown-menu{background:#98D7E1}

/******************************Drop-down menu work on hover**********************************/
.mainmenu{background: none;border: 0 solid;margin: 0;padding: 0;min-height:20px}
@media only screen and (min-width: 767px) {
.mainmenu .collapse ul li{position:relative;}
.mainmenu .collapse ul li:hover> ul{display:block}
.mainmenu .collapse ul ul{position:absolute;top:100%;left:0;min-width:250px;display:none}
/*******/
.mainmenu .collapse ul ul li{position:relative}
.mainmenu .collapse ul ul li:hover> ul{display:block}
.mainmenu .collapse ul ul ul{position:absolute;top:0;left:100%;min-width:250px;display:none}
/*******/
.mainmenu .collapse ul ul ul li{position:relative}
.mainmenu .collapse ul ul ul li:hover ul{display:block}
.mainmenu .collapse ul ul ul ul{position:absolute;top:0;left:100%;min-width:250px;display:none;z-index:1}

}

</style> 
<!-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script> -->
<!------ Include the above in your HEAD tag ---------->
<div id="page_heading"> 
        <?php echo $page_heading;?> 
    </div>
   <div id="header-area" class="header_area">
        <div class="header_bottom">
            <div class="container">
                <div class="row">
                    <nav role="navigation" class="navbar navbar-default mainmenu">
                <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <!-- Collection of nav links and other content for toggling -->
                        <div id="navbarCollapse" class="collapse navbar-collapse">
                            <ul id="fresponsive" class="nav navbar-nav dropdown">
                              
                               <?php $ct = $this->Dms__frontend__m->allct();
  $sel_menu_array= explode(",",$selmenu["MENU_SELECTED"]);
  foreach($ct as $msn){
       
       if (in_array($msn["ID"], $sel_menu_array))
  {
      $ctin = $this->Dms__frontend__m->allct_in($msn["ID"]);
      ?>
                               <li class="dropdown"><a data-toggle="dropdown" class="dropdown-toggle"><?php echo $msn["CATEGORY_ENG"];?><span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                           <?php 
        foreach($ctin as $cb){
                   if (in_array($cb["ID"], $sel_menu_array))
  {
      $lvel2 = $this->Dms__frontend__m->allct_in($cb["ID"]);
      ?>
                            <!--            <li><a href="#"><?php //echo $cb["CATEGORY_ENG"];?></a></li>-->
                    <li>
                                            <a href="<?php echo base_url().'cat_view/'.$cb["SLUG"];?>" class="dropdown-toggle"><?php echo $cb["CATEGORY_ENG"];?><?php if(count($lvel2)>0){?><span class="caret"></span><?php }?></a>
                                            <?php if(count($lvel2)>0){?>
                                            <ul class="dropdown-menu">
                                                
                                        <?php            foreach($lvel2 as $lvl){   
                if (in_array($lvl["ID"], $sel_menu_array))
  {     $lvel23 = $this->Dms__frontend__m->allct_in($lvl["ID"]); 
?>
                                                <li>
                                                    <a href="<?php echo base_url().'cat_view/'.$lvl["SLUG"];?>"  class="dropdown-toggle"><?php echo $lvl["CATEGORY_ENG"];?><?php if(count($lvel23)>0){?><span class="caret"></span><?php }?></a>
                                                <?php   foreach($lvel23 as $lvlc){ if (in_array($lvlc["ID"], $sel_menu_array))
  {?>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="<?php echo base_url().'cat_view/'.$lvlc["SLUG"];?>"><?php echo $lvlc["CATEGORY_ENG"];?></a></li>
                                                        
                                                    </ul>
                                                    <?php }
  }?>
                                            </li>
                                            <?php } }   ?> 
                                            </ul>
                                            <?php  }?>
                                        </li>
                                        
                                        
                                    <?php }?> 
    <?php   } ?></ul>
                                </li>
  <?php }
  
  
  } ?>       
                            </ul>
                        </div>
                    </nav>
                </div> 
            </div>            
        </div><!-- /.header_bottom -->
      
    </div>
    <br>

<section class="center" style=" margin: auto; width:30%; padding: 10px;">
</section>
<section class="center" style=" margin: auto; width:70%; padding: 10px;">
   <?php //$this->load->view('nav');?>
  
  <article>
<h3 style="color: #190FF6;">Category :</h3>
<div id="dm_cats">
<?php //print_r($data['category']);?>
<h2 class="dm_title"><img class="wi" src="<?php echo base_url();?>assets/folder.png" alt="Archive" class="s5_lazyload" style="opacity: 1;"><a href="<?php echo base_url().'cat_view/'.$category['SLUG'];?>"><?php echo $category['CATEGORY_ENG'];?></a></h2>
<div>
<div class="dm_row dm_light">
<a href="#">

</a>

<?php 
if(!empty($subcat)){
foreach($subcat as $doc){?>
<div class="summary">
<h3 class="dm_title ">
<a href="<?php  echo base_url().'cat_view/'.$section_name.'/'.$doc['SLUG'];?>"><img class="wi" src="<?php echo base_url();?>assets/folder.png" alt="Archive" class="s5_lazyload" style="opacity: 1;"><?php echo $doc['CATEGORY_ENG'];?>( <?php echo $this->Dms__frontend__m->get_filesCountByCat($doc['ID']); ?> Files )</small>
</a>
</h3>

<!-- Full width -->
</div>
<?php }
}else{
    echo "<span>Sorry ! No Document found.<span>";
    
} ?>
<div>
    <h3 style="color: #190FF6;">Documents :</h3>

</div>
<?php if(!empty($documents)){ 
foreach($documents as $doc){
    
$ext = pathinfo($doc['USER_FILE'], PATHINFO_EXTENSION); 
//echo $ext; 
$icon="pdf.png";
if($ext=="pdf"){
$icon="pdf.png";    
}elseif($ext =="docx"){
    
$icon="docx.png";   
}elseif($ext =="jpg"){
    
$icon="img.png";    
}
    ?>
<div class="summary">
<h2 class="dm_title ">
<a href=""><img class="wi" src="<?php echo base_url('assets').'/'.$icon;?>" alt="Archive" class="s5_lazyload" style="opacity: 1;"><?php echo $doc['FILE_NAME_HINDI'];?></a>
</h2>
<div class="containerbob">
<button class="btn-down"><a  href="<?php echo base_url().$doc["FILE_PATH"];?>" class="data-img row-icon" download><i class="fa fa-download"></i> Download</a></button> 
<?php if($ext ==="pdf"){?>
<button class="btn-view" onclick="toggleCommentPopup('<?php echo base_url().$doc["FILE_PATH"];?>')" ><i class="fa fa-eye"></i> View</button>
<?php }else{?>
<button class="btn" onclick="toggleCommentPopupimg('<?php echo base_url().$doc["FILE_PATH"];?>')" ><i class="fa fa-eye"></i> View</button>
<?php } ?>
</div>
<div class="containerbob">
<h2><strong>Date added : <?php       echo  date("d/m/Y", strtotime($doc['UPLOAD_DATE_TIME']));
 ?> </h2></strong>

</div>

<!-- Full width -->


</div>
<?php }

}else{
    echo "<h2><strong>No Document found!!!!!</strong></h2>";
    
} ?>
<div class="clr"></div>
</div>    </div>
</div>


  </article>
  
    <nav>
    <ul>
      <li><a href="#"></a></li> 
      <li><a href="#"></a></li>
      <li><a href="#"></a></li>
   
    </ul>
  </nav>
</section>

<!-- <footer>
  <p>Footer</p>
</footer> -->

</body>
</html>
<style>#dm_cats .dm_row {
    padding: 15px;
}#dm_cats .dm_row {
    padding: 15px;
}
.dm_row {
    background: url(<?php echo base_url();?>assets/bg-gradient.png) repeat-x;
}<style>



/* Create two columns/boxes that floats next to each other */
nav {
  float: left;
  width: 20%;
  height: 300px; /* only for demonstration, should be removed */
  background: #ccc;
  padding: 20px;
}

/* Style the list inside the menu */
nav ul {
  list-style-type: none;
  padding: 0;
}

article {
  float: left;
  padding: 10px;
  width: 100%;
  background-color: #f1f1f1;

}

/* Clear floats after the columns */
section::after {
  content: "";
  display: table;
  clear: both;
}

/* Style the footer */
footer {
  background-color: #777;
  padding: 10px;
  text-align: center;
  color: white;
}

/* Responsive layout - makes the two columns/boxes stack on top of each other instead of next to each other, on small screens */
@media (max-width: 600px) {
  nav, article {
    width: 100%;
    height: auto;
  }
}
.summary {
    padding: 2em;
    background: #d8d8d2;
    margin-bottom: 1em;
    cursor: pointer;
    outline: none;
    border-radius: 0.3em;
    font-weight: bold;
}.summary2 {
    padding: 2em;
    background: #fff;
    margin-bottom: 1em;
    cursor: pointer;
    outline: none;
    border-radius: 0.3em;
    font-weight: bold;
} h3.dm_title {
    font-size: 1.2em;
    font-weight: bold;
}
.wi{width:25px;float: left;}.containerbob {
  width: 50%; /* three containers (use 25% for four, and 50% for two, etc) */
  padding: 5px; /* if you want space between the images */
}
.btn-down{
    background-color: #26D25D; 
    border: 1px;
    color: black;
    padding: 5px 15px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    margin: 4px 2px;
    cursor: pointer;
}
.btn-view{
    background-color: #26D25D; 
    border: 1px;
    color: black;
    padding: 5px 15px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    margin: 4px 2px;
    cursor: pointer;
}
</style>    

<script>(function($){
    $(document).ready(function(){
        $('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
            event.preventDefault(); 
            event.stopPropagation(); 
            $(this).parent().siblings().removeClass('open');
            $(this).parent().toggleClass('open');
        });
    });
})(jQuery);</script>

<script>
function toggleCommentPopup(a){
    $('#myModal').modal('show');
    //url ="<?php echo base_url('assets/2.pdf')?>';
     var iframe = $('#iframeName');
       document.getElementById("iframeName").src = a;
     
            
           }
    function toggleCommentPopupimg(a){
    $('#myModal').modal('show');
    //url ="<?php echo base_url('assets/2.pdf')?>';
     var iframe = $('#iframeName');
       document.getElementById("iframeName").src = a;
     
            
           }
</script>
<div class="modal" id="myModal">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title"></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div id="sbox-content" class="sbox-content-iframe" style="opacity: 1;">
        
        
        <iframe id="iframeName" src="<?php echo base_url().'assets/sample.pdf';?>" frameborder="0" width="800" height="500"></iframe></div>
     

     </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
</div>

<div class="modal" id="myModal2">
   <div class="modal-dialog">   
    <div class="modal-content">
    

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title"></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div id="sbox-content" class="sbox-content-iframe" style="opacity: 1;">
        
        
        <img src="" id="iframeNamec"/></div>
     

     </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
 </div> 
  </div>

  
</div>
