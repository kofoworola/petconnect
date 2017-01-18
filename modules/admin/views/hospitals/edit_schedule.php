<link href="<?php echo site_url('assets/css/chosen.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/css/jquery.datetimepicker.css')?>" rel="stylesheet" type="text/css" /><!-- Content Header (Page header) -->
<link href="<?php echo site_url('assets/css/bootstrap-timepicker.css')?>" rel="stylesheet" type="text/css" />
<style>
.row{
	margin-bottom:10px;
}
</style>

 <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo lang('schedule');?>
        <small><?php echo lang('edit');?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin')?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard');?></a></li>
        <li><a href="<?php echo site_url('admin/hospital/view_all')?>"><?php echo lang('hospital');?></a></li>
        <li class="active"><?php echo lang('edit');?></li>
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
                    <h3 class="box-title"<?php echo lang('edit');?></h3>
                </div><!-- /.box-header -->
                <!-- form start -->
				<?php echo form_open_multipart('admin/hospital/edit_schedule/'.$schedule->id); ?>
                    <div class="box-body">
                        <div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
										<select name="day_id" class="form-control chzn">
											<option value="">--<?php echo lang('day');?>--</option>
											<?php foreach($days as $new) {
													$sel = "";
													if($new->id==$schedule->day) $sel = "selected='selected'";
													echo '<option value="'.$new->id.'" '.$sel.'>'.$new->name.'</option>';
												}
												
											?>
										</select>
								</div>
								
								<div class="col-md-2">	
									<input type="text" name="start" value="<?php echo $schedule->timing_from; ?>"  placeholder="10:00 am" class="form-control timepicker">
							    </div>
                                
                                <div class="col-md-2">	
									<input type="text" name="end" value="<?php echo $schedule->timing_to; ?>"  placeholder="05:00 pm" class="form-control timepicker">
							    </div>
                                
                                <div class="col-md-3">	
									<input type="text" name="work" value="<?php echo $schedule->work; ?>"  placeholder="Work" class="form-control">
							    </div>
								
                            </div>
                        </div>
						
						 
			   			
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary"><?php echo lang('save');?></button>
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
