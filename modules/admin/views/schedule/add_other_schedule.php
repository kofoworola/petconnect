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
        <?php echo lang('schedule');?>
        <small><?php echo lang('add');?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin')?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard');?></a></li>
        <li><a href="<?php echo site_url('admin/schedule/view_specific_schedule')?>"><?php echo lang('specific_schedule');?></a></li>
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
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"><?php echo lang('add');?></h3>
                </div><!-- /.box-header -->
                <!-- form start -->
				
				<?php echo form_open(); ?>
                    <div class="box-body"><?php $admin=$this->session->userdata('admin');?>
                      <input type="hidden" value="<?php echo $admin['id'];?>" name="doctor_id"  />
					   <div class="row">
					 
						  <div class="col-md-2">
								<label>Select Date</label>
						  </div>
						  <div class="col-md-2 bootstrap-timepicker">
						   		<label>Timing From</label>
						  </div>
					     <div class="col-md-2 bootstrap-timepicker">
						       <label>Timing To</label>
						 </div>
						 
						 
						 <div class="col-md-2">
						        <label>Purpose</label>
						 </div>
						 <div class="col-md-2">
						  		<label for="name" style="clear:both;"><?php echo lang('select_hospital_type');?> </label>
						 </div>
					     <div class="col-md-2">
						         <label>Add More</label>
						</div> 
					</div>
					  <div class="row">
					 
						  <div class="col-md-2">
								<input type="text" name="schedule[0][dates]" placeholder="Enter Date"  class="form-control datepicker">
						  </div>
						  <div class="col-md-2 bootstrap-timepicker">
						   		<input type="text" name="schedule[0][time_from]"   class="form-control timepicker" >
						  </div>
					     <div class="col-md-2 bootstrap-timepicker">
						       <input type="text" name="schedule[0][time_to]"  class="form-control timepicker" >
						 </div>
						 <div class="col-md-2">
						       <input type="text" name="schedule[0][work]"  placeholder="Work"  class="form-control" >
						 </div>
						 <div class="col-md-2">
						      
									<select name="schedule[0][hospital]" id="class_list" class="form-control">
                                          <option value="" >---Select---</option>
										  <?php foreach($hospital as $data) {?>
												<option value="<?php echo $data->id;?>">
												<?php echo $data->name ;?></option>
										  <?php }?>
											
									</select>
						 </div>
						 <input type="hidden" name="count" value="0"/>
					     <div class="col-md-2">
						       <input type="button" value="+" class="button2" />
						 </div>
						</div> 
						<div class="row2" ></div>
                    </div><!-- /.box-body --><!-- /.box-body -->
    
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" name="s3" value="ok"><?php echo lang('ok');?></button>
                    </div>
             <?php echo  form_close()?>
            </div><!-- /.box -->
        </div>
     </div>
</section>  


<!-- Modal -->

<script src="<?php echo site_url('assets/js/bootstrap-timepicker.min.js')?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/js/chosen.jquery.min.js')?>" type="text/javascript"></script>

<script src="<?php echo site_url('assets/js/jquery.datetimepicker.js')?>" type="text/javascript"></script>


<script src="<?php echo site_url('assets/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')?>" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
	
	$('.chzn').chosen();
	
});


$(document).on('click','.button2',function(){
 
 var inst = parseInt($('input[type=hidden]').val());
 $('input[type=hidden]').val((inst+1));
 html = '<div class="row">'+
			'<div class="col-md-2">'+
			'<input type="text" name="schedule['+inst+'][dates]" class="form-control datepicker" placeholder="Enter Date">'+
			'</div>'+
			'<div class="col-md-2 bootstrap-timepicker">'+
           '<input type="text" name="schedule['+inst+'][time_from]" class="form-control timepicker">'+
		   '</div>'+
		   '<div class="col-md-2 bootstrap-timepicker">'+
           '<input type="text" name="schedule['+inst+'][time_to]" class="form-control timepicker" >'+
           '</div>'+
		   '<div class="col-md-2">'+
		   '<input type="text" name="schedule['+inst+'][work]" class="form-control" placeholder="Work">'+
           '</div>'+
		    '<div class="col-md-2">'+
		  '<select name="schedule['+inst+'][hospital]" class="form-control">'+
																	'<option value="">Select Hospital</option>'+
																	<?php foreach($hospital as $data){?>
																	'<option value="<?php echo $data->id?>"><?php echo $data->name ;?></option>'+
																	<?php }?>
																	'</select>'+
           '</div>'
		   '<div class="col-md-2">'+
		   '<a class="rem">Remove</a>'+
           '</div>'+
		   '</div>';
    
    $('.row2').append(html);
	
	jQuery('.datepicker').datetimepicker({
	 lang:'en',
	 timepicker:false,
	 format:'Y-m-d'
	});
	
	$(".timepicker").timepicker({
		showInputs: false,
		defaultTime: 'value'
	});

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