<link href="<?php echo site_url('assets/css/chosen.css')?>" rel="stylesheet" type="text/css" />
<!-- Content Header (Page header) -->
<style>
.row{
	margin-bottom:10px;
}
</style>
 <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
       <?php echo lang('medicine');?>
        <small><?php echo lang('edit');?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin')?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard');?></a></li>
        <li><a href="<?php echo site_url('admin/medicine')?>"> <?php echo lang('medicine');?></a></li>
        <li class="active"> <?php echo lang('edit');?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
<?php 
	if(validation_errors()){
?>
<div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
                                        <b><?php echo lang('alert');?>!</b><?php echo validation_errors(); ?>
                                    </div>

<?php  } ?>  
	   	
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"><?php echo lang('edit');?></h3>
                </div><!-- /.box-header -->
                <!-- form start -->
				
				<?php echo form_open_multipart('admin/medicine/edit/'.$id); ?>
                    <div class="box-body">
                        <div class="box-body">
                         <div class="form-group">
                        	<div class="row">
                                <div class="col-md-4">
                                    <label for="name" style="clear:both;"> <?php echo lang('name');?></label>
									<input type="text" name="name" value="<?php echo set_value('name') . $medicine->name?>" class="form-control">
                                </div>
                            </div>
                        </div>
						
						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-4">
                                    <label for="name" style="clear:both;"> <?php echo lang('medicine_category');?></label>
									<select name="category_id" class="form-control chzn">
											<option value="">--<?php echo lang('select_medicine_category');?>--</option>
											<?php foreach($category as $new) {
													$sel = "";
													if($new->id==$medicine->category_id) $sel = "selected='selected'";
													echo '<option value="'.$new->id.'" '.$sel.'>'.$new->name.'</option>';
												}
												
											?>
										</select>
                                </div>
                            </div>
                        </div>
						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-4">
                                    <label for="name" style="clear:both;"> <?php echo lang('manufacturing_company');?></label>
									<select name="company_id" class="form-control chzn">
											<option value="">--<?php echo lang('select_manufacturing_company');?>--</option>
											<?php foreach($company as $new) {
													$sel = "";
													if($new->id==$medicine->company_id) $sel = "selected='selected'";
													echo '<option value="'.$new->id.'" '.$sel.'>'.$new->name.'</option>';
												}
												
											?>
										</select>
                                </div>
                            </div>
                        </div>
						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-4">
                                    <label for="name" style="clear:both;"> <?php echo lang('price');?></label>
									<input type="text" name="price" value="<?php echo set_value('price') . $medicine->price?>" class="form-control">
                                </div>
                            </div>
                        </div>
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-4">
                                    <label for="name" style="clear:both;"> <?php echo lang('description');?></label>
									<textarea name="description" class="form-control"><?php echo set_value('description'). $medicine->description?></textarea>
                                </div>
                            </div>
                        </div>
						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-4">
                                    <label for="name" style="clear:both;"> <?php echo lang('status');?></label>
									<input type="checkbox" name="status" value="1" <?php echo ($medicine->status==1)?'checked="checked"' : '' ?> class="form-control">
                                </div>
                            </div>
                        </div>
				<?php 
					$admin = $this->session->userdata('admin');
					if($admin['user_role']=="Admin"){
				?>		
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-4">
                                    <label for="name" style="clear:both;"> <?php echo lang('doctor');?></label>
									<select name="company_id" class="form-control chzn">
											<option value="">--<?php echo lang('doctor');?>--</option>
											<?php foreach($doctors as $new) {
													$sel = "";
													if($new->id==$medicine->doctor_id) $sel = "selected='selected'";
													echo '<option value="'.$new->id.'" '.$sel.'>'.$new->name.'</option>';
												}
												
											?>
										</select>
                                </div>
                            </div>
                        </div>
				<?php } ?>		
			   			
                     	
                    </div><!-- /.box-body -->
    
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary"><?php echo lang('update');?></button>
                    </div>
             <?php form_close()?>
            </div><!-- /.box -->
        </div>
     </div>
</section>  
<script src="<?php echo site_url('assets/js/chosen.jquery.min.js')?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/js/bootstrap-datepicker.js')?>" type="text/javascript"></script>


<script src="<?php echo site_url('assets/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')?>" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
	
	$('.chzn').chosen();
	
});


$(function() {
	//bootstrap WYSIHTML5 - text editor
	$(".txtarea").wysihtml5();
});

 $(function() {
    $( "#datepicker" ).pickmeup({
    format  : 'Y-m-d'
});
  });
</script>