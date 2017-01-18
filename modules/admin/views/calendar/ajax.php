<div id="view_todo">
						<div class="row">
							<div class="control-group col-md-5">
								<label class="control-label" for="when">Start:</label>
							</div>
							<div class="control-group col-md-5">
								<?php echo @$result->date;?>
							</div>
						</div>
						
						<div class="row">	
							<div class="control-group col-md-5">
								<label class="control-label" for="schedule_category">Schedule Category:</label>
							</div>
							<div class="control-group col-md-5">
								To Do	
						  	</div>	
						</div>
						<div class="row">
							<div class="control-group col-md-5">
								<label class="control-label" for="title">Detail</label>
							</div>
							<div class="control-group col-md-5">
							<?php echo @$result->title?>
							</div>
						</div>
						
						<div class="row">
							<div class="control-group col-md-2">
								<a href="<?php echo site_url('admin/calendar/delete_todo/'.@$result->id)?>" class="btn btn-danger" onclick="return confirm('Are You Sure')">Delete</a>
							</div>
							<div class="control-group col-md-5">
								<a href="#" class="btn btn-primary" id="edit_to">Edit</a>
							</div>
						</div>
						
						
</div>

<div id="edit_todo">
						<div class="row">	
							<div class="control-group col-md-8">
							<label class="control-label" for="schedule_category">Schedule Category:</label>
							<div class="controls">
								<select name="schedule_category" class="schedule_category form-control">
									<option value="1" <?php echo ($type==1)?'selected="selected"':''?> >To Do</option>
									
								</select>
								
								  <input type="hidden" id="apptStartTime" class="starttime"/>
								  <input type="hidden" id="apptEndTime"   class="endtime"/>
								  <input type="hidden" id="apptAllDay" 	  class="all"/>
							</div>
						  </div>	
						  
						</div>
						<div class="row">
							<div class="control-group col-md-8">
							<label class="control-label" for="title">Detail</label>
							<textarea name="title" class="title form-control"><?php echo @$result->title?></textarea>
							<input type="hidden" name="id" value="<?php echo $result->id; ?>" />
							</div>
						</div>
						
						<div class="row">
							<div class="control-group col-md-8">
							<label class="control-label" for="when">When:</label>
								
								 <input type="text" name="starttime" value="<?php echo @$result->date;?>" class="form-control starttime datetimepicker" />
							</div>
						</div>
</div>


<script>
$(function() {
	$("#edit_todo").hide();
	$("#view_todo").show();
	$(".update_the_form").hide();
})
$(document).on('click', '#edit_to', function(){
  		$("#edit_todo").show();
		$("#view_todo").hide();
	
});
</script>
