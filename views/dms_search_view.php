<?php $baseURL = base_url();?>
<title>DMS</title>
<div id="content_wrapper">
    <div id="page_heading">
        <?php echo $page_heading;?>
    </div>
    <div style="width:100%;float:left">
        <div id="messagebox" class="messagebox"></div>
    </div>
    <div style="width:100%;float:left">
        <?php echo getMessageBox('message', ''); ?>
    </div>
<form id="search_form" name="search_form" autocomplete="off">    
    
    </table>
        <div id="search_file">            
                <!-- <input type="hidden" name="ID" id="ID" title="Id" value="<//?php echo $arrData['ID']; ?>" /> -->
                <table cellspacing="1" cellpadding="3" class="ui-widget-content" width="100%">
                    <tr>
                        <td class="ui-state-default">Select Section </td>
                        <td class="ui-widget-content" colspan="3">
                        <select name="SECTION_ID" id="SECTION_ID" class="sel2" style="width:500px" onchange="changeCategory(0);">
                            <?php echo $section; ?>
                        </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="ui-state-default">Select Category </td>
                        <td class="ui-widget-content" colspan="3">
                            <select name="CATEGORY_ID" id="CATEGORY_ID" class="sel2" style="width:500px">
                                <option value="">Select Category</option>                                
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="ui-state-default">Choose Parameter</td>
                        <td class="ui-widget-content" colspan="3">
                        <div class="radioset">
                            <input type="radio" name="CHK_RADIO" id="FILE" value="1" onchange="changeRadio(this.value);">FILE NAME
                            <input type="radio" name="CHK_RADIO" id="LETTER" value="2" onchange="changeRadio(this.value);">LETTER NO                
                            <input type="radio" name="CHK_RADIO" id="DATE_RANGE" value="3" onchange="changeRadio(this.value);">Date Range                                    
                        </td>
                    </tr>
                     <tr class="tr_opt_file" style="display:none">
                        <td class="ui-state-default">File Name</td>
                        <td class="ui-widget-content" colspan="3">                           
                            <input type="text" name="FILE_NAME" id="FILE_NAME" size="78" title="FILE NAME"
                             value=""/>                            
                        </td>
                    </tr> 
                    <tr class="tr_opt_letter" style="display:none">
                        <td class="ui-state-default">Letter Number</td>
                        <td class="ui-widget-content" colspan="3">                           
                            <input type="text" name="LETTER_NO" id="LETTER_NO" size="78" title="LETTER_NO"
                             value=""/>                            
                        </td>
                    </tr> 
                    <tr class="tr_opt_date_range" style="display:none">
                        <td class="ui-state-default">Start Date</td>
                        <td class="ui-widget-content" colspan="3">                           
                            <input type="text" name="START_DATE" maxlength="10" id="START_DATE" readonly="readonly" value="" />                            
                        </td>
                    </tr> 
                    <tr class="tr_opt_date_range" style="display:none">
                        <td class="ui-state-default">End Date</td>
                        <td class="ui-widget-content" colspan="3">                           
                            <input type="text" name="END_DATE" maxlength="10" id="END_DATE" readonly="readonly" value="" />                            
                        </td>
                    </tr>                     
                </table>
                <div id="mySaveDiv" align="right" class="mysavebar">
                    <?php echo getButton('Search Data', 'getSearch()', 4, 'cus-zoom') . ' &nbsp; ' . getButton('Reset', 'resetParams()', 4, '').' &nbsp; ' . getButton('Cancel', 'closeDialog()', 4, 'cus-cancel'); ?>
                </div>
                 <br/>
                <div id="divSearch"></div>
        </div>
</form>


<script>
    $().ready(function () {
        $('.sel2').select2();
        /*if($('#SECTION_ID').val()!=''){
            changeCategory(<?php //echo $arrData['CATEGORY_ID']; ?>);
        }*/
    });
    
    function changeRadio(parameter){
        if(parameter==1){
            $('.tr_opt_file').show();
            $('#LETTER_NO').val('');
            $('.tr_opt_letter').hide();
            $('.tr_opt_date_range').hide();
        }
        if(parameter==2){
            $('.tr_opt_letter').show();
            $('#FILE_NAME').val('');
            $('.tr_opt_file').hide();
            $('.tr_opt_date_range').hide();
        }
        if(parameter==3){
            $('.tr_opt_letter').hide();
            $('.tr_opt_file').hide();
            $('.tr_opt_date_range').show();
            //$("#DATE_RANGE").prop('checked',false);
            $("#START_DATE").val('');
            $("#END_DATE").val('');
            var curDate = "<?php echo date('d-m-Y');?>";
            $("#START_DATE").attr("placeholder", "dd-mm-yyyy").datepicker({
                dateFormat:"dd-mm-yy", changeMonth:true, changeYear:true, showOtherMonths: true, maxDate: curDate
            });
            $("#END_DATE").attr("placeholder", "dd-mm-yyyy").datepicker({
                    dateFormat:"dd-mm-yy", changeMonth:true, changeYear:true, showOtherMonths: true 
                });
        }
    }

    $("#START_DATE").on('change',function(){
        var startdate = $("#START_DATE").val();
        if(startdate==''){
            return;
        }
        var curDate = "<?php echo date('d-m-Y');?>";
        var startDate = startdate.split("-");
            var startday = parseInt(startDate[0]);
            var startmonth = parseInt(startDate[1]);
            var startyear = parseInt(startDate[2]);

            var endday = 31;
            var endmonth = '03';
            var endyear = (startmonth>3) ? (startyear+1) : startyear;
            //console.log(endyear);
            var currdate = new Date(<?php echo date("Y").','.( intval(date("m"))-1).','.( intval(date("d")));?>);
            var curDate = '<?php echo date("d").'-'.date("m").'-'.date("Y");?>';
            var enddate = new Date(endyear+','+endmonth+','+endday);
            //var endDate = endday+'-'+endmonth+'-'+endyear;
            var endDate = curDate;
            console.log(endDate);
            if(startdate == endDate){
                $("#END_DATE").val(startdate);
                $("#END_DATE").prop('readonly','readonly');
            }else if(startdate < endDate){
                // console.log(startdate);
                // console.log(endDate);
                $("#END_DATE").val('');
                //console.log(startdate+" <"+ endDate);
                $("#END_DATE").attr("placeholder", "dd-mm-yyyy").datepicker({
                    dateFormat:"dd-mm-yy", changeMonth:true, changeYear:true, showOtherMonths: true 
                });
                if(currdate < enddate){
                    //console.log(curDate);
                    $('#END_DATE').datepicker('option','minDate',(parseInt(startday)+1)+'-'+startmonth+'-'+startyear);
                    $('#END_DATE').datepicker('option','maxDate', curDate);
                }else{
                    $('#END_DATE').datepicker('option','minDate',(parseInt(startday)+1)+'-'+startmonth+'-'+startyear);
                    $('#END_DATE').datepicker('option','maxDate', endDate);
                }
            }
    });

    //$('#SECTION_ID').on('change',function () {
    function changeCategory(categoryId){
        $('#CATEGORY_ID').select2("val",'');
        var SECTION_ID = $("#SECTION_ID").val();
        if(SECTION_ID!='')
        $.ajax({
            url: 'changeCategory',
            type: 'post',
            data: {SECTION_ID: SECTION_ID, CATEGORY_ID :categoryId},
            success: function(response){
                //alert(response);exit();
               $('#CATEGORY_ID').html(response);
               $('#CATEGORY_ID').trigger("updatecomplete");
               $('#CATEGORY_ID').select2();
            }
        });
    }

    function getSearch(){
        /*if($('#SECTION_ID').val()=='' && $('#FILE_NAME_ENG').val()=='' && $('#LETTER_NO').val()==''){
            showAlert('error','Choose any parameter to search..!!','error');
            return;
        }*/
        if($('#SECTION_ID').val()=='')
        if($('input[name="CHK_RADIO"]:checked').length == 0){
            showAlert('error','Please choose parameter.','cancel');
            return false;
        }else{
            if($('input[name="CHK_RADIO"]:checked').val() == 1 ){
                if($('#FILE_NAME').val()==''){
                   showAlert('error','Enter file name to search..!!','error');
                    return; 
                }
            }
            if($('input[name="CHK_RADIO"]:checked').val() == 2 ){
                if($('#LETTER_NO').val()==''){
                    showAlert('error','Enter letter No. to search..!!','error');
                    return;
                }
            }
            if($('input[name="CHK_RADIO"]:checked').val() == 3 ){
                if($("#START_DATE").val()==''){
                    showAlert('error','Enter Start Date to search..!!','error');
                    return;
                }
                if($("#END_DATE").val()==''){
                    showAlert('error','Enter End Date to search..!!','error');
                    return;
                }
            }
        }
    var params = {
        'divid':'none',
        'url':'getInfo',
        'data': $('#search_form').serialize(),
        'donefname': 'printIt', 
        'failfname' :'', 
        'alwaysfname':''
    };
    callMyAjax(params);
}
function printIt(data){
     $('#divSearch').html(data);
    
}
function resetParams() {
    $('#SECTION_ID').select2('val','');
    $('#CATEGORY_ID').select2('val','');
    $('input[name=CHK_RADIO]').attr('checked',false);
    $('.tr_opt_file').hide();
    $('.tr_opt_date_range').hide();
    $('.tr_opt_letter').hide();
    $('#FILE_NAME').val('');
    $('#LETTER_NO').val('');
    $('#START_DATE').val('');
    $('#END_DATE').val('');
    $('#divSearch').html('');
}
function closeDialog() {
        // body...
        $('#divSearch').html('');
    }

</script>