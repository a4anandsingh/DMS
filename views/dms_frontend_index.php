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
    <table width="100%" border="0" cellpadding="3" class="ui-widget-content" cellspacing="1" style="margin-bottom:9px">
        <tr>
            <td align="left" class="ui-widget-content">
                <button type="button" class="btn btn-primary" id='newsection'>Add New section</button>
            </td>
        </tr>
        <tr>
            <td align="left" class="ui-widget-content">
                
            </td>
        </tr>
        <tr>
            <td align="center" class="ui-widget-content">
                <div style="width:100%;float:left;padding-bottom:5px;padding-top:5px" align="center">
                    <table id="Grid"></table>
                    <div id="GridPager"></div>
                </div>
            </td>
        </tr>
    </table>
    <div id='modal'></div>
</div>