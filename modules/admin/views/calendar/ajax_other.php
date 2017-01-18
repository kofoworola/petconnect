<div id="view_other">					
						 <div class="row">	
							<div class="control-group col-md-5"> 
								<label class="control-label" for="schedule_category">Schedule Category:</label>
							</div>
							<div class="control-group col-md-5"> 
								Other
							</div>
						  </div>
						</div>
						<div class="row">
							<div class="control-group col-md-5"> 
								<label class="control-label" for="title">Title</label>
							</div>
							<div class="control-group col-md-5"> 
								<?php echo @$result->title?>
							</div>
						</div>
						
						<div class="row">
							<div class="control-group col-md-5">
								<label class="control-label" for="when">Start:</label>
							</div>
							<div class="control-group col-md-5"> 
								 <?php echo @$result->starttime;?>
							</div>
								 
						</div>
						
						<div class="row">
							<div class="control-group col-md-5">
								<label class="control-label" for="when">End:</label>
							</div>
							<div class="control-group col-md-5"> 
								 <?php echo @$result->endtime;?>
							</div>
								 
						</div>
						
						
												
						<div class="row">
							<div class="control-group col-md-2">
								<a href="<?php echo site_url('admin/calendar/delete_other/'.@$result->id)?>" class="btn btn-danger" onclick="return confirm('Are You Sure')">Delete</a>
							</div>
							<div class="control-group col-md-5">
								<a href="#" class="btn btn-primary" id="edit_o">Edit</a>
							</div>
						</div>

</div>


<div id="edit_other">					
						 <div class="row">	
							<div class="control-group col-md-8"> 
								<label class="control-label" for="schedule_category">Schedule Category:</label>
							<div class="controls">
								<select name="schedule_category" class="schedule_category form-control" >
									<option value="5" <?php echo ($type==5)?'selected="selected"':''?>>Other</option>
									
								</select>
								
								  <input type="hidden" id="apptStartTime" class="starttime"/>
								  <input type="hidden" id="apptEndTime"   class="endtime"/>
								  <input type="hidden" id="apptAllDay" 	  class="all"/>
							</div>
						  </div>
						  <div class="col-md-2">
									<a href="<?php echo site_url('admin/calendar/delete_other/'.@$result->id)?>" class="btn btn-danger" onclick="return confirm('Are You Sure')">Delete</a>
								</div>	
						</div>
						<div class="row">
							<div class="control-group col-md-8">
							<label class="control-label" for="title">Title</label>
							<input type="text" name="title" class="title form-control" value="<?php echo @$result->title?>" />
							<input type="hidden" name="id" value="<?php echo $result->id; ?>" />
							</div>
						</div>
						
						<div class="row">
							<div class="control-group col-md-8">
							<label class="control-label" for="when">When:</label>
								 <input type="text" name="starttime" value="<?php echo @$result->starttime;?>" class="form-control starttime" />
								 -
								 <input type="text" name="endtime" value="<?php echo @$result->endtime;?>" class="form-control endtime" />
						 </div>
						</div>
</div>
<script>
$(function() {
	$("#edit_other").hide();
	$("#view_other").show();
	$(".update_the_form").hide();
})
$(document).on('click', '#edit_o', function(){
  		$("#edit_other").show();
		$("#view_other").hide();
	
});
</script>