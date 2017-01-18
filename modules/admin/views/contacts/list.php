<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css') ?>" rel="stylesheet" type="text/css" />
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
        <li><a href="<?php echo site_url('admin') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard'); ?></a></li>
        <li class="active"><?php echo lang('contacts'); ?></li>
    </ol>
</section>

<section class="content">
    <div class="row" style="margin-bottom:10px;">
        <div class="col-xs-12">
            <div class="col-md-6 pull-right">
                <a class="btn btn-default" href="#add" data-toggle="modal"><i class="fa fa-plus"></i> <?php echo lang('add_new'); ?></a>
                <a class="btn btn-primary"  href="<?php echo site_url('admin/contacts/export/'); ?>"><i class="fa fa-download"></i> <?php echo lang('export'); ?></a>

                <a href="#myModal" data-toggle="modal" class="btn bg-olive btn-flat margin"><i class="fa fa-caret-square-o-down"></i> <?php echo lang('import'); ?></a>		
                <a href="<?php echo site_url('admin/contacts/import_patients'); ?>" class="btn bg-olive btn-flat margin" onclick="return areyousure()"><i class="fa fa-caret-square-o-down"></i> <?php echo lang('import_patients')?></a>
            </div>
        </div>    
    </div>	

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo lang('add'); ?></h3>                                    
                </div><!-- /.box-header -->

                <div class="box-body table-responsive" style="margin-top:40px;">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo lang('name'); ?></th>
                                <th><?php echo lang('phone'); ?></th>
                                <th width="28%"><?php echo lang('action'); ?></th>
                            </tr>
                        </thead>

                        <?php if (isset($contacts)): ?>
                            <tbody>
                                <?php $i = 1;
                                foreach ($contacts as $new) { ?>
                                    <tr class="gc_row">
                                        <td><?php echo $new->name ?></td>
                                        <td><?php echo $new->contact ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <a class="btn btn-default" href="#view<?php echo $new->id; ?>" data-toggle="modal"><i class="fa fa-eye"></i> <?php echo lang('view'); ?></a>
                                                <a class="btn btn-primary"  href="#edit<?php echo $new->id; ?>" data-toggle="modal"><i class="fa fa-edit"></i> <?php echo lang('edit'); ?></a>
                                                <a class="btn btn-danger" style="margin-left:20px;" href="<?php echo site_url('admin/contacts/delete/' . $new->id); ?>" onclick="return areyousure()"><i class="fa fa-trash"></i> <?php echo lang('delete'); ?></a>
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



<!-- Modal -->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="addlabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content ff">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="addlabel"><?php echo lang('add'); ?> <?php echo lang('contact') ?></h4>
            </div>
            <div class="modal-body">
                <div id="err">  
<?php if (validation_errors()) { ?>
                        <div class="alert alert-danger alert-dismissable">
                            <i class="fa fa-ban"></i>
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
                            <b><?php echo lang('alert') ?>!</b><?php echo validation_errors(); ?>
                        </div>

<?php } ?>  
                </div>

                <form method="post" id="add">
                    <div class="box-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="name" style="clear:both;"><?php echo lang('name'); ?></label>
                                    <input type="text" name="name" value="<?php echo set_value('name'); ?>" class="form-control name">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="name" style="clear:both;"><?php echo lang('phone'); ?></label>
                                    <input type="text" name="phone" value="<?php echo set_value('phone'); ?>" class="form-control phone">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="name" style="clear:both;"><?php echo lang('email'); ?></label>
                                    <input type="text" name="email" value="<?php echo set_value('email'); ?>"class="form-control email">
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

                    </div><!-- /.box-body -->

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







<?php if (isset($contacts)): ?>
    <?php
    $i = 1;
    foreach ($contacts as $new) {
        $contact = $this->contact_model->get_contact_by_id($new->id);
        ?>

        <!-- Modal -->
        <div class="modal fade" id="edit<?php echo $new->id ?>" tabindex="-1" role="dialog" aria-labelledby="editLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="editLabel"><?php echo lang('edit'); ?> <?php echo lang('contacts'); ?></h4>
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
        <?php echo form_open_multipart('admin/contacts/edit/' . $new->id); ?>
                        <input type="hidden" name="id" value="<?php echo $new->id; ?>" />
                        <div class="box-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="name" style="clear:both;"> <?php echo lang('name'); ?></label>
                                        <input type="text" name="name" value="<?php echo @$contact->name ?>" class="form-control name">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="name" style="clear:both;"><?php echo lang('phone'); ?></label>
                                        <input type="text" name="phone"class="form-control phone" value="<?php echo $contact->contact ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="name" style="clear:both;"><?php echo lang('email'); ?></label>
                                        <input type="text" name="email"class="form-control email" value="<?php echo @$contact->email ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="name" style="clear:both;"><?php echo lang('address'); ?></label>
                                        <textarea name="address" class="form-control address"><?php echo $contact->address ?></textarea>
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
                            <button type="submit" class="btn btn-primary update"><?php echo lang('update'); ?></button>
                        </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></button>  
                    </div>
                </div>
            </div>
        </div>

        <?php $i++;
    } ?>
<?php endif; ?>









<?php if (isset($contacts)): ?>
    <?php
    $i = 1;
    foreach ($contacts as $new) {
        $contact = $this->contact_model->get_contact_by_id($new->id);
        ?>

        <!-- Modal -->
        <div class="modal fade" id="view<?php echo $new->id ?>" tabindex="-1" role="dialog" aria-labelledby="viewLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="viewLabel"><?php echo lang('view'); ?> <?php echo lang('contacts'); ?></h4>
                    </div>
                    <div class="modal-body">
                        <div class="box-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="name" style="clear:both;"> <?php echo lang('name'); ?></label>
                                    </div>
                                    <div class="col-md-4">
        <?php echo @$contact->name ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="name" style="clear:both;"><?php echo lang('phone'); ?></label>
                                    </div>
                                    <div class="col-md-4">
        <?php echo $contact->contact ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="name" style="clear:both;"><?php echo lang('email'); ?></label>
                                    </div>
                                    <div class="col-md-4">
        <?php echo @$contact->email ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="name" style="clear:both;"><?php echo lang('address'); ?></label>
                                    </div>
                                    <div class="col-md-4">
        <?php echo $contact->address ?>
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
                    <?php $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '" . $doc->id . "' AND table_id = '" . $clients->id . "' AND form = '" . $doc->form . "' ")->row(); ?>		
                                                </div>
                                                <div class="col-md-4">	
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
                                                <div class="col-md-2">
                                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                                                </div>
                                                <div class="col-md-4">
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
                                                <div class="col-md-2">
                                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                                                </div>
                                                <div class="col-md-4">
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
                                                <div class="col-md-2">
                                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                                                </div>
                                                <div class="col-md-4">	
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
                                                <div class="col-md-2">
                                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
                                                </div>
                                                <div class="col-md-4">
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

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></button>  
                    </div>
                </div>
            </div>
        </div>

        <?php $i++;
    } ?>
<?php endif; ?>






<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo lang('import_contacts'); ?></h4>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url('admin/contacts/import') ?>" enctype="multipart/form-data">
                    <div class="alert alert-info alert-dismissable">
                        <i class="fa fa-info"></i>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
                        <b><?php echo lang('instruction'); ?>!</b> <?php echo lang('contacts_import_instruction'); ?>  
                    </div>

                    <div class="box-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <a href="<?php echo base_url('assets/contact.xls'); ?>" download class="btn btn-default"><i class="fa fa-download"></i> <?php echo lang('download_sample') ?></a>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="name" style="clear:both;"><?php echo lang('file'); ?></label>
                                    <input type="file" name="file" value="" class="form-control">
                                </div>
                            </div>
                        </div>



                    </div><!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary"><?php echo lang('save'); ?></button>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></button>  
            </div>
        </div>
    </div>
</div>


<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js') ?>" type="text/javascript"></script>
<script type="text/javascript">
                                            $(function () {
                                                $('#example1').dataTable({
                                                });
                                            });

                                            $("#add").submit(function (event) {
                                                name = $('.name').val();
                                                email = $('.email').val();
                                                phone = $('.phone').val();
                                                address = $('.address').val();
                                                reply = $('input[name=reply]').val();
                                                //alert("sdas");return false;	
                                                call_loader_ajax();
                                                $.ajax({
                                                    url: '<?php echo site_url('admin/contacts/add/') ?>',
                                                    type: 'POST',
                                                    data: {name: name, email: email, phone: phone, address: address, reply: reply},

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
                                                email = $(form).find('.email').val();
                                                phone = $(form).find('.phone').val();
                                                address = $(form).find('.address').val();
                                                reply = $('input[name=reply]').val();

                                                //alert(date_time);return false;
                                                call_loader_ajax();
                                                $.ajax({
                                                    url: '<?php echo site_url('admin/contacts/edit') ?>/' + id,
                                                    type: 'POST',
                                                    data: {name: name, email: email, phone: phone, address: address, reply: reply},
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