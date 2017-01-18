<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css')?>" rel="stylesheet" type="text/css" />                
				    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo lang('serial_number')?></th>
								<th><?php echo lang('name')?></th>
                                <th><?php echo lang('phone')?></th>
								<th width="35%"><?php echo lang('action')?></th>
                            </tr>
                        </thead>
                        
                        <?php if(isset($patients)):?>
                        <tbody>
                            <?php $i=1;foreach ($patients as $new){?>
                                <tr class="gc_row">
                                    <td><?php echo $i?></td>
                                    <td><?php echo ucwords($new->name)?></td>
                                    <td><?php echo $new->contact ?></td>
									
                                    <td width="35%">
                                        <div class="btn-group">
                                          <a class="btn btn-default"  href="#view<?php echo $new->id; ?>" data-toggle="modal"><i class="fa fa-eye"></i> <?php echo lang('view')?></a>
										  <a class="btn btn-primary"  style="margin-left:12px;" href="#edit<?php echo $new->id; ?>" data-toggle="modal"><i class="fa fa-edit"></i> <?php echo lang('edit')?></a>
                                         <a class="btn btn-danger" style="margin-left:20px;" href="<?php echo site_url('admin/patients/delete/'.$new->id); ?>" onclick="return areyousure()"><i class="fa fa-trash"></i> <?php echo lang('delete')?></a>
                                        </div>
                                   
										<div class="btn-group">
											<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
												Action <span class="caret"></span>
											</button>
											<ul class="dropdown-menu dropdown-default pull-right" role="menu">
												
												<li>
													<a href="<?php echo site_url('admin/patients/payment_history/'.$new->id); ?>">
														<i class="entypo-eye"></i>
														<?php echo lang('payment_history')?>                               </a>
												</li>
												<li class="divider"></li>
												<li>
													<a href="<?php echo site_url('admin/patients/medication_history/'.$new->id); ?>">
														<i class="entypo-eye"></i>
														<?php echo lang('medication_history')?> </a>                        </a>
												</li>
												
												
												
											</ul>
										</div>
                </td>
                                </tr>
                                <?php $i++;}?>
                        </tbody>
                        <?php endif;?>
                    </table>
					
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section>

<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="addlabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content ff">
      <div class="modal-header">
			
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="addlabel"><?php echo lang('add');?> <?php echo lang('patient')?></h4>
      </div>
      <div class="modal-body">
					<?php echo form_open_multipart('admin/patients/add/'); ?>
                    <div class="box-body">
                        <div class="form-group">
                        	<div class="row">
                                <div class="col-md-6">
                                    <label for="name" style="clear:both;"><?php echo lang('name')?></label>
									<input type="text" name="name" value="<?php echo set_value('name')?>" class="form-control">
                                </div>
                            </div>
                        </div>
						
							
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-6">
                                    <label for="gender" style="clear:both;"><?php echo lang('gender')?></label>
									<input type="radio" name="gender" value="Male" <?php echo (set_value('gender')=="Male")?'checked="checked"':'';?>  /> <?php echo lang('male')?>
									<input type="radio" name="gender" value="Female"  <?php echo (set_value('gender')=="Female")?'checked="checked"':'';?>/> <?php echo lang('female')?>
                                </div>
                            </div>
                        </div>
						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-6">
                                    <label for="name" style="clear:both;"><?php echo lang('blood_type');?></label>
									   <select name="blood_id" class="form-control chzn">
											<option value="">--<?php echo lang('select_blood_type');?>--</option>
											<?php foreach($groups as $new) {
													$sel = "";
													if(set_select('blood_id', $new->id)) $sel = "selected='selected'";
													echo '<option value="'.$new->id.'" '.$sel.'>'.$new->name.'</option>';
												}
												
											?>
										</select>
                                </div>
                            </div>
                        </div>
               
			   			 <div class="form-group">
                              <div class="row">
                                <div class="col-md-6">
                                    <label for="dob" style="clear:both;"><?php echo lang('date_of_birth');?></label>
									<input type="text" name="dob" value="<?php echo set_value('dob')?>" class="form-control datepicker">
									
                                </div>
                            </div>
                        </div>
						
                        <div class="form-group">
                              <div class="row">
                                <div class="col-md-6">
                                    <label for="email" style="clear:both;"><?php echo lang('email')?></label>
									<input type="text" name="email" value="<?php echo set_value('email')?>" class="form-control">
                                </div>
                            </div>
                        </div>
						
						<div class="form-group">
                              <div class="row">
                                <div class="col-md-6">
                                    <label for="username" style="clear:both;"><?php echo lang('username')?></label>
									<input type="text" name="username" value="<?php echo $username;?>" class="form-control " readonly="readonly">
                               
							    </div>
                            </div>
                        </div>
						
						<div class="form-group">
                              <div class="row">
                                <div class="col-md-6">
                                    <label for="password" style="clear:both;"><?php echo lang('password')?></label>
									<input type="password" name="password" value="" class="form-control">
                                </div>
                            </div>
                        </div>
						
						<div class="form-group">
                              <div class="row">
                                <div class="col-md-6">
                                    <label for="password" style="clear:both;"><?php echo lang('confirm')?> <?php echo lang('password')?></label>
									<input type="password" name="confirm" value="" class="form-control">
                                </div>
                            </div>
                        </div>
						
						 <div class="form-group">
                              <div class="row">
                                <div class="col-md-6">
                                    <label for="contact" style="clear:both;"><?php echo lang('phone')?></label>
									<input type="text" name="contact" value="<?php echo set_value('contact')?>" class="form-control">
                                </div>
                            </div>
                        </div>
						
						 <div class="form-group">
                              <div class="row">
                                <div class="col-md-6">
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
                                <div class="col-md-6">
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
                                <div class="col-md-6">
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
                                <div class="col-md-6">
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
                                <div class="col-md-6">
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
                                <div class="col-md-6">
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
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close')?></button>  
      </div>
    </div>
  </div>
</div>





<?php if(isset($patients)):?>
<?php $i=1;
foreach ($patients as $new){
$patient = $this->patient_model->get_patient_by_id($new->id);
?>
<!-- Modal -->

<div class="modal fade" id="view<?php echo $new->id?>" tabindex="-1" role="dialog" aria-labelledby="viewlabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
			
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="viewlabel"><?php echo lang('view');?> <?php echo lang('patient')?></h4>
      </div>
      <div class="modal-body">
              <div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
                                    <label for="name" style="clear:both;"><?php echo lang('name')?></label>
								</div>
								 <div class="col-md-4">	
									<?php echo $patient->name?>
                                </div>
                            </div>
                        </div>
						
						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
                                    <label for="gender" style="clear:both;"><?php echo lang('gender')?></label>
									</div>
								 <div class="col-md-4">	
									<?php echo $patient->gender?>
                                </div>
                            </div>
                        </div>
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
                                    <label for="name" style="clear:both;"><?php echo lang('blood_type');?></label>
								</div>
								 <div class="col-md-4">		  
									
											<?php foreach($groups as $new) {
													$sel = "";
													if($new->id==$patient->blood_group_id){
													echo	$new->name;
													}
												}
												
											?>
									</div>
                            </div>
                        </div>
               
			   			 <div class="form-group">
                              <div class="row">
                                <div class="col-md-3">
                                    <label for="dob" style="clear:both;"><?php echo lang('date_of_birth')?></label>
									
								</div>
								 <div class="col-md-4">	
								 	<?php echo $patient->dob?>
									
                                </div>
                            </div>
                        </div>
						
                        <div class="form-group">
                              <div class="row">
                                <div class="col-md-3">
                                    <label for="email" style="clear:both;"><?php echo lang('email')?></label>
								</div>
								 <div class="col-md-4">		
									<?php echo $patient->email?>
									
                                </div>
                            </div>
                        </div>
						
						<div class="form-group">
                              <div class="row">
                                <div class="col-md-3">
                                    <label for="username" style="clear:both;"><?php echo lang('username')?></label>
									</div>
								 <div class="col-md-4">	
									<?php echo $patient->username?>
							   </div>
                            </div>
                        </div>
						
						
						
						
						 <div class="form-group">
                              <div class="row">
                                <div class="col-md-3">
                                    <label for="contact" style="clear:both;"><?php echo lang('phone')?></label>
								</div>
								 <div class="col-md-4">		
								 	<?php echo $patient->contact?>
                                </div>
                            </div>
                        </div>
						
						 <div class="form-group">
                              <div class="row">
                                <div class="col-md-3">
                                    <label for="contact" style="clear:both;"><?php echo lang('address')?></label>
								</div>
								 <div class="col-md-4">		
									<?php echo $patient->address?>
                                </div>
                            </div>
                        </div>

										<?php 
					$CI = get_instance();
						if($fields){
							foreach($fields as $doc){
							$output = '';
							if($doc->field_type==1) //testbox
							{
						?>
						<div class="form-group">
                              <div class="row">
							  
                                <div class="col-md-3">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
								</div>
								<div class="col-md-4">	
							<?php  $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '".$doc->id."' AND table_id = '".$patient->id."' AND form = '".$doc->form."' ")->row();?>		
							<?php echo @$result->reply; ?>
								</div>
                            </div>
                        </div>
					 <?php 	}	
							if($doc->field_type==2) //dropdown list
							{
								$values = explode(",", $doc->values);
					?>	<div class="form-group">
                              <div class="row">
                                <div class="col-md-3">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
								</div>
								<div class="col-md-4">
								<?php  $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '".$doc->id."' AND table_id = '".$patient->id."'  ")->row();?>	
										<?php 
										$values = array();
										foreach($values as $key=>$val) {
											$sel='';
											if($val==$result->reply) echo $val;
										}
							?>			
								</div>
                            </div>
                        </div>
						<?php	}	
								if($doc->field_type==3) //radio buttons
							{
								$values = explode(",", $doc->values);
					?>	<div class="form-group">
                              <div class="row">
                                <div class="col-md-3">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
						
								</div>
								<div class="col-md-4">	
							<?php	
										foreach($values as $key=>$val) { ?>
							<?php 
							$x="";
							$result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '".$doc->id."' AND table_id = '".$patient->id."' AND form = '".$doc->form."' ")->row();
							if(!empty($result->reply)){
								if($result->reply==$val){
									$x= 'checked="checked"';
								}else{
									$x='';
								}
							}
							?>			
						
						<input type="radio" name="reply[<?php echo $doc->id ?>]"disabled="disabled" value="<?php echo $val;?>" <?php echo $x;?> />	<?php echo $val;?> &nbsp; &nbsp; &nbsp; &nbsp;
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
                                <div class="col-md-3">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
								</div>
								<div class="col-md-4">
							<?php	
										foreach($values as $key=>$val) { ?>
							<?php 
							$x="";
							$result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '".$doc->id."' AND table_id = '".$patient->id."' AND form = '".$doc->form."' ")->row();
							if(!empty($result->reply)){
								if($result->reply==$val){
									$x= 'checked="checked"';
								}else{
									$x='';
								}
							}
							?>	
										
										<input type="checkbox" disabled="disabled" name="reply[<?php echo $doc->id ?>]"  <?php echo $x;?> value="<?php echo $val;?>" class="form-control" />	&nbsp; &nbsp; &nbsp; &nbsp;
 							<?php 			}
							?>			
								</div>
                            </div>
                        </div>
					<?php }	if($doc->field_type==5) //Textarea
						  {		?>	<div class="form-group">
                              <div class="row">
                                <div class="col-md-3">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
								</div>
								<div class="col-md-4">
									<?php  $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '".$doc->id."' AND table_id = '".$patient->id."' AND form = '".$doc->form."'")->row();?>	
									<?php echo @$result->reply;?>
								</div>
                            </div>
                        </div>
							
						
						
					<?php 
								}	
							}
						}
					?>
			
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close')?></button>  
      </div>
    </div>
  </div>
</div>
  <?php $i++;}?>
<?php endif;?>


<?php if(isset($patients)):?>
<?php $i=1;
foreach ($patients as $new){
$patient = $this->patient_model->get_patient_by_id($new->id);
?>
<!-- Modal -->
<div class="modal fade" id="edit<?php echo $new->id?>" tabindex="-1" role="dialog" aria-labelledby="editlabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content ff">
      <div class="modal-header">
			
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="editlabel"><?php echo lang('edit');?> <?php echo lang('patient')?></h4>
      </div>
      <div class="modal-body">
			
			<form method="post" action="<?php echo site_url('admin/patients/edit/'.$new->id)?>">
                        <div class="form-group">
                        	<div class="row">
                                <div class="col-md-4">
                                    <label for="name" style="clear:both;"><?php echo lang('name')?></label>
									<input type="text" name="name" value="<?php echo $patient->name?>" class="form-control">
                                </div>
                            </div>
                        </div>
						
						
						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-4">
                                    <label for="gender" style="clear:both;"><?php echo lang('gender')?></label>
									<input type="radio"  name="gender" <?php echo $chk = ($patient->gender=="Male") ? 'checked="checked"': ''; ?>value="Male" /> <?php echo lang('male')?>
									<input type="radio" name="gender" <?php echo $chk = ($patient->gender=="Female") ? 'checked="checked"': ''; ?> value="Female" /> <?php echo lang('female')?>
                                </div>
                            </div>
                        </div>
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-4">
                                    <label for="name" style="clear:both;"><?php echo lang('blood_type');?></label>
									   <select name="blood_id" class="form-control">
											<option value="">--<?php echo lang('select_blood_type');?>--</option>
											<?php
												$groups = $this->patient_model->get_blood_group();
											 foreach($groups as $new) {
													$sel = "";
													if($new->id==$patient->blood_group_id) $sel = "selected='selected'";
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
									<input type="text" name="dob" id="datepicker" value="<?php echo $patient->dob?>"class="form-control datepicker">
									
                                </div>
                            </div>
                        </div>
						
                        <div class="form-group">
                              <div class="row">
                                <div class="col-md-4">
                                    <label for="email" style="clear:both;"><?php echo lang('email')?></label>
									<input type="text" name="email" value="<?php echo $patient->email?>" class="form-control">
                                </div>
                            </div>
                        </div>
						
						<div class="form-group">
                              <div class="row">
                                <div class="col-md-4">
                                    <label for="username" style="clear:both;"><?php echo lang('username')?></label>
									<input type="text" name="username" value="<?php echo $patient->username?>" class="form-control">
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
									<input type="text" name="contact" value="<?php echo $patient->contact?>" class="form-control">
                                </div>
                            </div>
                        </div>
						
						 <div class="form-group">
                              <div class="row">
                                <div class="col-md-4">
                                    <label for="contact" style="clear:both;"><?php echo lang('address')?></label>
									<textarea name="address"  class="form-control"><?php echo $patient->address?></textarea>
                                </div>
                            </div>
                        </div>
					<?php 
					$CI = get_instance();
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
							<?php  $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '".$doc->id."' AND table_id = '".$patient->id."' AND form = '".$doc->form."' ")->row();?>		
							<input type="text" class="form-control" name="reply[<?php echo $doc->id ?>]" value="<?php echo @$result->reply; ?>"/>
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
								<?php  $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '".$doc->id."' AND table_id = '".$patient->id."' AND form = '".$doc->form."' ")->row();?>	
							<select name="reply[<?php echo $doc->id ?>]" class="form-control">
							<?php	
										foreach($values as $key=>$val) {
											$sel='';
											if($val==$result->reply) $sel = "selected='selected'";
											echo '<option value="'.$val.'" '.$sel.'>'.$val.'</option>';
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
							<?php 
							$x="";
							$result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '".$doc->id."' AND table_id = '".$patient->id."' AND form = '".$doc->form."' ")->row();
							if(!empty($result->reply)){
								if($result->reply==$val){
									$x= 'checked="checked"';
								}else{
									$x='';
								}
							}
							?>			
						
						<input type="radio" name="reply[<?php echo $doc->id ?>]" value="<?php echo $val;?>" <?php echo $x;?> />	<?php echo $val;?> &nbsp; &nbsp; &nbsp; &nbsp;
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
							<?php 
							$x="";
							$result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '".$doc->id."' AND table_id = '".$patient->id."' AND form = '".$doc->form."' ")->row();
							if(!empty($result->reply)){
								if($result->reply==$val){
									$x= 'checked="checked"';
								}else{
									$x='';
								}
							}
							?>	
										
										<input type="checkbox" name="reply[<?php echo $doc->id ?>]"  <?php echo $x;?> value="<?php echo $val;?>" class="form-control" />	&nbsp; &nbsp; &nbsp; &nbsp;
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
									<?php  $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '".$doc->id."' AND table_id = '".$patient->id."' AND form = '".$doc->form."'")->row();?>	
										<textarea class="form-control" name="reply[<?php echo $doc->id ?>]" ><?php echo @$result->reply;?></textarea>
								</div>
                            </div>
                        </div>
							
						
						
					<?php 
								}	
							}
						}
					?>		

			
	   <div class="box-footer">
                        <button type="submit" class="btn btn-primary"><?php echo lang('update')?></button>
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



<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/chosen.jquery.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/jquery.datetimepicker.js')?>" type="text/javascript"></script>
<script type="text/javascript">


$(function() {
	
	$(".chzn").chosen({search_contains:true});
});
jQuery('.datepicker').datetimepicker({
 lang:'en',
 i18n:{
  de:{
   months:[
    'Januar','Februar','März','April',
    'Mai','Juni','Juli','August',
    'September','Oktober','November','Dezember',
   ],
   dayOfWeek:[
    "So.", "Mo", "Di", "Mi", 
    "Do", "Fr", "Sa.",
   ]
  }
 },
 timepicker:false,
 format:'Y-m-d'
});

</script>
