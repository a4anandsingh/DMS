<form id="data_view" name="data_view" autocomplete="off">    
    <input type="hidden" name="STATUS" id="STATUS" value="1"/>    
    <table width="100%" border="0" cellpadding="3" class="ui-widget-content" cellspacing="1" style="margin-bottom:9px">
        <tr>
            <td align="center" class="ui-widget-content"><?php echo getRequiredSign(''); ?> = Mandatory Field(जानकारी जरूरी है)
            </td>
        </tr>
    </table>
        <div id="create_section">
            <?php if($arrData['ID']>0){?>
                <input type="hidden" name="ID" id="ID" title="Id" value="<?php echo $arrData['ID']; ?>" />
            <?php }else{?>
                <input type="hidden" name="ID" id="ID" title="Id" value="" />
            <?php }?>                                
                <table cellspacing="1" cellpadding="3" class="ui-widget-content" width="100%">
                    <tr>
                        <td class="ui-state-default">Section Name :</td>
                        <td class="ui-widget-content" colspan="3">
                            <?php if($arrData['ID']>0){ ?>
                                <input class="uppercase" type="text" name="NEW_SECTION" id="NEW_SECTION" size="44" title="NEW SECTION"
                                 value="<?php echo $arrData['SECTION_NAME']; ?>"/>
                            <?php }else{ ?>
                                <input class="uppercase" type="text" name="NEW_SECTION" id="NEW_SECTION" size="44" title="NEW SECTION" value=""/>
                            <?php }?>
                        </td>
                    </tr>
                    <tr>
                        <td class="ui-state-default">Section name in Hindi :</td>
                        <td class="ui-widget-content" colspan="3">
                            <?php if($arrData['ID']>0){ ?>
                                <input type="text" name="NEW_SECTION_HINDI" id="NEW_SECTION_HINDI" size="44" title="NEW SECTION HINDI" value="<?php echo $arrData['SECTION_NAME_HINDI']; ?>"/>
                            <?php }else{ ?>
                                <input type="text" name="NEW_SECTION_HINDI" id="NEW_SECTION_HINDI" size="44" title="NEW SECTION HINDI" value=""/>
                            <?php }?>
                        </td>
                    </tr>
                    <tr>
                        <td class="ui-state-default">Active</td>
                        <td class="ui-widget-content" colspan="3">
                            <select name="STATUS" id="STATUS" class="sel2" style="width:210px">
                                <option value="">Select Status</option>
                                <option value="1" <?php echo (($arrData['STATUS']=='1')?" selected='selected'":""); ?> >Active</option>
                                <option value="2"  <?php echo (($arrData['STATUS']=='2')?" selected='selected'":""); ?>>Inactive</option>
                            </select>
                        </td>
                    </tr>
                    
                </table>
                <div id="mySaveDiv" align="right" class="mysavebar">
                    <?php echo getButton('Save', 'saveData(0)', 4, 'cus-disk') . ' &nbsp; ' . getButton('Cancel', 'closeDialog()', 4, 'cus-cancel'); ?>
                </div>
        </div>
</form>
<script>
    $().ready(function () {
        $('.sel2').select2();
        $('.uppercase').Setcase({caseValue: 'upper'});
        $("#data_view").validate({
          rules: {
            NEW_SECTION: {
                required:true
            },
            NEW_SECTION_HINDI:{
                required:true,
            },           
            STATUS :{
                required:true
            }
          },
          messages: {
            NEW_SECTION: {
                required:"Please enter Section Name"
            },
            NEW_SECTION_HINDI:{
                required:"Please enter Section Name Hindi"
            },
            STATUS:{
                required:"Please select Status"
            },
                       
            } 
        });
    });
    function saveData(){
        if($('#data_view').valid()){
            var params = {
                'divid':'mySaveDiv',
                'url':'saveData',
                'data': $('#data_view').serialize(),
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

    $('#NEW_SECTION_HINDI').alphanum({
        allow              : ' ',
        allowSpace         : true,
        allowNumeric       : false,
        allowUpper         : false,
        allowLower         : false,
        allowCaseless      : true,
        allowLatin         : true,
        allowOtherCharSets : true,
        forceUpper         : false,
        forceLower         : false,
        maxLength          : 1000
    });
</script>