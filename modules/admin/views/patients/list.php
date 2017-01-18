<?php //var_dump($this->_ci_cached_vars); die();?>
<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/chosen.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/jquery.datetimepicker.css') ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    function areyousure()
    {
        return confirm('Are You Sure');
    }
</script>
<style>
    .chosen-container{width:100% !important}
</style>
<section class="content-header">
    <h1>
        <?php echo $page_title; ?>
        <small><?php echo lang('list') ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard') ?></a></li>
        <li class="active"><?php echo lang('patients') ?></li>
    </ol>
</section>

<section class="content">
    <?php
    if (validation_errors()) {
        ?>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
            <b><?php echo lang('alert'); ?>!</b><?php echo validation_errors(); ?>
        </div>

    <?php } ?>
    <?php /*
      <div class="row" style="margin-bottom:10px;">
      <div class="col-xs-12">
      <div class="">
      <div class="col-xs-4">
      <select name="filter" id="patient_id" class="form-control chzn">
      <option value="0">--<?php echo lang('filter')?>--</option>
      <?php foreach($patients as $new) {
      $sel = "";
      echo '<option value="'.$new->id.'" '.$sel.'>'.$new->name.', '.$new->username.', '.$new->contact.'</option>';
      }

      ?>
      </select>
      </div>


      </div>
      </div>
      </div>
     */ ?>


    <div class="row" style="margin-bottom:10px;">
        <div class="col-xs-12">
            <div class="btn-group pull-right">
                <a class="btn btn-default" href="#add" data-toggle="modal"><i class="fa fa-plus"></i> <?php echo lang('add_new') ?> </a>
                <a class="btn btn-danger" style="margin-left:12px;" href="<?php echo site_url('admin/patients/export/'); ?>"><i class="fa fa-download"></i> <?php echo lang('export') ?></a>
            </div>
        </div>    
    </div>	

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo lang('patients') ?></h3>                                    
                </div><!-- /.box-header -->

                <div class="col-xs-6"  style="float:right">
                    <form method="post">
                        <div class="col-xs-5">
                            <input type="text" name="search" value="<?php echo @$_POST['search'] ?>" placeholder="Search" class="form-control" required="required" />
                        </div>
                        <div class="col-xs-5">
                            <select name="filter_id" class="form-control" >
                                <option value="">--Filter--</option>
                                <option value="name" <?php echo (@$_POST['filter_id'] == "name") ? 'selected="selected"' : ''; ?> ><?php echo lang('name'); ?></option>
                                <option value="address" <?php echo (@$_POST['filter_id'] == "address") ? 'selected="selected"' : ''; ?>><?php echo lang('address'); ?></option>
                                <option value="gender" <?php echo (@$_POST['filter_id'] == "gender") ? 'selected="selected"' : ''; ?>><?php echo lang('gender'); ?></option>
                                <option value="dob" <?php echo (@$_POST['filter_id'] == "dob") ? 'selected="selected"' : ''; ?>><?php echo lang('age'); ?></option>
                                <option value="contact" <?php echo (@$_POST['filter_id'] == "contact") ? 'selected="selected"' : ''; ?>><?php echo lang('phone'); ?></option>
                                <option value="email" <?php echo (@$_POST['filter_id'] == "email") ? 'selected="selected"' : ''; ?>><?php echo lang('email'); ?></option>
                                <option value="username" <?php echo (@$_POST['filter_id'] == "username") ? 'selected="selected"' : ''; ?>><?php echo lang('username'); ?></option>
                            </select>
                        </div>
                        <div class="col-xs-2">
                            <input type="submit" name="ok" value="<?php echo lang('search'); ?>" class="btn btn-default" />
                        </div>
                    </form>		
                </div>
                <div class="box-body table-responsive" style="margin-top:40px;" id="result">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo lang('id') ?></th>
                                <th><?php echo lang('pet_owner_name') ?></th>
                                <th><?php echo lang('address') ?></th>
                                <th><?php echo lang('gender') ?></th>
                                <th><?php echo lang('phone') ?></th>
                                <th><?php echo lang('email') ?></th>
                                <th><?php echo lang('username') ?></th>
                                <th width="35%" style="display:none"><?php echo lang('action') ?></th>
                            </tr>
                        </thead>

                        <?php if (isset($patients)): ?>
                            <tbody style="cursor:pointer">
                                <?php $i = 1;
                                foreach ($patients as $new) { ?>
                                    <tr class="gc_row">
                                        <td id="<?php echo $new->id ?>"><?php echo $this->patient_model->convertId($new->id); ?></td>
                                        <td id="<?php echo $new->id ?>"><?php echo ucwords($new->name) ?></td>
                                        <td id="<?php echo $new->id ?>"><?php echo $new->address ?></td>
                                        <td id="<?php echo $new->id ?>"><?php echo $new->gender ?></td>
                                        <td id="<?php echo $new->id ?>"><?php echo $new->contact ?></td>
                                        <td id="<?php echo $new->id ?>"><?php echo $new->email ?></td>
                                        <td id="<?php echo $new->id ?>"><?php echo $new->username ?></td>
                                        <td width="35%" style="display:none">
                                            <div class="btn-group">
                                                <a class="btn btn-default"  href="#view<?php echo $new->id; ?>" data-toggle="modal"><i class="fa fa-eye"></i> <?php echo lang('view') ?></a>
                                                <a class="btn btn-primary"  style="margin-left:12px;" href="#edit<?php echo $new->id; ?>" data-toggle="modal"><i class="fa fa-edit"></i> <?php echo lang('edit') ?></a>
                                                <a class="btn btn-danger" style="margin-left:20px;" href="<?php echo site_url('admin/patients/delete/' . $new->id); ?>" onclick="return areyousure()"><i class="fa fa-trash"></i> <?php echo lang('delete') ?></a>
                                            </div>

                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                    Action <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                                                    <li>
                                                        <a href="<?php echo site_url('admin/patients/payment_history/' . $new->id); ?>">
                                                            <i class="entypo-eye"></i>
        <?php echo lang('payment_history') ?>                               </a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a href="<?php echo site_url('admin/patients/medication_history/' . $new->id); ?>">
                                                            <i class="entypo-eye"></i>
        <?php echo lang('medication_history') ?> </a>                        </a>
                                                    </li>



                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                <?php $i++;
                            } ?>
                            </tbody>
<?php endif; ?>
                    </table>

                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section>

<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="addlabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content ff">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="addlabel"><?php echo lang('add'); ?> <?php echo lang('patient') ?></h4>
            </div>
            <div class="modal-body">
                <div id="err">  
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
                <form method="post" action="<?php echo site_url('admin/patients/add/') ?>" id="add_form" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name" style="clear:both;">First Name</label>
                                    <input type="text" name="fname" value="" class="form-control name">
                                </div>
                            </div>
                        </div>
                         <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name" style="clear:both;">Last Name</label>
                                    <input type="text" name="lname" value="" class="form-control name">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name" style="clear:both;">Pet's Name</label>
                                    <input type="text" name="pet_name" value="" class="form-control name">
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
                                            <div class="col-md-6">
                                                <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
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
                                            <div class="col-md-6">
                                                <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
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
                                            <div class="col-md-6">
                                                <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>

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
                                            <div class="col-md-6">
                                                <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>

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
                                            <div class="col-md-6">
                                                <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                                                <textarea class="form-control" name="reply[<?php echo $doc->id ?>]" ></textarea		
                                                ></div>
                                        </div>
                                    </div>



                                    <?php
                                }
                            }
                        }
                        ?>	
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="username" style="clear:both;"><?php echo lang('username') ?></label>
                                    <input type="text" name="username" value="Will be generated and mailed to patient" class="form-control name" readonly="readonly">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="username" style="clear:both;"><?php echo lang('password') ?></label>
                                    <input type="text" name="password" value="Will be generated and mailed to patient" class="form-control name" readonly="readonly">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="contact" style="clear:both;"><?php echo lang('address') ?></label>
                                    <textarea name="address"  class="form-control address"><?php echo set_value('address') ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="gender" style="clear:both;"><?php echo lang('gender') ?></label>
                                    <input type="radio" name="gender" class="gender"value="Male" <?php echo (set_value('gender') == "Male") ? 'checked="checked"' : ''; ?>  /> <?php echo lang('male') ?>
                                    <input type="radio" name="gender" class="gender" value="Female"  <?php echo (set_value('gender') == "Female") ? 'checked="checked"' : ''; ?>/> <?php echo lang('female') ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="contact" style="clear:both;"><?php echo lang('phone') ?></label>
                                    <input type="text" name="contact" value="<?php echo set_value('contact') ?>" class="form-control contact">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="email" style="clear:both;"><?php echo lang('email') ?></label>
                                    <input type="text" name="email" value="<?php echo set_value('email') ?>" class="form-control email">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary" ><?php echo lang('save') ?></button>

                    </div><!-- /.box-body -->

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close') ?></button>  
            </div>
        </div>
    </div>
</div>





<?php if (isset($patients)): ?>
    <?php
    $i = 1;
    foreach ($patients as $new) {
        $patient = $this->patient_model->get_patient_by_id($new->id);
        ?>
        <!-- Modal -->

        <div class="modal fade" id="view<?php echo $new->id ?>" tabindex="-1" role="dialog" aria-labelledby="viewlabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="viewlabel"><?php echo lang('view'); ?> <?php echo lang('patient') ?></h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="name" style="clear:both;"><?php echo lang('name') ?></label>
                                </div>
                                <div class="col-md-4">	
        <?php echo $patient->name ?>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="gender" style="clear:both;"><?php echo lang('gender') ?></label>
                                </div>
                                <div class="col-md-4">	
        <?php echo $patient->gender ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="name" style="clear:both;"><?php echo lang('blood_type'); ?></label>
                                </div>
                                <div class="col-md-4">		  

                                    <?php
                                    foreach ($groups as $new) {
                                        $sel = "";
                                        if ($new->id == $patient->blood_group_id) {
                                            echo $new->name;
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="dob" style="clear:both;">Age</label>

                                </div>
                                <div class="col-md-4">	
        <?php echo date("Y") - $patient->dob ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="email" style="clear:both;"><?php echo lang('email') ?></label>
                                </div>
                                <div class="col-md-4">		
        <?php echo $patient->email ?>

                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="username" style="clear:both;"><?php echo lang('username') ?></label>
                                </div>
                                <div class="col-md-4">	
        <?php echo $patient->username ?>
                                </div>
                            </div>
                        </div>




                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="contact" style="clear:both;"><?php echo lang('phone') ?></label>
                                </div>
                                <div class="col-md-4">		
        <?php echo $patient->contact ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="contact" style="clear:both;"><?php echo lang('address') ?></label>
                                </div>
                                <div class="col-md-4">		
        <?php echo $patient->address ?>
                                </div>
                            </div>
                        </div>

                        <?php
                        $CI = get_instance();
                        if ($fields) {
                            foreach ($fields as $doc) {
                                $output = '';
                                if ($doc->field_type == 1) { //testbox
                                    ?>
                                    <div class="form-group">
                                        <div class="row">

                                            <div class="col-md-3">
                                                <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                                            </div>
                                            <div class="col-md-4">	
                                                <?php $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '" . $doc->id . "' AND table_id = '" . $patient->id . "' AND form = '" . $doc->form . "' ")->row(); ?>		
                                                <?php echo @$result->reply; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                if ($doc->field_type == 2) { //dropdown list
                                    $values = explode(",", $doc->values);
                                    ?>	<div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                                            </div>
                                            <div class="col-md-4">
                                                <?php $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '" . $doc->id . "' AND table_id = '" . $patient->id . "'  ")->row(); ?>	
                                                <?php
                                                $values = array();
                                                foreach ($values as $key => $val) {
                                                    $sel = '';
                                                    if ($val == $result->reply)
                                                        echo $val;
                                                }
                                                ?>			
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                if ($doc->field_type == 3) { //radio buttons
                                    $values = explode(",", $doc->values);
                                    ?>	<div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>

                                            </div>
                                            <div class="col-md-4">	
                                                <?php foreach ($values as $key => $val) { ?>
                                                    <?php
                                                    $x = "";
                                                    $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '" . $doc->id . "' AND table_id = '" . $patient->id . "' AND form = '" . $doc->form . "' ")->row();
                                                    if (!empty($result->reply)) {
                                                        if ($result->reply == $val) {
                                                            $x = 'checked="checked"';
                                                        } else {
                                                            $x = '';
                                                        }
                                                    }
                                                    ?>			

                                                    <input type="radio" name="reply[<?php echo $doc->id ?>]"disabled="disabled" value="<?php echo $val; ?>" <?php echo $x; ?> />	<?php echo $val; ?> &nbsp; &nbsp; &nbsp; &nbsp;
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
                                            <div class="col-md-3">
                                                <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                                            </div>
                                            <div class="col-md-4">
                                                <?php foreach ($values as $key => $val) { ?>
                                                    <?php
                                                    $x = "";
                                                    $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '" . $doc->id . "' AND table_id = '" . $patient->id . "' AND form = '" . $doc->form . "' ")->row();
                                                    if (!empty($result->reply)) {
                                                        if ($result->reply == $val) {
                                                            $x = 'checked="checked"';
                                                        } else {
                                                            $x = '';
                                                        }
                                                    }
                                                    ?>	

                                                    <input type="checkbox" disabled="disabled" name="reply[<?php echo $doc->id ?>]"  <?php echo $x; ?> value="<?php echo $val; ?>" class="form-control" />	&nbsp; &nbsp; &nbsp; &nbsp;
                                                <?php }
                                                ?>			
                                            </div>
                                        </div>
                                    </div>
                                <?php } if ($doc->field_type == 5) { //Textarea
                                    ?>	<div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                                            </div>
                                            <div class="col-md-4">
                                                <?php $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '" . $doc->id . "' AND table_id = '" . $patient->id . "' AND form = '" . $doc->form . "'")->row(); ?>	
                                                <?php echo @$result->reply; ?>
                                            </div>
                                        </div>
                                    </div>



                                    <?php
                                }
                            }
                        }
                        ?>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close') ?></button>  
                    </div>
                </div>
            </div>
        </div>
        <?php $i++;
    } ?>
<?php endif; ?>


<?php if (isset($patients)): ?>
    <?php
    $i = 1;
    foreach ($patients as $new) {
        $patient = $this->patient_model->get_patient_by_id($new->id);
        ?>
        <!-- Modal -->
        <div class="modal fade" id="edit<?php echo $new->id ?>" tabindex="-1" role="dialog" aria-labelledby="editlabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content ff">
                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="editlabel"><?php echo lang('edit'); ?> <?php echo lang('patient') ?></h4>
                    </div>
                    <div class="modal-body">

                        <div id="err_edit<?php echo $new->id ?>">  
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

                        <form method="post" action="<?php echo site_url('admin/patients/edit/' . $new->id) ?>" id="edit" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $new->id; ?>" />
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="name" style="clear:both;"><?php echo lang('name') ?></label>
                                        <input type="text" name="name" value="<?php echo $patient->name ?>" class="form-control name">
                                    </div>
                                </div>
                            </div>



                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="gender" style="clear:both;"><?php echo lang('gender') ?></label>
                                        <input type="radio"  name="gender" class="gender" <?php echo $chk = ($patient->gender == "Male") ? 'checked="checked"' : ''; ?>value="Male" /> <?php echo lang('male') ?>
                                        <input type="radio" name="gender" class="gender" <?php echo $chk = ($patient->gender == "Female") ? 'checked="checked"' : ''; ?> value="Female" /> <?php echo lang('female') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="name" style="clear:both;"><?php echo lang('blood_type'); ?></label>
                                        <select name="blood_id" class="form-control blood_id">
                                            <option value="">--<?php echo lang('select_blood_type'); ?>--</option>
                                            <?php
                                            $groups = $this->patient_model->get_blood_group();
                                            foreach ($groups as $new) {
                                                $sel = "";
                                                if ($new->id == $patient->blood_group_id)
                                                    $sel = "selected='selected'";
                                                echo '<option value="' . $new->id . '" ' . $sel . '>' . $new->name . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="dob" style="clear:both;">Age</label>
                                        <input type="text" name="dob" value="<?php echo date("Y") - $patient->dob ?>"class="form-control dob">

                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="email" style="clear:both;"><?php echo lang('email') ?></label>
                                        <input type="text" name="email" value="<?php echo $patient->email ?>" class="form-control email">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="username" style="clear:both;"><?php echo lang('username') ?></label>
                                        <input type="text" name="username"  readonly="readonly" value="<?php echo $patient->username ?>" class="form-control username">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="password" style="clear:both;"><?php echo lang('password') ?></label>
                                        <input type="password" name="password" value="" class="form-control password">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="password" style="clear:both;"><?php echo lang('confirm') ?> <?php echo lang('password') ?></label>
                                        <input type="password" name="confirm" value="" class="form-control confirm">
                                    </div>
                                </div>
                            </div>



                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="contact" style="clear:both;"><?php echo lang('phone') ?></label>
                                        <input type="text" name="contact" value="<?php echo $patient->contact ?>" class="form-control contact">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="contact" style="clear:both;"><?php echo lang('address') ?></label>
                                        <textarea name="address"  class="form-control address"><?php echo $patient->address ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $CI = get_instance();
                            if ($fields) {
                                foreach ($fields as $doc) {
                                    $output = '';
                                    if ($doc->field_type == 1) { //testbox
                                        ?>
                                        <div class="form-group">
                                            <div class="row">

                                                <div class="col-md-4">
                                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                                                    <?php $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '" . $doc->id . "' AND table_id = '" . $patient->id . "' AND form = '" . $doc->form . "' ")->row(); ?>		
                                                    <input type="text" class="form-control" name="reply[<?php echo $doc->id ?>]" value="<?php echo @$result->reply; ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    if ($doc->field_type == 2) { //dropdown list
                                        $values = explode(",", $doc->values);
                                        ?>	<div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                                                    <?php $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '" . $doc->id . "' AND table_id = '" . $patient->id . "' AND form = '" . $doc->form . "' ")->row(); ?>	
                                                    <select name="reply[<?php echo $doc->id ?>]" class="form-control">
                                                        <?php
                                                        foreach ($values as $key => $val) {
                                                            $sel = '';
                                                            if ($val == $result->reply)
                                                                $sel = "selected='selected'";
                                                            echo '<option value="' . $val . '" ' . $sel . '>' . $val . '</option>';
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
                                                <div class="col-md-4">
                                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>

                                                    <?php foreach ($values as $key => $val) { ?>
                                                        <?php
                                                        $x = "";
                                                        $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '" . $doc->id . "' AND table_id = '" . $patient->id . "' AND form = '" . $doc->form . "' ")->row();
                                                        if (!empty($result->reply)) {
                                                            if ($result->reply == $val) {
                                                                $x = 'checked="checked"';
                                                            } else {
                                                                $x = '';
                                                            }
                                                        }
                                                        ?>			

                                                        <input type="radio" name="reply[<?php echo $doc->id ?>]" value="<?php echo $val; ?>" <?php echo $x; ?> />	<?php echo $val; ?> &nbsp; &nbsp; &nbsp; &nbsp;
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
                                                <div class="col-md-4">
                                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>

                                                    <?php foreach ($values as $key => $val) { ?>
                                                        <?php
                                                        $x = "";
                                                        $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '" . $doc->id . "' AND table_id = '" . $patient->id . "' AND form = '" . $doc->form . "' ")->row();
                                                        if (!empty($result->reply)) {
                                                            if ($result->reply == $val) {
                                                                $x = 'checked="checked"';
                                                            } else {
                                                                $x = '';
                                                            }
                                                        }
                                                        ?>	

                                                        <input type="checkbox" name="reply[<?php echo $doc->id ?>]"  <?php echo $x; ?> value="<?php echo $val; ?>" class="form-control" />	&nbsp; &nbsp; &nbsp; &nbsp;
                                                    <?php }
                                                    ?>			
                                                </div>
                                            </div>
                                        </div>
                                    <?php } if ($doc->field_type == 5) { //Textarea
                                        ?>	<div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                                                    <?php $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '" . $doc->id . "' AND table_id = '" . $patient->id . "' AND form = '" . $doc->form . "'")->row(); ?>	
                                                    <textarea class="form-control" name="reply[<?php echo $doc->id ?>]" ><?php echo @$result->reply; ?></textarea>
                                                </div>
                                            </div>
                                        </div>



                                        <?php
                                    }
                                }
                            }
                            ?>		

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary update" name="update"><?php echo lang('update') ?></button>
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close') ?></button>  
                    </div>
                </div>
            </div>
        </div>
        </form>
        <?php $i++;
    } ?>
<?php endif; ?>



<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/chosen.jquery.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/jquery.datetimepicker.js') ?>" type="text/javascript"></script>

<script type="text/javascript">
                                            $("#add_form").submit(function (event) {
                                                var form = $(this);
                                                name = $('.name').val();
                                                gender = $('input:radio[name=gender]:checked').val();
                                                blood_id = $('.blood_id').val();
                                                dob = $('.dob').val();
                                                //username = $('.username_u').val();
                                                email = $('.email').val();
                                                password = $('.password').val();
                                                conf = $('.confirm').val();
                                                contact = $('.contact').val();
                                                address = $('.address').val();
                                                //alert(blood_id);return false;

                                                call_loader_ajax();
                                                $.ajax({
                                                    url: '<?php echo site_url('admin/patients/add') ?>',
                                                    type: 'POST',
                                                    data: form.serialize(),

                                                    success: function (result) {
                                                        //alert(result);return false;
                                                        if (result == 1)
                                                        {
                                                            //alert("value=0");
                                                            //$('#myModal').fadeOut(500);
                                                            location.reload();
                                                            $('#add').modal('hide');
                                                            window.close();
                                                        } else
                                                        {
                                                            $("#overlay").hide();
                                                            $('#err').html(result);
                                                        }

                                                        $(".chzn").chosen();
                                                    }
                                                });

                                                event.preventDefault();
                                            });

                                            $(".update").click(function (event) {
                                                event.preventDefault();
//$(this).closest("form").submit();	
                                                var form = $(this).closest('form');
                                                id = $(form).find('input[name=id]').val();
                                                name = $(form).find('input[name=name]').val();
                                                gender = $('input:radio[name=gender]:checked').val();
                                                blood_id = $(form).find('.blood_id').val();
                                                dob = $(form).find('input[name=dob]').val();
                                                //username = $(form ).find('input[name=username]').val();
                                                email = $(form).find('input[name=email]').val();
                                                password = $(form).find('input[name=password]').val();
                                                conf = $(form).find('input[name=confirm]').val();
                                                contact = $(form).find('input[name=contact]').val();
                                                address = $(form).find('.address').val();
                                                //alert(blood_id);return false;
                                                call_loader_ajax();
                                                $.ajax({
                                                    url: '<?php echo site_url('admin/patients/edit') ?>/' + id,
                                                    type: 'POST',
                                                    data: {name: name, gender: gender, blood_id: blood_id, dob: dob, email: email, password: password, confirm: conf, contact: contact, address: address},

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
                                                $('#example1').dataTable({
                                                    "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                                                        // Bold the grade for all 'A' grade browsers
                                                        if (aData[4] == "A")
                                                        {
                                                            $('td:eq(4)', nRow).html('<b>A</b>');
                                                        }
                                                    }
                                                });
                                            });

                                            $(function () {
                                                $(".chzn").chosen({search_contains: true});
                                            });
                                            jQuery('.datepicker').datetimepicker({
                                                lang: 'en',
                                                i18n: {
                                                    de: {
                                                        months: [
                                                            'Januar', 'Februar', 'M�rz', 'April',
                                                            'Mai', 'Juni', 'Juli', 'August',
                                                            'September', 'Oktober', 'November', 'Dezember',
                                                        ],
                                                        dayOfWeek: [
                                                            "So.", "Mo", "Di", "Mi",
                                                            "Do", "Fr", "Sa.",
                                                        ]
                                                    }
                                                },
                                                timepicker: false,
                                                format: 'Y-m-d'
                                            });

                                            $(document).on('change', '#patient_id', function () {
                                                vch = $(this).val();

                                                call_loader_ajax();

                                                $.ajax({
                                                    url: '<?php echo site_url('admin/patients/get_patient') ?>',
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
<script>
    $("#example1 tbody td").on('click', function () {
        var id = $(this).attr('id');
        document.location.href = "<?php echo site_url('admin/patients/view/') ?>/" + id;
    });

</script>
