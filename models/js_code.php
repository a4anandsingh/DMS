<script>
    
    function toggleCommentPopup(a){
    $('#myModal').modal('show');
    //url ="<?php echo base_url('assets/2.pdf')?>';
     var iframe = $('#iframeName');
       document.getElementById("iframeName").src = a;
     }
    function toggleCommentPopupimg(a){
    $('#myModal').modal('show');
    //url ="<?php echo base_url('assets/2.pdf')?>';
     var iframe = $('#iframeName');
       document.getElementById("iframeName").src = a;            
     }
     jQuery("#treeview").kendoTreeView({
        checkboxes: {
        checkChildren: true,
                template: "<input type='checkbox' #= item.check# name='menu[]' value='#= item.value #'  />"
        },
                check: onCheck,
                dataSource: [
<?php 
    foreach ($result as $parent => $v_parent): 
        if (is_array($v_parent)): 
            foreach ($v_parent as $parent_id => $v_child): ?>
            {
                id: "", text: "<?php echo $parent; ?>", 
                value: "<?php if (!empty($parent_id)) { echo $parent_id; } ?>", expanded: false, 
                items: [ <?php 
                    foreach ($v_child as $child => $v_sub_child) : 
                        if (is_array($v_sub_child)): 
                            foreach ($v_sub_child as $sub_chld => $v_sub_chld): ?>
                            {
                                id: "", text: "<?php echo $child; ?>", 
                                value: "<?php if (!empty($sub_chld)) { echo $sub_chld; } ?>", expanded: false, 
                                items: [ <?php 
                                    foreach ($v_sub_chld as $sub_chld_name => $sub_chld_id): ?>
                                    {
                                        id: "", text: "<?php echo $sub_chld_name; ?>", 
                                        <?php if (!empty($roll[$sub_chld_id])) {
                                            echo $roll[$sub_chld_id] ? ' check: "checked",' : '';
                                        } ?> 
                                        value: "<?php if (!empty($sub_chld_id)) { echo $sub_chld_id; } ?>",
                                    },
                                    <?php endforeach; ?>
                                    ]
                            },
                        <?php endforeach; ?>
                        <?php else: ?>
                        { 
                            id: "", text: "<?php echo $child; ?>", 
                            <?php 
                            if (!is_array($v_sub_child)) { 
                                if (!empty($roll[$v_sub_child])) {
                                echo $roll[$v_sub_child] ? 'check: "checked",' : '';
                                }
                            } ?> 
                            value: "<?php if (!empty($v_sub_child)) { echo $v_sub_child; } ?>",

                        },
                        <?php endif; ?>
                    <?php endforeach; ?>
                ]
            },
            <?php endforeach; ?>
        <?php else: ?>
            { 
                <?php if ($parent == 'Dashboard') { ?>
                    id: "", text: "<?php echo $parent ?>", <?php echo 'check: "checked",'; ?>  
                    value: "<?php if (!is_array($v_parent)) { echo $v_parent; } ?>"
                <?php } else { ?>
                    id: "", text: "<?php echo $parent ?>", 
                    <?php
                    if (!is_array($v_parent)) {
                        if (!empty($roll[$v_parent])) {
                            echo $roll[$v_parent] ? 'check: "checked",' : '';
                        }
                    } ?> 
                    value: "<?php if (!is_array($v_parent)) { echo $v_parent; } ?>"
                <?php } ?>
            },
        <?php endif; ?>
    <?php endforeach; ?>
]
});
    // show checked node IDs on datasource change
    function onCheck() {
    var checkedNodes = [],
            treeView = $("#treeview").data("kendoTreeView"),
            message;
            /*checkedNodeIds(treeView.dataSource.view(), checkedNodes);*/
            $("#result").html(message);
    }
</script>
    <script type="text/javascript">
                $(function () {
                $("#treeview .k-checkbox input").eq(0).hide();
                        $('form').submit(function () {
                $('#treeview :checkbox').each(function () {
                if (this.indeterminate) {
                this.checked = true;
                }
                });
                })
                })
    </script> 