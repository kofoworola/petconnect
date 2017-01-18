<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/chosen.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/jquery.datetimepicker.css') ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    function areyousure()
    {
        return confirm('<?php echo lang('are_you_sure') ?>');
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
        <li class="active"><?php echo lang('assistants') ?></li>
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
                <a class="btn btn-default" href="#add" data-toggle="modal"><i class="fa fa-plus"></i> <?php echo lang('add_new') ?> </a>
            </div>
        </div>    
    </div>	

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo lang('assistants') ?></h3>                                    
                </div><!-- /.box-header -->

                <div class="box-body table-responsive" style="margin-top:40px;" id="result">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo lang('serial_number') ?></th>
                                <th><?php echo lang('name') ?></th>
                                <th><?php echo lang('phone') ?></th>
                                <th>User Type</th>
                                <th width="44%"><?php echo lang('action') ?></th>
                            </tr>
                        </thead>

                        <?php if (isset($assistants)): ?>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($assistants as $new) {
                                    ?>
                                    <tr class="gc_row">
                                        <td><?php echo $i ?></td>
                                        <td><?php echo ucwords($new->name) ?></td>
                                        <td><?php echo $new->contact ?></td>
                                        <td><?php echo $this->assistant_model->get_type($new->user_type); ?></td>
                                        <td width="40%">
                                            <div class="btn-group">
                                                <a class="btn btn-default"  href="#view<?php echo $new->id; ?>" data-toggle="modal"><i class="fa fa-eye"></i> <?php echo lang('view') ?></a>
                                                <a class="btn btn-primary"  style="margin-left:12px;" href="#edit<?php echo $new->id; ?>" data-toggle="modal"><i class="fa fa-edit"></i> <?php echo lang('edit') ?></a>
                                                <a class="btn btn-danger" style="margin-left:20px;" href="<?php echo site_url('admin/assistants/delete/' . $new->id); ?>" onclick="return areyousure()"><i class="fa fa-trash"></i> <?php echo lang('delete') ?></a>
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

<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="addlabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content ff">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="addlabel"><?php echo lang('add'); ?> <?php echo lang('assistant') ?></h4>
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
                <form method="post" action="<?php echo site_url('admin/assistants/add/') ?>" id="add_form" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name" style="clear:both;"><?php echo lang('firstname') ?></label>
                                    <input type="text" name="fname" value="<?php echo set_value('fname') ?>" class="form-control name">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name" style="clear:both;"><?php echo lang('lastname') ?></label>
                                    <input type="text" name="lname" value="<?php echo set_value('lname') ?>" class="form-control name">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-8">
                                    <label for="user_type" style="clear: both">Job Type</label>
                                    <select name="user_type" class="form-control user_type">
                                        <option value="medical"><?php echo lang('medical_staff') ?></option>
                                        <option value="office"><?php echo lang('office_staff') ?></option>
                                        <option value="management"><?php echo lang('management_staff') ?></option>
                                    </select>
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
                                    <label for="email" style="clear:both;"><?php echo lang('email') ?></label>
                                    <input type="text" name="email" value="<?php echo set_value('email') ?>" class="form-control email">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="username" style="clear:both;"><?php echo lang('username') ?></label>
                                    <input type="text" name="username" value="Will be generated and sent to user" class="form-control " readonly="readonly username">
                                    <input type="hidden" name="username_u"  class="username_u" value="<?php echo $username; ?>" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="password" style="clear:both;"><?php echo lang('password') ?></label>
                                    <input type="text" name="password" value="Will be generated and sent to user" class="form-control password" readonly>
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
                                    <label for="contact" style="clear:both;"><?php echo lang('address') ?></label>
                                    <textarea name="address"  class="form-control address"><?php echo set_value('address') ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group rules">
                            <div class="row">
                                <div class="col-md-12" style="padding-left:10px">
                                    <div>
                                        <label for="rules" style="clear:both;">Allow Access to:</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" name="rules[]" value="patients" class="form-control"><label style="font-weight: normal; margin-left: 10px;">Patients</label><br>
                                        <input type="checkbox" name="rules[]" value="payments" class="form-control"><label style="font-weight: normal; margin-left: 10px;">Payments</label><br>
                                        <input type="checkbox" name="rules[]" value="prescriptions" class="form-control"><label style="font-weight: normal; margin-left: 10px;">Prescriptions</label><br>
                                        <input type="checkbox" name="rules[]" value="calendar" class="form-control"><label style="font-weight: normal; margin-left: 10px;">Calendar</label><br>
                                        <input type="checkbox" name="rules[]" value="message" class="form-control"><label style="font-weight: normal; margin-left: 10px;">Message</label><br>
                                        <input type="checkbox" name="rules[]" value="todo" class="form-control"><label style="font-weight: normal; margin-left: 10px;">To-do List</label><br>
                                        <input type="checkbox" name="rules[]" value="notes" class="form-control"><label style="font-weight: normal; margin-left: 10px;">Notes</label><br>
                                        <input type="checkbox" name="rules[]" value="contacts" class="form-control"><label style="font-weight: normal; margin-left: 10px;">Contacts</label></input><br>
                                        <input type="checkbox" name="rules[]" value="appointments" class="form-control"><label style="font-weight: normal; margin-left: 10px;">Appointment</label><br>
                                        <input type="checkbox" name="rules[]" value="locations" class="form-control"><label style="font-weight: normal; margin-left: 10px;">Locations </label><br>
                                        <input type="checkbox" name="rules[]" value="settings" class="form-control"><label style="font-weight: normal; margin-left: 10px;">Settings </label><br>
                                    </div>
                                </div>
                            </div>
                        </div>




                        <button type="submit" class="btn btn-primary" ><?php echo lang('save') ?></button>

                    </div><!-- /.box-body -->

                </form>
            </div>
            <div class="modal-footer"
                 <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close') ?></button>  
            </div>
        </div>
    </div>
</div>





<?php if (isset($assistants)): ?>
    <?php
    $i = 1;
    foreach ($assistants as $new) {
        $assistant = $this->assistant_model->get_assistant_by_id($new->id);
        ?>
        <!-- Modal -->

        <div class="modal fade" id="view<?php echo $new->id ?>" tabindex="-1" role="dialog" aria-labelledby="viewlabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="viewlabel"><?php echo lang('view'); ?> <?php echo lang('assistant') ?></h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="name" style="clear:both;"><?php echo lang('name') ?></label>
                                </div>
                                <div class="col-md-4">	
                                    <?php echo $assistant->name ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="business_type" style="clear:both;"><?php echo lang('business_type') ?></label>
                                </div>
                                <div class="col-md-4">		
                                    <?php echo $this->assistant_model->get_type($assistant->user_type) ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="gender" style="clear:both;"><?php echo lang('gender') ?></label>
                                </div>
                                <div class="col-md-4">	
                                    <?php echo $assistant->gender ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="email" style="clear:both;"><?php echo lang('email') ?></label>
                                </div>
                                <div class="col-md-4">		
                                    <?php echo $assistant->email ?>

                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="username" style="clear:both;"><?php echo lang('username') ?></label>
                                </div>
                                <div class="col-md-4">	
                                    <?php echo $assistant->username ?>
                                </div>
                            </div>
                        </div>




                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="contact" style="clear:both;"><?php echo lang('phone') ?></label>
                                </div>
                                <div class="col-md-4">		
                                    <?php echo $assistant->contact ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="contact" style="clear:both;"><?php echo lang('address') ?></label>
                                </div>
                                <div class="col-md-4">		
                                    <?php echo $assistant->address ?>
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


<?php if (isset($assistants)): ?>
    <?php
    $i = 1;
    foreach ($assistants as $new) {
        $assistant = $this->assistant_model->get_assistant_by_id($new->id);
        ?>
        <!-- Modal -->
        <div class="modal fade" id="edit<?php echo $new->id ?>" tabindex="-1" role="dialog" aria-labelledby="editlabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content ff">
                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="editlabel"><?php echo lang('edit'); ?> <?php echo lang('assistant') ?></h4>
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

                        <form method="post" action="<?php echo site_url('admin/assistant/edit/' . $new->id) ?>" id="edit" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $new->id; ?>" />
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="name" style="clear:both;"><?php echo lang('name') ?></label>
                                        <input type="text" name="name" value="<?php echo $assistant->name ?>" class="form-control name">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-8">
                                        <label for="user_type" style="clear: both">User Type</label>
                                        <select name="user_type" class="form-control user_type" id="user_type">
                                            <option value="management" <?php echo ($assistant->user_type == 'management') ? 'selected' : ''; ?>><?php echo lang('management_staff') ?></option>
                                            <option value="office" <?php echo ($assistant->user_type == 'office') ? 'selected' : ''; ?>><?php echo lang('office_staff') ?></option>
                                            <option value="medical" <?php echo ($assistant->user_type == 'medical') ? 'selected' : ''; ?>><?php echo lang('medical_staff') ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="gender" style="clear:both;"><?php echo lang('gender') ?></label>
                                        <input type="radio"  name="gender" class="gender" <?php echo $chk = ($assistant->gender == "Male") ? 'checked="checked"' : ''; ?>value="Male" /> <?php echo lang('male') ?>
                                        <input type="radio" name="gender" class="gender" <?php echo $chk = ($assistant->gender == "Female") ? 'checked="checked"' : ''; ?> value="Female" /> <?php echo lang('female') ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="email" style="clear:both;"><?php echo lang('email') ?></label>
                                        <input type="text" name="email" value="<?php echo $assistant->email ?>" class="form-control email">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="username" style="clear:both;"><?php echo lang('username') ?></label>
                                        <input type="text" name="username"  readonly="readonly" value="<?php echo $assistant->username ?>" class="form-control username">
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
                                        <input type="text" name="contact" value="<?php echo $assistant->contact ?>" class="form-control contact">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="contact" style="clear:both;"><?php echo lang('address') ?></label>
                                        <textarea name="address"  class="form-control address"><?php echo $assistant->address ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group rules">
                                <?php $rules = explode(',', $assistant->rules) ?>
                                <div class="row">
                                    <div class="col-md-12" style="padding-left:10px">
                                        <div>
                                            <label for="rules" style="clear:both;">Allow Access to:</label>
                                        </div>
                                        <div>
                                            <input type="checkbox" name="rules[]" value="patients" class="form-control" <?php echo(in_array('patients', $rules)) ? 'checked' : ''; ?>><label style="font-weight: normal; margin-left: 10px;">Patients</label><br>
                                            <input type="checkbox" name="rules[]" value="payments" class="form-control" <?php echo(in_array('payments', $rules)) ? 'checked' : ''; ?>><label style="font-weight: normal; margin-left: 10px;">Payments</label><br>
                                            <input type="checkbox" name="rules[]" value="prescriptions" class="form-control" <?php echo(in_array('prescriptions', $rules)) ? 'checked' : ''; ?>><label style="font-weight: normal; margin-left: 10px;">Prescriptions</label><br>
                                            <input type="checkbox" name="rules[]" value="calendar" class="form-control" <?php echo(in_array('calendar', $rules)) ? 'checked' : ''; ?>><label style="font-weight: normal; margin-left: 10px;">Calendar</label><br>
                                            <input type="checkbox" name="rules[]" value="message" class="form-control" <?php echo(in_array('message', $rules)) ? 'checked' : ''; ?>><label style="font-weight: normal; margin-left: 10px;">Message</label><br>
                                            <input type="checkbox" name="rules[]" value="todo" class="form-control" <?php echo(in_array('todo', $rules)) ? 'checked' : ''; ?>><label style="font-weight: normal; margin-left: 10px;">To-do List</label><br>
                                            <input type="checkbox" name="rules[]" value="notes" class="form-control" <?php echo(in_array('notes', $rules)) ? 'checked' : ''; ?>><label style="font-weight: normal; margin-left: 10px;">Notes</label><br>
                                            <input type="checkbox" name="rules[]" value="contacts" class="form-control" <?php echo(in_array('contacts', $rules)) ? 'checked' : ''; ?>><label style="font-weight: normal; margin-left: 10px;">Contacts</label><br>
                                            <input type="checkbox" name="rules[]" value="appointments" class="form-control" <?php echo(in_array('appointments', $rules)) ? 'checked' : ''; ?>><label style="font-weight: normal; margin-left: 10px;">Appointment</label><br>
                                            <input type="checkbox" name="rules[]" value="locations" class="form-control" <?php echo(in_array('locations', $rules)) ? 'checked' : ''; ?>><label style="font-weight: normal; margin-left: 10px;">Locations</label><br>
                                            <input type="checkbox" name="rules[]" value="settings" class="form-control" <?php echo(in_array('settings', $rules)) ? 'checked' : ''; ?>><label style="font-weight: normal; margin-left: 10px;">Settings</label><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
        <?php
        $i++;
    }
    ?>
<?php endif; ?>


<script>
    $(".user_type").change(function ()
    {
        var value = this.value;
        if (value === 'management')
        {
            var form = $(this).closest('.form');
            form.find(".rules").hide();
        }
    });
</script>
<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/chosen.jquery.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/jquery.datetimepicker.js') ?>" type="text/javascript"></script>
<script type="text/javascript">
    $(".user_type").change(function (event)
    {
        var form = $(this).closest('form');
        var rules = form.find(".rules");
        var val = this.value;
        if (val == 'management')
        {
            rules.hide();
        } else
        {
            rules.show();
        }
    });
    var type = $(".user_type");
    var val = type.val();
    var form = $(".user_type").closest('form');
    var rules = form.find(".rules");
    
    if (val == 'management')
    {
        alert('holla');
        rules.hide();
    } else
    {
        rules.show();
    }
</script>
<script type="text/javascript">
    $("#add_form").submit(function (event) {
        var form = $(this);
        name = $('.name').val();
        gender = $('input:radio[name=gender]:checked').val();
        dob = $('.dob').val();
        username = $('.username_u').val();
        email = $('.email').val();
        password = $('.password').val();
        conf = $('.confirm').val();
        contact = $('.contact').val();
        address = $('.address').val();
        //alert(blood_id);return false;

        call_loader_ajax();
        $.ajax({
            url: '<?php echo site_url('admin/assistants/add') ?>',
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
            url: '<?php echo site_url('admin/assistants/edit') ?>/' + id,
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
