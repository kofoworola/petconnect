<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css') ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    function areyousure()
    {
        return confirm('Are You Sure You Want Delete This Location ?');
    }
</script>
<section class="content-header">
    <h1>
        <?php echo $page_title; ?>
        <small><?php echo lang('list'); ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard'); ?></a></li>
        <li class="active"><?php echo lang('hospital'); ?> </li>
    </ol>
</section>

<section class="content">
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
                    <h3 class="box-title"><?php echo lang('view_all'); ?></h3>                                    
                </div><!-- /.box-header -->

                <div class="box-body table-responsive" style="margin-top:40px;">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo lang('name'); ?></th>
                                <th><?php echo lang('address'); ?></th>
                                <th><?php echo lang('phone'); ?></th>

                                <th><?php echo lang('action'); ?></th>
                            </tr>
                        </thead>


                        <tbody>
                            <?php $i = 1;
                            foreach ($hospitals as $new) { ?>
                                <tr class="gc_row">
                                    <td><?php echo $new->name ?></td>
                                    <td><?php echo $new->address ?></td>
                                    <td><?php echo $new->phone ?></td>
                                    <td width="27%">
                                        <div class="btn-group">
                                            <a class="btn btn-default"  href="#view<?php echo $new->id; ?>" data-toggle="modal"><i class="fa fa-eye"></i> <?php echo lang('view'); ?></a>

                                            <a class="btn btn-primary"  style="margin-left:15px;" href="#edit<?php echo $new->id; ?>" data-toggle="modal"><i class="fa fa-edit"></i> <?php echo lang('edit'); ?></a>
                                            <a class="btn btn-danger" style="margin-left:20px;" href="<?php echo site_url('admin/locations/delete/' . $new->id); ?>" onclick="return areyousure()"><i class="fa fa-trash"></i> <?php echo lang('delete'); ?></a>
                                            <a class="btn btn-default" style="display:none"  href="<?php echo site_url('admin/location/manage/' . $new->id); ?>"><i class="fa fa-arrows"></i> <?php echo lang('manage'); ?></a>
                                        </div>


                                    </td>
                                </tr>
                                <?php $i++;
                            } ?>
                        </tbody>

                    </table>

                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section>



<?php if (isset($hospitals)): ?>
    <?php
    $i = 1;
    foreach ($hospitals as $new) {
        $hospital_details = $this->hospital_model->get_hospital_by_id($new->id);
//echo '<pre>'; print_r($hospital_details);
        ?>
        <!-- Modal -->
        <div class="modal fade" id="edit<?php echo $new->id ?>" tabindex="-1" role="dialog" aria-labelledby="editlabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content ff">
                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="editlabel"><?php echo lang('edit'); ?> <?php echo lang('hospital') ?></h4>
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
                        <form method="post" action="<?php echo site_url('admin/location/edit/' . $hospital_details->id) ?>"?>
                            <input type="hidden" name="id" value="<?php echo $hospital_details->id; ?>" />
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="name" style="clear:both;"> <?php echo lang('name'); ?></label>
                                        <input type="text" name="name" value="<?php echo $hospital_details->name ?>" class="form-control name">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="name" style="clear:both;"><?php echo lang('address'); ?></label>
                                        <textarea name="address" class="form-control address"><?php echo $hospital_details->address; ?></textarea>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="name" style="clear:both;"><?php echo lang('phone'); ?> </label>
                                        <input type="text" name="phone" value="<?php echo $hospital_details->phone; ?>"class="form-control phone">
                                    </div>
                                </div>
                            </div>


                            <div class="box-footer">
                                <button type="submit" name="s1" value="s1" class="btn btn-primary update"><?php echo lang('save'); ?></button>
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






<?php if (isset($hospitals)): ?>
    <?php
    $i = 1;
    foreach ($hospitals as $new) {
        $hospital_details = $this->hospital_model->get_hospital_by_id($new->id);
        ?>
        <!-- Modal -->
        <div class="modal fade" id="view<?php echo $new->id ?>" tabindex="-1" role="dialog" aria-labelledby="viewlabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content ff">
                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="viewlabel"><?php echo lang('view'); ?> <?php echo lang('hospital') ?></h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('name'); ?></label>
                                </div>
                                <div class="col-md-4">
        <?php echo $hospital_details->name; ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"><?php echo lang('address'); ?></label>
                                </div>
                                <div class="col-md-4">
        <?php echo $hospital_details->address; ?> 
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"><?php echo lang('phone'); ?></label>
                                </div>
                                <div class="col-md-4">
        <?php echo $hospital_details->phone; ?>
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
        <?php $i++;
    } ?>
<?php endif; ?>



<!-- Modal -->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="addlabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content ff">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="addlabel"><?php echo lang('add'); ?> <?php echo lang('hospital') ?></h4>
            </div>
            <div class="modal-body">

                        <?php // echo form_open_multipart('admin/hospital/add/'); ?>
                <form method="post" id="add_hospital">

                    <div id="err">  
<?php if (validation_errors()) { ?>
                            <div class="alert alert-danger alert-dismissable">
                                <i class="fa fa-ban"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
                                <b><?php echo lang('alert') ?>!</b><?php echo validation_errors(); ?>
                            </div>

<?php } ?>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="name" style="clear:both;"> <?php echo lang('name'); ?></label>
                                    <input type="text" name="name" value="<?php echo set_value('name'); ?>"class="form-control name">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="name" style="clear:both;"><?php echo lang('address'); ?></label>
                                    <textarea name="address" class="form-control address"><?php echo set_value('address'); ?></textarea>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="name" style="clear:both;"><?php echo lang('phone'); ?> </label>
                                    <input type="text" name="phone" value="<?php echo set_value('phone'); ?>"class="form-control phone">
                                </div>
                            </div>
                        </div>



                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary"><?php echo lang('save'); ?></button>
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



<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js') ?>" type="text/javascript"></script>
<script type="text/javascript">
                                             $(function () {
                                                 $('#example1').dataTable({
                                                 });
                                             });


                                             $("#add_hospital").submit(function (event) {
                                                 var form = $(this).closest('form');
                                                 //id = $(form ).find('input[name=id]').val();
                                                 name = $(form).find('.name').val();
                                                 address = $(form).find('.address').val();
                                                 phone = $(form).find('.phone').val();
                                                 //alert(name);
                                                 call_loader_ajax();
                                                 $.ajax({
                                                     url: '<?php echo site_url('admin/locations/add/') ?>',
                                                     type: 'POST',
                                                     data: {name: name, address: address, phone: phone},

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
                                                 address = $(form).find('.address').val();
                                                 phone = $(form).find('.phone').val();

                                                 //alert(name);return false;
                                                 call_loader_ajax();
                                                 $.ajax({
                                                     url: '<?php echo site_url('admin/locations/edit') ?>/' + id,
                                                     type: 'POST',
                                                     data: {name: name, address: address, phone: phone},
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
