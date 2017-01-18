<?php
//print_r($clients);die()
$admin = $this->session->userdata('admin');
$CI = get_instance();
$CI->load->model('message_model');
?>	


<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    function areyousure()
    {
        return confirm('Are You Sure');
    }
</script>
<section class="content-header">
    <h1>
        <?php echo $page_title; ?>
        <small><?php echo lang('list'); ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard'); ?></a></li>
        <li class="active"><?php echo lang('message'); ?></li>
    </ol>
</section>

<section class="content">


    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo lang('select_patient_to_send_message'); ?></h3>                                    
                </div><!-- /.box-header -->

                <div class="box-body table-responsive" style="margin-top:40px;">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo lang('serial_number'); ?></th>
                                <th><?php echo lang('name'); ?></th>
                                <th width="20%"><?php echo lang('action'); ?></th>
                            </tr>
                        </thead>

                        <?php if (isset($clients)): ?>
                            <tbody>

                                <?php
                                $i = 1;
                                foreach ($clients as $new) {
                                    $admin = $this->session->userdata('admin');
                                    if ($new->id != $admin['id']) {
                                        ?>
                                        <tr class="gc_row">
                                            <td><?php echo $i ?></td>
                                            <td><?php echo $new->name ?>
                                                <?php
                                                $result = $CI->db->query("SELECT `M`.*, `U1`.`name` from_user, `U2`.`name` to_user, `U1`.`image` FROM (`user_message` M) LEFT JOIN `users` U2 ON `U2`.`id` = `M`.`to_id` LEFT JOIN `users` U1 ON `U1`.`id` = `M`.`from_id` WHERE `M`.`to_id` = '" . $admin['id'] . "' AND `M`.`from_id` = '" . $new->id . "' AND `M`.`is_view_to` = 1 ")->result();
                                                if (!$result != 0) {
                                                    echo "";
                                                } else {
                                                    ?>	
                                                    <small class="badge pull-right bg-red"><?php echo count($result) ?></small>
                                                    <?php
                                                }
                                                ?>
                                            </td>

                                            <td>
                                                <div class="btn-group">
                                                    <a class="btn btn-primary"  href="#view<?php echo $new->id; ?>" data-toggle="modal"><i class="fa fa-eye"></i> <?php echo lang('message_board') ?></a>

                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
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




<?php if (isset($clients)): ?>
    <?php
    $i = 1;
    foreach ($clients as $new) {
//        die($new->id);
        $this->message_model->user_message_is_view_by_admin($new->id);
        $patient = $this->message_model->get_patient_by_id($new->id);
        $messages = $this->message_model->get_user_message_by_id($new->id);
        ?>
        <!-- Modal -->
        <div class="modal fade" id="view<?php echo $new->id ?>" tabindex="-1" role="dialog" aria-labelledby="viewlabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content ff">
                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="viewlabel"><?php echo lang('view'); ?> <?php echo lang('message') ?></h4>
                    </div>
                    <div class="modal-body">

                        <div id="err_edit<?php echo $new->id ?>">  
                            <?php if (validation_errors()) { ?>
                                <div class="alert alert-danger alert-dismissable">
                                    <i class="fa fa-ban"></i>
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
                                    <b><?php echo lang('alert') ?>!</b><?php echo validation_errors(); ?>
                                </div>

                            <?php } ?>  
                        </div>   <!-- Chat box -->
                        <div class="box box-success">
                            <div class="box-header">
                                <i class="fa fa-comments-o"></i>
                                <h3 class="box-title"><?php echo lang('message'); ?> <?php echo lang('to'); ?> <?php echo $patient->name; ?></h3>
                                <div class="box-tools pull-right" data-toggle="tooltip" title="Status">

                                </div>
                            </div>
                            <div class="box-body chat" id="chat-box">
                                <!-- chat item -->
                                <?php if (isset($messages)): ?>		
                                    <?php
                                    $i = 1;
                                    foreach ($messages as $new) {
                                        ?>		
                                        <div class="item">
                                            <?php
                                            if (empty($new->image)) {
                                                ?>
                                                <img src="<?php echo base_url('assets/uploads/images/avatar5.png') ?>" alt="user image" class="online"/>
                                            <?php } else { ?>
                                                <img src="<?php echo base_url('assets/uploads/images/' . $new->image) ?>" alt="user image" class="online"/>
                                            <?php } ?>	
                                            <div class="col-xs-12"> <?php if ($admin['user_role'] == 1) {
                                                ?><a href="<?php echo site_url('admin/user_message/delete/' . $new->id) ?>" onclick="return confirm('are you sure?')" class="btn btn-danger" style="float:right"><i class="fa fa-times"></i></a></div>
                                                <?php } ?>
                                            <p class="message" style="padding-top:12px;">

                                                <a href="#" class="name">


                                                    <?php if ($new->from_id == $admin['id']) {
                                                        ?>     

                                                        <span style="color:#FF0000">	 <?php echo $new->from_user ?></span> 
                                                        <small class="text-muted"><i class="fa fa-clock-o"></i> <?php echo date("d/m/y h:i a", strtotime($new->date_time)); ?> </small>
                                                        <?php
                                                    } else {
                                                        echo $new->from_user;
                                                        ?>
                                                        <small class="text-muted"><i class="fa fa-clock-o"></i> <?php echo date("d/m/y h:i a", strtotime($new->date_time)); ?> </small><br />
                                                    <?php } ?>	

                                                </a>
                                                <?php echo $new->message ?> 
                                            </p>
                                            <?php if ($new->file != '') {
                                                ?>
                                                <div class="col-xs-12"> 
                                                    <a class="btn btn-default"  href="<?php echo base_url('assets/uploads/files/' . $new->file); ?>" download style="float:right"><?php echo lang('download') . ' ' . lang('attachment') ?></a>
                                                </div>
                                            <?php }
                                            ?>

                                        </div><!-- /.item -->
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                <?php endif; ?> 

                            </div><!-- /.chat -->

                        </div><!-- /.box (chat box) -->
                        <!-- form start -->

                        <h3 style="color:#FF0000"><?php echo validation_errors(); ?></h3>
                        <?php echo form_open_multipart('admin/user_message/send/' . $patient->id); ?>
                        <input type="hidden"  name="id" value="<?php echo $patient->id; ?>" />    
                        <div class="box-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="name" style="clear:both;"><?php echo lang('message'); ?></label>
                                        <textarea name="message" class="form-control redactor message"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="name" style="clear:both;"><?php echo lang('upload_file'); ?></label>
                                        <input name="file" type="file" class="form-control"/>
                                    </div>
                                </div>
                            </div>



                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary update"><?php echo lang('submit') ?></button>
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


<script src="<?php //echo site_url('assets/js/redactor.min.js')        ?>"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') ?>" type="text/javascript"></script>
<script type="text/javascript">
                                                $(function () {
                                                    $('#example1').dataTable({
                                                    });
                                                });




                                                $(".update").click(function (event) {
                                                    event.preventDefault();
//$(this).closest("form").submit();	
                                                    var form = $(this).closest('form');
                                                    var formData = new FormData(form[0]);
                                                    id = $(form).find('input[name=id]').val();
                                                    message = $(form).find('.message').val();
                                                    call_loader_ajax();
                                                    $.ajax({
                                                        url: '<?php echo site_url('admin/user_message/send/') ?>/' + id,
                                                        type: 'POST',
                                                        async: false,
                                                        data: formData,
                                                        cache: false,
                                                        contentType: false,
                                                        processData: false,

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

</script>

<script>
    $(function () {
        $(".redactor").wysihtml5({
            "link": false, //Button to insert a link. Default true
            "image": false, //Button to insert an image. Default true,
        });
    });
</script>