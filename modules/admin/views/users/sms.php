<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/chosen.css') ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    function areyousure()
    {
        return confirm('<?php echo lang('are_you_sure'); ?>');
    }
</script>
<style>
    .chosen-container{width:100% !important
    }


</style>
<section class="content-header">
    <h1>
        <?php echo $page_title; ?>
        <small><?php echo lang('list'); ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard'); ?></a></li>
        <li class="active"><?php echo lang('sms_settings'); ?></li>
    </ol>
</section>
<section class="content">
    <div class="row no-print">
        <div class="col-xs-12">
            <div class="body">
                <div class="box-header">
                    <h3 class="box-title">Twilio Credntials</h3>
                </div><!--Box header -->

                <div class="box-body table-responsive no-print" style="margin-top:40px;">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="display:none">#</th>
                                <th><?php echo lang('name'); ?></th>
                                <th><?php echo lang('twillo_id'); ?></th>
                                <th><?php echo lang('auth_token');?></th>
                                <th>Messaging Service Id</th>
                                <th width="20%"></th>
                            </tr>
                        </thead>

                        <?php if (isset($users)): ?>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($users as $new) {
                                    ?>
                                    <tr class="gc_row">
                                        <td style="display:none"><?php echo $i ?></td>
                                        <td><?php echo $this->setting_model->get_setting_name_by_id($new->id); ?></td>
                                        <td><?php echo $new->twillo_id ?></td>
                                        <td><?php echo $new->twillo_auth?></td>
                                        <td><?php echo $new->message_id?></td>
                                        
                                        <td width="20%">
                                            <div class="btn-group">
                                                <a class="btn btn-primary" style="margin-left:10px;"  href="#add<?php echo $new->id; ?>" data-toggle="modal"><i class="fa fa-edit"></i> Edit Credentials</a>
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
                </div>
            </div>
        </div>
    </div>
</section>

<?php if (isset($users)): ?>
    <?php
    $i = 1;
    foreach ($users as $new) {
        ?>
        <div class="modal fade" id="add<?php echo $new->id ?>" tabindex="-1" role="dialog" aria-labelledby="editlabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content ff">
                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="editlabel">Edit Credentials</h4>
                    </div>
                    <div class="modal-body">
                        <div id="err_add<?php echo $new->id ?>">  
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

                        <form method="post" id="add<?php echo $new->id; ?>" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $new->id ?>"/>
                            <div class="box-body">
                                <div class="form-group" style="margin-top:20px;"> 
                                    <legend>Edit Twilio Credentials</legend>  
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <b>Twillo ID</b>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="twillo_id" value="<?php echo $new->twillo_id; ?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <b>Authentication Token</b>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="password" class="form-control" name="twillo_auth" value="<?php echo $new->twillo_auth; ?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <b>Messaging Service Id</b>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="message_id" value="<?php echo $new->message_id; ?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary update"><?php echo lang('update') ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
<?php endif; ?>

<script src="<?php echo base_url('assets/js/chosen.jquery.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js') ?>" type="text/javascript"></script>
<script type="text/javascript">
    $(function () {
        $('#example1').dataTable({
        });
        $('.chzn').chosen({search_contains: true});
    });

    $(".update").click(function (event) {
        event.preventDefault();

        var form = $(this).closest('form');
        id = $(form).find('input[name=id]').val();
        twillo_id = $(form).find('input[name=twillo_id]').val();
        twillo_auth = $(form).find('input[name=twillo_auth]').val();
        call_loader_ajax();

        $.ajax({
            url: '<?php echo site_url('admin/sms/update') ?>/' + id,
            type: 'POST',
            data: form.serialize(),

            success: function (result) {
                //alert('result');
                if (result == 1)
                {
                    location.reload();
                } else
                {
                    $("#overlay").hide();
                    $('#err_add' + id).html(result);
                }
            }
        });
    });
</script>


