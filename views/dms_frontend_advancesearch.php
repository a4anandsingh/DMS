<?php include("header.php"); ?>

<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>js/select2/select2.min.css?v=2019022202" />

<div class="container">
    <div class="row">
        <section class="center" style=" margin: auto; width:100%; padding: 10px;">
            <article>
                <form id="search_form" name="search_form" autocomplete="off">
                    <div id="search_file">
                        <table cellspacing="1" cellpadding="3" class="ui-widget-content" width="100%">
                            <tr>
                                <td width="20%" class="ui-state-default">Tag/keywords </td>
                                <td class="ui-widget-content" colspan="3">


                                    <input type="text" class="form-control" name="SEARECH_KEYWORD" id="SEARECH_KEYWORD" value="">
                                </td>
                            </tr>
                            <tr>
                                <td class="ui-state-default">Section </td>
                                <td class="ui-widget-content" colspan="3">
                                    <select name="SECTION_ID" id="SECTION_ID" class="form-control" onchange="changeCategorys(0);">
                                        <option>All</option>
                                        <?php foreach ($allct as $category) {
                                        ?>
                                            <option value="<?php echo $category["id"]; ?>"><?php echo $category["name"]; ?></option>

                                        <?php } ?>
                                    </select>


                                </td>
                            </tr>
                            <tr>
                                <td class="ui-state-default">Category</td>
                                <td class="ui-widget-content" colspan="3">

                                    <select name="CATEGORY_ID" id="CATEGORY_ID" class="form-control">
                                        <option>All</option>
                                        <option value=""></option>
                                    </select>

                                </td>
                            </tr>
                            <tr>
                                <td width="20%" class="ui-state-default">Office </td>
                                <td class="ui-widget-content" colspan="3">

                                    <select name="SEARCH_CE_ID" id="SEARCH_CE_ID" class="form-control select2" style="font-size: 13px;">
                                        <?php echo $arrCurrentOffice['OFFICE_LIST_CURRENT_OFFICE']; ?>


                                    </select>

                                </td>
                            </tr>
                        </table>

                        <table cellspacing="1" cellpadding="3" class="ui-widget-content" width="100%">


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
                            <?php echo getButton('Search Data', 'getAdvamceSearch()', 4, 'cus-zoom'); ?>
                            <?php echo getButton('Reset', 'reset()', 4, 'cus-zoom'); ?>
                        </div>
                        <br />
                    </div>
                </form>

                <div id="dm_cats">
                    <h2 class="dm_title">

                        <div class="dm_row dm_light">
                            <ul class="breadcrumb">
                                <?php if (!empty($section_name)) { ?>
                                    <h3>Search result</a></h3>
                                <?php } ?>


                            </ul>

                            <div id="loaderex" class="loaderex" style=" display:none;">

                                <img src="<?php echo base_url() ?>/assets/images/loader.gif" alt="Loading...">

                            </div>

                            <div class="container" style="overflow-x:auto;width: 100%;" id="divSearch">




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
                                                <td><img class="wi" src="<?php echo base_url('assets') . '/' . $icon; ?>" alt="Archive" class="s5_lazyload" style="opacity: 1;" /><strong><?php echo wordwrap($doc['FILE_NAME_ENG'], 55, "<br>\n") . "<br />" . wordwrap($doc['FILE_NAME_HINDI'], 150, "<br>\n"); ?></strong></td>
                                                <td><?php echo $doc["LETTER_NO"]; ?></td>

                                                <td><strong><?php echo  date("d/m/Y", strtotime($doc['UPLOAD_DATE_TIME'])); ?></strong></td>
                                                <td><button class="btn bgc" onclick="toggleCommentPopup('<?php echo base_url() . $doc["FILE_PATH"]; ?>')"><span style="color: #337ab7;"> View</span></button>

                                                    |<button class="btn bgc"><a href="<?php echo base_url() . $doc["FILE_PATH"]; ?>" class="data-img row-icon" download><i class="fa fa-download"></i> Download</a></button></td>
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