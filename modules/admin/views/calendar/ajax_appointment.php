
<div id="view_app">
						<div class="row">	
							<div class="control-group col-md-5"> 
								<label class="control-label" for="schedule_category">Schedule Category:</label>
							</div>
							<div class="control-group col-md-5">
								Appointment
							</div>
						</div>
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-5">
                                    <label for="name" style="clear:both;"><?php echo lang('with_whom');?></label>
								</div>
								 <div class="col-md-5">
								 			<?php echo (@$app->whom==1)?'Patient':'';?>
											<?php echo (@$app->whom==2)?'Contact':'';?>
											<?php echo (@$app->whom==3)?'Other':'';?>
								</div>
							
                            </div>
                        </div>
					<?php if($app->whom==1){ ?>	
						 <div class="form-group patient">
                        	<div class="row">
                                <div class="col-md-5">
                                    <label for="name" style="clear:both;"><?php echo lang('patient');?></label>
								</div>
								<div class="col-md-5">		
											<?php foreach($contacts as $new) {
													if($app->patient_id==$new->id) echo $new->id;
												}
											?>
										</select>
                                </div>
							
                            </div>
                        </div>
					<?php } ?>	
					<?php if($app->whom==2){ ?>	
						<div class="form-group contact">
                        	<div class="row">
                                <div class="col-md-5">
                                    <label for="name" style="clear:both;"><?php echo lang('contact');?></label>
								</div>
								<div class="col-md-5">	  
									   	<?php foreach($contact as $new) {
													if($app->contact_id==$new->id) echo $new->name;
												}
											?>
										</select>
                                </div>
							
                            </div>
                        </div>
					<?php } ?>		
					<?php if($app->whom==3){ ?>	
						<div class="form-group other ">
                        	<div class="row">
                                <div class="col-md-5">
                                    <label for="name" style="clear:both;"><?php echo lang('other');?></label>
								</div>
								<div class="col-md-5">
									  <?php echo@ $app->other?>
                                </div>
							
                            </div>
                        </div>
				<?php } ?>
						
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-5">
                                    <label for="name" style="clear:both;"><?php echo lang('motive');?></label>
								</div>
								<div class="col-md-5">
									<?php echo @$app->motive; ?>
                                </div>
                            </div>
                        </div>
						
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-5">
                                    <label for="name" style="clear:both;"><?php echo lang('date');?></label>
								</div>
								<div class="col-md-5">	
									<?php echo @$app->date; ?>
                                </div>
                            </div>
                        </div>
						
					<?php if($app->whom==1){ ?>		 
						<div class="form-group paid">
                        	<div class="row">
                                <div class="col-md-5">
                                    <label for="name" style="clear:both;">Is Paid</label>
								</div>
								<div class="col-md-5">
									<?php echo (@$app->is_paid==1)?'Yes':'No';?>
					            </div>
                            </div>
                        </div>
					<?php } ?>	
						<div class="row">
							<div class="control-group col-md-2">
									<a href="<?php echo site_url('admin/calendar/delete_appointment/'.@$app->id)?>" class="btn btn-danger" onclick="return confirm('Are You Sure')" >Delete</a>
							</div>
							<div class="control-group col-md-5">
								<a href="#" class="btn btn-primary" id="edit_ap">Edit</a>
							</div>
						</div>
</div>

<div id="edit_app">
		<div class="row">	
							<div class="control-group col-md-8"> 
								<label class="control-label" for="schedule_category">Schedule Category:</label>
							<div class="controls">
								<select name="schedule_category" class="schedule_category form-control" >
									<option value="2" <?php echo ($type==2)?'selected="selected"':''?>>Appointment</option>
									
								</select>
							</div>
						  </div>
							
						</div>
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-8">
                                    <label for="name" style="clear:both;"> <?php echo lang('title');?></label>
									<input type="text" name="title" value="<?php echo @$app->title; ?>" class="form-control title">
									<input type="hidden" name="id" value="<?php echo $app->id; ?>" />
                                </div>
								
                            </div>
                        </div>
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-8">
                                    <label for="name" style="clear:both;"><?php echo lang('with_whom');?></label>
									   <select name="whom" class="form-control chzn whom"  >
											<option value="0">--<?php echo lang('with_whom');?>--</option>
											<option value="1" <?php echo (@$app->whom==1)?'selected="selected"':'';?> ><?php echo lang('patient');?></option>
											<option value="2" <?php echo (@$app->whom==2)?'selected="selected"':'';?>><?php echo lang('contact');?></option>
											<option value="3" <?php echo (@$app->whom==3)?'selected="selected"':'';?>><?php echo lang('other');?></option>
										
										</select>
                                </div>
							
                            </div>
                        </div>
						
						 <div class="form-group patient <?php echo (@$app->whom==1)? 'block':''?>">
                        	<div class="row">
                                <div class="col-md-8">
                                    <label for="name" style="clear:both;"><?php echo lang('patient');?></label>
									   <select name="patient_id" class="form-control chzn patient_id">
											<option value="">--<?php echo lang('select_patient');?>--</option>
											<?php foreach($contacts as $new) {
													$sel = "";
													if(@$app->patient_id==$new->id) $sel = "selected='selected'";
													echo '<option value="'.$new->id.'" '.$sel.'>'.$new->name.'</option>';
												}
											?>
										</select>
                                </div>
							
                            </div>
                        </div>
						
						<div class="form-group contact <?php echo (@$app->whom==2)? 'block':''?>">
                        	<div class="row">
                                <div class="col-md-8">
                                    <label for="name" style="clear:both;"><?php echo lang('contact');?></label>
									   <select name="contact_id" class="form-control chzn contact_id">
											<option value="">--<?php echo lang('select_contact');?>--</option>
											<?php foreach($contact as $new) {
													$sel = "";
													if($app->contact_id==$new->id) $sel = "selected='selected'";
													echo '<option value="'.$new->id.'" '.$sel.'>'.$new->name.'</option>';
												}
											?>
										</select>
                                </div>
							
                            </div>
                        </div>
						
						<div class="form-group other <?php echo (@$app->whom==3)? 'block':''?>">
                        	<div class="row">
                                <div class="col-md-8">
                                    <label for="name" style="clear:both;"><?php echo lang('other');?></label>
									  <input type="text" name="other" class="form-control other_text" value="<?php echo@ $app->other?>" />
                                </div>
							
                            </div>
                        </div>

						
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-8">
                                    <label for="name" style="clear:both;"><?php echo lang('motive');?></label>
									<textarea name="motive" class="form-control motive"><?php echo @$app->motive; ?></textarea>
                                </div>
                            </div>
                        </div>
						
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-8">
                                    <label for="name" style="clear:both;"><?php echo lang('date');?></label>
									<input type="text" name="starttime" value="<?php echo @$app->date; ?>" class="form-control datetimepicker date_time starttime">
                                </div>
                            </div>
                        </div>
						
						 
						<div class="form-group paid">
                        	<div class="row">
                                <div class="col-md-8">
                                    <label for="name" style="clear:both;">Is Paid</label>
									<input type="checkbox" name="is_paid" class="is_paid" <?php echo (@$app->is_paid==1)?'checked="checked"':'';?> value="1" />
					            </div>
                            </div>
                        </div>
</div>						
<script>
$(".patient").hide();
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
	}
	
	if(vch==2){
		$(".contact").show();
		$(".patient").hide();
		$(".paid").hide();
		$(".other").hide();
	}
	if(vch==3){
		$(".contact").hide();
		$(".patient").hide();
		$(".paid").hide();
		$(".other").show();
	}

});
</script>

<script>
$(function() {
	$("#edit_app").hide();
	$("#view_app").show();
	$(".update_the_form").hide();
})
$(document).on('click', '#edit_ap', function(){
 		$("#edit_app").show();
		$("#view_app").hide();
	
});
</script>