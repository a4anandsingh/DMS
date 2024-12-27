<?php //showArrayValues($SECTION_NAME);
?>
<form id="data_fileupload_view" name="data_fileupload_view" autocomplete="off">
    <input type="hidden" name="ID" value="<?php echo $arrData['ID']; ?>" />
    <input type="hidden" name="hfimg" value="<?php echo $arrData['FILE_PATH']; ?>" />
    <!-- <input type="hidden" name="USER_ID" value="<?php echo $arrData['USER_ID']; ?>" />    
    <input type="hidden" name="USER_CLASS_ID" value="<?php echo $arrData['USER_CLASS_ID']; ?>" />   -->
    <input type="hidden" id="selsubcat" name="selsubcat" value="<?php echo $userSelcat; ?>" />
    <table width="100%" border="0" cellpadding="3" class="ui-widget-content" cellspacing="1" style="margin-bottom:9px">
        <tr>
            <td align="center" class="ui-widget-content"><?php echo getRequiredSign(''); ?> = Mandatory Field(जानकारी जरूरी है)
            </td>
        </tr>
    </table>
    <div id="create_fileUpload">
        <input type="hidden" name="ID" id="ID" title="Id" value="<?php echo $arrData['ID']; ?>" />
        <table cellspacing="1" cellpadding="3" class="ui-widget-content" width="100%">
            <tr>
                <td class="ui-state-default">File Name</td>
                <td class="ui-widget-content" colspan="3">
                    <input type="text" name="FILE_NAME_ENG" id="FILE_NAME_ENG" size="44" title="FILE NAME ENG"
                        value="<?php echo $arrData['FILE_NAME_ENG']; ?>" />
                </td>
            </tr>
            <tr>
                <td class="ui-state-default">File Name Hindi</td>
                <td class="ui-widget-content" colspan="3">
                    <input type="text" name="FILE_NAME_HINDI" id="FILE_NAME_HINDI" size="44" title="FILENAME HINDI"
                        value="<?php echo $arrData['FILE_NAME_HINDI']; ?>" />
                </td>
            </tr>
            <tr>
                <td class="ui-state-default">File Description</td>
                <td class="ui-widget-content" colspan="3">
                    <textarea name="FILE_DESCRIPTION" id="FILE_DESCRIPTION" title="FILE DESCRIPTION" rows="4" cols="42"><?php echo $arrData['FILE_DESCRIPTION']; ?></textarea>
                </td>
            </tr>
            <tr>
                <td class="ui-state-default">File Description Hindi</td>
                <td class="ui-widget-content" colspan="3">
                    <textarea name="FILE_DESCRIPTION_HINDI" id="FILE_DESCRIPTION_HINDI" title="FILE_DESCRIPTION_HINDI" rows="4" cols="42"><?php echo $arrData['FILE_DESCRIPTION_HINDI']; ?></textarea>

                </td>
            </tr>
            <tr>
                <td class="ui-state-default">Letter Number</td>
                <td class="ui-widget-content" colspan="3">
                    <input type="text" name="LETTER_NO" id="LETTER_NO" title="LETTER NUMBER"
                        value="<?php echo $arrData['LETTER_NO']; ?>" />
                </td>
            </tr>
            <tr>
                <td class="ui-state-default">Letter Date</td>
                <td class="ui-widget-content" colspan="3">
                    <input type="text" name="LETTER_DATE" id="LETTER_DATE" title="LETTER DATE"
                        value="<?php echo $arrData['LETTER_DATE']; ?>" />
                </td>
            </tr>
            <tr>
                <td class="ui-state-default">Select Section </td>
                <td class="ui-widget-content" colspan="3">
                    <?php if ($arrData['ID'] > 0) { ?>
                        <select name="SECTION_ID" id="SECTION_ID" class="sel2" style="width:370px" onchange="changeCategory(0);">
                            value="<?php echo $section; ?>"/>
                            <!--  <//?php echo $section; ?> -->
                        </select>
                    <?php } else { ?>
                        <select name="SECTION_ID" id="SECTION_ID" class="sel2" style="width:370px" onchange="changeCategory(0);">
                            value="<?php echo $section; ?>"/>
                        <?php } ?>
                </td>
            </tr>
            <tr>
                <td class="ui-state-default">Select Category </td>
                <td class="ui-widget-content" colspan="3">
                    <?php if ($arrData['ID'] > 0) { ?>
                        <select name="CATEGORY_ID" id="CATEGORY_ID" class="sel2" style="width:370px">
                            <option value="">Select Category</option>
                        </select>
                    <?php } else { ?>
                        <select name="CATEGORY_ID" id="CATEGORY_ID" class="sel2" style="width:370px">
                            <option value="">Select Category</option>
                        </select>
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <td class="ui-state-default">Access Level</td>
                <td class="ui-widget-content" colspan="3">
                    <select name="ACCESS_LEVEL" id="ACCESS_LEVEL" class="sel2" style="width:210px">
                        <option value="">Select</option>
                        <option value="1" <?php echo (($arrData['ACCESS_LEVEL'] == '1') ? " selected='selected'" : ""); ?>>Public</option>
                        <option value="2" <?php echo (($arrData['ACCESS_LEVEL'] == '2') ? " selected='selected'" : ""); ?>>Private</option>
                        <option value="3" <?php echo (($arrData['ACCESS_LEVEL'] == '3') ? " selected='selected'" : ""); ?>>Both</option>
                    </select>
                </td>
            </tr>
            <?php //if($status==1){ 
            ?>
            <!-- <tr>
                        <td class="ui-state-default">Publication Status</td>
                        <td class="ui-widget-content" colspan="3">
                            <select name="STATUS" id="STATUS" class="sel2" style="width:210px">
                                <option value="">Select</option>
                                <option value="1" <?php //echo (($arrData['STATUS']=='1')?" selected='selected'":""); 
                                                    ?> >Publish</option>
                                <option value="2"  <?php //echo (($arrData['STATUS']=='2')?" selected='selected'":""); 
                                                    ?>>Un-Publish</option>
                            </select>
                        </td>
                    </tr> -->
            <?php //} 
            ?>
            <input type="hidden" name="STATUS" id="STATUS" value="2" />
            <tr id="upload_file">
                <td class="ui-state-default" style="font-size:14px">
                    <div class="en"><strong>Upload File Here </strong></div>
                </td>
                <!-- Start Commented 27th April 2022 <td class="ui-widget-content" style="font-size:13px;font-weight:bold" colspan="3">
                            <input type="file" name="UPLOAD_FILE" onchange="" id="UPLOAD_FILE"/>
                        </td> End 27th April 2022 -->
                <td class="ui-widget-content" style="font-size:13px;font-weight:bold" colspan="3">
                    <input type="file" name="UPLOAD_FILE" onchange="" id="UPLOAD_FILE" accept="application/pdf" />
                    <span class="help-text">Allowed file types:<strong><?php echo $setting["FILE_EXT"]; ?></strong></span><br>
                    <span class="help-text">Maximum upload file size is : <strong> <?php echo $setting["MAXFILESIZE"]; ?> KB</strong></span>
                </td>
            </tr>
            <?php //if($arrData['ID']>0){ 
            ?>
            <tr id="view_file">
                <td class="ui-state-default" style="font-size:14px">
                    <div class="en"><strong>View File </strong></div>
                </td>
                <td class="ui-widget-content" style="font-size:13px;font-weight:bold; padding-top: 5px;" colspan="3">
                    <!-- <a href="<?php //echo base_url() . $arrData['FILE_PATH']; 
                                    ?>" target="_blank">Click To View File</a> -->
                    <?php
                    $url =  base_url() . $arrData['FILE_PATH'];
                    $path = parse_url($url, PHP_URL_PATH);
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    if ($ext) { ?>
                        <a data-fancybox data-type="iframe" href='<?php echo base_url() . $arrData['FILE_PATH']; ?>'> <span style="color: #337ab7;">Click To View File</span></a>
                    <?php  } else {
                        echo '<b class="text-danger">File not found</b>';
                    }
                    ?>

                    <button type="button" class="btn btn-danger" id='DELETE_FILE' style="padding-right: 15px;">DELETE FILE</button>
                </td>
            </tr>
            <?php //} 
            ?>
            <tr>
                <td class="ui-state-default">Tag /keyword</td>
                <td class="ui-widget-content" colspan="3">
                    <input type="text" name="tags" value="<?php echo $arrData['tags']; ?>"" data-role=" tagsinput" size="100" style="width:98%" />
                    <span class="text-danger">Tag should be separated by comma (,) e.g. Tag1, Tag2 </span>
                </td>
            </tr>
        </table>

        <div id="mySaveDiv" align="right" class="mysavebar">
            <?php echo getButton('Save', 'saveData(0)', 4, 'cus-disk') . ' &nbsp; ' . getButton('Cancel', 'closeDialog()', 4, 'cus-cancel'); ?>
        </div>
    </div>
</form>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/bootstrap-tagsinput.css">
<script src="<?php echo base_url(); ?>assets/dist/bootstrap-tagsinput.min.js"></script>


<script>
    /* Start 27th April 2022*/
    var MAX_FILE_SIZE = 5 * 1024 * 1024; // 5MB

    $(document).ready(function() {
        $('#UPLOAD_FILE').change(function() {
            fileSize = this.files[0].size;
            if (fileSize > MAX_FILE_SIZE) {
                this.setCustomValidity("File must not exceed 5 MB!");
                this.reportValidity();
            } else {
                this.setCustomValidity("");
            }
            var fileInput = document.getElementById('UPLOAD_FILE');

            var filePath = fileInput.value;

            // Allowing file type
            var allowedExtensions =
                /(<?php echo $setting["FILE_EXT"]; ?>)$/i;

            if (!allowedExtensions.exec(filePath)) {
                alert('Invalid file type');
                fileInput.value = '';
                return false;
            }
        });
    });
    /* End 27th April 2022*/
    $().ready(function() {
        $('.sel2').select2();
        if ($('#SECTION_ID').val()) {
            changeCategory(<?php echo $arrData['CATEGORY_ID']; ?>);
        }
        <?php if ($arrData['ID'] > 0) { ?>
            $("#view_file").show();
            $("#upload_file").hide();
        <?php } else { ?>
            $("#view_file").hide();
            $("#upload_file").show();
        <?php } ?>


        //$("#view_file").show();
    });
    $("#data_fileupload_view").validate({
        rules: {
            FILE_NAME_ENG: {
                required: true
            },
            FILE_NAME_HINDI: {
                required: true,
            },
            FILE_DESCRIPTION: {
                required: true
            },
            LETTER_NO: {
                required: true
            },
            SECTION_ID: {
                required: true
            },
            /*CATEGORY_ID :{
                required:true
            },*/
            FILE_TYPE: {
                required: true
            },
            UPLOAD_FILE: {
                <?php if ($arrData['ID'] == 0) ?>
                required: true
            }
            /*,
                        STATUS :{
                            required:true
                        }*/
        },
        messages: {
            FILE_NAME_ENG: {
                required: "Please enter File Name English"
            },
            FILE_NAME_HINDI: {
                required: "Please enter File Name Hindi"
            },
            FILE_DESCRIPTION: {
                required: "Please enter File Description"
            },
            LETTER_NO: {
                required: "Please enter File Number"
            },
            SECTION_ID: {
                required: "Please select Section"
            },
            /*CATEGORY_ID:{
                required:"Please select Category"
            },*/
            FILE_TYPE: {
                required: "Please select File Type"
            },
            UPLOAD_FILE: {
                required: "File must be Uploaded"
            }
            /*,
                        STATUS:{
                            required:"Please select Status"
                        }, */
        }
    });

    var validator;
    validator = $("#data_fileupload_view").validate({
        rules: {
            "FILE_NAME_ENG": {
                required: true
            },
            "FILE_NAME_HINDI": {
                required: true
            },
            "FILE_DESCRIPTION": {
                required: true
            },
            "LETTER_NO": {
                required: true
            },
            "SECTION_ID": {
                required: true
            },
            "CATEGORY_ID": {
                required: false
            },
            "FILE_TYPE": {
                required: true
            },
            "FILE_URL": {
                required: true
            },
            "UPLOAD_FILE": {
                required: true,
                extension: "pdf|jpg|zip|jpeg",
                filesize: 2000000
            }
            /*"STATUS": {required: true}*/
        },
        messages: {
            "FILE_NAME_ENG": {
                required: "File Name English is Must."
            },
            "FILE_NAME_HINDI": {
                required: "File Name Hindi is Must."
            },
            "FILE_DESCRIPTION": {
                required: "File Description is Must."
            },
            "LETTER_NO": {
                required: "File Number is Must."
            },
            "SECTION_ID": {
                required: "Section is Must."
            },
            /*"CATEGORY_ID":{required:"Category is Must."},*/
            "FILE_TYPE": {
                required: "File Type is Must."
            },
            "FILE_URL": {
                required: "File URL is Must."
            },
            "UPLOAD_FILE": {
                required: "Choose File To Upload"
            }
            /*"STATUS":{required:"Status is Must."}*/
        }
    });

    function changeCategory(categoryId) {
        $('#CATEGORY_ID').select2("val", '');
        var SECTION_ID = $("#SECTION_ID").val();
        var subcat_ID = $("#selsubcat").val();
        $.ajax({
            url: 'changeCategory',
            type: 'post',
            data: {
                subcat_ID: subcat_ID,
                SECTION_ID: SECTION_ID,
                CATEGORY_ID: categoryId
            },
            success: function(response) {
                //alert(response);exit();
                $('#CATEGORY_ID').html(response);
                $('#CATEGORY_ID').trigger("updatecomplete");
                $('#CATEGORY_ID').select2();
            }
        });
    }

    $("#DELETE_FILE").click(function() {
        $("#view_file").hide();
        $("#upload_file").show();
    });

    $('#LETTER_DATE').attr("placeholder", "dd-mm-yyyy").datepicker({
        //dateFormat: 'dd-mm-yy',
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        showOtherMonths: true,
        maxDate: new Date
    });
    /*$("#UPLOAD_FILE").click(function(){
      $("p").show();
    });*/


    function saveData() {
        if ($('#data_fileupload_view').valid()) {
            /*var params = {
                'divid':'mySaveDiv',
                'url':'saveData',
                'data': $('#data_fileupload_view').serialize(),
                'donefname': 'doneSave',
                'failfname' :'',
                'alwaysfname':''
            };*/
            var fileData = new FormData($('#data_fileupload_view')[0]);
            var params = {
                'divid': 'mySaveDiv',
                'url': 'saveData',
                'data': fileData,
                'donefname': 'doneSave',
                'failfname': '',
                'alwaysfname': ''
            };
            callMyAjaxUploadFile(params);
        }
    }

    function doneSave(response) {
        // alert(response);
        // return false;
        $('#message').html(parseAndShowMyResponse(response));
        closeMyDialog("modalBox");
        $('#fileUploadGrid').trigger("reloadGrid");

    }
    /*function showSize(){
    var oFile = document.getElementById('UPLOAD_FILE').files[0];
    //oFile.size
    var file_size = bytesToSize(oFile.size);
   // console.log(" 1= "+oFile.size + " 2="+ file_size);

} 
*/
    $('#FILE_NAME_HINDI').alphanum({
        allow: ' ',
        allowSpace: true,
        allowNumeric: false,
        allowUpper: false,
        allowLower: false,
        allowCaseless: true,
        allowLatin: true,
        allowOtherCharSets: true,
        forceUpper: false,
        forceLower: false,
        maxLength: 100
    });
    $('#FILE_NAME_ENG').alphanum({
        allow: ' ',
        allowSpace: true,
        allowNumeric: true,
        allowUpper: true,
        allowLower: true,
        allowCaseless: true,
        allowLatin: true,
        allowOtherCharSets: false,
        forceUpper: false,
        forceLower: false,
        maxLength: 30
    });
    $('#FILE_DESCRIPTION').alphanum({
        allow: ' ',
        allowSpace: true,
        allowNumeric: true,
        allowUpper: true,
        allowLower: true,
        allowCaseless: true,
        allowLatin: true,
        allowOtherCharSets: false,
        forceUpper: false,
        forceLower: false,
        maxLength: 300
    });
    $('#FILE_DESCRIPTION_HINDI').alphanum({
        allow: ' ',
        allowSpace: true,
        allowNumeric: true,
        allowUpper: false,
        allowLower: false,
        allowCaseless: true,
        allowLatin: true,
        allowOtherCharSets: true,
        forceUpper: false,
        forceLower: false,
        maxLength: 500
    });

    $("#button").click(function() {
        var input = $("input[name='tags']").tagsinput('items');
        console.clear();
        console.log(input);
        console.log(JSON.stringify(input));
        console.log(input[input.length - 1]);
    });
</script>