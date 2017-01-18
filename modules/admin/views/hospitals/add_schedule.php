<link href="<?php echo base_url('assets/css/chosen.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/jquery.datetimepicker.css')?>" rel="stylesheet" type="text/css" /><!-- Content Header (Page header) -->
<link href="<?php echo base_url('assets/css/bootstrap-timepicker.css')?>" rel="stylesheet" type="text/css" />
<style>
.row{
	margin-bottom:10px;
}
</style>

<style>

.chosen-container{width:100% !important}
.monthly_div {
  display: inline-block;
  background: #009999;
  border-collapse: collapse;
  border: #000000 solid 1px;
  height: 100px;
  width: 100px;
}

.effect {
  display: inline-block;
  margin-bottom: 2px;
  background: #0BCB6B;
  border-collapse: collapse;
  border: #000000 solid 1px;
  height: 100px;
  padding:10px !important
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
        <li><a href="<?php echo site_url('admin/hospital/view_all')?>"><?php echo lang('hospital');?></a></li>
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
				
				<?php echo form_open_multipart('admin/hospital/add_schedule/'.$h_id); ?>
                    <div class="box-body">
                        <div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
										<select name="day_id" class="form-control chzn">
											<option value="">--<?php echo lang('select');?> <?php echo lang('day');?>--</option>
											<?php foreach($days as $new) {
													$sel = "";
													//if($new->id==$patient->blood_group_id) $sel = "selected='selected'";
													echo '<option value="'.$new->id.'" '.$sel.'>'.$new->name.'</option>';
												}
												
											?>
										</select>
								</div>
								
								<div class="col-md-2">	
									<input type="text" name="start" value=""  placeholder="10:00 am" class="form-control timepicker">
							    </div>
                                
                                <div class="col-md-2">	
									<input type="text" name="end" value=""  placeholder="05:00 pm" class="form-control timepicker">
							    </div>
                                
                                <div class="col-md-3">	
									<input type="text" name="work" value=""  placeholder="Work" class="form-control">
							    </div>
								
                            </div>
                        </div>
						
						 
			   			
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary"><?php echo lang('save');?></button>
                    </div>
				</form>					
					
					<div class="row">
            <div class="col-md-12">
				
				<div class="box box-solid box-success">
                                <div class="box-header">
                                    <h3 class="box-title"><?php echo lang('manage_schedule');?></h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-success btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="box-body" style="display: block;">
									       <!-- BEGIN SAMPLE FORM PORTLET-->
              <?php foreach($days as $day) { $inst = 0; ?>
                                     <div class="row" style="padding:10px;">
                                            <div class="col-md-12 classRoutineRow">
                                                <div class="col-sm-2 day Open monthly_div">
													<span style="margin-top:50px; color:#fff;">
														<strong><?php echo $day->name; ?></strong>
													</span>
                                                 </div>
                                                 
                                    <?php  foreach ($fixed_schedule as $data) 
											{
															
											if($data->day==$day->id)
											{
											 ?>             
												<div class="">
													 <div class="col-sm-2 effect left_to_right subjectMotherDiv">
														<div class="backDiv subject">
															<p><b><?php echo $data->work; ?></b></p>
															<p class="pFontSize"><?php echo date("h:i:a", strtotime($data->timing_from)); ?> - <?php echo date("h:i:a", strtotime($data->timing_to)); ?></p>
														</div>
														<div class="info">
															<button class="btn blue btn-xs buttonMargin" data-toggle="modal" data-target="#edit<?php echo $data->id?>" type="button"><i class="fa fa-cogs"></i> <?php echo lang('edit')?></button>
															<a class="btn btn-xs red buttonMargin btn-danger" href="<?php echo site_url('admin/hospital/delete_week_schedule/'.$data->id.'/'.$this->uri->segment(4)); ?>"  onclick="javascript:return confirm('Are you sure you want to delete this schedule');"> <i class="fa fa-trash-o"></i> <?php echo lang('delete');?> </a>
															<!--<a class="btn btn-xs red buttonMargin" href="index.php/sclass/deleteRoutine?id=2&class=class 1" onClick="javascript:return confirm('Are you sure you want to delete this subject from this Class routine?')"> <i class="fa fa-trash-o"></i> Delete </a>-->
														</div>
													</div>
                                                </div>
                                                <?php }	} ?>
                                                
                                               </div>
                                        </div>
                                        <?php $inst++;} ?>
                                      
                            </div>
                            <div class="form-actions fluid marginTopNone">
                                <div class="col-md-offset-3 col-md-9">
                                    <button class="btn blue col-sm-9 col-xs-12 routineGoBack" type="button" onclick="window.location.href = &#39;javascript:history.back()&#39;"><?php echo lang('go_back');?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
           
            </div><!-- /.box -->
        </div>
     </div>
</section>  




<?php if(isset($fixed_schedule)):?>
<?php $i=1;
foreach ($fixed_schedule as $schedule){?>
<!-- Modal -->
<div class="modal fade" id="edit<?php echo $schedule->id?>" tabindex="-1" role="dialog" aria-labelledby="editlabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content ff">
      <div class="modal-header">
			
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="editlabel"><?php echo lang('edit');?> <?php echo lang('hospital')?> <?php echo lang('schedule')?></h4>
      </div>
      <div class="modal-body">
				<?php echo form_open_multipart('admin/hospital/edit_schedule/'.$schedule->id.'/'.$this->uri->segment(4)); ?>
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
									<div class="bootstrap-timepicker">   
									<input type="text" name="start" value="<?php echo $schedule->timing_from; ?>"  placeholder="<?php echo lang('start_time')?>" class="form-control timepicker">
									</div>
                                </div>
                                
                                <div class="col-md-2">	
									<div class="bootstrap-timepicker">   
									<input type="text" name="end" value="<?php echo $schedule->timing_to; ?>"  placeholder="<?php echo lang('end_time')?>" class="form-control timepicker">
									</div>
                                </div>
                                
                                <div class="col-md-3">	
									<div class="bootstrap-timepicker">   
									<input type="text" name="work" value="<?php echo $schedule->work; ?>"  placeholder="<?php echo lang('work')?>" class="form-control">
									</div>
                                </div>
								
                            </div>
                        </div>
						
						 
			   			
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary"><?php echo lang('save');?></button>
                    </div>
           </div>
	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close')?></button>  
      </div>
    </div>
  </div>
</div>
</form>
 <?php $i++;}?>
<?php endif;?>





<script src="<?php echo base_url('assets/js/chosen.jquery.min.js')?>" type="text/javascript"></script>

<script src="<?php echo base_url('assets/js/jquery.datetimepicker.js')?>" type="text/javascript"></script>
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
