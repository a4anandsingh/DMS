<html>
<head>
<title>Display Sections</title>
<!-- <style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
</style> -->
</head>
 
<body>
<table width="100%" border="0" cellspacing="5" cellpadding="5">
  
  <tr>
    <td class="ui-state-default">Section </td>
    <td class="ui-widget-content" colspan="3">
        <?php
          $i=1;
          foreach($data as $row)
          {
          echo '<input type="checkbox" id="sectiondata" class="section-list"  value="'.$row->ID.' "> '.$row->SECTION_NAME.' <br/>';
          }
          $i++;
           ?>
    </td>
</tr>
<tr id="category">
    <td class="ui-state-default">Category </td>
    <td class="ui-widget-content" colspan="3" id="category_list">
        
    </td>
</tr>
<tr id="subcategory">
    <td class="ui-state-default">Sub Category </td>
    <td class="ui-widget-content" colspan="3" id="subcategory_list">
        
    </td>
</tr>
  
</table
></body>
<script>
    $().ready(function () {
        $("#category").hide();
        $("#subcategory").hide();
    });
    $('.section-list').on('change', function() {
        $('.section-list').not(this).prop('checked', false);
        //alert($('.section-list:checked').val());
        var sectionId = $('.section-list:checked').val();
        if (sectionId > 0) {
            $.ajax({
                url: 'getCategory',
                type: 'post',
                data: {SECTION_ID: sectionId},
                success: function(response){
                    var myArray = jQuery.parseJSON(response);// instead of JSON.parse(data)
                    if(myArray!=''){
                        $("#category").show();
                        $("#subcategory").hide();
                        var output = '';
                        jQuery(myArray).each(function( index, element ) {     
                            output += '<input type="checkbox" id="categorydata" class="category-list" value="'+ element.CATEGORY_ID +'" /> '+ element.CATEGORY_NAME +'<br/>';
                        });
                        $("#category_list").html(output);
                    }else{
                        $("#category").hide();
                        $("#subcategory").hide();
                    }
                }
            });
        }
         
    });
    
    $('.category-list').on('change', function() {
        $('.category-list').not(this).prop('checked', false);
        //alert($('.section-list:checked').val());
        var categoryId = $('.category-list:checked').val();
        if (categoryId > 0) {
            $.ajax({
                url: 'getSubCategory',
                type: 'post',
                data: {CATEGORY_ID: categoryId},
                success: function(response){
                    $("#sub_category").show();
                    var myArray = jQuery.parseJSON(response);// instead of JSON.parse(data)
                    //sconsole.log(myArray);
                    var output = '';
                    jQuery(myArray).each(function( index, element ) {     
                        //$("#category_list").html('<input type="checkbox" id="sectiondata" class="section-list"  value="'+ element.CATEGORY_ID +'"> '+ element.CATEGORY_NAME +'<br/>');
                        output += '<input type="checkbox" id="subcategorydata" class="subcategory-list"  value="'+ element.CATEGORY_ID +'"> '+ element.CATEGORY_NAME +'<br/>';
                    });
                    $("#subcategory_list").html(output);
                }
            });
        }
    });
    

   /* function myFunction(){

        var checkBox = document.getElementById("sectiondata");
        if (checkBox.checked == true) {
            var checkBoxValue = document.getElementById("sectiondata").value;
            alert(checkBoxValue);
        }
    }*/
        
  





</script>
</html>
