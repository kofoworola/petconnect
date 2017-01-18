<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/jquery.datetimepicker.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/chosen.css') ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    function areyousure()
    {
        return confirm('<?php echo lang('are_you_sure'); ?>');
    }
</script>
<style>
    .chosen-container{width:100% !important}
    .block{display:block !important}
</style>


<section class="content-header">
    <h1>
        <?php echo $page_title; ?>
        <small><?php echo lang('list'); ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard'); ?></a></li>
        <li class="active"><?php echo lang('appointments'); ?></li>
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
                <a class="btn btn-default" href="#add" data-toggle="modal"><i class="fa fa-plus"></i> <?php echo lang('add'); ?></a>
            </div>
        </div>    
    </div>	

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo lang('appointment_schedule'); ?></h3>                                    
                </div><!-- /.box-header -->


                <div class="box-body table-responsive" style="margin-top:40px;">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo lang('date'); ?></th>

                                <th><?php echo lang('with_whom'); ?></th>
                                <th>Detail</th>
                                <th><?php echo lang('motive'); ?></th>
                                <th><?php echo lang('notes'); ?></th>
                                <th><?php echo lang('status'); ?></th>
                                <th width="20%"><?php echo lang('action'); ?></th>
                            </tr>
                        </thead>

                        <?php if (isset($appointments)): ?>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($appointments as $new) {
                                    $with = "";
                                    if ($new->whom == 1) {
                                        $with = $new->patient;
                                    }
                                    if ($new->whom == 2) {
                                        $with = $new->contact;
                                    }
                                    if ($new->whom == 3) {
                                        $with = $new->other;
                                    }

                                    if ($new->status == 0) {
                                        $val = '<a href="' . site_url('admin/appointments/approve/' . $new->id) . '/1" class="btn btn-danger">' . lang('approve') . '</a>';
                                    } else {
                                        $val = '<a href="' . site_url('admin/appointments/approve/' . $new->id) . '/0" class="btn btn-success">Approved</a>';
                                    }

                                    if ($new->is_closed == 1) {
                                        $close = "<b>Closed</b>";
                                    } else {
                                        $close = '<a href="' . site_url('admin/appointments/close_record/' . $new->id) . '" class="btn btn-info"> <i class="fa fa-times"></i>  Close</a>';
                                    }
                                    ?>
                                    <tr class="gc_row">
                                        <td><?php echo date("d/m/Y h:i:s a", strtotime($new->date)) ?></td>
                                        <td><?php echo $with; ?></td>
                                        <td><?php echo $new->title ?></td>
                                        <td><?php echo $new->motive ?></td>
                                        <td><?php echo substr($new->notes, 0, 50) ?></td>
                                        <td><?php echo $val ?></td>
                                        <td width="25%">
                                            <div class="btn-group">
                                                <a class="btn btn-default" href="#view<?php echo @$new->id; ?>" data-toggle="modal" ><i class="fa fa-eye"></i> <?php echo lang('view'); ?></a>
                                                <a class="btn btn-primary" href="#edit<?php echo @$new->id; ?>" data-toggle="modal"><i class="fa fa-eye"></i> <?php echo lang('edit'); ?></a>
                                                <a class="btn btn-danger" style="margin-left:20px;" href="<?php echo site_url('admin/appointments/delete/' . $new->id); ?>" onclick="return areyousure()"><i class="fa fa-trash"></i> <?php echo lang('delete'); ?></a>
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





<?php if (isset($appointments)): ?>
    <?php
    $i = 1;
    foreach ($appointments as $apps) {

        $app = $this->appointment_model->get_appointment_by_doctor_id($apps->id);
//echo '<pre>'; print_r($app);die;
        ?>
        <!-- Modal -->
        <div class="modal fade" id="edit<?php echo $apps->id ?>" tabindex="-1" role="dialog" aria-labelledby="editlabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content ff">
                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="editlabel"><?php echo lang('edit'); ?> <?php echo lang('appointment') ?></h4>
                    </div>
                    <div class="modal-body">
                        <div id="err_edit<?php echo $apps->id ?>">  
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
                            <input type="hidden" name="id" value="<?php echo $apps->id ?>" />
                            <div class="box-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="name" style="clear:both;"> <?php echo lang('detail') ?></label>
                                            <input type="text" name="title" value="<?php echo $app->title; ?>" class="form-control title">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="name" style="clear:both;"><?php echo lang('with_whom'); ?></label>
                                            <select name="whom" class="form-control chzn whom" >
                                                <option value="0">--<?php echo lang('with_whom'); ?>--</option>
                                                <option value="1" <?php echo ($app->whom == 1) ? 'selected="selected"' : ''; ?> ><?php echo lang('patient'); ?></option>
                                                <option value="2" <?php echo ($app->whom == 2) ? 'selected="selected"' : ''; ?>><?php echo lang('contact'); ?></option>
                                                <option value="3" <?php echo ($app->whom == 3) ? 'selected="selected"' : ''; ?>><?php echo lang('other'); ?></option>

                                            </select>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group patient <?php echo ($app->whom == 1) ? 'block' : '' ?>">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="name" style="clear:both;"><?php echo lang('patient'); ?></label>
                                            <select name="patient_id" class="form-control chzn patient_id">
                                                <option value="">--<?php echo lang('select_patient'); ?>--</option>
                                                <?php
                                                foreach ($contacts as $new) {
                                                    $sel = "";
                                                    if ($app->patient_id == $new->id)
                                                        $sel = "selected='selected'";
                                                    echo '<option value="' . $new->id . '" ' . $sel . '>' . $new->name . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group contact <?php echo ($app->whom == 2) ? 'block' : '' ?>">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="name" style="clear:both;"><?php echo lang('contact'); ?></label>
                                            <select name="contact_id" class="form-control chzn contact_id">
                                                <option value="">--<?php echo lang('select_contact'); ?>--</option>
                                                <?php
                                                foreach ($contact as $new) {
                                                    $sel = "";
                                                    if ($app->contact_id == $new->id)
                                                        $sel = "selected='selected'";
                                                    echo '<option value="' . $new->id . '" ' . $sel . '>' . $new->name . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group other <?php echo ($app->whom == 3) ? 'block' : '' ?>">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="name" style="clear:both;"><?php echo lang('other'); ?></label>
                                            <input type="text" name="other" class="form-control other_text" value="<?php echo $app->other ?>" />
                                        </div>

                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="name" style="clear:both;"><?php echo lang('motive'); ?></label>
                                            <textarea name="motive" class="form-control motive"><?php echo $app->motive; ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="name" style="clear:both;"><?php echo lang('date'); ?></label>
                                            <input type="text" name="date_time" value="<?php echo $app->date; ?>" class="form-control datetimepicker date_time">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="checkbox" name="remind_patient" value="1" <?php echo ($app->remind_patient == 1)? 'checked' : ''?>> Send SMS reminder to patient
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="checkbox" name="remind_doctor" value="1" <?php echo ($app->remind_doctor == 1)? 'checked' : ''?>> Send SMS reminder to doctor
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="name" style="clear:both;">Reminder time</label>
                                            <input type="text" name="reminder" value="<?php echo $app->reminder; ?>" class="form-control datetimepicker date_time">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="name" style="clear:both;"><?php echo lang('notes'); ?></label>
                                            <textarea name="notes" class="form-control notes"> <?php echo $app->notes; ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary update" name="ok" value="ok"><?php echo lang('save'); ?></button>
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
        <?php
        $i++;
    }
    ?>
<?php endif; ?>


<?php if (isset($appointments)): ?>
    <?php
    $i = 1;
    foreach ($appointments as $apps) {

        $app = $this->appointment_model->get_appointment_by_doctor_id($apps->id);
//echo '<pre>'; print_r($app);die;
        ?>
        <!-- Modal -->
        <div class="modal fade" id="view<?php echo $apps->id ?>" tabindex="-1" role="dialog" aria-labelledby="viewlabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content ff">
                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="viewlabel"><?php echo lang('view'); ?> <?php echo lang('appointment') ?></h4>
                    </div>
                    <div class="modal-body">

                        <div class="box-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="name" style="clear:both;"> <?php echo lang('detail') ?></label>
                                    </div>
                                    <div class="col-md-4">
                                        <?php echo $app->title; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="name" style="clear:both;"><?php echo lang('with_whom'); ?></label>
                                    </div>	

                                    <div class="col-md-4">
                                        <?php
                                        foreach ($contacts as $new) {
                                            $sel = "";
                                            if ($app->patient_id == $new->id && $app->whom == 1)
                                                echo $new->name;
                                        }
                                        ?>

                                        <?php
                                        foreach ($contact as $new) {
                                            $sel = "";
                                            if ($app->contact_id == $new->id && $app->whom == 2)
                                                echo $new->name;
                                        }
                                        ?>

                                        <?php echo ($app->whom == 3) ? $app->other : ''; ?>		

                                        (<?php echo ($app->whom == 1) ? lang('patient') : ''; ?> 
                                        <?php echo ($app->whom == 2) ? lang('contact') : ''; ?>
                                        <?php echo ($app->whom == 3) ? lang('other') : ''; ?>)

                                    </div>

                                </div>
                            </div>






                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="name" style="clear:both;"><?php echo lang('motive'); ?></label>
                                    </div>
                                    <div class="col-md-4">
                                        <?php echo $app->motive; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="name" style="clear:both;"><?php echo lang('date'); ?></label>
                                    </div>
                                    <div class="col-md-4">
                                        <?php echo $app->date; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="name" style="clear:both;">Reminder time</label>
                                    </div>
                                    <div class="col-md-4">
                                        <?php echo $app->reminder; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="name" style="clear:both;"><?php echo lang('notes'); ?></label>
                                    </div>
                                    <div class="col-md-4">
                                        <?php echo $app->notes; ?>
                                    </div>
                                </div>
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

        <?php
        $i++;
    }
    ?>
<?php endif; ?>



<!-- Modal -->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="addlabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content ff">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="editlabel"><?php echo lang('add'); ?> <?php echo lang('appointment') ?></h4>
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
                <form method="post" id="add_app">
                    <div class="box-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name" style="clear:both;"> <?php echo lang('detail') ?></label>
                                    <input type="text" name="title" value="<?php echo set_value('title'); ?>" class="form-control title">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name" style="clear:both;"><?php echo lang('with_whom'); ?></label>
                                    <select name="whom" class="form-control chzn whom" >
                                        <option value="0">--<?php echo lang('with_whom'); ?>--</option>
                                        <option value="1"><?php echo lang('patient'); ?></option>
                                        <option value="2"><?php echo lang('contact'); ?></option>
                                        <option value="3"><?php echo lang('other'); ?></option>

                                    </select>
                                </div>

                            </div>
                        </div>

                        <div class="form-group patient">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name" style="clear:both;"><?php echo lang('patient'); ?></label>
                                    <select name="patient_id" class="form-control chzn patient_id">
                                        <option value="">--<?php echo lang('select_patient'); ?>--</option>
                                        <?php
                                        foreach ($contacts as $new) {
                                            $sel = "";
                                            if (set_select('contact_id', $new->id))
                                                $sel = "selected='selected'";
                                            echo '<option value="' . $new->id . '" ' . $sel . '>' . $new->name . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                            </div>
                        </div>

                        <div class="form-group contact" >
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name" style="clear:both;"><?php echo lang('contact'); ?></label>
                                    <select name="contact_id" class="form-control chzn contact_id">
                                        <option value="">--<?php echo lang('select_contact'); ?>--</option>
                                        <?php
                                        foreach ($contact as $new) {
                                            $sel = "";
                                            if (set_select('contact_id', $new->id))
                                                $sel = "selected='selected'";
                                            echo '<option value="' . $new->id . '" ' . $sel . '>' . $new->name . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                            </div>
                        </div>

                        <div class="form-group other" >
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name" style="clear:both;"><?php echo lang('other'); ?></label>
                                    <input type="text" name="other" class="form-control other_text" />
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name" style="clear:both;"><?php echo lang('motive'); ?></label>
                                    <textarea name="motive" class="form-control motive"><?php echo set_value('motive'); ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name" style="clear:both;"><?php echo lang('date'); ?></label>
                                    <input type="text" name="date_time" value="<?php echo set_value('date_time'); ?>" class="form-control datetimepicker date_time">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="checkbox" name="remind_patient" value="0" checked> Send SMS reminder to patient
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="checkbox" name="remind_doctor" value="1" checked> Send SMS reminder to doctor
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name" style="clear:both;">Reminder time</label>
                                    <input type="text" name="reminder" class="form-control datetimepicker date_time">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name" style="clear:both;"><?php echo lang('notes'); ?></label>
                                    <textarea name="notes" class="form-control notes"> <?php echo set_value('notes'); ?></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary" name="ok" value="ok"><?php echo lang('save'); ?></button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close') ?></button>  
                    </div>
            </div>
        </div>
    </div>
</form>		



<script src="<?php echo base_url('assets/js/chosen.jquery.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/jquery.datetimepicker.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js') ?>" type="text/javascript"></script>
<script type="text/javascript">
                                            $(function () {
                                                $('.chzn').chosen();
                                                $('#example1').dataTable({
                                                    "aaSorting": [[0, 'desc']]
                                                });
                                            });


                                            $("#add_app").submit(function (event) {
                                                //title 		= $('input[name=title]').val();
                                                var form = $(this).closest('form');
                                                title = $(form).find('.title').val();
                                                whom = $(form).find('.whom').val();
                                                patient_id = $(form).find('.patient_id').val();
                                                contact_id = $(form).find('.contact_id').val();
                                                other = $(form).find('.other_text').val();
                                                date_time = $(form).find('.date_time').val();
                                                notes = $(form).find('.notes').val();
                                                motive = $(form).find('.motive').val();
                                                is_paid = $(form).find('.is_paid:checked').val();
                                                //alert(is_paid); return false;
                                                call_loader_ajax();
                                                $.ajax({
                                                    url: '<?php echo site_url('admin/appointments/add/') ?>',
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
                                                            $("#overlay").remove();
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
                                                title = $(form).find('.title').val();
                                                whom = $(form).find('.whom').val();
                                                patient_id = $(form).find('.patient_id').val();
                                                contact_id = $(form).find('.contact_id').val();
                                                other = $(form).find('.other_text').val();
                                                date_time = $(form).find('.date_time').val();
                                                notes = $(form).find('.notes').val();
                                                motive = $(form).find('.motive').val();
                                                is_paid = $(form).find('.is_paid:checked').val();
//	alert(date_time);return false;
                                                call_loader_ajax();
                                                $.ajax({
                                                    url: '<?php echo site_url('admin/appointments/edit_appointment') ?>/' + id,
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
                                                            $("#overlay").remove();
                                                            $('#err_edit' + id).html(result);
                                                        }

                                                    }
                                                });


                                            });


                                            $(document).on('focusout', '.datetimepicker', function () {
                                                vch = $(this).val();

                                                call_loader_ajax();
                                                $.ajax({
                                                    url: '<?php echo site_url('admin/appointments/check_datetime') ?>',
                                                    type: 'POST',
                                                    data: {datetime: vch},

                                                    success: function (result) {
                                                        //alert(result);return false;
                                                        if (result == 1)
                                                        {
                                                            $("#overlay").remove();
                                                            $('.datetimepicker').val(' ');
                                                            alert("This Date Time Is Not Available");
                                                            //window.close(); 
                                                        } else
                                                        {
                                                            $("#overlay").remove();
                                                            //$('#err_edit'+id).html(result);
                                                        }

                                                    }
                                                });
                                            });


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
                                                format: 'y-m-d H:i:00'
                                            });
                                            $(".patient").hide();
                                            $(".contact").hide();
                                            $(".other").hide();
                                            $(document).on('change', '.whom', function () {
                                                vch = $(this).val();
                                                $("div").removeClass("block");
                                                //alert(vch);  
                                                if (vch == 1) {
                                                    $(".patient").show();
                                                    $(".contact").hide();
                                                    $(".other").hide();
                                                }

                                                if (vch == 2) {
                                                    $(".contact").show();
                                                    $(".patient").hide();
                                                    $(".other").hide();
                                                }
                                                if (vch == 3) {
                                                    $(".contact").hide();
                                                    $(".patient").hide();
                                                    $(".other").show();
                                                }

                                            });
</script>