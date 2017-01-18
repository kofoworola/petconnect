<link href="<?php echo site_url('assets/css/chosen.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/css/jquery.datetimepicker.css')?>" rel="stylesheet" type="text/css" />
<!-- Content Header (Page header) -->

<style>
.row{
	margin-bottom:10px;
}
.monthly_div
{
display: inline-block;
margin-bottom:2px; 
background:#009999;
border-collapse:collapse;
border:#000000 solid 1px; 
height:80px ;
width:80px;

}

</style>
 <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo lang('schedule');?>
        <small><?php echo lang('list');?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin')?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard');?></a></li>
        <li><a href="<?php echo site_url('admin/schedule')?>"><?php echo lang('schedule');?></a></li>
        <li class="active"><?php echo lang('monthly_schedule');?></li>
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
			<div class="row" style="margin-bottom:10px;">
					<div class="col-xs-12">
						<div class="btn-group pull-right">
							<a class="btn btn-default" href="<?php echo site_url('admin/schedule/monthly_schedule'); ?>"> <i class="fa fa-arrows"></i> <?php echo lang('manage');?></a>
						</div>
					</div>    
				</div>	
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"><?php echo lang('monthly_schedule');?></h3>
                </div><!-- /.box-header -->
                <!-- form start -->
				
				
				
				<?php echo form_open(); ?>
                    <div class="box-body">
                       <?php $admin=$this->session->userdata('admin');?>
                     
			           <div class="box-body table-responsive div1">	<?php //echo '<pre>' ;print_r($days); die?>	
													<div>		
													<?php $k=0; for($i=1; $i<=31; $i++) {  ?>
															<a href="#myModal<?php echo $i; ?>" class="btn btn-lg btn-success" data-toggle="modal">				
															<div  class="monthly_div" style="font-size:24px">
																<?php echo $i ?>
															</div> 
															
															</a>
																<?php if($i%7==0){ echo '<br/>';} else { echo '';} ?>
													<?php } ?>
													</div>
											
					   </div><!-- /.box-body --><!-- /.box-body -->
    
                    <div class="box-footer">
                       
                    </div>
             <?php echo  form_close()?>
            </div><!-- /.box -->
        </div>
     </div>
</section>  
<?php $k=0; for($i=1; $i<=31; $i++) {  ?>
<div name="modal_div">
																<div id="myModal<?php echo $i;?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
																		<div class="modal-dialog">
																		<div class="modal-content">
																							<div class="modal-header">
																								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																								<h3 class="modal-title">Schedule</h3>
																							</div>
																							
																							<div class="modal-body">
																							
																								
																										<table class="table-responsive">
																										<tr class="col-md-12">
																										<th class="col-md-3"><?php echo lang('hospital')?></th>
																										<th class="col-md-3"><?php echo lang('from')?></th>
																										<th class="col-md-3"><?php echo lang('to')?></th>
																										<th class="col-md-3"><?php echo lang('work')?></th>
																										</tr>
																										
																										
																								<?php $count=0; foreach ($monthly_schedule as $data) 
																								{	
																										if($data->date_id==$i)
																										{ $count++;
																										?>
																										<tr class="col-md-12">
																										<td class="col-md-3"><?php echo $data->name; ?></td>
																										<td class="col-md-3"><?php echo date("g:i a", strtotime("$data->timing_from")); ?></td>
																										<td class="col-md-3"><?php echo date("g:i a", strtotime("$data->timing_to")); ?></td>
																										<td class="col-md-3"><?php echo $data->work; ?></td>
																										</tr>
																										<?php
																										}
																									
																										
																								} 
																								
																								if(!$count>0)
																								 { ?><tr><?php echo 'There is no schedule for the day!!'; ?></tr> <?php }?>
																								</table>
																									
																							</div>
																							
																							<div class="modal-footer">
																								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																								
																							</div>
																							
																				</div>
																		</div>
															   </div>
															</div>
<?php } ?>														
<!-- Modal -->


<script src="<?php echo site_url('assets/js/chosen.jquery.min.js')?>" type="text/javascript"></script>

<script src="<?php echo site_url('assets/js/jquery.datetimepicker.js')?>" type="text/javascript"></script>


<script src="<?php echo site_url('assets/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')?>" type="text/javascript"></script>
<script>
$.modal.close();
</script>