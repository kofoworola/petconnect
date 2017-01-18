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
        <li><a href="<?php echo site_url('admin/schedules')?>"><?php echo lang('schedule');?></a></li>
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
                    <div class="box-body">
                       <?php $admin=$this->session->userdata('admin');?>
                      
			           <div class="box-body table-responsive div1">	
														<table id="example1" class="table table-bordered table-hover">		
													<tr>
														<?php foreach($days as $day) { ?>
														<th width="200px;" ><?php echo $day->name; ?></th>
														<?php } ?>
													</tr>
													
													<tr><?php foreach($days as $day1){?>
														<td><input type="button" id="<?php echo $day1->id;?>" value="+" class="button1">
<input type="hidden" name="count" value="0"/>
</td><?php }?>										
													
													<tr>
													<?php foreach($days as $day1){?>
														<td><div class="container<?php echo $day1->id;?>"></div></td>
													<?php }?>		
													</tr>	
													
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
<script src="<?php echo site_url('assets/js/chosen.jquery.min.js')?>" type="text/javascript"></script>

<script src="<?php echo site_url('assets/js/jquery.datetimepicker.js')?>" type="text/javascript"></script>


<script src="<?php echo site_url('assets/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')?>" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
	
	$('.chzn').chosen();
	
});


$(document).on('click','.button1',function(){
    var day_id = $(this).attr('id');
	console.log(day_id); 
    var inst = parseInt($('input[type=hidden]').val());
	console.log(inst);
    $('input[type=hidden]').val((inst+1));
	 html='<div class="row" style="margin-bottom:20px;">'+
															'<div class="col-md-12">'+
																	'<label>Select Hospital</label>'+
																	'<select name="hospital" class="form-control">'+
																	'<option value="">Select Hospital</option>'+
																	<?php foreach($hospital as $data){?>
																	'<option value="<?php echo $data->id?>"><?php echo $data->name ;?></option>'+
																	<?php }?>
																	'</select>'+
																	'<br/>'+
																	'<label>Timing</label>'+
																	'<label class="pull-right">'+
																		'<a class="btn btn-danger btn-xs rem" ><i class="fa fa-trash"></i></a>'+
																	'</label>'+
																	'<br/>'+
																	'<label>From</label>'+'<div class="bootstrap-timepicker">'+
																	'<input type="time" class="form-control input-sm timepicker" '+
																	'name="schedule['+day_id+']'+
         															'['+inst+'][form]" />'+
																	'</div>'+
																	'<label>To</label>'+'<div class="bootstrap-timepicker">'+
																	'<input type="time" class="form-control input-sm timepicker" '+
																	'name="schedule['+day_id+']'+
																	'</div>'+
          														    '['+inst+'][to]" />'+
																	'<label>Work</label>'+
																	'<input type="text" class="form-control input-sm timepicker" '+   
																	 'name="schedule['+day_id+']'+'['+inst+'][work]" />'+
															'</div>'+
															
			'</div>'
    
    $('.container'+day_id).append(html);
});

$(document).on('click','.rem',function(){
    if(confirm('Are You Sure?')){
		$(this).closest('.row').remove();
	}
});



$(document).on('click','.rem',function(){
    $(this).closest('.row').remove();
});

 $(function() {
   $('.datetimepicker').datetimepicker({
	//mask:'9999-19-39 29:59',
	format  : 'Y-m-d h:i'
	});
	
	$(".timepicker").timepicker({
		showInputs: false,
		defaultTime: 'value'
	});
	
  });
</script>