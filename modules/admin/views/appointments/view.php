<link href="<?php echo base_url('assets/css/chosen.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/jquery.datetimepicker.css')?>" rel="stylesheet" type="text/css" />
<!-- Content Header (Page header) -->
<style>
.row{
	margin-bottom:10px;
}
</style>
 <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo lang('appointments');?>
        <small><?php echo lang('view');?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin')?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard');?></a></li>
        <li><a href="<?php echo site_url('admin/appointments')?>"><?php echo lang('appointments');?></a></li>
        <li class="active"><?php echo lang('view');?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"><?php echo lang('view');?></h3>
                </div><!-- /.box-header -->
                <!-- form start -->
				     <div class="box-body">
                      <div class="form-group">
					    <div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('title');?></label>
								</div>
								<div class="col-md-4">
									<?php echo $appointment->title; ?>
                                </div>
                            </div>
                        </div>
						
						<div class="form-group">
                        	<div class="row">
							 <div class="col-md-2">
                                    <label for="name" style="clear:both;"><?php echo lang('with_whom');?></label>
								</div>	
								
								<div class="col-md-4">
									<?php echo ($appointment->whom==1)?$appointment->name:'';?>
									
									<?php foreach($contacts as $new) {
													$sel = "";
													if($appointment->contact_id==$new->id&&$appointment->whom==2) echo $appointment->contact;
												}
											?>
											
									<?php echo ($appointment->whom==3)? $appointment->other:'';?>		
								
								   		(<?php echo ($appointment->whom==1)?lang('patient'):'';?> 
										<?php echo ($appointment->whom==2)? lang('contact'):'';?>
										<?php echo ($appointment->whom==3)? lang('other'):'';?>)
										
                                </div>
								
                            </div>
                        </div>
						
						
						
						

						
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"><?php echo lang('motive');?></label>
								</div>
								<div class="col-md-4">
									<?php echo $appointment->motive; ?>
                                </div>
                            </div>
                        </div>
						
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"><?php echo lang('date');?></label>
								</div>
								<div class="col-md-4">
									<?php echo $appointment->date; ?>
                                </div>
                            </div>
                        </div>
						
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"><?php echo lang('notes');?></label>
								</div>
								<div class="col-md-4">
									 <?php echo $appointment->notes; ?>
                                </div>
                            </div>
                        </div>
				

				<?php if($appointment->status==0){
									$val ='<a href="'.site_url('admin/appointments/approve/'.$appointment->id).'/1" class="btn btn-danger">Approve</a>';
								}else{
									$val ='<a href="'.site_url('admin/appointments/approve/'.$appointment->id).'/0" class="btn btn-success">Approved</a>';
								}?>		
						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('status');?></label>
								</div>	
								<div class="col-md-3">
									<?php echo $val;?>
                                </div>
                            </div>
                        </div>
						
				
						
			   			
                      
						
                    </div><!-- /.box-body -->
    
                  
             <?php form_close()?>
            </div><!-- /.box -->
        </div>
     </div>
</section>  
<script src="<?php echo base_url('assets/js/chosen.jquery.min.js')?>" type="text/javascript"></script>

<script src="<?php echo base_url('assets/js/jquery.datetimepicker.js')?>" type="text/javascript"></script>


<script src="<?php echo base_url('assets/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')?>" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
	
	$('.chzn').chosen();
	
});


$(function() {
	//bootstrap WYSIHTML5 - text editor
	$(".txtarea").wysihtml5();
});

 $(function() {
   $('.datetimepicker').datetimepicker({
	//mask:'9999-19-39 29:59',
	format  : 'Y-m-d h:i'
	
	}
	
	);
  });
</script>