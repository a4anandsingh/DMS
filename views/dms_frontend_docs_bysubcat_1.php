<?php include("header.php");?>
<section class="center" style=" margin: auto; width:70%; padding: 10px;">
  <article> 

    <div id="dm_cats">
        <h2 class="dm_title"><img class="wi" src="<?php echo base_url();?>assets/folder.png" alt="Archive" class="s5_lazyload" style="opacity: 1;">
            <a href="<?php echo base_url().'cat_view/'.$category_name;?>"><?php echo str_replace("-"," ",ucfirst($category_name));?></a>
        </h2>
    <div>
    <div class="dm_row dm_light">

    <?php 
    if(!empty($subcat)){
        $selmenu=$this->Dms__frontend__m->getmenu_master(1);
$sel_menu_array= explode(",",$selmenu["MENU_SELECTED"]);
		foreach($subcat as $doc){
			if (in_array($doc["ID"], $sel_menu_array))
  {
			?>
            <div class="summary">
            <h3 class="dm_title ">
            <a href="<?php  echo base_url().'cat_view/'.$category_name.'/'.$doc['SLUG'];?>"><img class="wi" src="<?php echo base_url();?>assets/folder.png" alt="Archive" class="s5_lazyload" style="opacity: 1;"><?php echo $doc['CATEGORY_ENG'];?>( <?php echo $this->Dms__frontend__m->get_filesCountByCat($doc['ID']); ?> Files )</small>
            </a>
            </h3>
    </div>
  <?php }
	
	} 
	
	
	}else{
        echo "<span>Sorry ! No Document found.<span>";

    } ?>
<?php if(!empty($documents)){ ?>
 <div class="container" style="overflow-x:auto;">
 <!-- <div class="container"> -->
    <h3 class="title is-3">Documents :</h3>
    <div class="column">
        <table border="0" width="100%" cellpadding="4" cellspacing="1" align="center" class="ui-widget-content">
            <thead>
                <tr>
                    <th class="ui-widget-content" align="center"><strong style="font-size:15px;">S.No.</strong></th>
                    <th class="ui-widget-content" align="center"><strong style="font-size:15px;">File Name</strong></th>
                    <th class="ui-widget-content" align="center"><strong style="font-size:15px;">Date</strong></th>
                    <th class="ui-widget-content" align="center"><strong style="font-size:15px;">Download</strong></th>
                    <th class="ui-widget-content" align="center"><strong style="font-size:15px;">View</strong></th>
                </tr>
            </thead>
            <tbody>

                <?php $i=1; 
                //echo $offSet; //exit
                foreach($documents as $doc){ 
                    $i++;
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
                    <tr>
                        <td class="ui-widget-content" align="center"><?php echo $offSet;?></td>
                        <td class="ui-widget-content" style="word-wrap: break-word; font-size: 18px;"><img class="wi" src="<?php echo base_url('assets').'/'.$icon;?>" alt="Archive" class="s5_lazyload" style="opacity: 1;"><strong><?php echo $doc['FILE_NAME_ENG']."<br />".$doc['FILE_NAME_HINDI'];?></strong></td>
                        <td class="ui-widget-content" style="font-size: 15px;"><strong><?php echo  date("d/m/Y", strtotime($doc['UPLOAD_DATE_TIME'])); ?></strong></td>
                        <td class="ui-widget-content"><button class="btn-view" onclick="toggleCommentPopup('<?php echo base_url().$doc["FILE_PATH"];?>')" ><i class="fa fa-eye"></i> View</button></td>
                        <td class="ui-widget-content">|<a  target="_blank" href="<?php echo base_url().$doc["FILE_PATH"];?>" class="data-img row-icon" download="<?php echo str_replace("dms_uploads","",$doc["FILE_PATH"]);?>"><i class="fa fa-download"></i> Download</a></td>
                    </tr>
                <?php $i++;} ?>
            </tbody>
        </table>
        <center><h1><?php echo $links; ?></h1></center>
    </div>
</div>
<?php 
}else{
    echo "<h2><strong>No Document found!!!!!</strong></h2>";
    
} ?>
</div>
</div>
</div>
</article>    
</section>
<?php include("footer.php");?>