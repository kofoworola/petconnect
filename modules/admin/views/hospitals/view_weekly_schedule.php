
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
        <?php echo lang('manage_hospital_schedule');?>
        <small><?php echo lang('view');?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin')?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard');?></a></li>
        <li><a href="<?php echo site_url('admin/hospital/view_all')?>"><?php echo lang('manage_hospital_schedule');?></a></li>
        <li class="active"><?php echo lang('manage');?></li>
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
                    <h3 class="box-title"><?php echo lang('manage');?> <?php echo lang('weekly_schedule');?></h3>
                </div><!-- /.box-header -->
                <!-- form start -->
				
				<?php echo form_open(); ?>
                    <div class="box-body">
                       <?php $admin=$this->session->userdata('admin');?>
                      <input type="hidden" value="<?php echo $admin['id'];?>" name="doctor_id"  />
			          
					   <div class="box-body table-responsive div1">	<?php //echo '<pre>' ;print_r($days); die?>	
														<table id="example1" class="table table-bordered table-hover">	
							<tr class="row">
									<td class="col-md-1"><?php echo lang('days');?></td>
									<td class="col-md-1"><?php echo lang('add_more');?></td>
									<td class="col-md-10">
										<table>
											<tr class="row">
									
									<td class="col-md-3">
											<?php echo lang('timing_from');?>
									</td>
									<td class="col-md-3">
											<?php echo lang('timing_to');?>
									</td>
									<td class="col-md-4">
											<?php echo lang('work');?>
									</td>
									<td class="col-md-2"><?php echo lang('remove');?></td>
								</tr>
										</table>
									</td>
							</tr>
							
							<?php foreach($days as $day) { $inst = 0; ?>
							<tr class="row">
								<td class="col-md-1"><strong><?php echo $day->name; ?></strong></td>
								<td class="col-md-1"><input type="button" id="<?php echo $day->id ;?>" value="+" class="button1"></td>
								<td class="col-md-10">
									<table class="addition<?php echo $day->id; ?>">
											<?php  foreach ($fixed_schedule as $data) 
											{
															
															if($data->day==$day->id)
															{
															 ?>
									
									<tr class="row">
												<input type="hidden" name="schedule[<?php echo $day->id;?>][<?php echo $inst;?>][entry_id]" value="<?php echo $data->id; ?>" />
										<td class="col-md-3">
												<div class="bootstrap-timepicker">
												<input type="text" value="<?php echo $data->timing_from; ?>" class="form-control 
												input-sm timepicker "  name="schedule[<?php echo $day->id;?>][<?php echo $inst;?>][from]" />
												</div>
										</td>
										<td class="col-md-3">
												<div class="bootstrap-timepicker">
												<input type="text" value="<?php echo $data->timing_to; ?>" class="form-control input-sm timepicker "
												name="schedule[<?php echo $day->id?>][<?php echo $inst;?>][to]" />
												</div>
										</td>
										<td class="col-md-4">
												<input type="text" class="form-control input-sm"  value="<?php echo $data->work; ?>" 
												name="schedule[<?php echo $day->id;?>][<?php echo $inst;?>][work]" />
										</td>
										<td class="col-md-2"><a class="btn btn-danger btn-xs rem" ><i class="fa fa-trash"></i></a></td>
									</tr>
									
									
													
															
											<?php }
											}
											 ?><input type="hidden" name="count" value="0"/>
									</table>
								</td>
							</tr>
							
							<?php $inst++;} ?>
							</table>
														
														
												 </div>
					  
					  
						
                    </div><!-- /.box-body --><!-- /.box-body -->
    
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" name="s2" value="ok"><?php echo lang('ok');?></button>
                    </div>
             <?php echo  form_close()?>
            </div><!-- /.box -->
        </div>
     </div>
</section>  

<!-- Modal -->
<script src="<?php echo site_url('assets/js/bootstrap-timepicker.min.js')?>" type="text/javascript"></script>
<script type="text/javascript">
$(document).on('click','.button1',function(){
    var day_id = $(this).attr('id');
	var inst = $('.addition'+day_id+' >tbody > tr').length;
	 
   console.log($('.addition'+day_id+' >tbody > tr').length);
    $('input[type=hidden]').val((inst+1));
	 html='<tr class="row">'+
																	
																	'<td class="col-md-3">'+
																	'<input type="hidden" name="schedule['+day_id+']'+'['+inst+'][entry_id]" value="" />'+
																	'<div class="bootstrap-timepicker">'+
																	'<input type="text" class="form-control input-sm timepicker" '+
																	'name="schedule['+day_id+']'+'['+inst+'][from]" /></div>'+
																	'</td>'+
																	'<td class="col-md-3">'+
																	'<div class="bootstrap-timepicker">'+
																	'<input type="text" class="form-control input-sm timepicker" '+
																	'name="schedule['+day_id+']'+'['+inst+'][to]" /></div>'+
																	'</td>'+
																	'<td class="col-md-4">'+
																	'<input type="text" class="form-control input-sm" '+
																	'name="schedule['+day_id+']'+'['+inst+'][work]" />'+
																	'</td>'+
																	'<td class="col-md-2">'+
																	'<a class="btn btn-danger btn-xs rem" ><i class="fa fa-trash"></i></a>'+
																	'</td>'+
																	'<row>';
    
    $('.addition'+day_id).append(html);
	$(".timepicker").timepicker({
		showInputs: false,
		defaultTime: 'value'
	});
});

$(document).on('click','.rem',function(){
    if(confirm('Are You Sure?')){
		$(this).closest('.row').remove();
	}
});
	

 $(function() {

	$(".timepicker").timepicker({
		showInputs: false,
		defaultTime: 'value'
	});

  });
  
</script>