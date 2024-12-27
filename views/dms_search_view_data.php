<?php //showArrayValues($dmsValue);?>
<table border="2" class="ui-state-default" cellpadding="2" cellspacing="1" width="100%" >   
    <tr>
        <th width="1%" class="ui-widget-content" ><strong>S.No</strong></th>
        <th width="5%" class="ui-widget-content" ><strong>FILE NAME</strong></th>
        <th width="7%" class="ui-widget-content" ><strong>FILE DESCRIPTION</strong></th>
        <th width="2%" class="ui-widget-content" ><strong>LETTER NO.</strong></th>
        <th width="2%" class="ui-widget-content" ><strong>LETTER DATE</strong></th>
        <th width="5%" class="ui-widget-content" ><strong>FILE PATH</strong></th>
    </tr>
    
    <?php $i=1;
    if($dmsValue){
    foreach ($dmsValue as $key => $value) { ?>
        <tr>
            <td class="ui-widget-content" valign="top" align="center"><?php echo $i; ?></td>
            <td class="ui-widget-content" valign="top" align="center"><?php echo $value->FILE_NAME_ENG.'<br>'. $value->FILE_NAME_HINDI; ?></td>
            <td class="ui-widget-content" valign="top" align="center"><?php echo $value->FILE_DESCRIPTION; ?></td>
            <td class="ui-widget-content" valign="top" align="center"><?php echo $value->LETTER_NO; ?></td>
            <td class="ui-widget-content" valign="top" align="center"><?php echo $value->LETTER_DATE; ?></td>
            <!-- <td class="ui-widget-content" valign="top" align="center"><//?php echo $value->FILE_PATH; ?></td> --> 
            <td class="ui-widget-content" valign="top" align="center"><a href="<?php echo base_url().$value->FILE_PATH;?>" target="_blank" >Download File</a></td>
        </tr>
        
    <?php $i++; }
    }else{ ?>
        <tr>
            <td class="ui-widget-content" valign="top" align="center" colspan="6">No Record Found!!!!!!!!!!</td>
        </tr>
    <?php } ?>
    
        
</table>
            