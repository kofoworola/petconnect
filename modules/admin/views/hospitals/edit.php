<link href="<?php echo site_url('assets/css/chosen.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/css/jquery.datetimepicker.css')?>" rel="stylesheet" type="text/css" />
<!-- Content Header (Page header) -->
<style>
.row{
	margin-bottom:10px;
}
</style>

 <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo lang('hospital');?>
        <small><?php echo lang('add');?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin')?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard');?></a></li>
        <li><a href="<?php echo site_url('admin/to_do_list')?>"><?php echo lang('to_do_list');?></a></li>
        <li class="active"><?php echo lang('add');?></li>
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
			<?php //echo '<pre>'; print_r($hospital_details); die;?>
            <div class="box box-primary">
			 <div class="box-header">
                    <h3 class="box-title"><?php echo lang('add');?></h3>
                </div><!-- /.box-header -->
                <!-- form start -->
				
				<?php echo form_open(); ?>
                    <div class="box-body">
                        <div class="form-group">
                        	<div class="row">
                                <div class="col-md-4">
                                    <label for="name" style="clear:both;"> <?php echo lang('name');?></label>
									<input type="text" name="name" value="<?php echo $hospital_details->name ?>" class="form-control">
                                </div>
                            </div>
                        </div>
						
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-4">
                                    <label for="name" style="clear:both;"><?php echo lang('address');?></label>
									<textarea name="address" class="form-control"><?php echo $hospital_details->address; ?></textarea>
                                </div>
                            </div>
                        </div>
						
						
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-4">
                                    <label for="name" style="clear:both;"><?php echo lang('phone');?> </label>
									<input type="text" name="phone" value="<?php echo $hospital_details->phone; ?>"class="form-control">
                                </div>
                            </div>
                        </div>
						
						 
                    <div class="box-footer">
                        <button type="submit" name="s1" value="s1" class="btn btn-primary"><?php echo lang('save');?></button>
                    </div>
             <?php form_close()?>
            </div><!-- /.box -->
        </div>
     </div>
</section>  
<script src="<?php echo site_url('assets/js/chosen.jquery.min.js')?>" type="text/javascript"></script>



<script src="<?php echo site_url('assets/js/jquery.datetimepicker.js')?>" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
	
	$('.chzn').chosen();
	
});




 $(function() {
   $('.datetimepicker').datetimepicker({
	//mask:'9999-19-39 29:59',
	format  : 'Y-m-d'
	
	}
	
	);
  });
</script>
