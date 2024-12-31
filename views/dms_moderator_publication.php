<link rel="stylesheet" href="<?php echo base_url(); ?>js/fancybox/fancybox.css" />
<style>
    .fancybox__content {
        height: 100% !important;
        /* Overwrite Fancy box height */
    }
</style>
<script type="text/javascript" src="<?php echo base_url(); ?>js/fancybox/fancybox.umd.js"></script>
<script>
    Fancybox.bind("[data-fancybox]", {
        iframe: {
            preload: false, // Disable iframe preloading
            css: {
                width: "100%",
                height: "90%",
            },
        },
    });
</script>
<form id="data_fileupload_view" name="data_fileupload_view" autocomplete="off">
    <input type="hidden" name="ID" value="<?php echo $arrData['ID']; ?>" />
    <input type="hidden" name="hfimg" value="<?php echo $arrData['FILE_PATH']; ?>" />
    <!-- <input type="hidden" name="USER_ID" value="<?php echo $arrData['USER_ID']; ?>" />    
    <input type="hidden" name="USER_CLASS_ID" value="<?php echo $arrData['USER_CLASS_ID']; ?>" />   -->

    <div id="create_fileUpload">
        <input type="hidden" name="ID" id="ID" title="Id" value="<?php echo $arrData['ID']; ?>" />
        <table cellspacing="1" cellpadding="3" class="ui-widget-content" width="100%">
            <tr>
                <td class="ui-state-default">File Name</td>
                <td class="ui-widget-content" colspan="3">
                    <?php echo $arrData['FILE_NAME_ENG']; ?>
                </td>
            </tr>
            <tr>
                <td class="ui-state-default">File Name Hindi</td>
                <td class="ui-widget-content" colspan="3">
                    <a href="<?php echo base_url() . $arrData['FILE_PATH']; ?>" target="_blank" title="Click here to view/Download file">
                        <span style="color: #337ab7;"> <?php echo $arrData['FILE_NAME_HINDI']; ?> </span>
                    </a>
                </td>
            </tr>
            <tr>
                <td class="ui-state-default">File Description</td>
                <td class="ui-widget-content" colspan="3">
                    <?php echo $arrData['FILE_DESCRIPTION']; ?>
                </td>
            </tr>
            <tr>
                <td class="ui-state-default">File Description Hindi</td>
                <td class="ui-widget-content" colspan="3">
                    <?php echo $arrData['FILE_DESCRIPTION_HINDI']; ?>
                </td>
            </tr>
            <tr>
                <td class="ui-state-default">Letter Number</td>
                <td class="ui-widget-content" colspan="3">
                    <?php echo $arrData['LETTER_NO']; ?>
                </td>
            </tr>
            <tr>
                <td class="ui-state-default">Letter Date</td>
                <td class="ui-widget-content" colspan="3">
                    <?php echo $arrData['LETTER_DATE']; ?>
                </td>
            </tr>
            <tr>
                <td class="ui-state-default">Select Section </td>
                <td class="ui-widget-content" colspan="3">
                    <?php if ($arrData['ID'] > 0) {
                    } ?>
                    <p id="SECTION_ID" style="width:370px">
                        <?php if ($arrData['SECTION_ID'] > 0) {
                            echo $arrData[0]['SECTION_NAME'];
                        } ?></p>


                </td>
            </tr>
            <tr>
                <td class="ui-state-default">Select Category </td>
                <td class="ui-widget-content" colspan="3">
                    <p id="CATEGORY_ID" style="width:370px">
                        <?php if ($arrData['CATEGORY_ID'] > 0) {
                            echo $arrData[0]['CATEGORY_NAME'];
                        } ?>
                    </p>


                </td>
            </tr>
            <tr>
                <td class="ui-state-default">Access Level</td>
                <td class="ui-widget-content" colspan="3">
                    <?php if ($arrData['ACCESS_LEVEL'] == '1') {
                        echo "Public";
                    } elseif ($arrData['ACCESS_LEVEL']) {
                        echo "Private";
                    } else {
                        echo "Both";
                    } ?>
                </td>
            </tr>


            <tr id="view_file">
                <td class="ui-state-default" style="font-size:14px">
                    <div class="en"><strong>View File </strong></div>
                </td>
                <td class="ui-widget-content" style="font-size:13px;font-weight:bold; padding-top: 5px;" colspan="3">
                    <!--  <a href="<?php //echo base_url() . $arrData['FILE_PATH']; 
                                    ?>" target="_blank">
                        <span style="color: #337ab7;"> <img class="wi" src="<?php echo base_url(); ?>assets/pdf.png" alt="Archive" style="opacity: 1;"> Click To View File </span>
                    </a> -->
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
                </td>
            </tr>
            <?php //} 
            ?>
            <tr>
                <td class="ui-state-default">Tag /keyword</td>
                <td class="ui-widget-content" colspan="3">
                    <?php echo $arrData['tags']; ?>
                </td>
            </tr>
            <tr>
                <td class="ui-state-default">Published on Website</td>
                <td class="ui-widget-content" colspan="3">

                    <?php
                    $session =   $this->load->library('session');
                    /*
                    echo "<pre>";
                    print_r($session->session->CLASS_NAME);
                    echo "</pre>"; 
                    */
                    if ($getWebsiteStatus && $session->session->CLASS_NAME == "misopt") { ?>
                        <select name="STATUS" id="STATUS" class="sel2" style="width:100%" required>
                            <option value="">--Select Option--</option>
                            <?php
                            foreach ($getWebsiteStatus as $k => $v) { ?>
                                <option <?php echo ($k == $arrData['STATUS']) ? 'selected' : ''; ?> value="<?php echo $k; ?>"> <?php echo $v; ?></option>
                            <?php } ?>
                        </select>
                    <?php } ?>
                </td>
            </tr>
        </table>

        <?php
        if ($session->session->CLASS_NAME == "misopt") { ?>

            <div id="mySaveDiv" align="right" class="mysavebar">
                <?php echo getButton('Save', 'saveData(0)', 4, 'cus-disk') . ' &nbsp; ' . getButton('Cancel', 'closeDialog()', 4, 'cus-cancel'); ?>
            </div>
        <?php } ?>
    </div>
</form>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/bootstrap-tagsinput.css">
<script src="<?php echo base_url(); ?>assets/dist/bootstrap-tagsinput.min.js"></script>


<script>
    function saveData() {
        if ($('#data_fileupload_view').valid()) {
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
        $('#message').html(parseAndShowMyResponse(response));
        closeMyDialog("modalBox");
        $('#fileUploadGrid').trigger("reloadGrid"); //reload grid2
        $('#fileUploadedGrid').trigger("reloadGrid"); //reload Published grid1  

    }

    $("#button").click(function() {
        var input = $("input[name='tags']").tagsinput('items');
        console.clear();
        console.log(input);
        console.log(JSON.stringify(input));
        console.log(input[input.length - 1]);
    });
</script>