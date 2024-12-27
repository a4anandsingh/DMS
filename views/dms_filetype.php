<form id="data_filetype_view" name="data_filetype_view" autocomplete="off">    
    <input type="hidden" name="STATUS" id="STATUS" value="1"/>    
    <table width="100%" border="0" cellpadding="3" class="ui-widget-content" cellspacing="1" style="margin-bottom:9px">
        <tr>
            <td align="center" class="ui-widget-content"><?php echo getRequiredSign(''); ?> = Mandatory Field(जानकारी जरूरी है)
            </td>
        </tr>
    </table>
        <div id="allow_filetype">
            <?php if($arrData['ID']>0){?>
                <input type="hidden" name="ID" id="ID" title="Id" value="<?php echo $arrData['ID']; ?>" />
            <?php }else{?>
                <input type="hidden" name="ID" id="ID" title="Id" value="0" />
            <?php }?>                                
                <table cellspacing="1" cellpadding="3" class="ui-widget-content" width="100%">
                    <tr>
                        <td class="ui-state-default" id="">File Type :</td>
                        <td class="ui-widget-content" colspan="3">
                            <?php 
                                //echo ">> ". $arrData['FILETYPE_NAME'];
                                $arrFileType = array();
                                $arrFileType = explode(",",$arrData['FILETYPE_NAME']);
                                // showArrayValues($arrFileType);

                             ?>
                                <table cellspacing="3" cellpadding="3" class="ui-widget-content" width="100%">
                                        <?php 
                                foreach ($arrData['allFileTypes'] as $key => $value) {
                                    ?>
                                    <tr>
                                        <td>
                                               <label><input type="checkbox" name="FILETYPE_NAME[]" id="" title="<?php echo $value['DOCUMENT_TYPE']; ?>" value="<?php echo $value['ID']; ?>" 
                                                <?php echo ( in_array($value['ID'] , $arrFileType) ? " checked='checked'" :""); ?>
                                                />

                                                <?php echo $value['DOCUMENT_TYPE']; ?></label>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            ?>


                                </table>    

                            
                         </td>                        
                    </tr>
                    <tr>
                        <td class="ui-state-default">Max File Size (MB)</td>
                        <td class="ui-widget-content" colspan="3">
                           <?php if($arrData['ID']>0){?>
                                <input type="text" name="MAX_FILE_SIZE" id="MAX_FILE_SIZE" title="MAX FILE SIZE" 
                                value="<?php echo $arrData['MAX_FILE_SIZE']; ?>" />      
                            <?php }else{?>
                                <input type="text" name="MAX_FILE_SIZE" id="MAX_FILE_SIZE" title="MAX FILE SIZE" value="" />
                            <?php }?>
                         </td>
                    </tr>
                    <tr>
                        <td class="ui-state-default">Max Upload Size (MB)</td>
                        <td class="ui-widget-content" colspan="3">
                           
                                <input type="text" name="MAX_UPLOAD_SIZE" id="MAX_UPLOAD_SIZE" title="MAX UPLOAD SIZE" value="<?php echo $arrData['MAX_UPLOAD_SIZE']; ?>" />                                 
                         </td>
                    </tr>
                    
                </table>
                <div id="mySaveDiv" align="right" class="mysavebar">
                    <?php echo getButton('Update Permission', 'saveData(0)', 4, 'cus-disk') . ' &nbsp; ' . getButton('Cancel', 'closeDialog()', 4, 'cus-cancel'); ?>
                </div>
        </div>
</form>
<script>
    $().ready(function () {
        $('.sel2').select2();
      /*  $('.uppercase').Setcase({caseValue: 'upper'});*/
        $("#data_filetype_view").validate({
          rules: {
            FILETYPE_NAME: {
                required:true
            },        
            STATUS :{
                required:true
            }
          },
          messages: {
            FILETYPE_NAME: {
                required:"Please select FileType"
            },
            STATUS:{
                required:"Please select Status"
            },
                       
            } 
        });
    });
    function saveData(){
        if($('#data_filetype_view').valid()){
            var params = {
                'divid':'mySaveDiv',
                'url':'saveData',
                'data': $('#data_filetype_view').serialize(),
                'donefname': 'doneSave',
                'failfname' :'',
                'alwaysfname':''
            };
            callMyAjax(params);
        }
    }
    function doneSave(response){
        $('#message').html(parseAndShowMyResponse(response));
        closeMyDialog("modalBox");
        $('#Grid').trigger("reloadGrid");
    }
</script>