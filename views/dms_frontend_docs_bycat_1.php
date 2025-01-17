<?php include("header.php");
error_reporting(E_ALL);

?>

<div class="container">
    <div class="row">
        <section class="center" style=" margin: auto; width:100%; padding: 10px;">
            <article>
                <form id="search_form" name="search_form" autocomplete="off">
                    <div id="search_file">
                        <table cellspacing="1" cellpadding="3" class="ui-widget-content" width="100%">
                            <tr>
                                <td class="ui-state-default">Section </td>
                                <td class="ui-widget-content" colspan="3">
                                    <?php echo strtoupper(str_replace("-", " ", $section_name)); ?>
                                    <input type="hidden" name="SECTION_ID" id="SECTION_ID" readonly value="<?php echo $category_ids['SECTION_ID']; ?>">
                                    <input type="hidden" name="SECTION_NAME" id="SECTION_NAME" readonly value="<?php echo $section_name; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td class="ui-state-default">Category </td>
                                <td class="ui-widget-content" colspan="3">
                                    <?php echo strtoupper(str_replace("-", " ", $category_name)); ?>

                                    <input type="hidden" name="CATEGORY_ID" id="CATEGORY_ID" readonly value="<?php echo $category_id; ?>">
                                    <input type="hidden" name="CATEGORY_NAME" id="CATEGORY_NAME" readonly value="<?php echo $category_name; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td class="ui-state-default">Choose Parameter</td>
                                <td class="ui-widget-content" colspan="3">
                                    <div class="radioset">

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="CHK_RADIO" id="FILE" value="1" onchange="changeRadio(this.value);" />
                                            <label class="form-check-label" for="FILE">FILE NAME</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="CHK_RADIO" id="LETTER" value="2" onchange="changeRadio(this.value);" />
                                            <label class="form-check-label" for="LETTER">LETTER NO</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="CHK_RADIO" id="DATE_RANGE" value="3" onchange="changeRadio(this.value);" />
                                            <label class="form-check-label" for="DATE_RANGE">Date Range</label>
                                        </div>
                                        <?php $session = $this->Dms__frontend__m->sessionRange(); ?>
                                        &nbsp;&nbsp;&nbsp;
                                        <div class="form-check form-check-inline">
                                            <select name="session" id="session" class="form-control">
                                                <option value="">Select Session</option>
                                                <?php foreach ($session as $ss) { ?>
                                                    <option value="<?php echo $ss["SESSION"]; ?>"><?php echo $ss["SESSION"]; ?></option>

                                                <?php    } ?>
                                            </select>
                                </td>
                            </tr>
                            <tr class="tr_opt_file" style="display:none">
                                <td class="ui-state-default">File Name</td>
                                <td class="ui-widget-content" colspan="3">
                                    <input type="text" name="FILE_NAME" id="FILE_NAME" size="78" title="FILE NAME"
                                        value="" />
                                </td>
                            </tr>
                            <tr class="tr_opt_letter" style="display:none">
                                <td class="ui-state-default">Letter Number</td>
                                <td class="ui-widget-content" colspan="3">
                                    <input type="text" name="LETTER_NO" id="LETTER_NO" size="78" title="LETTER_NO"
                                        value="" />
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
                            <?php echo getButton('Search Data', 'getSearch()', 4, 'cus-zoom'); ?>
                            <?php echo getButton('Advance Search', 'link()', 4, 'cus-zoom'); ?>
                        </div>
                        <br />
                    </div>
                </form>

                <div id="dm_cats">
                    <h2 class="dm_title">

                        <div class="dm_row dm_light">
                            <ul class="breadcrumb">
                                <?php if (!empty($section_name)) { ?>
                                    <li><a href="#"><img class="wi" src="<?php echo base_url(); ?>assets/folder.png" alt="Archive" class="s5_lazyload" style="opacity: 1;"> <?php if (!empty($section_name)) { ?><a href="<?php echo base_url() . 'cat_view/' . $section_name; ?>"><?php echo str_replace("-", " ", ucfirst($section_name)); ?></a> <?php } ?></a></li>
                                <?php } ?>
                                <?php if (!empty($sub_category_name)) { ?>
                                    <li><a href="#"><img class="wi" src="<?php echo base_url(); ?>assets/folder.png" alt="Archive" class="s5_lazyload" style="opacity: 1;"> <?php if (!empty($sub_category_name)) { ?><a href="<?php echo base_url() . 'cat_view/' . $section_name . '/' . $sub_category_name; ?>"><?php echo str_replace("-", " ", ucfirst($sub_category_name)); ?></a> <?php } ?></a></li>
                                <?php } ?>
                                <?php if (!empty($category_name)) { ?>
                                    <li><a href="#"><img class="wi" src="<?php echo base_url(); ?>assets/folder.png" alt="Archive" class="s5_lazyload" style="opacity: 1;"> <?php if (!empty($category_name)) { ?><?php echo str_replace("-", " ", ucfirst($category_name)); ?><?php } ?></a></li>
                                <?php } ?>
                            </ul>
                            <?php

                            if (!empty($subcat)) {
                                foreach ($subcat as $doc) {
                                    $subs = "";

                                    if ($sub_category_name) {

                                        $subs = $section_name . '/' . $sub_category_name . '/' . str_replace(" ", '-', strtolower($doc["CATEGORY_ENG"]));
                                    } elseif ($category_name) {

                                        $subs = $section_name . '/' . $category_name . '/' . str_replace(" ", '-', strtolower($doc["CATEGORY_ENG"]));
                                    } elseif (!empty($section_name)) {
                                        $subs    = $section_name;
                                    }

                            ?>
                                    <?php if ($this->Dms__frontend__m->get_filesCountByCat($doc['ID']) > 0) {  ?>
                                        <div class="summary">
                                            <h3 class="dm_title ">
                                                <a href="<?php echo base_url() . 'cat_view/' . $subs; ?>"><img class="wi" src="<?php echo base_url(); ?>assets/folder.png" alt="Archive" class="s5_lazyload" style="opacity: 1;"><?php echo $doc['CATEGORY_ENG']; ?>( <?php echo $this->Dms__frontend__m->get_filesCountByCat($doc['ID']); ?> Files )</small>
                                                </a>
                                            </h3>
                                        </div>
                            <?php }
                                }
                            } else {
                                //echo "<span>Sorry ! No Document found.<span>";

                            } ?>


                            <div class="container" style="overflow-x:auto;width: 100%;" id="divSearch">
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
                                            $i = 1;
                                            foreach ($documents as $doc) {
                                                //$offSet++;
                                                $ext = pathinfo($doc['USER_FILE'], PATHINFO_EXTENSION);
                                                //echo $ext; 
                                                $icon = "pdf.png";
                                                if ($ext == "pdf") {
                                                    $icon = "pdf.png";
                                                } elseif ($ext == "docx") {
                                                    $icon = "docx.png";
                                                } elseif ($ext == "jpg") {
                                                    $icon = "img.png";
                                                }
                                            ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><strong><?php echo wordwrap($doc['FILE_NAME_ENG'], 55, "<br>\n") . "<br />" . wordwrap($doc['FILE_NAME_HINDI'], 150, "<br>\n"); ?></strong></td>
                                                    <td><?php echo $doc["LETTER_NO"]; ?></td>
                                                    <!-- <td><strong><//?php echo  date("Y/m/d", strtotime($doc['UPLOAD_DATE_TIME'])); ?></strong></td> -->
                                                    <td><strong><?php echo  date("d/m/Y", strtotime($doc['UPLOAD_DATE_TIME'])); ?></strong></td>
                                                    <td>
                                                        <!-- <button class="btn bgc" onclick="toggleCommentPopup('<?php echo base_url() . $doc["FILE_PATH"]; ?>')" ><span style="color: #337ab7;"> View</span></button> -->
                                                        <a data-fancybox data-type="iframe" href='<?php echo base_url() . $doc["FILE_PATH"]; ?>'> <span style="color: #337ab7;"> <img class="wi" src="<?php echo base_url('assets') . '/' . $icon; ?>" alt="Archive" class="s5_lazyload" style="opacity: 1;" /> View</span></a>

                                                        |<a target="_blank" href="<?php echo base_url() . $doc["FILE_PATH"]; ?>" class="data-img row-icon" download="<?php echo str_replace("dms_uploads", "", $doc["FILE_PATH"]); ?>"><i class="fa fa-download"></i> Download</a>
                                                    </td>
                                                </tr>


                                            <?php $i++;
                                            } ?>

                                        </tbody>
                                    </table>
                                </div>
                                </table>


                            </div>

                        </div>

                </div>
            </article>
        </section>
    </div>
</div>
</div>
</body>
<?php include("footer.php"); ?>