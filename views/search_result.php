 <h3 class="title is-3">Documents :</h3>

	   <div class="container-fluid">
	   
	   <table id="example" class="table table-striped table-bordered nowrap" style="width:100%">
            <thead>
            <tr style="background: #0e5bc0;">
                <th>S.No</th>
                <th>Subject</th>
                <th>Letter Number</th>
                <th>Date</th>
                <th>Action</th>
               
            </tr>
        </thead>
		   <tbody>
		<?php   
            $i=1;
            foreach($documents as $doc){ 
                //$offSet++;
                $ext = pathinfo($doc['USER_FILE'], PATHINFO_EXTENSION); 
                //echo $ext; 
                $icon="pdf.png";
                if($ext=="pdf"){
                    $icon="pdf.png";    
                }elseif($ext =="docx"){
                    $icon="docx.png";   
                }elseif($ext =="jpg"){
                    $icon="img.png";
                }
            ?>
     
              <tr>
                <td><?php echo $i;?></td>
                <td><img class="wi" src="<?php echo base_url('assets').'/'.$icon;?>" alt="Archive" class="s5_lazyload" style="opacity: 1;"><strong><?php echo $doc['FILE_NAME_ENG']."<br />".$doc['FILE_NAME_HINDI'];?></td>
                <td><?php echo $doc["LETTER_NO"];?></td>
				<td><strong><?php echo  date("Y/m/d", strtotime($doc['UPLOAD_DATE_TIME'])); ?></td>
                <td>
				<!-- <button class="btn bgc" onclick="toggleCommentPopup('<?php echo base_url().$doc["FILE_PATH"];?>')" ><span style="color: #337ab7;"> View</span></button>
				 -->
                 <a data-fancybox data-type="iframe" href='<?php echo base_url().$doc["FILE_PATH"];?>'> <span style="color: #337ab7;"> View</span></a>

				|<button class="btn bgc"><a  href="<?php echo base_url().$doc["FILE_PATH"];?>" class="data-img row-icon" download><i class="fa fa-download"></i> Download</a></button>
                
				</td>
                
              </tr>
            <?php $i++;}?>       
       
        </tbody>
    </table>
  </div>
</table>
  

</div>


<?php include("footer.php");?>