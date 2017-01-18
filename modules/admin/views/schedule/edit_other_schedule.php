
<link href="<?php echo site_url('assets/css/chosen.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/css/jquery.datetimepicker.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/css/bootstrap-timepicker.css')?>" rel="stylesheet" type="text/css" />

<!-- Content Header (Page header) -->
<style>
.row{
	margin-bottom:10px;
}
</style>
 <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
      Edit Specific Schedule
        <small><?php echo lang('edit');?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin')?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard');?></a></li>
        <li><a href="<?php echo site_url('admin/appointments')?>"><?php echo lang('appointments');?></a></li>
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
                    <h3 class="box-title"> Edit Specific Schedule Edit</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
			
				<?php //echo '<pre>' ; print_r($specific_schedule_details);die; // 
				echo form_open(); ?>
				<input type="hidden" name="id" value="<?php echo $specific_schedule_details->id ;?>" >
                    <div class="box-body">
                       <div class="form-group">
                        	<div class="row">
                                <div class="col-md-4">
                                    <label for="name" style="clear:both;">Hospital</label>
									<select name="hospital" id="class_list" class="form-control">
													 <option value="">Select</option>
													  <?php foreach($hospital as $hos) {?>
													  <option value="<?php echo $hos->id ;?>" <?php echo($hos->id==$specific_schedule_details->hospital_id)?'selected':'';?>>
													  <?php echo $hos->name ;?></option>
													  <?php }?>
												</select>
                                </div>
                            </div>
                        </div>
					    <div class="form-group">
                        	<div class="row">
                                <div class="col-md-4">
                                    <label for="name" style="clear:both;"> Work</label>
									<input type="text" name="work" value="<?php echo $specific_schedule_details->work ;?>" class="form-control">
                                </div>
                            </div>
                        </div>
						
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-4">
                                   <label for="name" style="clear:both;"> Date</label>
									<input type="text" name="dates" value="<?php echo $specific_schedule_details->dates ;?>" class="form-control datepicker">
                                </div>
                            </div>
                        </div>
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-4 bootstrap-timepicker">
                                    <label for="name" style="clear:both;">Timing From</label>
									<input type="text" name="timing_from" value="<?php echo $specific_schedule_details->timing_from ;?>" class="form-control timepicker">
                                </div>
                            </div>
                        </div>
						
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-4 bootstrap-timepicker">
                                    <label for="name" style="clear:both;">Timing To</label>
									<input type="text" name="timing_to" value="<?php echo $specific_schedule_details->timing_to;?>" class="form-control timepicker">
                                </div>
                            </div>
                        </div>
						
						
								
                            </div>
                      <div class="box-footer">
                        <button type="submit"  name="s1" value="s1" class="btn btn-primary"><?php echo lang('save');?></button>
                    </div>	
					    </div>
							
							
					
                    </div><!-- /.box-body -->
    
                    
             <?php form_close()?>
            </div><!-- /.box -->
        </div>
     </div>
</section>  
<script src="<?php echo site_url('assets/js/bootstrap-timepicker.min.js')?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/js/chosen.jquery.min.js')?>" type="text/javascript"></script>

<script src="<?php echo site_url('assets/js/jquery.datetimepicker.js')?>" type="text/javascript"></script>


<script src="<?php echo site_url('assets/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')?>" type="text/javascript"></script>
<script type="text/javascript">
$('.datepicker').datetimepicker({
 lang:'en',
 timepicker:false,
 format:'Y-m-d'
});

$(".timepicker").timepicker({
	showInputs: false,
	defaultTime: 'value'
});


$(document).on('click','.rem',function(){
    $(this).closest('.row').remove();
});


 jQuery('.datepicker').datetimepicker({
 lang:'en',
 timepicker:false,
 format:'Y-m-d'
});
 
  $(function() {

	$(".timepicker").timepicker({
		showInputs: false,
		defaultTime: 'value'
	});

  });
	
</script>