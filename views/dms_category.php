<?php //showArrayValues($SECTION_NAME);?>
<form id="data_category_view" name="data_category_view" autocomplete="off">
    
    <input type="hidden" name="STATUS" ID="STATUS" value="1"/>
    
    <table width="100%" border="0" cellpadding="3" class="ui-widget-content" cellspacing="1" style="margin-bottom:9px">
        <tr>
            <td align="center" class="ui-widget-content"><?php echo getRequiredSign(''); ?> = Mandatory Field(जानकारी जरूरी है)
            </td>
        </tr>
    </table>
        <div id="create_category">            
                <input type="hidden" name="ID" id="ID" title="Id" value="<?php echo $arrData['ID']; ?>" />
                <table cellspacing="1" cellpadding="3" class="ui-widget-content" width="100%">
                    <tr>
                        <td class="ui-state-default">Choose Parameter :</td>
                        <td class="ui-widget-content" colspan="3">
                        <?php if($arrData['ID']>0){ ?>
                            <div class="radioset" style="margin-top:2px" >
                            <label style="padding: 5px" class="ui-state-default">
                                <!-- added on 4 may 2022 ( CHK_RADIO was getting set to 0 when updated.) -->
                                <input type="hidden" name="CHK_RADIO" id="CHK_RADIO" value="<?php echo $arrData['CHK_RADIO']; ?>" /> 
                                <?php echo $arrData['CHK_RADIO'] == '1'?'Section':'Category' ?></label>
                            </div>
                        <?php }else{ ?>
                            <div class="radioset">
                                <input type="radio" name="CHK_RADIO" id="ROOT" value="1" onchange="changeRadio(this.value);">Add Section
                                <input type="radio" name="CHK_RADIO" id="SUBCAT" value="2" onchange="changeRadio(this.value);">Add Category   
                            </div> 
                        <?php } ?>                                               
                        </td>
                    </tr>
                    <tr class="tr_opt_cat" style="display:b">
                        <td class="ui-state-default">Select Section :</td>
                        <td class="ui-widget-content" colspan="3">
                        <select name="SECTION_ID" id="SECTION_ID" class="sel2" style="width:310px" onchange="changeCategory(0);">
                            <?php echo $section; ?>
                        </select>
                        </td>
                    </tr>
                    <tr class="tr_opt_cat" style="display:none">
                        <td class="ui-state-default">Select Parent Category :</td>
                        <td class="ui-widget-content" colspan="3">
                            <select name="PARENT_CATE_ID" id="PARENT_CATE_ID" class="sel2" style="width:310px">
                                <option value="">Select Parent Category</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="ui-state-default" id="lbl_eng_name">Name English :</td>
                        <td class="ui-widget-content" colspan="3">
                            <?php if($arrData['ID']>0){ ?>
                                <input type="text" name="CATEGORY_ENG" id="CATEGORY_ENG" size="44" title="CATEGORY ENG"
                                 value="<?php echo $arrData['CATEGORY_ENG']; ?>"/>
                            <?php }else{ ?>
                                <input type="text" name="CATEGORY_ENG" id="CATEGORY_ENG" size="44" title="CATEGORY ENG" value=""/>
                            <?php }?>
                        </td>
                    </tr>
                    <tr>
                        <td class="ui-state-default" id="lbl_hindi_name">Name Hindi :</td>
                        <td class="ui-widget-content" colspan="3">
                            <?php if($arrData['ID']>0){ ?>
                                <input type="text" name="CATEGORY_HINDI" id="CATEGORY_HINDI" size="44" title="CATEGORY HINDI" value="<?php echo $arrData['CATEGORY_HINDI']; ?>"/>
                            <?php }else{ ?>
                                <input type="text" name="CATEGORY_HINDI" id="CATEGORY_HINDI" size="44" title="CATEGORY HINDI" value=""/>
                            <?php }?>
                        </td>
                    </tr>
                    <tr>
                        <td class="ui-state-default">Status :</td>
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
        <?php if($arrData['ID']>0 AND $arrData['CHK_RADIO']==2){ ?>
            $('.tr_opt_cat').show();
        <?php } ?>

        $('.sel2').select2();

        $("#data_category_view").validate({
          rules: {
            SECTION_ID: {
                required:true
            },
            /*PARENT_CATE_ID:{
                required:true,
            },*/           
            CATEGORY_ENG :{
                required:true
            },
            CATEGORY_HINDI :{
                required:false
            },
            STATUS :{
                required:true
            }
          },
          messages: {
            SECTION_ID: {
                required:"Please select Section Name"
            },
            /*PARENT_CATE_ID:{
                required:"Please enter Company Name"
            },*/
            CATEGORY_ENG:{
                required:"Please enter Category Name English"
            },
            CATEGORY_HINDI :{
                required:"Please enter Category Name Hindi"
            },
            STATUS:{
                required:"Please select Status"
            },
                       
            }   
        });

        if($('#SECTION_ID').val()){
            changeCategory(<?php echo $arrData['PARENT_CATE_ID']; ?>);
        }
    });

    function changeRadio(parameter){
        if(parameter==1){
            $('.tr_opt_cat').hide();

            //$('.tr_opt_section').hide();
            $('#lbl_eng_name').html('Section Name English :');
            $('#lbl_hindi_name').html('Section Hindi Name :');
        }
        if(parameter==2){
            $('.tr_opt_cat').show();
            //$('.tr_opt_section').hide();
            $('#lbl_eng_name').html('Category Name English :');
            $('#lbl_hindi_name').html('Category Hindi Name :');
        }
    }

    function changeCategory(categoryId){
        $('#PARENT_CATE_ID').select2("val",'');
        var SECTION_ID = $("#SECTION_ID").val();
        $.ajax({
            url: 'changeCategory',
            type: 'post',
            data: {SECTION_ID: SECTION_ID, PARENT_CATE_ID :categoryId},
            success: function(response){
                //alert(response);exit();
               $('#PARENT_CATE_ID').html(response);
               $('#PARENT_CATE_ID').trigger("updatecomplete");
               $('#PARENT_CATE_ID').select2();
            }
        });
    }

    var validator;
    validator = $("#data_category_view").validate({
        rules: {
            "CATEGORY_ENG": {required: true},
            "CATEGORY_HINDI": {required: false},
            "SECTION_NAME": {required: true}
        },
        messages: {
            "CATEGORY_ENG":{required:"Category is Must."},
            "CATEGORY_HINDI":{required:"Category Charged Name is Must."},
            "SECTION_NAME":{required:"Section Name is Must."}
        }
    });
    
    function saveData(){
        if($('#data_category_view').valid()){
            var params = {
                'divid':'mySaveDiv',
                'url':'saveData',
                'data': $('#data_category_view').serialize(),
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
        $('#categoryGrid').trigger("reloadGrid");
    }

    $('#CATEGORY_HINDI').alphanum({
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
    $('#CATEGORY_ENG').alphanum({
        allow              : ' ',
        allowSpace         : true,
        allowNumeric       : true,
        allowUpper         : true,
        allowLower         : true,
        allowCaseless      : true,
        allowLatin         : true,
        allowOtherCharSets : false,
        forceUpper         : false,
        forceLower         : false,
        maxLength          : 1000
    }
    );
</script>