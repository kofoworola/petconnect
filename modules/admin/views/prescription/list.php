<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/chosen.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/jquery.datetimepicker.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/print.css') ?>" rel="stylesheet" type="text/css" media="print" />
<style>
    .aligncenter { text-align:center !important }
    @media print {
        .btn {
            display: none;
        }
        .aligncenter { text-align:center !important}
        .pt{font-size:6px !important}
        .header{line-height:110% !important}
        .pt>tbody>tr:last-child { background:#ff0000; }
    }
    #progressBar {
        width: 400px;
        height: 22px;
        border: 1px solid #111;
        background-color: #292929;
    }

    #progressBar div {
        height: 100%;
        color: #fff;
        text-align: right;
        line-height: 22px; /* same as #progressBar height if we want text middle aligned */
        width: 0;
        background-color: #0099ff;
    }

    .chosen-container{width:100% !important}
</style>

<script type="text/javascript">
    function areyousure()
    {
        return confirm('<?php echo lang('are_you_sure'); ?>');
    }
</script>
<section class="content-header no-print">
    <h1>
        <?php echo $page_title; ?>
        <small><?php echo lang('list'); ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard'); ?></a></li>
        <li class="active"><?php echo lang('prescription'); ?></li>
    </ol>
</section>

<?php
if (validation_errors()) {
    ?>
    <div class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
        <b><?php echo lang('alert') ?>!</b><?php echo validation_errors(); ?>
    </div>

<?php } ?>



<section class="content no-print">
    <?php
    $admin = $this->session->userdata('admin');
    if ($admin['user_role'] == 1) {
        ?>
        <div class="row" style="margin-bottom:10px;">
            <div class="col-xs-12">
                <div class="btn-group pull-right">
                    <a class="btn btn-default" href="<?php echo site_url('admin/prescription/add/'); ?>"><i class="fa fa-plus"></i> <?php echo lang('add_new'); ?></a>
                </div>
            </div>    
        </div>	
    <?php } ?>		

    <?php /* 		<div class="row" style="margin-bottom:10px;" >
      <div class="col-xs-12">
      <div class="">
      <div class="col-xs-2">
      <select name="filter" id="prescription_id" class="form-control chzn">
      <option value="0">--<?php echo lang('search')?>--</option>
      <?php foreach($prescriptions as $new) {
      $sel = "";
      echo '<option value="'.$new->prescription_id.'" '.$sel.'>'.$new->prescription_id.'</option>';
      }

      ?>
      </select>
      </div>


      </div>
      </div>
      </div>
     */ ?>

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo lang('prescription'); ?></h3>                                    
                </div><!-- /.box-header -->

                <div class="box-body table-responsive" style="margin-top:40px;" id="result">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>

                                <th><?php echo lang('date'); ?></th>
                                <th><?php echo lang('name'); ?></th>
                                <th><?php echo lang('prescription_id') ?></th>
                                <th width="50%"></th>
                            </tr>
                        </thead>

                        <?php if (isset($prescriptions)): ?>
                            <?php // echo '<pre>'; print_r($prescriptions);'</pre>';?>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($prescriptions as $prescription) {
//                                    //$date = new DateTime($prescription->dob);
//                                    $now = new DateTime();
//                                    $interval = $now->diff($date);
                                    ?>
                                    <tr class="gc_row">

                                        <td><?php echo date("d/m/y h:i:a", strtotime($prescription->date_time)) ?></td>
                                        <td><?php echo $prescription->patient ?></td>
                                        <td><?php echo $this->prescription_model->convert_id($prescription->id); ?></td>
                                        <td width="50%">
                                            <div class="btn-group">
                                                <a class="btn btn-primary" style="margin-left:10px;"  href="#myModal<?php echo $prescription->id ?>"  data-toggle="modal"><i class="fa fa-eye"></i> <?php echo lang('view'); ?> <?php echo lang('prescription'); ?></a>
                                                <a class="btn btn-primary" style="margin-left:10px;"  href="#report<?php echo $prescription->id ?>" data-toggle="modal"><i class="fa fa-file"></i> <?php echo lang('view_diagonsis_report'); ?></a>
                                                <a class="btn btn-primary" style="margin-left:10px;"  href="<?php echo site_url('admin/prescription/edit/' . $prescription->id) ?>" ><i class="fa fa-edit"></i> <?php echo lang('edit'); ?></a>
                                                <a class="btn btn-danger" style="margin-left:20px;" href="<?php echo site_url('admin/prescription/delete/' . $prescription->id); ?>" onclick="return areyousure()"><i class="fa fa-trash"></i> <?php echo lang('delete'); ?></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                                ?>
                            </tbody>
<?php endif; ?>
                    </table>

                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section>






<?php if (isset($prescriptions)): ?>
    <?php
    $i = 1;
    foreach ($prescriptions as $new) {
        $prescription = $this->prescription_model->get_prescription_by_id($new->id);
//echo '<pre>';print_r($medicines);die;
//        $date = new DateTime($prescription->dob);
//        $now = new DateTime();
//        $interval = $now->diff($date);
        ?>
        <!-- Modal -->
        <div class="modal fade" id="edit<?php echo $new->id ?>" tabindex="-1" role="dialog" aria-labelledby="editLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="editLabel"><?php echo lang('edit'); ?> <?php echo lang('prescription'); ?> </h4>
                    </div>
                    <div class="modal-body">
                        <div id="#err_edit">			
                            <?php
                            if (validation_errors()) {
                                ?>
                                <div class="alert alert-danger alert-dismissable">
                                    <i class="fa fa-ban"></i>
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
                                    <b><?php echo lang('alert') ?>!</b><?php echo validation_errors(); ?>
                                </div>

        <?php } ?>  
                        </div>

                        <form method="post" action="<?php echo site_url('admin/prescription/edit/' . $new->id) ?>" enctype="multipart/form-data" id="edit_form">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="name" style="clear:both;"> <?php echo lang('prescription_id') ?></label>
                                    </div>	
                                    <div class="col-md-3">
                                        <input type="text" name="prescription_id" value="<?php echo $prescription->prescription_id ?>" readonly="readonly"  class="form-control prescription_id"/>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="name" style="clear:both;"> <?php echo lang('patient'); ?></label>
                                    </div>	
                                    <div class="col-md-4">
                                        <input type="hidden" name="id" value="<?php echo $new->id; ?>" />		
                                        <select name="patient_id" id="patient_id" class="form-control chzn patient_id" style="z-index: 999">
                                            <option value="">--<?php echo lang('select_patient'); ?>--</option>
                                            <?php
                                            foreach ($pateints as $new) {
                                                $sel = "";
                                                if ($prescription->patient_id == $new->id)
                                                    $sel = "selected='selected'";
                                                echo '<option value="' . $new->id . '" ' . $sel . '>' . $new->name . ',' . $new->username . ',' . $new->contact . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" name="date_time" class="form-control datepicker" placeholder="<?php echo lang('date') ?>" value="<?php echo $prescription->date_time; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="name" style="clear:both;"><?php echo lang('case_history') ?></label>
                                            </div>	
                                            <div class="col-md-8">

                                                <select name="case_history_id[]" class="form-control chzn" multiple="multiple" data-placeholder="Select an option">
                                                    <option value="">--Select Option--</option>
                                                    <?php
                                                    foreach ($case_historys as $new) {
                                                        $sel = "";
                                                        $sel = (in_array($new->name, json_decode($prescription->case_history_id))) ? 'selected' : '';
                                                        echo '<option value="' . $new->name . '" ' . $sel . '>' . $new->name . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <textarea name="case_history"class="form-control redactor case_history"><?php echo strip_tags($prescription->case_history); ?></textarea>

                                            </div>

                                        </div>
                                    </div>
                                </div>	

                            </div>


                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="name" style="clear:both;"> <?php echo lang('oe') ?></label>
                                    </div>	
                                    <div class="col-md-4">
                                        <select name="disease_id[]" class="form-control chzn disease_id" multiple="multiple">
                                            <?php
                                            foreach ($diseases as $new) {
                                                $sel = "";
                                                $sel = (in_array($new->name, json_decode($prescription->disease))) ? 'selected' : '';
                                                echo '<option value="' . $new->name . '" ' . $sel . '>' . $new->name . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">

                                        <textarea name="oe_description"class="form-control oe_description"><?php echo strip_tags(@$prescription->oe_description); ?></textarea>
                                    </div>
                                </div>
                            </div>


                            <?php
                            $medicine1 = json_decode($prescription->medicines);
                            $medi_ins1 = json_decode($prescription->medicine_instruction);

                            $tests1 = json_decode($prescription->tests);
                            $tests_ins1 = json_decode($prescription->test_instructions);
                            //echo '<pre>'; print_r();
                            //echo '</pre>';
                            if (!empty($medicine1[0])) {
                                foreach ($medicine1 as $key => $val) {
                                    ?>	

                                    <div class="form-group">
                                        <div class="row  ">
                                            <div class="col-md-2">
                                                <label for="name" style="clear:both;"> <?php echo lang('medicine'); ?></label>

                                            </div>

                                            <div class="col-md-4" >

                                                <select name="medicine_id[]" class="form-control chzn medicine_id" id="medicine_id"style="width:100%">
                                                    <option value="">--<?php echo lang('select_medicine'); ?>--</option>
                                                    <?php
                                                    foreach ($medicines as $new) {
                                                        $sel = " ";
                                                        if ($new->name == $val)
                                                            $sel = "selected='selected'";
                                                        echo '<option value="' . $new->name . '" ' . $sel . '>' . $new->name . '</option>';
                                                    }
                                                    ?>


                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <select name="instruction[]" class="form-control chzn instruction">
                                                    <option value="">--<?php echo $medi_ins1[@$key] ?>--</option>
                                                    <?php
                                                    foreach ($medicine_ins as $new) {
                                                        $sel = "";
                                                        if ($new->name == $medi_ins1[$key])
                                                            $sel = "selected='selected'";
                                                        echo '<option value="' . $new->name . '" ' . $sel . '>' . $new->name . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <a href="#" class="delete_activity btn btn-danger"><?php echo lang('remove'); ?></a> 
                                            </div>

                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>	







                            <div class="form-group input_fields_wrap">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="name" style="clear:both;"> <?php echo lang('medicine'); ?></label>

                                    </div>

                                    <div class="col-md-4" >
                                        <div>
                                            <select name="medicine_id[]" class="form-control chzn medicine_id" id="medicine_id">
                                                <option value="">--<?php echo lang('select_medicine'); ?>--</option>
                                                <?php
                                                foreach ($medicines as $new) {
                                                    $sel = "";
                                                    echo '<option value="' . $new->name . '" ' . $sel . '>' . $new->name . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>	

                                    </div>
                                    <div class="col-md-4">
                                        <select name="instruction[]" class="form-control chzn instruction">
                                            <option value="">--<?php echo lang('medicine_instruction'); ?>--</option>
                                            <?php
                                            foreach ($medicine_ins as $new) {
                                                $sel = "";
                                                echo '<option value="' . $new->name . '" ' . $sel . '>' . $new->name . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button class="add_field_button btn btn-success"><?php echo lang('add'); ?> </button>
                                    </div>

                                </div>
                            </div>





                            <?php
                            if (!empty($tests1[0])) {
                                foreach ($tests1 as $key => $val) {
                                    ?>	

                                    <div class="form-group">
                                        <div class="row  ">
                                            <div class="col-md-2">
                                                <label for="name" style="clear:both;"> <?php echo lang('medical_test'); ?></label>

                                            </div>

                                            <div class="col-md-4" >
                                                <div>

                                                    <select name="report_id[]" class="form-control chzn report_id">

                                                        <?php
                                                        foreach ($tests as $new) {
                                                            $sel = " ";
                                                            if ($new->name == $val)
                                                                $sel = "selected='selected'";
                                                            echo '<option value="' . $new->name . '" ' . $sel . '>' . $new->name . '</option>';
                                                        }
                                                        ?>


                                                    </select>
                                                </div>	
                                            </div>

                                            <div class="col-md-4">
                                                <select name="test_instruction[]" class="form-control chzn test_instruction">

                                                    <?php
                                                    foreach ($test_ins as $new) {
                                                        $sel = "";
                                                        if ($new->name == $tests_ins1[$key])
                                                            $sel = "selected='selected'";
                                                        echo '<option value="' . $new->name . '" ' . $sel . '>' . $new->name . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <a href="#" class="delete_activity btn btn-danger"><?php echo lang('remove'); ?></a> 
                                            </div>

                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>



                            <div class="form-group input_fields_wrap1">
                                <div class="row  ">
                                    <div class="col-md-2">
                                        <label for="name" style="clear:both;"> <?php echo lang('medical_test'); ?></label>

                                    </div>

                                    <div class="col-md-4" >
                                        <div>
                                            <select name="report_id[]" class="form-control chzn report_id">
                                                <option value="">--<?php echo lang('select_medical_test'); ?>--</option>
                                                <?php
                                                foreach ($tests as $new) {
                                                    $sel = "";
                                                    echo '<option value="' . $new->name . '" ' . $sel . '>' . $new->name . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>	

                                    </div>
                                    <div class="col-md-4">
                                        <select name="test_instruction[]" class="form-control chzn test_instruction">
                                            <option value="">--<?php echo lang('medical_test_instruction'); ?>--</option>
                                            <?php
                                            foreach ($test_ins as $new) {
                                                $sel = "";
                                                echo '<option value="' . $new->name . '" ' . $sel . '>' . $new->name . '</option>';
                                            }
                                            ?>
                                        </select>

                                    </div>
                                    <div class="col-md-2">
                                        <button class="add_field_button1 btn btn-success"><?php echo lang('add'); ?> </button>
                                    </div>

                                </div>
                            </div>


                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="name" style="clear:both;"> <?php echo lang('remark'); ?></label>
                                    </div>	
                                    <div class="col-md-8">
                                        <textarea name="remark" class="form-control redactor remark"  ><?php echo @$prescription->remark; ?></textarea>
                                    </div>
                                </div>
                            </div>




                            <?php
                            if ($fields) {
                                foreach ($fields as $doc) {
                                    $output = '';
                                    if ($doc->field_type == 1) { //testbox
                                        ?>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                                                </div>

                                                <div class="col-md-4" >
                                                    <input type="text" class="form-control" name="reply[<?php echo $doc->id ?>]" id="req_doc" />
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    if ($doc->field_type == 2) { //dropdown list
                                        $values = explode(",", $doc->values);
                                        ?>	<div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                                                </div>

                                                <div class="col-md-4" >	
                                                    <select name="reply[<?php echo $doc->id ?>]" class="form-control">
                                                        <?php
                                                        foreach ($values as $key => $val) {
                                                            echo '<option value="' . $val . '">' . $val . '</option>';
                                                        }
                                                        ?>			
                                                    </select>	
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    if ($doc->field_type == 3) { //radio buttons
                                        $values = explode(",", $doc->values);
                                        ?>	<div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                                                </div>

                                                <div class="col-md-4" >
                    <?php foreach ($values as $key => $val) { ?>

                                                        <input type="radio" name="reply[<?php echo $doc->id ?>]" value="<?php echo $val; ?>" />	<?php echo $val; ?> &nbsp; &nbsp; &nbsp; &nbsp;
                                                    <?php }
                                                    ?>			
                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                    }
                                    if ($doc->field_type == 4) { //checkbox
                                        $values = explode(",", $doc->values);
                                        ?>	<div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                                                </div>

                                                <div class="col-md-4" >
                    <?php foreach ($values as $key => $val) { ?>

                                                        <input type="checkbox" name="reply[<?php echo $doc->id ?>]" value="<?php echo $val; ?>" class="form-control" />	&nbsp; &nbsp; &nbsp; &nbsp;
                                                    <?php }
                                                    ?>			
                                                </div>
                                            </div>
                                        </div>
                                    <?php } if ($doc->field_type == 5) { //Textarea
                                        ?>	<div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                                                </div>

                                                <div class="col-md-8" >
                                                    <textarea class="form-control" name="reply[<?php echo $doc->id ?>]" ></textarea		
                                                    ></div>
                                            </div>
                                        </div>



                                        <?php
                                    }
                                }
                            }
                            ?>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary update"><?php echo lang('update'); ?></button>
                            </div>
                        </form>				


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close') ?></button>  
                    </div>
                </div>
            </div>
        </div>
        <?php
        $i++;
    }
    ?>
<?php endif; ?>







<?php if (isset($prescriptions)): ?>
    <?php
    $i = 1;
    foreach ($prescriptions as $prescription) {
//        $date = new DateTime($prescription->dob);
//        $now = new DateTime();
//        $interval = $now->diff($date);
        ?>

        <!-- Modal -->
        <div class="modal fade" id="myModal<?php echo $prescription->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="width:800px;">
                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><?php echo lang('view'); ?> <?php echo lang('prescription'); ?> </h4>
                    </div>
                    <div class="modal-body" >
                        <table width="100%" border="0" id="printTable<?php echo $prescription->id ?>"  class="pt" style="padding-bottom:0px; height:85%;" >
                            <thead>
                                <tr>
                                    <td>
                                        <table width="100%" style="border-bottom:1px solid;">
                                            <tr>
                                                <td style="line-height:110%">
        <?php echo @$template->header; ?>											
                                                </td>

                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>	
                                <tr>
                                    <td >
                                        <table width="100%">
                                            <tr>
                                                <td width="40%"><b><?php echo lang('name') ?></b> : <?php echo substr($prescription->patient, 0, 20) ?></td>
                                                <td ><b><?php echo lang('sex') ?></b> : <?php echo $prescription->gender ?></td>
                                                <td ><b><?php echo lang('id') ?></b> : <?php echo $this->patient_model->convertId($prescription->patient_id) ?></td>
                                                <td ><b><?php echo lang('date') ?></b> : <?php echo date("d-m-y", strtotime($prescription->date_time)) ?></td>
                                            </tr>
                                        </table>	
                                    </td>
                                </tr>

                                <tr height="100%">
                                    <td valign="top">
                                        <table width="100%" border="0">
                                            <tr>
                                                <td width="51%" valign="top">
                                                    <table width="80%" border="0">
                                                        <tr>
                                                            <td width="100%">
                                                                <table border="0" >
                                                                    <tr>
                                                                        <td><b>Medical History</b></td>
                                                                    </tr>
                                                                    <?php
                                                                    $c = json_decode($prescription->case_history_id);

                                                                    if (is_array($c)) {
                                                                        foreach ($c as $new) {
                                                                            echo '<tr><td>' . $dis = $new . '</td></tr>';
                                                                        }
                                                                    } else {
                                                                        echo '<tr><td>' . $c . '</td></tr>';
                                                                    }
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo $prescription->case_history ?></td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <table border="0">
                                                                    <tr>
                                                                        <td><b>O/E</b></td>
                                                                    </tr>
                                                                    <?php
                                                                    $d = json_decode($prescription->disease);

                                                                    if (is_array($d)) {
                                                                        foreach ($d as $new) {
                                                                            echo '<tr><td>' . $dis = $new . '</td></tr>';
                                                                        }
                                                                    } else {
                                                                        echo '<tr><td>' . $d . '</td></tr>';
                                                                    }
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo $prescription->oe_description; ?></td>
                                                                    </tr>		
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="51%">
                                                                <?php
                                                                $d = json_decode($prescription->tests);
                                                                //echo '<pre>'; print_r($d);'</pre>';
                                                                if (!empty($d[0])) {
                                                                    ?>
                                                                    <table border="0" width="100%">
                                                                        <tr>
                                                                            <td><b><?php echo lang('test') ?></b></td>
                                                                        </tr>
                                                                        <?php
                                                                        $ins = json_decode($prescription->test_instructions);
                                                                        if (is_array($d)) {
                                                                            $i = 1;
                                                                            foreach ($d as $key => $new) {

                                                                                echo '<tr><td>' . $i . '. ' . $d[$key] . '<td></tr>';
                                                                                if (!empty($ins[$key])) {
                                                                                    echo '<tr><td><p style="padding-left:14px;"><small>(' . $ins[$key] . ')</small></p><td></tr>';
                                                                                }
                                                                                $i++;
                                                                            }
                                                                        } else {
                                                                            echo '<tr><td>' . $i . ' ' . $d . '<td></tr>';
                                                                            echo '<tr><td><p style="padding-left:14px;"><small>( ' . $ins . ' )</small></p><td></tr>';
                                                                        }
                                                                        ?>
                                                                    </table>	
        <?php } ?>		
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td valign="top">
                                                    <table border="0" width="100%" >
                                                        <tr>
                                                            <td><p><span style="font-size:26px"><b>R</span ><sub style="font-size:18px">x</b></sub></p></td>
                                                        </tr>
                                                        <?php
                                                        $d = json_decode($prescription->medicines);
                                                        $ins = json_decode($prescription->medicine_instruction);
                                                        if (is_array($d)) {
                                                            $i = 1;
                                                            foreach ($d as $key => $new) {
                                                                if (!empty($d[$key]))
                                                                    echo '<tr><td style="padding-left:18px;">' . $i . '. ' . $d[$key] . '<td></tr>';
                                                                echo '<tr><td><p style="padding-left:32px;"><small>' . @$ins[$key] . '</small></p><td></tr>';
                                                                $i++;
                                                            }
                                                        }else {
                                                            echo '<tr><td style="padding-left:18px;">' . $i . ' ' . $d . '<td></tr>';
                                                            echo '<tr><td><p style="padding-left:32px;"><small>' . $ins . '</small></p><td></tr>';
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td>
        <?php if (!empty($prescription->remark)) { ?>
                                                                    <table width="100%" border="0">
                                                                        <tr>
                                                                            <td><b><?php echo lang('remark') ?></b></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><?php echo $prescription->remark ?></td>
                                                                        </tr>
                                                                    </table>
        <?php } ?>		
                                                            </td>	
                                                        </tr>	
                                                    </table>	
                                                </td>
                                            </tr>

                                        </table>
                                    </td>
                                </tr>

                            </tbody>
                            <tfoot>	
                                <tr>	
                                    <td style="border-top:1px solid;" class="aligncenter">

        <?php echo @$template->footer; ?>
                                    </td>
                                </tr>
                            </tfoot>	

                        </table>


                        <div class="form-group no-print">		
                            <div class="row no-print">
                                <div class="col-sm-4 pull-right">
                                    <a href="#"class="btn btn-default yes-print no-print" id="print_p"  onclick="printData<?php echo $prescription->id ?>();" style="margin-right: 5px;"><i class="fa fa-print"></i> <?php echo lang('print') ?>
                                        <a target="_blank" href="<?php echo site_url('admin/prescription/pdf/' . $prescription->id) ?>" id="pdf" class="btn btn-primary  no-print" style="margin-right: 5px;"><i class="fa fa-download"></i> <?php echo lang('generate_pdf') ?></a>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close') ?></button>  
                    </div>
                </div>
            </div>
        </div>
        <script>
            function printData<?php echo $prescription->id ?>()
            {
                var divToPrint = document.getElementById("printTable<?php echo $prescription->id ?>");
                document.getElementById("print_p").style.display = 'none';
                document.getElementById("pdf").style.display = 'none';
                newWin = window.open("");
                newWin.document.write(divToPrint.outerHTML);
                newWin.print();
                newWin.close();
            }

            $('.yes-print').on('click', function () {
                printData<?php echo $prescription->id ?>();
            })
        </script> 

        <?php
        $i++;
    }
    ?>
<?php endif; ?>








<?php if (isset($prescriptions)): ?>
    <?php
    $i = 1;
    foreach ($prescriptions as $pre) {
        ?>
        <!-- Modal -->

        <div class="modal fade" id="report<?php echo $pre->id ?>" tabindex="-1" role="dialog" aria-labelledby="reportlabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="reportlabel"><?php echo lang('view_diagonsis_report'); ?></h4>
                    </div>
                    <div class="modal-body">
                        <form method="post" class="theform<?php echo $pre->id; ?>" action="<?php echo site_url('admin/prescription/reports/' . $pre->id) ?>" enctype="multipart/form-data" >						
                            <input type="hidden" name="p_id" value="<?php echo $pre->id ?>" />								
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="name" style="clear:both;"> <?php echo lang('type'); ?></label>
                                    </div>	

                                    <div class="col-md-6">
                                        <select name="type_id" class="form-control chzn">
                                            <option value="">--<?php echo lang('select_report') ?>--</option>
                                            <?php
                                            foreach ($tests as $new) {
                                                $sel = "";

                                                echo '<option value="' . $new->id . '" ' . $sel . '>' . $new->name . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>	
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="name" style="clear:both;"> <?php echo lang('upload_file'); ?></label>
                                    </div>	

                                    <div class="col-md-6">
                                        <input type="file" name="file" class="form-control" />
                                    </div>	
                                </div>
                            </div>




                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="name" style="clear:both;"> <?php echo lang('remark'); ?></label>
                                    </div>	
                                    <div class="col-md-6">
                                        <textarea name="remark" class="form-control" required="required"></textarea>
                                    </div>
                                </div>
                            </div>





                            <div class="box-footer">
                                <input type="submit" name="save" id="save" value="<?php echo lang('save'); ?>" class="btn btn-primary" />
                            </div>

                        </form>				

                        <?php
                        $reports = $this->prescription_model->get_reports_by_id($pre->id);
                        if (isset($reports)):
                            ?>	
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th><?php echo lang('date'); ?></th>
                                        <th><?php echo lang('type'); ?></th>
                                        <th><?php echo lang('remark'); ?></th>
                                        <th><?php echo lang('from'); ?></th>
                                        <th><?php echo lang('to'); ?></th>
                                        <th width="20%"><?php echo lang('action'); ?></th>
                                    </tr>
                                </thead>


                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($reports as $prescription) {
                                        //if($prescription)
                                        ?>
                                        <tr class="gc_row">
                                            <td><?php echo date("d/m/y h:i", strtotime($prescription->date_time)) ?></td>
                                            <td><?php echo $prescription->type ?></td>
                                            <td><?php echo $prescription->remark ?></td>
                                            <td><?php echo $prescription->from_user ?></td>
                                            <td><?php echo $prescription->to_user ?></td>
                                            <td width="20%">
                                                <div class="btn-group">
                                                    <?php if (!empty($prescription->file)) { ?>	
                                                        <a href="<?php echo base_url('assets/uploads/files/' . $prescription->file) ?>" class="btn btn-default"  download><?php echo lang('download') ?></a>
                <?php } else { ?>
                                                        <a href="#" class="btn btn-default" style="width:85px;">N/A</a>
                <?php } ?>  
                                                    <a class="btn btn-danger" style="margin-left:10px;" href="<?php echo site_url('admin/prescription/delete_report/' . $prescription->id); ?>" onclick="return areyousure()"><i class="fa fa-trash"></i> <?php echo lang('delete'); ?></a>
                                                </div>
                                            </td>
                                        </tr>
                <?php
                $i++;
            }
            ?>
                                </tbody>

                            </table>
        <?php endif; ?>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close') ?></button>  
                    </div>
                </div>
            </div>
        </div>
        <?php
        $i++;
    }
    ?>
<?php endif; ?>

<?php if (isset($prescriptions)): ?>
    <?php
    $i = 1;
    foreach ($prescriptions as $pre) {
        ?>

        <script>
            var check = false;
            $(document).ready(function () {
                $('.theform<?php echo $pre->id; ?>').submit(function (e) {

                    if (check == false) {
                        event.preventDefault();
                        call_loader();
                        setTimeout(function () {
                            check = true;
                            $(".theform<?php echo $pre->id; ?>").submit();

                        }, 2000);
                    }

                });

            });

        </script>
        <?php
        $i++;
    }
    ?>
<?php endif; ?>



<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js') ?>" type="text/javascript"></script>
<script type="text/javascript">


            $(document).on('change', '#prescription_id', function () {
                vch = $(this).val();

                call_loader_ajax();

                $.ajax({
                    url: '<?php echo site_url('admin/prescription/get_prescription') ?>',
                    type: 'POST',
                    data: {id: vch},
                    success: function (result) {
                        //alert(result);return false;

                        $('#result').html(result);
                        $(".chzn").chosen({search_contains: true});
                        $('#example1').dataTable({});
                        $("#overlay").hide();

                    }
                });
            });


</script>


<script src="<?php echo base_url('assets/js/chosen.jquery.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/redactor.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.datetimepicker.js') ?>" type="text/javascript"></script>
<script>


            $(".update").click(function (event) {
                event.preventDefault();
//$(this).closest("form").submit();	
                var form = $(this).closest('form');

                id = $(form).find('input[name=id]').val();
<?php /*
  patient_id = $(form ).find('.patient_id').val();
  date_time = $(form ).find('input[name=date_time]').val();
  case_history = $(form ).find('.case_history').val();
  case_history_id = $(form ).find('.case_history_id').val();
  disease_id = $(form ).find('.disease_id').val();
  instruction = $(form ).find('.instruction').val();
  test_instruction = $(form ).find('.test_instruction').val();
  remark = $(form ).find('.remark').val();
  medicine_id = $(form ).find('.medicine_id').val();
  oe_description = $(form ).find('.oe_description').val();

  report_id = $(form ).find('.report_id').val();
  data = 	$('#edit').serializeArray();

  alert(medicine_id);return false;
 */ ?>
                call_loader_ajax();
                $.ajax({
                    url: '<?php echo site_url('admin/prescription/edit') ?>/' + id,
                    type: 'POST',
                    data: $(this).closest('#edit_form').serialize(),

                    success: function (result) {
                        //alert(result);return false;
                        if (result == 1)
                        {
                            location.reload();
                            // $('#edit'+id).modal('hide');
                            //window.close(); 
                        } else
                        {
                            $("#overlay").hide();
                            $('#err_edit' + id).html(result);
                        }

                        $(".chzn").chosen();
                    }
                });


            });


            $(document).ready(function () {
                $(".chzn").chosen();
                $('#example1').dataTable({
                    "aaSorting": [[0, 'desc']]
                });
                $('.delete_activity').click(function () {
                    $(this).closest('.row').remove();
                });
            });

</script>

<script type="text/javascript">
    jQuery('.datepicker').datetimepicker({
        lang: 'en',
        i18n: {
            de: {
                months: [
                    'January', 'February', 'March', 'April',
                    'May', 'June', 'July', 'August',
                    'September', 'October', 'November', 'December',
                ],
                dayOfWeek: [
                    "Sun.", "Mon", "Tue", "Wed",
                    "Thu", "Fri", "Sat",
                ]
            }
        },
        timepicker: true,
        format: 'Y-m-d H:i'
    });



</script>


<script type="text/javascript">
    $(function () {

        $('.chzn').chosen({search_contains: true});

    });




    $(document).on('change', '#patient_id', function () {
        //alert(12);
        var form = $(this).closest('form');

        id = $(form).find('input[name=id]').val();
        patient_id = $(form).find('#patient_id').val();
        //alert(id);return false;

        call_loader_ajax();
        $.ajax({
            url: '<?php echo site_url('admin/prescription/get_case_history') ?>',
            type: 'POST',
            data: {patient_id: patient_id, },

            success: function (result) {
                //alert(result);return false;
                $("#overlay").hide();
                $('#result' + id).html(result);
                $(".chzn").chosen();
            }
        });
    });


    $(document).ready(function () {
        var max_fields = 100; //maximum input boxes allowed
        var wrapper = $(".input_fields_wrap"); //Fields wrapper
        var add_button = $(".add_field_button"); //Add button ID

        var x = 1; //initlal text box count
        $(add_button).click(function (e) { //on add input button click
            e.preventDefault();
            if (x < max_fields) { //max input box allowed
                x++; //text box increment
                $(wrapper).append('</br><div class="row"><div class="col-md-2"></div><div class="col-md-4"><select name="medicine_id[]" class="form-control chzn"><option value="">--<?php echo lang('select_medicine'); ?>--</option><?php
foreach ($medicines as $new) {
    echo '<option value="' . $new->name . '">' . $new->name . '</option>';
}
?></select></div><div class="col-md-4"><select name="instruction[]" class="form-control chzn"><option value="">--<?php echo lang('medicine_instruction'); ?>--</option><?php
foreach ($medicine_ins as $new) {
    echo '<option value="' . $new->name . '">' . $new->name . '</option>';
}
?></select></div><a href="#" class="remove_field btn btn-danger"><?php echo lang('remove'); ?></a></div></div>'); //add input box
                $('.chzn').chosen({search_contains: true});
            }
        });

        $(wrapper).on("click", ".remove_field", function (e) { //user click on remove text
            e.preventDefault();
            $(this).parent('div').remove();
            x--;
        })
    });



    $(document).ready(function () {
        var max_fields = 100; //maximum input boxes allowed
        var wrapper = $(".input_fields_wrap1"); //Fields wrapper
        var add_button = $(".add_field_button1"); //Add button ID

        var x = 1; //initlal text box count
        $(add_button).click(function (e) { //on add input button click
            e.preventDefault();
            if (x < max_fields) { //max input box allowed

                x++; //text box increment
                $(wrapper).append('</br><div class="row"><div class="col-md-2"></div><div class="col-md-4"><select name="report_id[]" class="form-control chzn"><option value="">--<?php echo lang('select_medical_test'); ?>--</option><?php
foreach ($tests as $new) {
    echo '<option value="' . $new->name . '">' . $new->name . '</option>';
}
?></select></div><div class="col-md-4"><select name="test_instruction[]" class="form-control chzn"><option value="">--<?php echo lang('medical_test_instruction'); ?>--</option><?php
foreach ($test_ins as $new) {
    echo '<option value="' . $new->name . '">' . $new->name . '</option>';
}
?></select></div><a href="#" class="remove_field1 btn btn-danger"><?php echo lang('remove'); ?></a></div></div>'); //add input box
                $('.chzn').chosen({search_contains: true});
            }
        });

        $(wrapper).on("click", ".remove_field1", function (e) { //user click on remove text
            e.preventDefault();
            $(this).parent('div').remove();
            x--;
        })
    });

    function call_loader() {

        if ($('#overlay').length == 0) {
            var over = '<div id="overlay">' +
                    '<img  style="padding-top:300px; padding-left:500px;"id="loading" src="<?php echo base_url('assets/img/green-ajax-loader.gif') ?>"></div>';

            $(over).appendTo('body');
        }
    }

</script>