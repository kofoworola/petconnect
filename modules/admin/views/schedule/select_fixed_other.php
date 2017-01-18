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
				
				<?php echo form_open_multipart('admin/schedule/index/'); ?>
                    <div class="box-body">
                       
		<div class="row">
            <div class="col-md-12">
              	<label>Select Fixed Schedule / Other Specific Schedule</label>
        	</div>
		</div>
        <div class="row">
				<div class="col-md-12">   <input type="radio" name="schedule_type" value="1">Fixed<br/>
				<input type="radio" name="schedule_type" value="2">Other Specific<br/>
				</div>
		</div>
					  
					  
						
                    </div><!-- /.box-body --><!-- /.box-body -->
    
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" name="s1" value="ok"><?php echo lang('ok');?></button>
                    </div>
             <?php echo  form_close()?>
            </div><!-- /.box -->
        </div>
     </div>
</section>  


<!-- Modal -->


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
    html = '<div class="row" style="padding:10px;">'+
           '<input type="time" name="schedule['+day_id+']'+
           '['+inst+'][form]" placeholder="Timing From" style="width:137px">'+'<br/>'+
           '<input type="time" name="schedule['+day_id+']'+
           '['+inst+'][to]" placeholder="Timing To" style="width:137px">'+'<br/>'+
           '<input type="text" name="schedule['+day_id+']'+
           '['+inst+'][work]" placeholder="Work">'+'<br/>'+
           '<a class="rem">Remove</a>'+
           '</div>';
    
    $('.container'+day_id).append(html);
});

$(document).on('click','.rem',function(){
    $(this).closest('.row').remove();
});

 $(function() {
   $('.datetimepicker').datetimepicker({
	//mask:'9999-19-39 29:59',
	format  : 'Y-m-d h:i'
	
	}
	
	);
  });
</script>