<style>
button:hover {
  background-color: #5bc0de;
}
hr.new {
  border: 1px solid red;
}
hr.new1 {
  border-top: 1px dotted #5bc0de ;
}
</style>
<h1 style="display:block;font-size: 25px;">Sub Categories</h1> 
<?php if($sub_category){
     foreach($sub_category as $key => $value) {?>
    <div style="font-weight: bold;display: block; width: 30%; font-size: 16px; cursor: pointer;text-align: left; background-color: #D3D3D3" class="" onclick="get_sub_category('<?php echo $value->ID; ?>','<?php echo $value->CATEGORY_ENG; ?>')"><img src="https://img.icons8.com/color/48/26e07f/folder-invoices--v1.png"/> <?php echo $value->CATEGORY_ENG; ?></div><br>
<?php } 
}else{ ?>
     <h2 style="font-weight: bold;text-align: left;color: red";>No Sub Category Found..!!!!</h2>
<?php } ?>
<hr class="new">


<!-- File Data Code goes here-->

<h1 style="display:block;font-size: 25px;">Documents</h1> 

<?php if ($files) {
 foreach($files as $key => $value) {?>
    <b style="display:block;font-size: 16px;"><a href="<?php echo base_url().$value->FILE_PATH;?>" target="_blank" ><img src="https://img.icons8.com/cute-clipart/64/000000/pdf.png"/><?php echo $value->FILE_NAME_ENG; ?>(<?php echo $value->FILE_NAME_HINDI; ?>)</b></a><br>


     <a href="<?php echo base_url().$value->FILE_PATH;?>" target="_blank" ><button type="button" class="btn btn-secondary btn-sm" style="color: blue;font: 15px Arial,sans-serif;">View File</button></a>
     <a href="<?php echo base_url().$value->FILE_PATH;?>" download target="_blank" ><button type="button" class="btn btn-secondary btn-sm" style="position:absolute;left:150px;color: blue;font: 15px Arial,sans-serif;">Download</button></a>

    <hr class="new1"><br>

    <!-- <img src="https://img.icons8.com/cute-clipart/64/000000/pdf.png"/><div style="display: block; width: 50%;padding: 14px 28px; font-size: 16px; cursor: pointer;text-align: center;" class="d-inline p-2 bg-primary text-white"><a href="<//?php echo base_url().$value->FILE_PATH;?>" target="_blank" ><//?php echo $value->FILE_NAME_ENG; ?></a></div><br> -->
<?php } 
}else{ ?>
    <h2 style="font-weight: bold;text-align: left;color: red";>No Douments Found!!!!</h2> 
<?php }?>
</div>
</script>
<div class="modal" id="myModal">
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
        
        
        <iframe id="iframeName" src="<?php echo base_url().'assets/sample.pdf';?>" frameborder="0" width="800" height="500"></iframe></div>
     

     </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
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
