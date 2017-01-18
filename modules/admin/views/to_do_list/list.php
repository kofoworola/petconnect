<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/jquery.datetimepicker.css') ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    function areyousure()
    {
        return confirm('<?php echo lang('are_you_sure'); ?>');
    }
</script>
<section class="content-header">
    <h1>
        <?php echo $page_title; ?>
        <small><?php echo lang('list'); ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard') ?></a></li>
        <li class="active"><?php echo lang('to_do_list'); ?></li>
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
    <div class="row" style="margin-bottom:10px;">
        <div class="col-xs-12">
            <div class="btn-group pull-right">
                <a class="btn btn-default" href="#add" data-toggle="modal"><i class="fa fa-plus"></i> <?php echo lang('add_new'); ?></a>
            </div>
        </div>    
    </div>	

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo lang('to_do_list'); ?></h3>                                    
                </div><!-- /.box-header -->

                <div class="box-body table-responsive" style="margin-top:40px;">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo lang('serial_number'); ?></th>
                                <th><?php echo lang('date'); ?></th>
                                <th><?php echo lang('detail') ?></th>
                                <th><?php echo lang('description'); ?></th>
                                <th width="20%"><?php echo lang('action'); ?></th>
                            </tr>
                        </thead>

                        <?php if (isset($lists)): ?>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($lists as $new) {
                                    ?>
                                    <tr class="gc_row">
                                        <td><?php echo $i ?></td>
                                        <td><?php echo date("d/m/Y h:i:a", strtotime($new->date)) ?></td>
                                        <td><?php echo $new->title ?></td>
                                        <td><?php echo $new->description ?></td>

                                        <td width="27%">
                                            <div class="btn-group">
                                                <a class="btn btn-default"   href="#view<?php echo $new->id; ?>" data-toggle="modal"><i class="fa fa-eye"></i> <?php echo lang('view'); ?></a>
                                                <a class="btn btn-primary" style="margin-left:12px;" href="#edit<?php echo $new->id; ?>" data-toggle="modal"><i class="fa fa-edit"></i> <?php echo lang('edit'); ?></a>
                                                <a class="btn btn-danger" style="margin-left:20px;" href="<?php echo site_url('admin/to_do_list/delete/' . $new->id); ?>" onclick="return areyousure()"><i class="fa fa-trash"></i> <?php echo lang('delete'); ?></a>
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



<!-- Modal -->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="addlabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content ff">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="addlabel"><?php echo lang('add'); ?> <?php echo lang('to_do') ?></h4>
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
                <form method="post" id="add_form">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="name" style="clear:both;"> <?php echo lang('detail') ?></label>
                                <input type="text" name="name" value="<?php echo set_value('name'); ?>"class="form-control name">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="name" style="clear:both;"><?php echo lang('description'); ?></label>
                                <textarea name="description"class="form-control description"><?php echo set_value('description'); ?></textarea>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="name" style="clear:both;"><?php echo lang('notification_date'); ?> </label>
                                <input type="text" name="date_time" value="<?php echo set_value('date_time'); ?>"class="form-control datetimepicker date_time">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">    
                                <input type="checkbox" name="sms" value="1" checked class="sms_notify">SMS Notification
                            </div>
                        </div>
                    </div>

                    <div id="sms">
                        <div class="form-group" id="default">
                            <div class="row">
                                <div class="col-md-6">    
                                    <input type="checkbox" name="default" value="1">Use notification date
                                </div>
                            </div>
                        </div>

                        <div class="form-group" id="reminder">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="name" style="clear:both;">Reminder Date </label>
                                    <input type="text" name="reminder" value="" class="form-control datetimepicker date_time">
                                </div>
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
                                        <div class="col-md-4">
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
                                        <div class="col-md-4">
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
                                        <div class="col-md-4">
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
                                        <div class="col-md-4">
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
                                        <div class="col-md-4">
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
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary"><?php echo lang('save'); ?></button>
                    </div>


            </div><!-- /.box-body -->





            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close') ?></button>  
            </div>
        </div>
    </div>
</div>
</form>








<?php if (isset($lists)): ?>
    <?php
    $i = 1;
    foreach ($lists as $list) {
        ?>
        <!-- Modal -->
        <div class="modal fade" id="edit<?php echo $list->id ?>" tabindex="-1" role="dialog" aria-labelledby="editlabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content ff">
                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="editlabel"><?php echo lang('edit'); ?> <?php echo lang('to_do') ?></h4>
                    </div>
                    <div class="modal-body">
                        <div id="err_edit<?php echo $list->id ?>">  
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
                        <form method="post" action="<?php echo site_url('admin/to_do_list/edit/' . $list->id) ?>">
                            <input type="hidden" name="id" value="<?php echo $list->id ?>" />
                            <div class="box-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="name" style="clear:both;"> <?php echo lang('detail') ?></label>
                                            <input type="text" name="name" value="<?php echo $list->title ?>" class="form-control name">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="name" style="clear:both;"><?php echo lang('description'); ?></label>
                                            <textarea name="description"class="form-control description" ><?php echo $list->description ?></textarea>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="name" style="clear:both;"><?php echo lang('notification_date'); ?></label>
                                            <input type="text" name="date_time"class="form-control datetimepicker date_time"  value="<?php echo $list->date ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">    
                                            <input type="checkbox" name="sms" value="1" class="sms_notify" <?php echo ($list->remind == 1)? 'checked' : ''?>>SMS Notification
                                        </div>
                                    </div>
                                </div>

                                <div id="sms">
                                    <div class="form-group" id="default">
                                        <div class="row">
                                            <div class="col-md-6">    
                                                <input type="checkbox" name="default" value="1">Use notification date
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group" id="reminder">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="name" style="clear:both;">Reminder Date </label>
                                                <input type="text" name="reminder" value="<?php echo $list->reminder ?>" class="form-control datetimepicker date_time">
                                            </div>
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
                                                        <?php $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '" . $doc->id . "' AND table_id = '" . $clients->id . "' AND form = '" . $doc->form . "' ")->row(); ?>		
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
                                                        <?php $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '" . $doc->id . "' AND table_id = '" . $clients->id . "' AND form = '" . $doc->form . "' ")->row(); ?>	
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
                                                            $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '" . $doc->id . "' AND table_id = '" . $clients->id . "' AND form = '" . $doc->form . "' ")->row();
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
                                                            $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '" . $doc->id . "' AND table_id = '" . $clients->id . "' AND form = '" . $doc->form . "' ")->row();
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
                                                        <?php $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '" . $doc->id . "' AND table_id = '" . $clients->id . "' AND form = '" . $doc->form . "'")->row(); ?>	
                                                        <textarea class="form-control" name="reply[<?php echo $doc->id ?>]" ><?php echo @$result->reply; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>



                                            <?php
                                        }
                                    }
                                }
                                ?>		




                            </div><!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary update"><?php echo lang('save'); ?></button>
                            </div>



                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close') ?></button>  
                    </div>
                </div>
            </div>
        </div>
        </form>
        <?php
        $i++;
    }
    ?>
<?php endif; ?>








<?php if (isset($lists)): ?>
    <?php
    $i = 1;
    foreach ($lists as $list) {
        ?>
        <!-- Modal -->
        <div class="modal fade" id="view<?php echo $list->id ?>" tabindex="-1" role="dialog" aria-labelledby="viewlabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content ff">
                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="viewlabel"><?php echo lang('view'); ?> <?php echo lang('to_do') ?></h4>
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


                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('detail') ?></label>
                                </div>	
                                <div class="col-md-3">
                                    <?php echo $list->title ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"><?php echo lang('description'); ?></label>
                                </div>	
                                <div class="col-md-3">
                                    <?php echo $list->description ?>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"><?php echo lang('notification_date'); ?> </label>
                                </div>	
                                <div class="col-md-3">	
                                    <?php echo date("d/m/Y h:i:a", strtotime($list->date)) ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;">Reminder </label>
                                </div>	
                                <div class="col-md-3">	
                                    <?php echo ($list->remind ==1)? 'Yes' : 'No' ?>
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

                                            <div class="col-md-2">
                                                <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                                            </div>	
                                            <div class="col-md-3">	

                                                <?php $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '" . $doc->id . "' AND table_id = '" . $list->id . "' AND form = '" . $doc->form . "' ")->row(); ?>		
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
                                            <div class="col-md-2">
                                                <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                                            </div>	
                                            <div class="col-md-3">	

                                                <?php
                                                $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '" . $doc->id . "' AND table_id = '" . $list->id . "' AND form = '" . $doc->form . "' ")->row();
                                                //echo '<pre>'; print_r($result);die;
                                                ?>	
                                                <?php
                                                $values = array();

                                                foreach ($values as $key => $val) {
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
                                            <div class="col-md-2">
                                                <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                                            </div>	
                                            <div class="col-md-7">	


                                                <?php foreach ($values as $key => $val) { ?>
                                                    <?php
                                                    $x = "";
                                                    $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '" . $doc->id . "' AND table_id = '" . $list->id . "' AND form = '" . $doc->form . "' ")->row();
                                                    if (!empty($result->reply)) {
                                                        if ($result->reply == $val) {
                                                            $x = 'checked="checked"';
                                                        } else {
                                                            $x = '';
                                                        }
                                                    }
                                                    ?>			

                                                    <input type="radio" name="reply[<?php echo $doc->id ?>]" disabled="disabled"value="<?php echo $val; ?>" <?php echo $x; ?> />	<?php echo $val; ?> &nbsp; &nbsp; &nbsp; &nbsp;
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
                                            <div class="col-md-3">	

                                                <?php foreach ($values as $key => $val) { ?>
                                                    <?php
                                                    $x = "";
                                                    $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '" . $doc->id . "' AND table_id = '" . $list->id . "' AND form = '" . $doc->form . "' ")->row();
                                                    if (!empty($result->reply)) {
                                                        if ($result->reply == $val) {
                                                            $x = 'checked="checked"';
                                                        } else {
                                                            $x = '';
                                                        }
                                                    }
                                                    ?>	

                                                    <input type="checkbox" name="reply[<?php echo $doc->id ?>]" disabled="disabled" <?php echo $x; ?> value="<?php echo $val; ?>" class="form-control" />	&nbsp; &nbsp; &nbsp; &nbsp;
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
                                            <div class="col-md-7">	

                                                <?php $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '" . $doc->id . "' AND table_id = '" . $list->id . "' AND form = '" . $doc->form . "'")->row(); ?>	
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
        <?php
        $i++;
    }
    ?>
<?php endif; ?>
<script src="<?php echo base_url('assets/js/jquery.datetimepicker.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js') ?>" type="text/javascript"></script>
<script type="text/javascript">
                                                    $(function () {
                                                        $('#example1').dataTable({
                                                        });
                                                    });

                                                    $("#add_form").submit(function (event) {
                                                        var form = $(this);
                                                        name = $('.name').val();
                                                        description = $('.description').val();
                                                        date_time = $('.date_time').val();
                                                        reply = $('input[name=reply]').val();
                                                        call_loader_ajax();
                                                        $.ajax({
                                                            url: '<?php echo site_url('admin/to_do_list/add/') ?>',
                                                            type: 'POST',
                                                            data: form.serialize(),

                                                            success: function (result) {
                                                                //alert(result);return false;
                                                                if (result == 1)
                                                                {
                                                                    //alert("value=0");
                                                                    //$('#myModal').fadeOut(500);
                                                                    $('#add').modal('hide');
                                                                    window.close();
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
                                                        name = $(form).find('.name').val();
                                                        description = $(form).find('.description').val();
                                                        date_time = $(form).find('.date_time').val();
                                                        reply = $('input[name=reply]').val();

                                                        call_loader_ajax();
                                                        $.ajax({
                                                            url: '<?php echo site_url('admin/to_do_list/edit') ?>/' + id,
                                                            type: 'POST',
                                                            data: form.serialize(),

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

                                                            }
                                                        });


                                                    });

</script>

<script type="text/javascript">
    jQuery('.datetimepicker').datetimepicker({
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