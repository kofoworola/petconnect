<link href="<?php echo base_url('assets/css/chosen.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/bootstrap-timepicker.css')?>" rel="stylesheet" type="text/css" />
<!-- Content Header (Page header) -->
<style>
.row{
	margin-bottom:10px;
}
.bootstrap-timepicker-widget{margin-bottom:-200px !important
}
</style>
 <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo lang('appointments');?>
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
                    <h3 class="box-title"><?php echo lang('edit');?></h3>
                </div><!-- /.box-header -->
                <!-- form start -->
				
				<?php echo form_open_multipart('admin/appointments/edit/'.$id); ?>
                    <div class="box-body" style="height:400px;">
                    		
							<div class="form-group">
								<div class="row">	
										<div class="col-md-2">
										<label>	<?php echo lang('title');?></label>
										</div>
										<div class="col-md-3">
											<input type="text" name="title" value="<?php echo @$times->title ?>" class="form-control" />
										</div>
										
								</div>
							</div>	
							
							<div class="form-group">
								<div class="row">	
										<div class="col-md-2">
										<label>	Days</label>
										</div>
										<div class="col-md-3">
										<label>	From</label>
										</div>
										<div class="col-md-3">
										<label>	To</label>
										</div>
								</div>
							</div>				
							
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-1">
                                    <label for="name" style="clear:both;"> <?php echo lang('monday')?></label>
								</div>	
								<div class="col-md-3">	
								<div class="bootstrap-timepicker">   
									<input type="text" name="mon_start" value="<?php echo  @$times->mon_start?>"  placeholder="Start Time" class="form-control timepicker">
									</div>
                                </div>
								<div class="col-md-3">	
									<div class="bootstrap-timepicker">    
									<input type="text" name="mon_end" value="<?php echo  @$times->mon_end?>"  placeholder="End Time" class="form-control timepicker">
									</div>
                                </div>
                            </div>
                        </div>
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-1">
                                    <label for="name" style="clear:both;"> <?php echo lang('tuesday')?></label>
								</div>	
								<div class="col-md-3">	
								<div class="bootstrap-timepicker">   
									<input type="text" name="tue_start" value="<?php echo  @$times->tue_start?>"  placeholder="Start Time" class="form-control timepicker">
									</div>
                                </div>
								<div class="col-md-3">	
									<div class="bootstrap-timepicker">    
									<input type="text" name="tue_end" value="<?php echo  @$times->tue_end?>"  placeholder="End Time" class="form-control timepicker">
									</div>
                                </div>
                            </div>
                        </div>
						
						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-1">
                                    <label for="name" style="clear:both;"> <?php echo lang('wednusday')?></label>
								</div>	
								<div class="col-md-3">	
								<div class="bootstrap-timepicker">   
									<input type="text" name="wed_start" value="<?php echo  @$times->wed_start?>"  placeholder="Start Time" class="form-control timepicker">
									</div>
                                </div>
								<div class="col-md-3">	
									<div class="bootstrap-timepicker">    
									<input type="text" name="wed_end" value="<?php echo  @$times->wed_end?>"  placeholder="End Time" class="form-control timepicker">
									</div>
                                </div>
                            </div>
                        </div>
						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-1">
                                    <label for="name" style="clear:both;"> <?php echo lang('thursday')?></label>
								</div>	
								<div class="col-md-3">	
								<div class="bootstrap-timepicker">   
									<input type="text" name="thu_start" value="<?php echo  @$times->thu_start?>"  placeholder="Start Time" class="form-control timepicker">
									</div>
                                </div>
								<div class="col-md-3">	
									<div class="bootstrap-timepicker">    
									<input type="text" name="thu_end" value="<?php echo  @$times->thu_end?>"  placeholder="End Time" class="form-control timepicker">
									</div>
                                </div>
                            </div>
                        </div>
						
						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-1">
                                    <label for="name" style="clear:both;"> <?php echo lang('friday')?></label>
								</div>	
								<div class="col-md-3">	
								<div class="bootstrap-timepicker">   
									<input type="text" name="fri_start" value="<?php echo  @$times->fri_start?>"  placeholder="Start Time" class="form-control timepicker">
									</div>
                                </div>
								<div class="col-md-3">	
									<div class="bootstrap-timepicker">    
									<input type="text" name="fri_end" value="<?php echo  @$times->fri_end?>"  placeholder="End Time" class="form-control timepicker">
									</div>
                                </div>
                            </div>
                        </div>
				
		
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-1">
                                    <label for="name" style="clear:both;"> <?php echo lang('saturday')?></label>
								</div>	
								<div class="col-md-3">	
								<div class="bootstrap-timepicker">   
									<input type="text" name="sat_start" value="<?php echo  @$times->sat_start?>"  placeholder="Start Time" class="form-control timepicker">
									</div>
                                </div>
								<div class="col-md-3">	
									<div class="bootstrap-timepicker">    
									<input type="text" name="sat_end" value="<?php echo  @$times->sat_end?>"  placeholder="End Time" class="form-control timepicker">
									</div>
                                </div>
                            </div>
                        </div>
						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-1">
                                    <label for="name" style="clear:both;"> <?php echo lang('sunday')?></label>
								</div>	
								<div class="col-md-3">	
								<div class="bootstrap-timepicker">   
									<input type="text" name="sun_start" value="<?php echo  @$times->sun_start?>"  placeholder="Start Time" class="form-control timepicker">
									</div>
                                </div>
								<div class="col-md-3">	
									<div class="bootstrap-timepicker">    
									<input type="text" name="sun_end" value="<?php echo  @$times->sun_end?>"  placeholder="End Time" class="form-control timepicker">
									</div>
                                </div>
                            </div>
                        </div>
						
                    </div><!-- /.box-body -->
    
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" name="ok" value="ok"><?php echo lang('save');?></button>
                    </div>
             <?php echo  form_close()?>
            </div><!-- /.box -->
        </div>
     </div>
</section>  



<script src="<?php echo base_url('assets/js/chosen.jquery.min.js')?>" type="text/javascript"></script>

<script src="<?php echo base_url('assets/js/bootstrap-timepicker.min.js')?>" type="text/javascript"></script>

<script type="text/javascript">
$(function() {
	
	$('.chzn').chosen();
	
});
	
$(".timepicker").timepicker({
                    showInputs: false,
					defaultTime: 'value'
					
});


</script>