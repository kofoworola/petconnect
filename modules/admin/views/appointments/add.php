<link href="<?php echo base_url('assets/css/chosen.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/jquery.datetimepicker.css')?>" rel="stylesheet" type="text/css" />
<!-- Content Header (Page header) -->
<style>
.row{
	margin-bottom:10px;
}
.chosen-container{width:100% !important
}
</style>
 <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo lang('appointments');?>
        <small><?php echo lang('add');?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin')?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard');?></a></li>
        <li><a href="<?php echo site_url('admin/appointments')?>"><?php echo lang('appointments');?></a></li>
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
				
				<?php echo form_open_multipart('admin/appointments/add/'); ?>
                    <div class="box-body">
                        <div class="form-group">
                        	<div class="row">
                                <div class="col-md-4">
                                    <label for="name" style="clear:both;"> <?php echo lang('title');?></label>
									<input type="text" name="title" value="<?php echo set_value('title'); ?>" class="form-control">
                                </div>
                            </div>
                        </div>
						
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-4">
                                    <label for="name" style="clear:both;"><?php echo lang('patient');?></label>
									   <select name="patient_id" class="form-control chzn">
											<option value="">--<?php echo lang('select_patient');?>--</option>
											<?php foreach($contacts as $new) {
													$sel = "";
													if(set_select('contact_id', $new->id)) $sel = "selected='selected'";
													echo '<option value="'.$new->id.'" '.$sel.'>'.$new->name.'</option>';
												}
											?>
										</select>
                                </div>
								<a href="#myModal" data-toggle="modal" class="btn  btn-default margin"><i class="fa fa-plus"></i> <?php echo lang('add_new');?> <?php echo lang('patient');?></a>
                            </div>
                        </div>
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-4">
                                    <label for="name" style="clear:both;"><?php echo lang('motive');?></label>
									<textarea name="motive" class="form-control"><?php echo set_value('motive'); ?></textarea>
                                </div>
                            </div>
                        </div>
						
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-4">
                                    <label for="name" style="clear:both;"><?php echo lang('date');?></label>
									<input type="text" name="date_time" value="<?php echo set_value('date_time'); ?>" class="form-control datetimepicker">
                                </div>
                            </div>
                        </div>
						
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-4">
                                    <label for="name" style="clear:both;"><?php echo lang('notes');?></label>
									<textarea name="notes" class="form-control"> <?php echo set_value('notes'); ?></textarea>
                                </div>
                            </div>
                        </div>
						
						
                    </div><!-- /.box-body -->
    
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" name="ok" value="ok"><?php echo lang('save');?></button>
                    </div>
             </form>
            </div><!-- /.box -->
        </div>
     </div>
</section>  


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo lang('add_new');?> <?php echo lang('patient');?></h4>
      </div>
      <div class="modal-body">
				
				<?php echo form_open_multipart('admin/patients/add/'); ?>
                    <div class="box-body">
                        <div class="form-group">
                        	<div class="row">
                                <div class="col-md-4">
                                    <label for="name" style="clear:both;"><?php echo lang('name')?></label>
									<input type="text" name="name" value="<?php echo set_value('name')?>" class="form-control">
                                </div>
                            </div>
                        </div>
						
							
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-4">
                                    <label for="gender" style="clear:both;"><?php echo lang('gender')?></label>
									<input type="radio" name="gender" value="Male" /> <?php echo lang('male')?>
									<input type="radio" name="gender" value="Female" /> <?php echo lang('female')?>
                                </div>
                            </div>
                        </div>
						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-4">
                                    <label for="name" style="clear:both;"><?php echo lang('blood_type');?></label>
									   <select name="blood_id" class="form-control chzn">
											<option value="">--<?php echo lang('select_blood_type');?>--</option>
											<?php foreach($groups as $new) {
													$sel = "";
													//if($new->id==$patient->blood_group_id) $sel = "selected='selected'";
													echo '<option value="'.$new->id.'" '.$sel.'>'.$new->name.'</option>';
												}
												
											?>
										</select>
                                </div>
                            </div>
                        </div>
               
			   			 <div class="form-group">
                              <div class="row">
                                <div class="col-md-4">
                                    <label for="dob" style="clear:both;"><?php echo lang('date_of_birth');?></label>
									<input type="text" name="dob" value="<?php echo set_value('dob')?>" class="form-control datetimepicker">
									
                                </div>
                            </div>
                        </div>
						
                        <div class="form-group">
                              <div class="row">
                                <div class="col-md-4">
                                    <label for="email" style="clear:both;"><?php echo lang('email')?></label>
									<input type="text" name="email" value="<?php echo set_value('email')?>" class="form-control">
                                </div>
                            </div>
                        </div>
						
						<div class="form-group">
                              <div class="row">
                                <div class="col-md-4">
                                    <label for="username" style="clear:both;"><?php echo lang('username')?></label>
									<input type="text" name="username" value="<?php echo set_value('username')?>" class="form-control">
                                </div>
                            </div>
                        </div>
						
						<div class="form-group">
                              <div class="row">
                                <div class="col-md-4">
                                    <label for="password" style="clear:both;"><?php echo lang('password')?></label>
									<input type="password" name="password" value="" class="form-control">
                                </div>
                            </div>
                        </div>
						
						<div class="form-group">
                              <div class="row">
                                <div class="col-md-4">
                                    <label for="password" style="clear:both;"><?php echo lang('confirm')?> <?php echo lang('password')?></label>
									<input type="password" name="confirm" value="" class="form-control">
                                </div>
                            </div>
                        </div>
						
						 <div class="form-group">
                              <div class="row">
                                <div class="col-md-4">
                                    <label for="contact" style="clear:both;"><?php echo lang('phone')?></label>
									<input type="text" name="contact" value="<?php echo set_value('contact')?>" class="form-control">
                                </div>
                            </div>
                        </div>
						
						 <div class="form-group">
                              <div class="row">
                                <div class="col-md-4">
                                    <label for="contact" style="clear:both;"><?php echo lang('address')?></label>
									<textarea name="address"  class="form-control"><?php echo set_value('address')?></textarea>
                                </div>
                            </div>
                        </div>
						
						<?php 
						if($fields){
							foreach($fields as $doc){
							$output = '';
							if($doc->field_type==1) //testbox
							{
						?>
						<div class="form-group">
                              <div class="row">
                                <div class="col-md-4">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
							<input type="text" class="form-control" name="reply[<?php echo $doc->id ?>]" id="req_doc" />
								</div>
                            </div>
                        </div>
					 <?php 	}	
							if($doc->field_type==2) //dropdown list
							{
								$values = explode(",", $doc->values);
					?>	<div class="form-group">
                              <div class="row">
                                <div class="col-md-4">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
							<select name="reply[<?php echo $doc->id ?>]" class="form-control">
							<?php	
										foreach($values as $key=>$val) {
											echo '<option value="'.$val.'">'.$val.'</option>';
										}
							?>			
							</select>	
								</div>
                            </div>
                        </div>
						<?php	}	
								if($doc->field_type==3) //radio buttons
							{
								$values = explode(",", $doc->values);
					?>	<div class="form-group">
                              <div class="row">
                                <div class="col-md-4">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
							
							<?php	
										foreach($values as $key=>$val) { ?>
										
										<input type="radio" name="reply[<?php echo $doc->id ?>]" value="<?php echo $val;?>" />	<?php echo $val;?> &nbsp; &nbsp; &nbsp; &nbsp;
 							<?php 			}
							?>			
								</div>
                            </div>
                        </div>
						
						<?php }
						if($doc->field_type==4) //checkbox
							{
								$values = explode(",", $doc->values);
					?>	<div class="form-group">
                              <div class="row">
                                <div class="col-md-4">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
							
							<?php	
										foreach($values as $key=>$val) { ?>
										
										<input type="checkbox" name="reply[<?php echo $doc->id ?>]" value="<?php echo $val;?>" class="form-control" />	&nbsp; &nbsp; &nbsp; &nbsp;
 							<?php 			}
							?>			
								</div>
                            </div>
                        </div>
					<?php }	if($doc->field_type==5) //Textarea
						  {		?>	<div class="form-group">
                              <div class="row">
                                <div class="col-md-4">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
										<textarea class="form-control" name="reply[<?php echo $doc->id ?>]" ></textarea		
								></div>
                            </div>
                        </div>
							
						
						
					<?php 
								}	
							}
						}
					?>	

                    </div><!-- /.box-body -->
    
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary"><?php echo lang('save')?></button>
                    </div>
             <?php form_close()?>
            </div><!-- /.box -->
                  
             </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close');?></button>  
      </div>
    </div>
  </div>
</div>

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

 jQuery('.datetimepicker').datetimepicker({
 lang:'en',
 i18n:{
  de:{
   months:[
    'January','February','March','April',
    'May','June','July','August',
    'September','October','November','December',
   ],
   dayOfWeek:[
    "Sun.", "Mon", "Tue", "Wed", 
    "Thu", "Fri", "Sat",
   ]
  }
 },
 timepicker:true,
 format:'y-m-d H:i'
});
</script>