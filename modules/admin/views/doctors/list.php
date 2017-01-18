<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css') ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    function areyousure()
    {
        return confirm('Are You Sure You Want Delete This Doctor');
    }
</script>
<section class="content-header">
    <h1>
        <?php echo $page_title; ?>
        <small><?php echo lang('list') ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard') ?></a></li>
        <li class="active"><?php echo lang('doctors') ?></li>
    </ol>
</section>

<section class="content">
    <div class="row" style="margin-bottom:10px;">
        <div class="col-xs-12">
            <div class="btn-group pull-right">
                <a class="btn btn-default" href="#add" data-toggle="modal"><i class="fa fa-plus"></i> <?php echo lang('add_new') ?> </a>

                <a  style="margin-left:12px;"class="btn btn-danger" href="<?php echo site_url('admin/doctors/export/'); ?>"><i class="fa fa-download"></i> <?php echo lang('export') ?> </a>

            </div>
        </div>    
    </div>	

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo lang('doctors') ?></h3>                                    
                </div><!-- /.box-header -->

                <div class="box-body table-responsive" style="margin-top:40px;">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo lang('serial_number') ?></th>
                                <th><?php echo lang('name') ?></th>
                                <th><?php echo lang('phone') ?></th>
                                <th width="20%"><?php echo lang('action') ?></th>
                            </tr>
                        </thead>

                        <?php if (isset($doctors)): ?>
                            <tbody>
                                <?php $i = 1;
                                foreach ($doctors as $new) {
                                    ?>
                                    <tr class="gc_row">
                                        <td><?php echo $i ?></td>
                                        <td><?php echo ucwords($new->name) ?></td>
                                        <td><?php echo $new->contact ?></td>

                                        <td width="41%">
                                            <div class="btn-group">
                                                <a class="btn btn-default" style="margin-left:7px;" href="#view<?php echo $new->id ?>" data-toggle="modal"><i class="fa fa-eye"></i> <?php echo lang('view') ?></a>
                                                <a class="btn btn-primary"  style="margin-left:12px;" href="#edit<?php echo $new->id ?>" data-toggle="modal"><i class="fa fa-edit"></i> <?php echo lang('edit') ?></a>
                                                <a class="btn btn-danger" style="margin-left:20px;" href="<?php echo site_url('admin/doctors/delete/' . $new->id); ?>" onclick="return areyousure()"><i class="fa fa-trash"></i> <?php echo lang('delete') ?></a>

                                                <a class="btn btn-default"  style="margin-left:12px;" href="<?php echo site_url('admin/doctor_payment/payment_history/' . $new->id); ?>"><i class="fa fa-list"></i> <?php echo lang('payment_history') ?> </a>
                                            </div>

                                        </td>
                                    </tr>
                                    <?php $i++;
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



<?php if (isset($doctors)): ?>
    <?php
    $i = 1;
    foreach ($doctors as $new) {
        $doctor = $this->doctor_model->get_doctor_by_id($new->id);
        ?>
        <!-- Modal -->
        <div class="modal fade" id="view<?php echo $new->id ?>" tabindex="-1" role="dialog" aria-labelledby="viewlabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content ff">
                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="viewlabel"><?php echo lang('edit'); ?> <?php echo lang('patient') ?></h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="name" style="clear:both;"><?php echo lang('name') ?></label>
                                </div>
                                <div class="col-md-4">	
        <?php echo $doctor->name ?>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="gender" style="clear:both;"><?php echo lang('gender') ?></label>
                                </div>
                                <div class="col-md-4">	
        <?php echo $doctor->gender ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="dob" style="clear:both;"><?php echo lang('date_of_birth') ?></label>

                                </div>
                                <div class="col-md-4">	
        <?php echo date("Y") - $doctor->dob ?>

                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="email" style="clear:both;"><?php echo lang('email') ?></label>
                                </div>
                                <div class="col-md-4">		
        <?php echo $doctor->email ?>

                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="username" style="clear:both;"><?php echo lang('username') ?></label>
                                </div>
                                <div class="col-md-4">	
        <?php echo $doctor->username ?>
                                </div>
                            </div>
                        </div>




                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="contact" style="clear:both;"><?php echo lang('phone') ?></label>
                                </div>
                                <div class="col-md-4">		
        <?php echo $doctor->contact ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="contact" style="clear:both;"><?php echo lang('address') ?></label>
                                </div>
                                <div class="col-md-4">		
        <?php echo $doctor->address ?>
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
                    <?php $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '" . $doc->id . "' AND table_id = '" . $doctor->id . "' AND form = '" . $doc->form . "' ")->row(); ?>		
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
                                                <?php $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '" . $doc->id . "' AND table_id = '" . $doctor->id . "'  ")->row(); ?>	
                                                <?php
                                                $values = array();
                                                foreach ($values as $key => $val) {
                                                    $sel = '';
                                                    if ($val == $result->reply)
                                                        echo $val;
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
                                            <div class="col-md-3">
                                                <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                                            </div>
                                            <div class="col-md-4">	

                                                <?php foreach ($values as $key => $val) { ?>
                                                    <?php
                                                    $x = "";
                                                    $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '" . $doc->id . "' AND table_id = '" . $doctor->id . "' AND form = '" . $doc->form . "' ")->row();
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
                                                    $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '" . $doc->id . "' AND table_id = '" . $doctor->id . "' AND form = '" . $doc->form . "' ")->row();
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
                    <?php $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '" . $doc->id . "' AND table_id = '" . $doctor->id . "' AND form = '" . $doc->form . "'")->row(); ?>	
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
        </form>
        <?php $i++;
    }
    ?>
<?php endif; ?>











<?php if (isset($doctors)): ?>
    <?php
    $i = 1;
    foreach ($doctors as $new) {
        $doctor = $this->doctor_model->get_doctor_by_id($new->id);
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

                        <form method="post">
                            <input type="hidden" name="id" value="<?php echo $new->id; ?>" />
                            <div class="box-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <label for="name" style="clear:both;"><?php echo lang('name') ?></label>
                                            <input type="text" name="name" value="<?php echo $doctor->name ?>" class="form-control name">
                                        </div>
                                    </div>
                                </div>



                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <label for="gender" style="clear:both;"><?php echo lang('gender') ?></label>
                                            <input type="radio"  name="gender" <?php echo $chk = ($doctor->gender == "Male") ? 'checked="checked"' : ''; ?>value="Male" /> <?php echo lang('male') ?>
                                            <input type="radio" name="gender" <?php echo $chk = ($doctor->gender == "Female") ? 'checked="checked"' : ''; ?> value="Female" /> <?php echo lang('female') ?>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <label for="dob" style="clear:both;">Age</label>
                                            <input type="text" name="dob" value="<?php echo date("Y") - $doctor->dob ?>"class="form-control dob">

                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <label for="email" style="clear:both;"><?php echo lang('email') ?></label>
                                            <input type="text" name="email" value="<?php echo $doctor->email ?>" class="form-control email">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <label for="username" style="clear:both;"><?php echo lang('username') ?></label>
                                            <input type="text" name="username" value="<?php echo $doctor->username ?>" class="form-control username">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <label for="password" style="clear:both;"><?php echo lang('password') ?></label>
                                            <input type="password" name="password" value="" class="form-control password">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <label for="password" style="clear:both;"><?php echo lang('confirm') ?> <?php echo lang('password') ?></label>
                                            <input type="password" name="confirm" value="" class="form-control conifrm">
                                        </div>
                                    </div>
                                </div>



                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <label for="contact" style="clear:both;"><?php echo lang('phone') ?></label>
                                            <input type="text" name="contact" value="<?php echo $doctor->contact ?>" class="form-control contact">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <label for="contact" style="clear:both;"><?php echo lang('address') ?></label>
                                            <textarea name="address"  class="form-control address"><?php echo $doctor->address ?></textarea>
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

                                                    <div class="col-md-8">
                                                        <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                    <?php $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '" . $doc->id . "' AND table_id = '" . $doctor->id . "' AND form = '" . $doc->form . "' ")->row(); ?>		
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
                                                    <div class="col-md-8">
                                                        <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                                                            <?php $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '" . $doc->id . "' AND table_id = '" . $doctor->id . "' AND form = '" . $doc->form . "' ")->row(); ?>	
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
                                                    <div class="col-md-8">
                                                        <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>

                                                        <?php foreach ($values as $key => $val) { ?>
                                                            <?php
                                                            $x = "";
                                                            $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '" . $doc->id . "' AND table_id = '" . $doctor->id . "' AND form = '" . $doc->form . "' ")->row();
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
                                                    <div class="col-md-8">
                                                        <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>

                                                        <?php foreach ($values as $key => $val) { ?>
                                                            <?php
                                                            $x = "";
                                                            $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '" . $doc->id . "' AND table_id = '" . $doctor->id . "' AND form = '" . $doc->form . "' ")->row();
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
                                                    <div class="col-md-8">
                                                        <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                    <?php $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '" . $doc->id . "' AND table_id = '" . $doctor->id . "' AND form = '" . $doc->form . "'")->row(); ?>	
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close') ?></button>  
                    </div>
                </div>
            </div>
        </div>
        </form>
        <?php $i++;
    }
    ?>
<?php endif; ?>






<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="addlabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content ff">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="addlabel"><?php echo lang('add'); ?> <?php echo lang('doctor') ?></h4>
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
                <form method="post" id="add_form" >			
                    <div class="box-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-8">
                                    <label for="name" style="clear:both;"><?php echo lang('name') ?></label>
                                    <input type="text" name="name" value="<?php echo set_value('name') ?>" class="form-control name">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-8">
                                    <label for="gender" style="clear:both;"><?php echo lang('gender') ?></label>
                                    <input type="radio" name="gender" value="Male" /> <?php echo lang('male') ?>
                                    <input type="radio" name="gender" value="Female" /> <?php echo lang('female') ?>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-8">
                                    <label for="dob" style="clear:both;">Age</label>
                                    <input type="text" name="dob" value="<?php echo set_value('dob') ?>" class="form-control dob">

                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-8">
                                    <label for="email" style="clear:both;"><?php echo lang('email') ?></label>
                                    <input type="text" name="email" value="<?php echo set_value('email') ?>" class="form-control email">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-8">
                                    <label for="username" style="clear:both;"><?php echo lang('username') ?></label>
                                    <input type="text" name="username" value="<?php echo set_value('username') ?>" class="form-control username">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-8">
                                    <label for="password" style="clear:both;"><?php echo lang('password') ?></label>
                                    <input type="password" name="password" value="" class="form-control password">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-8">
                                    <label for="password" style="clear:both;"><?php echo lang('confirm') ?> <?php echo lang('password') ?></label>
                                    <input type="password" name="confirm" value="" class="form-control confirm">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-8">
                                    <label for="contact" style="clear:both;"><?php echo lang('phone') ?></label>
                                    <input type="text" name="contact" value="<?php echo set_value('contact') ?>" class="form-control contact">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-8">
                                    <label for="contact" style="clear:both;"><?php echo lang('address') ?></label>
                                    <textarea name="address"  class="form-control address"><?php echo set_value('address') ?></textarea>
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
                                            <div class="col-md-8">
                                                <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                                                <input type="text" class="form-control " name="reply[<?php echo $doc->id ?>]" id="req_doc" />
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                if ($doc->field_type == 2) { //dropdown list
                                    $values = explode(",", $doc->values);
                                    ?>	<div class="form-group">
                                        <div class="row">
                                            <div class="col-md-8">
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
                                            <div class="col-md-8">
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
                                            <div class="col-md-8">
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
                                            <div class="col-md-8">
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




                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary"><?php echo lang('save') ?></button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close') ?></button>  
                    </div>
                </form>
            </div>
        </div>
    </div>



    <script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js') ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js') ?>" type="text/javascript"></script>
    <script type="text/javascript">
                                                    $("#add_form").submit(function (event) {
                                                        var form = $(this).closest('form');
                                                        name = $(form).find('.name').val();
                                                        gender = $(form).find('input:radio[name=gender]:checked').val();
                                                        dob = $(form).find('.dob').val();
                                                        username = $(form).find('.username').val();
                                                        email = $(form).find('.email').val();
                                                        password = $(form).find('.password').val();
                                                        conf = $(form).find('.confirm').val();
                                                        contact = $(form).find('.contact').val();
                                                        address = $(form).find('.address').val();
                                                        //alert(blood_id);return false;

                                                        call_loader_ajax();
                                                        $.ajax({
                                                            url: '<?php echo site_url('admin/doctors/add') ?>',
                                                            type: 'POST',
                                                            data: {name: name, gender: gender, dob: dob, email: email, username: username, password: password, confirm: conf, contact: contact, address: address},

                                                            success: function (result) {
                                                                //alert(result);return false;
                                                                if (result == 1)
                                                                {
                                                                    location.reload();
                                                                } else
                                                                {
                                                                    $("#overlay").hide();
                                                                    $('#err').html(result);
                                                                }

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
                                                        dob = $(form).find('input[name=dob]').val();
                                                        username = $(form).find('input[name=username]').val();
                                                        email = $(form).find('input[name=email]').val();
                                                        password = $(form).find('input[name=password]').val();
                                                        conf = $(form).find('input[name=confirm]').val();
                                                        contact = $(form).find('input[name=contact]').val();
                                                        address = $(form).find('.address').val();
                                                        //alert(blood_id);return false;
                                                        call_loader_ajax();
                                                        $.ajax({
                                                            url: '<?php echo site_url('admin/doctors/edit') ?>/' + id,
                                                            type: 'POST',
                                                            data: {name: name, gender: gender, username: username, dob: dob, email: email, password: password, confirm: conf, contact: contact, address: address},

                                                            success: function (result) {
                                                                //alert(result);return false;
                                                                if (result == 1)
                                                                {
                                                                    location.reload();
                                                                } else
                                                                {
                                                                    $("#overlay").hide();
                                                                    $('#err_edit' + id).html(result);
                                                                }

                                                            }
                                                        });


                                                    });


                                                    $(function () {
                                                        $('#example1').dataTable({
                                                        });
                                                    });

    </script>
