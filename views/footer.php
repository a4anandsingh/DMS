<style>
    .btn-down a {

        color: #fff;
    }

    .btn-view span {

        color: #fff;
    }

    #dm_cats {
        width: 100%;
        flot: left;
    }

    #dm_row dm_light {
        width: 100%;
        flot: left;
    }

    #dm_cats .dm_row {
        padding: 15px;
    }

    .dm_row {
        background: url(<?php echo base_url(); ?>assets/bg-gradient.png) repeat-x;
    }

    <style>nav {
        float: left;
        width: 20%;
        height: 300px;
        /* only for demonstration, should be removed */
        background: #ccc;
        padding: 20px;
    }

    /* Style the list inside the menu */
    nav ul {
        list-style-type: none;
        padding: 0;
    }


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

        nav,
        article {
            width: 100%;
            height: auto;
        }
    }

    .summary {

        padding: 2em;
        background: linear-gradient(90deg, rgb(221 211 211) 0%, rgb(229 222 222) 35%, rgb(229 221 221) 100%);
        margin-bottom: 1em;
        cursor: pointer;
        outline: none;
        border-radius: 0.3em;
        font-weight: bold;
    }

    .summary2 {
        padding: 2em;
        background: #fff;
        margin-bottom: 1em;
        cursor: pointer;
        outline: none;
        border-radius: 0.3em;
        font-weight: bold;
    }

    h3.dm_title {
        font-size: 1.2em;
        font-weight: bold;
    }

    .wi {
        width: 25px;
        float: left;
    }

    .containerbob {

        width: 50%;
        /* three containers (use 25% for four, and 50% for two, etc) */
        padding: 5px;
        /* if you want space between the images */
    }

    .btn-down {
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

    .btn-view {
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

    .btn bgc {
        background: #e9e2e2;
        border: 1px solid #deebef;
        cursor: pointer;
        display: block;
        padding: 4px 15px;
        -moz-border-radius: 7px;
        -webkit-border-radius: 7px;
    }

    h1,
    h2 {
        font-size: 14px !important;
    }

    .ui-widget-content {
        padding: 3px;
    }

    .ui-state-default,
    .ui-widget-content .ui-state-default,
    .ui-widget-header .ui-state-default {

        text-align: center;
    }

    #mySaveDiv {
        margin: 14px;
    }

    .site-navbar .site-navigation .site-menu>li>a {
        margin-left: 15px;
        margin-right: 15px;
        padding: 20px 0px;
        color: #fff !important;
        display: inline-block;
        text-decoration: none !important;
    }

    .sitenv {
        background: -webkit-linear-gradient(top, #2976db 0%, #014eb3 100%) !important;
        background: -o-linear-gradient(top, #2976db 0%, #014eb3 100%) !important;
        background: -ms-linear-gradient(top, #2976db 0%, #014eb3 100%) !important;
    }

    #example th {
        color: #fff;
    }

    #loaderex {
        top: 200px;
        position: absolute;
        left: 45%;
        width: 20px;
    }

    .fancybox__content {
        height: 100% !important;
        /* Overwrite Fancy box height */
    }
</style>
<link rel="stylesheet" href="<?php echo base_url(); ?>js/ui/jquery-ui.min.css?v=20210120001">
<link rel="stylesheet" href="<?php echo base_url(); ?>js/validation/css/core.css">
<script src="<?php echo base_url(); ?>assets/dist/main.js"></script>

<script src="<?php echo base_url(); ?>assets/front/js/jquery-3.3.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/front/js/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/front/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/front/js/jquery.sticky.js"></script>
<script src="<?php echo base_url(); ?>assets/front/js/main.js"></script>

<script>
    $(document).ready(function() {
        var table = $('#example').DataTable({
            responsive: true,
        });

        new $.fn.dataTable.FixedHeader(table);
    });
    $().ready(function() {
        $('.sel2').select2();
        SEARCH_ = new clsOffice();
        var objOffice = new clsOffice();
    });
</script>
<script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.2.3/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/ui/jquery-ui.min.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>js/ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/commonlibrary.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/select2/select2.min.js?v=2019022202"></script>
<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>js/js/offices.js?v=1"></script>
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

<script type="text/javascript" language="javascript">
    function changeCategorys(categoryId) {
        //$('#CATEGORY_ID').select2("val",'');
        var SECTION_ID = $("#SECTION_ID").val();
        var subcat_ID = ""; // $("#selsubcat").val();
        $.ajax({
            url: '<?php echo base_url(); ?>dms/Dms_fileupload_c/changeCategory',
            type: 'post',
            data: {
                subcat_ID: subcat_ID,
                SECTION_ID: SECTION_ID,
                CATEGORY_ID: categoryId
            },
            success: function(response) {

                $('#CATEGORY_ID').html(response);
                //$('#CATEGORY_ID').trigger("updatecomplete");
                //$('#CATEGORY_ID').select2();
            }
        });
    }

    function reset() {
        $('input[type=text]').each(function() {
            $(this).val('');
        });
        $('#SECTION_ID').prop('selectedIndex', 0);
        $('#CATEGORY_ID').prop('selectedIndex', 0);
        $('#SEARCH_CE_ID').prop('selectedIndex', 0);
    }

    function link() {
        /*window.location.href="<?php echo base_url("dms/advance_search"); ?>";*/
        window.location.href = "<?php echo base_url("dms/Dms_frontend_c/advance_search"); ?>";
    }

    function myButtonMouseOver(th) {
        $(th).addClass('ui-state-hover');
    }

    function myButtonMouseOut(th) {
        $(th).removeClass('ui-state-hover');
    }


    function changeRadio(parameter) {
        if (parameter == 1) {
            $('.tr_opt_file').show();
            $('#LETTER_NO').val('');
            $('.tr_opt_letter').hide();
            $('.tr_opt_date_range').hide();
        }
        if (parameter == 2) {
            $('.tr_opt_letter').show();
            $('#FILE_NAME').val('');
            $('.tr_opt_file').hide();
            $('.tr_opt_date_range').hide();
        }
        if (parameter == 3) {
            $('.tr_opt_letter').hide();
            $('.tr_opt_file').hide();
            $('.tr_opt_date_range').show();
            //$("#DATE_RANGE").prop('checked',false);
            $("#START_DATE").val('');
            $("#END_DATE").val('');
            var curDate = "<?php echo date('d-m-Y'); ?>";
            $("#START_DATE").attr("placeholder", "dd-mm-yyyy").datepicker({
                dateFormat: "dd-mm-yy",
                changeMonth: true,
                changeYear: true,
                showOtherMonths: true,
                maxDate: curDate
            });
            $("#END_DATE").attr("placeholder", "dd-mm-yyyy").datepicker({
                dateFormat: "dd-mm-yy",
                changeMonth: true,
                changeYear: true,
                showOtherMonths: true
            });
        }
    }

    $("#START_DATE").on('change', function() {
        var startdate = $("#START_DATE").val();
        if (startdate == '') {
            return;
        }
        var curDate = "<?php echo date('d-m-Y'); ?>";
        var startDate = startdate.split("-");
        var startday = parseInt(startDate[0]);
        var startmonth = parseInt(startDate[1]);
        var startyear = parseInt(startDate[2]);

        var endday = 31;
        var endmonth = '03';
        var endyear = (startmonth > 3) ? (startyear + 1) : startyear;
        //console.log(endyear);
        var currdate = new Date(<?php echo date("Y") . ',' . (intval(date("m")) - 1) . ',' . (intval(date("d"))); ?>);
        var curDate = '<?php echo date("d") . '-' . date("m") . '-' . date("Y"); ?>';
        var enddate = new Date(endyear + ',' + endmonth + ',' + endday);
        //var endDate = endday+'-'+endmonth+'-'+endyear;
        var endDate = curDate;
        console.log(endDate);
        if (startdate == endDate) {
            $("#END_DATE").val(startdate);
            $("#END_DATE").prop('readonly', 'readonly');
        } else if (startdate < endDate) {
            // console.log(startdate);
            // console.log(endDate);
            $("#END_DATE").val('');
            //console.log(startdate+" <"+ endDate);
            $("#END_DATE").attr("placeholder", "dd-mm-yyyy").datepicker({
                dateFormat: "dd-mm-yy",
                changeMonth: true,
                changeYear: true,
                showOtherMonths: true
            });
            if (currdate < enddate) {
                //console.log(curDate);
                $('#END_DATE').datepicker('option', 'minDate', (parseInt(startday) + 1) + '-' + startmonth + '-' + startyear);
                $('#END_DATE').datepicker('option', 'maxDate', curDate);
            } else {
                $('#END_DATE').datepicker('option', 'minDate', (parseInt(startday) + 1) + '-' + startmonth + '-' + startyear);
                $('#END_DATE').datepicker('option', 'maxDate', endDate);
            }
        }
    });


    function getSearch() {
        /*if($('#SECTION_ID').val()=='' && $('#FILE_NAME_ENG').val()=='' && $('#LETTER_NO').val()==''){
            showAlert('error','Choose any parameter to search..!!','error');
            return;
        }*/
        //alert(<?php echo base_url() ?>);
        //if($('#SECTION_ID').val()=='')
        if ($('input[name="CHK_RADIO"]:checked').length == 0 && $("#session").val() == "") {
            // showAlert('error','Please choose parameter.','cancel');
            alert("Please choose parameter");
            return false;
        } else {
            if ($('input[name="CHK_RADIO"]:checked').val() == 1) {
                if ($('#FILE_NAME').val() == '') {
                    showAlert('error', 'Enter file name to search..!!', 'error');
                    return;
                }
            }
            if ($('input[name="CHK_RADIO"]:checked').val() == 2) {
                if ($('#LETTER_NO').val() == '') {
                    showAlert('error', 'Enter letter No. to search..!!', 'error');
                    return;
                }
            }
            if ($('input[name="CHK_RADIO"]:checked').val() == 3) {
                if ($("#START_DATE").val() == '') {
                    showAlert('error', 'Enter Start Date to search..!!', 'error');
                    return;
                }
                if ($("#END_DATE").val() == '') {
                    showAlert('error', 'Enter End Date to search..!!', 'error');
                    return;
                }
            }
        }
        //alert(<?php //echo base_url() 
                ?>)
        var params = {
            'divid': 'none',
            'url': '<?php echo base_url('dms/Dms_frontend_c/getInfo') ?>',
            'data': $('#search_form').serialize(),
            'donefname': 'printIt',
            'failfname': '',
            'alwaysfname': ''
        };
        callMyAjax(params);
    }



    function getAdvamceSearch() {


        if ($('input[name="CHK_RADIO"]:checked').val() == 1) {
            if ($('#FILE_NAME').val() == '') {
                showAlert('error', 'Enter file name to search..!!', 'error');
                return;
            }
        }
        if ($('input[name="CHK_RADIO"]:checked').val() == 2) {
            if ($('#LETTER_NO').val() == '') {
                showAlert('error', 'Enter letter No. to search..!!', 'error');
                return;
            }
        }
        if ($('input[name="CHK_RADIO"]:checked').val() == 3) {
            if ($("#START_DATE").val() == '') {
                showAlert('error', 'Enter Start Date to search..!!', 'error');
                return;
            }
            if ($("#END_DATE").val() == '') {
                showAlert('error', 'Enter End Date to search..!!', 'error');
                return;
            }
        }

        // }
        //alert(<?php //echo base_url() 
                ?>)
        var params = {
            'divid': 'none',
            'url': '<?php echo base_url('dms/Dms_frontend_c/advance_searchResult') ?>',
            'data': $('#search_form').serialize(),
            'donefname': 'printIt',
            'failfname': '',
            'alwaysfname': ''
        };
        var loader = document.getElementById('loaderex');
        loader.style.display = 'block';

        callMyAjax(params);
        setTimeout(function() {

            // Hide the loader after a certain time (e.g., 3 seconds)

            loader.style.display = 'none';

        }, 3000);


    }


    function printIt(data) {
        $('#divSearch').html(data);
    }
    /*End 08-02-2022 For searching*/

    function toggleCommentPopup(a) {
        $('#myModal').modal('show');
        //url ="<?php echo base_url('assets/2.pdf') ?>';
        var iframe = $('#iframeName');
        document.getElementById("iframeName").src = a;
    }

    function toggleCommentPopupimg(a) {
        $('#myModal').modal('show');
        //url ="<?php echo base_url('assets/2.pdf') ?>';
        var iframe = $('#iframeName');
        document.getElementById("iframeName").src = a;
    }
</script>

</body>

</html>