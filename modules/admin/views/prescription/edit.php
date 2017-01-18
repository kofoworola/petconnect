<link href="<?php echo base_url('assets/css/chosen.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/jquery.datetimepicker.css')?>" rel="stylesheet" type="text/css" />
<!-- Content Header (Page header) -->
<style>
.row{
	margin-bottom:10px;
}

.mg{
	margin-top:20px;
}
.row{
	/*padding-left:20px;*/
}
</style>
 <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo lang('prescription');?>
        <small><?php echo lang('add');?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin')?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard');?></a></li>
        <li><a href="<?php echo site_url('admin/prescription')?>"> <?php echo lang('prescription');?></a></li>
        <li class="active"><?php echo lang('edit');?></li>
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
                    <h3 class="box-title"><?php echo lang('edit');?></h3>
                </div><!-- /.box-header -->
                <!-- form start -->
			  <div class="box-body">
			<form method="post" action="<?php echo site_url('admin/prescription/edit/'.$id.'/'.$redirect)?>" enctype="multipart/form-data" id="edit_form">
			          <div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('prescription_id') ?></label>
								</div>	
								<div class="col-md-3">
									<input type="text" name="prescription_id" value="<?php echo $prescription->prescription_id ?>" readonly="readonly"  class="form-control prescription_id"/>
                                </div>
						    </div>
                        </div>
					  
					    <div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('patient');?></label>
								</div>	
								<div class="col-md-4">
									<input type="hidden" name="id" value="<?php echo $prescription->id;?>" />		
									<select name="patient_id" id="patient_id" class="form-control chzn patient_id" style="z-index: 999">
											<option value="">--<?php echo lang('select_patient');?>--</option>
											<?php foreach($pateints as $new) {
													$sel = "";
													if($prescription->patient_id==$new->id) $sel = "selected='selected'";
													echo '<option value="'.$new->id.'" '.$sel.'>'.$new->name.','.$new->username.','.$new->contact.'</option>';
												}
												
											?>
									</select>
                                </div>
								<div class="col-md-4">
									<input type="text" name="date_time" class="form-control datetimepicker" placeholder="<?php echo lang('date') ?>" value="<?php echo $prescription->date_time;?>">
								</div>
                            </div>
                        </div>
						
						<div class="row">
							<div class="col-md-6">
									<div class="form-group">
												<div class="row">
													<div class="col-md-4">
														<label for="name" style="clear:both;"><?php echo lang('case_history') ?></label>
													</div>	
													<div class="col-md-8">
														
														<select name="case_history_id[]" class="form-control chzn" multiple="multiple" data-placeholder="Select an option">
																<option value="">--<?php echo lang('select') ?> <?php echo lang('option') ?>--</option>
																<?php foreach($case_historys as $new) {
																		$sel = "";
																		$sel = (in_array($new->name,json_decode($prescription->case_history_id)))?'selected': '';
																		echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
																	}
																	
																?>
														</select>
													</div>
						 
												</div>
									</div>
							</div>
							<div class="col-md-6">
									<div class="form-group">
												<div class="row">
													<div class="col-md-8">
														<textarea name="case_history"class="form-control redactor case_history"><?php echo strip_tags($prescription->case_history);?></textarea>
														
													</div>
						 
												</div>
									</div>
							</div>	
                        	
                        </div>

						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"><?php echo lang('oe') ?></label>
								</div>	
								<div class="col-md-4">
									<select name="disease_id[]" class="form-control chzn disease_id" multiple="multiple">
											<?php foreach($diseases as $new) {
													$sel = "";
													$sel = (in_array($new->name,json_decode($prescription->disease)))?'selected': '';
													echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
												}
												
											?>
									</select>
                                </div>
								 <div class="col-md-4">
                                    
									<textarea name="oe_description"class="form-control oe_description redactor"><?php echo strip_tags(@$prescription->oe_description);?></textarea>
                                </div>
                            </div>
                        </div>
						
						
					<?php
						$medicine1 = json_decode($prescription->medicines);
						$medi_ins1= json_decode($prescription->medicine_instruction);
						
						$tests1	= json_decode($prescription->tests);
						$tests_ins1 = json_decode($prescription->test_instructions);
					//echo '<pre>'; print_r();
					//echo '</pre>';
					if(!empty($medicine1[0])){
					foreach($medicine1 as $key => $val){
					 ?>	
						
						<div class="form-group">
                        	<div class="row  ">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('medicine');?></label>
									
								</div>
								
								<div class="col-md-4" >
									
												<select name="medicine_id[]" class="form-control chzn medicine_id" id="medicine_id"style="width:100%">
												<option value="">--<?php echo lang('select_medicine');?>--</option>
												<?php foreach($medicines as $new) {
														$sel = " ";
														if($new->name==$val) $sel = "selected='selected'";
														echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
													}
													
												?>
										
												
										</select>
								</div>
                                
								<div class="col-md-4">
									<select name="instruction[]" class="form-control chzn instruction">
												<option value="">--<?php echo $medi_ins1[@$key] ?>--</option>
												<?php foreach($medicine_ins as $new) {
														$sel = "";
														if($new->name==$medi_ins1[$key]) $sel = "selected='selected'";
														echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
													}
													
												?>
										</select>
								</div>
								<div class="col-md-2">
										<a href="#" class="delete_activity btn btn-danger"><?php echo lang('remove'); ?></a> 
								</div>
								
                            </div>
                        </div>
					<?php }
					}
					 ?>	
						
						
						
						
						
						
						
						<div class="form-group input_fields_wrap">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('medicine');?></label>
									
								</div>
								
								<div class="col-md-4" >
									<div>
										<select name="medicine_id[]" class="form-control chzn medicine_id" id="medicine_id">
												<option value="">--<?php echo lang('select_medicine');?>--</option>
												<?php foreach($medicines as $new) {
														$sel = "";
														echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
													}
													
												?>
										</select>
									</div>	
										
                                </div>
								<div class="col-md-4">
									<select name="instruction[]" class="form-control chzn instruction">
												<option value="">--<?php echo lang('medicine_instruction'); ?>--</option>
												<?php foreach($medicine_ins as $new) {
														$sel = "";
														echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
													}
													
												?>
										</select>
								</div>
								
                            </div>
                        </div>
				<div class="form-group">
                        	<div class="row">
								<div class="col-md-offset-2" style="padding-left:12px;">
										<button class="add_field_button btn btn-success"><?php echo lang('add'); ?> </button>
								</div>
							</div>
						</div>	
					
					
					
					<?php 
					if(!empty($tests1[0])){
					 foreach($tests1 as $key => $val){
					 ?>	
						
						<div class="form-group">
                        	<div class="row  ">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('medical_test');?></label>
									
								</div>
								
								<div class="col-md-4" >
									<div>
									
												<select name="report_id[]" class="form-control chzn report_id">
												
												<?php foreach($tests as $new){
														$sel = " ";
														if($new->name==$val) $sel = "selected='selected'";
														echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
													}
													
												?>
										
												
										</select>
									</div>	
                                </div>
                                
								<div class="col-md-4">
									<select name="test_instruction[]" class="form-control chzn test_instruction">
												
												<?php foreach($test_ins as $new) {
														$sel = "";
														if($new->name==$tests_ins1[$key]) $sel = "selected='selected'";
														echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
													}
													
												?>
										</select>
								</div>
								<div class="col-md-2">
										<a href="#" class="delete_activity btn btn-danger"><?php echo lang('remove'); ?></a> 
								</div>
								
                            </div>
                        </div>
					<?php } 
						}
					?>
						
						
						
						<div class="form-group input_fields_wrap1">
                        	<div class="row  ">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('medical_test');?></label>
									
								</div>
								
								<div class="col-md-4" >
									<div>
										<select name="report_id[]" class="form-control chzn report_id">
												<option value="">--<?php echo lang('select_medical_test');?>--</option>
												<?php foreach($tests as $new) {
														$sel = "";
														echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
													}
													
												?>
										</select>
									</div>	
										
                                </div>
								<div class="col-md-4">
									<select name="test_instruction[]" class="form-control chzn test_instruction">
												<option value="">--<?php echo lang('medical_test_instruction'); ?>--</option>
												<?php foreach($test_ins as $new) {
														$sel = "";
														echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
													}
													
												?>
										</select>
								
								</div>
								
                            </div>
                        </div>
						<div class="form-group">
                        	<div class="row">
								<div class="col-md-offset-2" style="padding-left:12px;">
										<button class="add_field_button1 btn btn-success"><?php echo lang('add'); ?> </button>
								</div>
							</div>
						</div>	
					
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('remark');?></label>
								</div>	
								<div class="col-md-8">
								<textarea name="remark" class="form-control "><?php echo @$prescription->remark;?></textarea>
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
                                <div class="col-md-2">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
									</div>
								
								<div class="col-md-4" >
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
                                <div class="col-md-2">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
								</div>
								
								<div class="col-md-4" >	
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
                                <div class="col-md-2">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
								</div>
								
								<div class="col-md-4" >
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
                                <div class="col-md-2">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
								</div>
								
								<div class="col-md-4" >
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
                                <div class="col-md-2">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
								</div>
								
								<div class="col-md-8" >
										<textarea class="form-control" name="reply[<?php echo $doc->id ?>]" ></textarea		
								></div>
                            </div>
                        </div>
							
						
						
					<?php 
								}	
							}
						}
					?>
				  <div class="box-footer">
                        <button type="submit" class="btn btn-primary update"><?php echo lang('update');?></button>
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
	   
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo lang('add_new_patient')?> </h4>
      </div>
      <div class="modal-body">
			<form method="post" action="<?php echo base_url('admin/patients/add_patient') ?>" id="my_form">
			         <div class="box-body">
                        <div class="form-group">
                        	<div class="row">
                                <div class="col-md-4">
                                    <label for="name" style="clear:both;"><?php echo lang('name')?></label>
									<input type="text" name="name" id="name" class="form-control">
                                </div>
                            </div>
                        </div>
						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-4">
                                    <label for="gender" style="clear:both;"><?php echo lang('gender')?></label>
									<input type="radio" name="gender" id="gender" value="Male" /> <?php echo lang('male')?>
									<input type="radio" name="gender" id="gender"value="Female" /> <?php echo lang('female')?>
                                </div>
                            </div>
                        </div>
						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-4">
                                    <label for="blood_id" style="clear:both;"><?php echo lang('blood_type');?></label>
									   <select name="blood_id" class="form-control" id="blood_id">
											<option value="">--<?php echo lang('select_blood_type');?>--</option>
											<?php foreach($groups as $new) {
													$sel = "";
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
                                    <label for="dob" style="clear:both;"><?php echo lang('date_of_birth')?></label>
									<input type="text" name="dob" id="dob"  class="form-control datepicker">
									
                                </div>
                            </div>
                        </div>
						
					
                        <div class="form-group">
                              <div class="row">
                                <div class="col-md-4">
                                    <label for="email" style="clear:both;"><?php echo lang('email')?></label>
									<input type="text" name="email" id="email" value="" class="form-control">
                                </div>
                            </div>
                        </div>
						
						<div class="form-group">
                              <div class="row">
                                <div class="col-md-4">
                                    <label for="username" style="clear:both;"><?php echo lang('username')?></label>
									<input type="text" name="username" id="username" class="form-control">
                                </div>
                            </div>
                        </div>
						
						<div class="form-group">
                              <div class="row">
                                <div class="col-md-4">
                                    <label for="password" style="clear:both;"><?php echo lang('password')?></label>
									<input type="password" name="password" id="password" class="form-control">
                                </div>
                            </div>
                        </div>
						
						<div class="form-group">
                              <div class="row">
                                <div class="col-md-4">
                                    <label for="password" style="clear:both;"><?php echo lang('confirm')?> <?php echo lang('password')?></label>
									<input type="password" name="confirm" id="confirm" class="form-control">
                                </div>
                            </div>
                        </div>
						
						 <div class="form-group">
                              <div class="row">
                                <div class="col-md-4">
                                    <label for="contact" style="clear:both;"><?php echo lang('phone')?></label>
									<input type="text" name="contact" id="contact" class="form-control">
                                </div>
                            </div>
                        </div>
						
						 <div class="form-group">
                              <div class="row">
                                <div class="col-md-4">
                                    <label for="contact" style="clear:both;"><?php echo lang('address')?></label>
									<textarea name="address"  id="address" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
						

                    </div><!-- /.box-body -->
    
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary"><?php echo lang('save')?></button>
                    </div>
             </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close')?></button>  
      </div>
    </div>
  </div>
</div>



<script src="<?php echo base_url('assets/js/chosen.jquery.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/redactor.min.js')?>"></script>
<script src="<?php echo base_url('assets/js/jquery.datetimepicker.js')?>" type="text/javascript"></script>
<script type="text/javascript">
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
 format:'Y-m-d H:i'
});

</script>

<script>
 $(document).ready(function(){

    $('.redactor').redactor({
	buttons:['html', 'formatting', 'bold', 'italic', 'deleted',
'unorderedlist', 'orderedlist', 'outdent', 'indent',
 'alignment', 'horizontalrule'],
 formatting: ['p','table','tr','td'],
	removeEmpty: ['strong', 'em', 'span', 'p'],
			link:false,
			insertVideo:false,
			image_web_link:false,
            
      });
	  
	     
      $('.delete_activity').click(function(){
			$(this).closest('.row').remove();
		});
});
   
  </script>
<script>
$( "#my_form" ).submit(function( event ) {
	name = $('#name').val();
	
	gender = $('#gender').val();
	blood = $('#blood_id').val();
	dob = $('#dob').val();
	email = $('#email').val();
	username = $('#username').val();
	password = $('#password').val();
	conf = $('#confirm').val();
	contact = $('#contact').val();
	address = $('#address').val();
	
	$.ajax({
		url: '<?php echo site_url('admin/patients/add_patient') ?>',
		type:'POST',
		data:{name:name,gender:gender,blood:blood,dob:dob,email:email,username:username,password:password,confirm:conf,contact:contact,address:address},
		
		success:function(result){
		var res = jQuery.trim(result);
		 //alert(res);return;
			  if(res=="Success")
				{
					 $('#myModal').modal('hide');
					 window.close(); 
				}
				else
				{
					$('#err').html(result);
				}
		  
		  $(".chzn").chosen();
		 }
	  });
	
	event.preventDefault();
});
 
 
 
 
</script>
<script type="text/javascript">
$(function() {
	
	$('.chzn').chosen({search_contains:true});
	
});

$(document).ready(function() {
    var max_fields      = 100; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('</br><div class="row"><div class="col-md-2"></div><div class="col-md-4"><select name="medicine_id[]" class="form-control chzn"><option value="">--<?php echo lang('select_medicine');?>--</option><?php foreach($medicines as $new) {echo '<option value="'.$new->name.'">'.$new->name.'</option>';}?></select></div><div class="col-md-4"><select name="instruction[]" class="form-control chzn"><option value="">--<?php echo lang('medicine_instruction'); ?>--</option><?php foreach($medicine_ins as $new) {echo '<option value="'.$new->name.'">'.$new->name.'</option>';}?></select></div><a href="#" class="remove_field btn btn-danger"><?php echo lang('remove'); ?></a></div></div>'); //add input box
			$('.chzn').chosen({search_contains:true});
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});



$(document).ready(function() {
    var max_fields      = 100; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap1"); //Fields wrapper
    var add_button      = $(".add_field_button1"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('</br><div class="row"><div class="col-md-2"></div><div class="col-md-4"><select name="report_id[]" class="form-control chzn"><option value="">--<?php echo lang('select_medical_test');?>--</option><?php foreach($tests as $new) {echo '<option value="'.$new->name.'">'.$new->name.'</option>';}?></select></div><div class="col-md-4"><select name="test_instruction[]" class="form-control chzn"><option value="">--<?php echo lang('medical_test_instruction'); ?>--</option><?php foreach($test_ins as $new) {echo '<option value="'.$new->name.'">'.$new->name.'</option>';}?></select></div><a href="#" class="remove_field1 btn btn-danger"><?php echo lang('remove'); ?></a></div></div>'); //add input box
			$('.chzn').chosen({search_contains:true});
        }
    });
    
    $(wrapper).on("click",".remove_field1", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
	})
});
</script>
