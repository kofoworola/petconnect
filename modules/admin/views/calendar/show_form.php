<div class="modal fade" id="createEventModal" tabindex="-1" role="dialog" aria-labelledby="editlabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content ff">
      <div class="modal-header">
			
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		 <h4 class="modal-title" id="editlabel">Create Event</h4>
      </div>
	  		  <div class="modal-body">
		 <div id="err">  
				<?php 
			if(validation_errors()){
		?>
		<div class="alert alert-danger alert-dismissable">
												<i class="fa fa-ban"></i>
												<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
												<b><?php echo lang('alert')?>!</b><?php echo validation_errors(); ?>
											</div>
		
		<?php  } ?>  
			</div>
					<form id="createAppointmentForm" class="form-horizontal" method="post">
						
						<div class="row">
							<div class="control-group col-md-8">
							<label class="control-label" for="when">Start:</label>
								<input type="text" id="apptStartTime" class="starttime form-control datetimepicker"/>
								
							</div>
						</div>
						
						<div class="row">
							<div class="control-group col-md-8">
							<label class="control-label" for="when">End:</label>
								
								<input type="text" id="apptEndTime"   class="endtime form-control datetimepicker"/>
							</div>
						</div>
						 <div class="row">	
							<div class="control-group col-md-8">
							<label class="control-label" for="schedule_category">Schedule Category:</label>
							<div class="controls">
								<select name="schedule_category" class="schedule_category form-control chzn">
									<option value="">Select Schedule Category</option>
									<option value="1">To Do</option>
									<option value="2">Appointment</option>
									<option value="3">Medical College Schedule</option>
									<option value="4">Hospital Schedule</option>
									<option value="5">Other</option>
									
								</select>
								
								  <input type="hidden" id="apptStartTime" class="starttime"/>
								  <input type="hidden" id="apptEndTime"   class="endtime"/>
								  <input type="hidden" id="apptAllDay" 	  class="all"/>
							</div>
						  </div>	
						</div>
						<div class="row detail">
							<div class="control-group col-md-8">
							<label class="control-label" for="title">Detail</label>
							<textarea name="title" class="title form-control"></textarea>
							</div>
						</div>
						
						
				<div id="show_appointment">		
						 <div class="control-group">
                        	<div class="row">
                                <div class="col-md-8">
                                    <label for="name" style="clear:both;"><?php echo lang('with_whom');?></label>
									   <select name="whom" class="form-control chzn whom" >
											<option value="0">--<?php echo lang('with_whom');?>--</option>
											<option value="1"><?php echo lang('patient');?></option>
											<option value="2"><?php echo lang('contact');?></option>
											<option value="3"><?php echo lang('other');?></option>
										
										</select>
                                </div>
							
                            </div>
                        </div>
						
						 <div class="control-group patient">
                        	<div class="row">
                                <div class="col-md-8">
                                    <label for="name" style="clear:both;"><?php echo lang('patient');?></label>
									   <select name="patient_id" class="form-control chzn patient_id ">
											<option value="">--<?php echo lang('select_patient');?>--</option>
											<?php foreach($contacts as $new) {
													$sel = "";
													if(set_select('contact_id', $new->id)) $sel = "selected='selected'";
													echo '<option value="'.$new->id.'" '.$sel.'>'.$new->name.','.$new->username.','.$new->email.','.$new->contact.'</option>';
												}
											?>
										</select>
                                </div>
							
                            </div>
                        </div>
						
						<div class="control-group contact" >
                        	<div class="row">
                                <div class="col-md-8">
                                    <label for="name" style="clear:both;"><?php echo lang('contact');?></label>
									   <select name="contact_id" class="form-control chzn contact_id">
											<option value="">--<?php echo lang('select_contact');?>--</option>
											<?php foreach($contact as $new) {
													$sel = "";
													if(set_select('contact_id', $new->id)) $sel = "selected='selected'";
													echo '<option value="'.$new->id.'" '.$sel.'>'.$new->name.','.$new->email.','.$new->contact.'</option>';
												}
											?>
										</select>
                                </div>
							
                            </div>
                        </div>
						
						<div class="control-group other" >
                        	<div class="row">
                                <div class="col-md-8">
                                    <label for="name" style="clear:both;"><?php echo lang('other');?></label>
									  <input type="text" name="other" class="form-control other_text" />
                                </div>
							
                            </div>
                        </div>
						 <div class="control-group">
                        	<div class="row">
                                <div class="col-md-8">
                                    <label for="name" style="clear:both;"><?php echo lang('motive');?></label>
									<textarea name="motive" class="form-control motive"><?php echo set_value('motive'); ?></textarea>
                                </div>
                            </div>
                        </div>
						
						<div class="control-group paid">
                        	<div class="row">
                                <div class="col-md-8">
                                    <label for="name" style="clear:both;">Is Paid</label>
									<input type="checkbox" name="is_paid" value="1" class="is_paid" />
					            </div>
                            </div>
                        </div>
				</div>		
					</form>
					</div>
    	
				
			
      <div class="modal-footer">
         <button type="submit" class="btn btn-primary" id="submitButton">Save</button>
		 
		<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close')?></button>  
      </div>
    </div>
  </div>
</div>

<script>
$("#show_appointment").hide();
$(document).on('change', '.schedule_category', function(){
 var type_id = $(".schedule_category").val();
 if(type_id==1){
 
		$("#show_appointment").hide();
		$(".detail").show();
		//$(".contact").hide();
		//$(".other").hide();
 }	
 if(type_id==2){
 
		$("#show_appointment").show();
		$(".detail").hide();
		//$(".contact").hide();
		//$(".other").hide();
 }
 
 if(type_id==3 || type_id==4){
 
		$("#show_appointment").show();
		$(".detail").hide();
		//$(".contact").hide();
		//$(".other").hide();
 }
 if(type_id==5){
 
		$("#show_appointment").hide();
		$(".detail").show();
		//$(".contact").hide();
		//$(".other").hide();
 }		

});

$(".patient").hide();
$(".detail").hide();
$(".paid").hide();
$(".contact").hide();
$(".other").hide();
$(document).on('change', '.whom', function(){
  vch = $(this).val();
  $( "div" ).removeClass( "block" );
	//alert(vch);  
	if(vch==1){
		$(".patient").show();
		$(".paid").show();
		$(".contact").hide();
		$(".other").hide();
		$(".detail").hide();
	}
	
	if(vch==2){
		$(".contact").show();
		$(".patient").hide();
		$(".paid").hide();
		$(".other").hide();
		$(".detail").hide();
	}
	if(vch==3){
		$(".contact").hide();
		$(".patient").hide();
		$(".paid").hide();
		$(".other").show();
		$(".show").hide();
	}

});
</script>
<script>
$(function() {
	
	$(".update_the_form").hide();
	$("#edit_todo").hide();
		$("#view_todo").show();
})
$(document).on('click', '#edit_to', function(){
  		$("#edit_todo").show();
		$(".update_the_form").show();
		$("#view_todo").hide();
	
});
</script>

<script>
