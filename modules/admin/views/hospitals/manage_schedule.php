<link href="<?php echo base_url('assets/css/chosen.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/jquery.datetimepicker.css')?>" rel="stylesheet" type="text/css" /><!-- Content Header (Page header) -->
<link href="<?php echo base_url('assets/css/bootstrap-timepicker.css')?>" rel="stylesheet" type="text/css" />
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
        <small><?php echo lang('view');?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin')?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard');?></a></li>
        <li><a href="<?php echo site_url('admin/hospital/view_all')?>"><?php echo lang('hospital');?></a></li>
        <li class="active"><?php echo lang('view');?></li>
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
				
	<div class="box-body">
                       
                       <div class="row">
            <div class="col-md-12">
				
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
															<button class="btn blue btn-xs buttonMargin" data-toggle="modal" data-target="#edit<?php echo $data->id?>" type="button"><i class="fa fa-cogs"></i> Edit</button>
															<a class="btn btn-xs red buttonMargin btn-danger" href="<?php echo site_url('admin/hospital/delete_week_schedule_manage/'.$data->id.'/'.$this->uri->segment(4)); ?>"  onclick="javascript:return confirm('Are you sure you want to delete this schedule');"> <i class="fa fa-trash-o"></i> <?php echo lang('delete')?></a>
															<!--<a class="btn btn-xs red buttonMargin" href="index.php/sclass/deleteRoutine?id=2&class=class 1" onClick="javascript:return confirm('Are you sure you want to delete this subject from this Class routine?')"> <i class="fa fa-trash-o"></i> Delete </a>-->
														</div>
													</div>
                                                </div>
                                                <?php }	} ?>
                                                
                                               </div>
                                        </div>
                                        <?php $inst++;} ?>
                                      
                            </div>
                           
                        </div>
                    </div>
         
                                   
                                </div><!-- /.box-body -->
                            </div>
            </div>
        </div>

                       
						 
			   			
            </form>        
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
				<?php echo form_open_multipart('admin/hospital/edit_schedule_manage/'.$schedule->id.'/'.$this->uri->segment(4)); ?>
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
									<input type="text" name="start" value="<?php echo $schedule->timing_from; ?>"  placeholder="10:00 am"  class="form-control timepicker">
									</div>
                                </div>
                                
                                <div class="col-md-2">	
									<div class="bootstrap-timepicker">   
									<input type="text" name="end" value="<?php echo $schedule->timing_to; ?>"  placeholder="05:00 pm"  class="form-control timepicker">
									</div>
                                </div>
                                
                                <div class="col-md-3">	
									<div class="bootstrap-timepicker">   
									<input type="text" name="work" value="<?php echo $schedule->work; ?>"  placeholder="Work" class="form-control">
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
<script src="<?php echo base_url('assets/js/bootstrap-timepicker.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/jquery.datetimepicker.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/bootstrap-hover-dropdown.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/jquery.blockui.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/bootstrap-switch.min.js')?>" type="text/javascript"></script>

<script type="text/javascript">
$(function() {
	
	$('.chzn').chosen();
	 // Handle Hower Dropdowns
    var handleDropdownHover = function () {
        $('[data-hover="dropdown"]').dropdownHover();
    }
    
    // Handles Bootstrap Popovers

    // last popep popover
    var lastPopedPopover;

    var handlePopovers = function () {
        $('.popovers').popover();

        // close last displayed popover

        $(document).on('click.bs.popover.data-api', function (e) {
            if (lastPopedPopover) {
                lastPopedPopover.popover('hide');
            }
        });
    }
	
});

$(".timepicker").timepicker({
                    showInputs: false,
					defaultTime: 'value'
					
});

 $(function() {
   $('.datetimepicker').datetimepicker({
	//mask:'9999-19-39 29:59',
	format  : 'Y-m-d'
	
	}
	
	);
  });
</script>
