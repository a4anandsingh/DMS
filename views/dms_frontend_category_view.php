<h1 style="display:block;font-size: 25px;">Root Categories</h1> 
<?php if($category){
foreach($category as $key => $value){ ?>
    <div style="font-weight: bold;display: block; width: 30%; font-size: 16px; cursor: pointer;text-align: left; background-color: #D3D3D3" class="" onclick="get_sub_category('<?php echo $value->ID; ?>','<?php echo $value->CATEGORY_ENG; ?>')"><img src="https://img.icons8.com/color/48/26e07f/folder-invoices--v1.png"/> <?php echo $value->CATEGORY_ENG; ?></div><br>
<?php } 
}else{ ?>
     <h2 style="font-weight: bold;text-align: left;color: red";>No Category Found..!!!!</h2>
<?php } ?>
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