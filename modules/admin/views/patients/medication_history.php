<link href="<?php echo base_url('assets/css/chosen.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/jquery.datetimepicker.css')?>" rel="stylesheet" type="text/css" />
<!-- Content Header (Page header) -->
<script type="text/javascript">
function areyousure()
{
	return confirm('<?php echo lang('are_you_sure')?>');
}
</script>
<style>
.row{
	margin-bottom:10px;
}
.chosen-container{width:100% !important}
</style>
 <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
       <?php echo lang('medication_history')?>
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin')?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
        <li><a href="<?php echo site_url('admin/patients')?>"><?php echo lang('patients')?></a></li>
        <li class="active"><?php echo lang('medication_history')?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
<?php 
	if(validation_errors()){
?>
<div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
                                        <b><?php echo lang('alert')?>!</b><?php echo validation_errors(); ?>
                                    </div>

<?php  } ?>
                <!-- form start -->
				    <div class="box-body">
                 <div class="box-body table-responsive" style="margin-top:40px;">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo lang('date');?></th>
								<th><?php echo lang('name');?></th>
								
								<th width="20%"></th>
                            </tr>
                        </thead>
                        
                        <?php if(isset($prescriptions)):?>
                        <tbody>
                            <?php $i=1;foreach ($prescriptions as $new){?>
                                <tr class="gc_row">
                                    <td><?php echo date("d/m/Y", strtotime($new->date_time));?></td>
                                    <td><?php echo $new->patient?></td>
								    <td width="45%">
                                        <div class="btn-group pull-right">
                                        <?php $admin = $this->session->userdata('admin');
										if($admin['user_role']==1){?>
										  <a class="btn btn-primary" style="margin-left:10px;"  href="#report<?php echo $new->id; ?>" data-toggle="modal"> <i class="fa fa-file"></i> <?php echo lang('reports');?></a>
										  <a class="btn btn-primary" style="margin-left:10px;"  href="#myModal<?php echo $new->id; ?>" data-toggle="modal"><i class="fa fa-eye"></i> <?php echo lang('view');?> <?php echo lang('prescription')?></a>
										  <a class="btn btn-primary" style="margin-left:10px;"  href="<?php echo site_url('admin/prescription/edit/'.$new->id.'/'.$this->uri->segment(4)); ?>" ><i class="fa fa-edit"></i> <?php echo lang('edit');?> </a>
                                         <a class="btn btn-danger" style="margin-left:20px;" href="<?php echo site_url('admin/prescription/delete/'.$new->id); ?>" onclick="return areyousure()"><i class="fa fa-trash"></i> <?php echo lang('delete');?></a>
								<?php }else{ ?>
								 <a class="btn btn-primary" style="margin-left:10px;"  href="#report<?php echo $new->id; ?>" data-toggle="modal"> <i class="fa fa-file"></i> <?php echo lang('reports');?></a>
										  <a class="btn btn-primary" style="margin-left:10px;"  href="#myModal<?php echo $new->id; ?>" data-toggle="modal"><i class="fa fa-eye"></i> <?php echo lang('view');?> <?php echo lang('prescription')?></a>
										 
								<?php } ?>		 
                                        </div>
                                    </td>
                                </tr>
                                <?php $i++;}?>
                        </tbody>
                        <?php endif;?>
                    </table>
			    </div><!-- /.box-body -->
             </form>
            </div><!-- /.box -->
        </div>
     </div>
</section>  












<?php if(isset($prescriptions)):?>
<?php $i=1;foreach ($prescriptions as $new){
$prescription = $this->prescription_model->get_prescription_by_id($new->id);
//echo '<pre>';print_r($medicines);die;
$date = new DateTime($prescription->dob);
 							$now = new DateTime();
 						$interval = $now->diff($date);
?>
<!-- Modal -->
<div class="modal fade" id="edit<?php echo $new->id?>" tabindex="-1" role="dialog" aria-labelledby="editLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
			
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="editLabel"><?php echo lang('edit');?> <?php echo lang('prescription');?> </h4>
      </div>
      <div class="modal-body">
							
				<?php echo form_open_multipart('admin/prescription/edit/'.$new->id); ?>
                        <div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('patient');?></label>
								</div>	
								<div class="col-md-3">
									
									<select name="patient_id" class="form-control chzn" style="z-index: 999">
											<option value="">--<?php echo lang('select_patient');?>--</option>
											<?php foreach($pateints as $new) {
													$sel = "";
													if($prescription->patient_id==$new->id) $sel = "selected='selected'";
													echo '<option value="'.$new->id.'" '.$sel.'>'.$new->name.','.$new->username.','.$new->contact.'</option>';
												}
												
											?>
									</select>
                                </div>
								 <div class="col-md-3">
                                	<a href="#myModal"  data-toggle="modal" class="btn bg-olive btn-flat margin"><?php echo lang('add_new_patient')?></a>		
								</div>
								<div class="col-md-3">
									<input type="text" name="date_time" class="form-control datepicker" placeholder="Date" value="<?php echo $prescription->date_time;?>">
								</div>
                            </div>
                        </div>
						
						
						<div class="form-group">
                        	<div class="row">
								<div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('case_history');?></label>
								</div>	
                                <div class="col-md-8">
                                    
									<textarea name="case_history"class="form-control redactor"><?php echo @$prescription->case_history;?></textarea>
                                </div>
                            </div>
                        </div>
						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('disease');?></label>
								</div>	
								<div class="col-md-3">
									<select name="disease_id[]" class="form-control chzn" multiple="multiple">
											<option value="">--<?php echo lang('select_patient');?>--</option>
											<?php foreach($diseases as $new) {
													$sel = "";
													$sel = (in_array($new->name,json_decode($prescription->disease)))?'selected': '';
													echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
												}
												
											?>
									</select>
                                </div>
                            </div>
                        </div>
						
						
					<?php
						$medicine1 = json_decode($prescription->medicines);
						$medi_ins1= json_decode($prescription->medicine_instruction);
						
						$tests1	= json_decode($prescription->tests);
						$tests_ins1 = json_decode($prescription->test_instructions);
						
					//echo '<pre>'; print_r($medicine);	
					foreach($medicine1 as $key => $val){
					 ?>	
						
						<div class="form-group">
                        	<div class="row  ">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('medicine');?></label>
									
								</div>
								
								<div class="col-md-4" >
									
												<select name="medicine_id[]" class="form-control chzn" style="width:100%">
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
									<select name="instruction[]" class="form-control chzn">
												<option value="">--<?php echo $medi_ins1[$key] ?>--</option>
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
					<?php } ?>	
						
						
						
						
						
						
						
						<div class="form-group input_fields_wrap">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('medicine');?></label>
									
								</div>
								
								<div class="col-md-4" >
									<div>
										<select name="medicine_id[]" class="form-control chzn">
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
									<select name="instruction[]" class="form-control chzn">
												<option value="">--<?php echo lang('medicine_instruction'); ?>--</option>
												<?php foreach($medicine_ins as $new) {
														$sel = "";
														echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
													}
													
												?>
										</select>
								</div>
								<div class="col-md-2">
										<button class="add_field_button btn btn-success"><?php echo lang('add'); ?> </button>
								</div>
								
                            </div>
                        </div>
					
					
					
					
					
					<?php foreach($tests1 as $key => $val){
					 ?>	
						
						<div class="form-group">
                        	<div class="row  ">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('medical_test');?></label>
									
								</div>
								
								<div class="col-md-4" >
									<div>
									
												<select name="report_id[]" class="form-control chzn">
												
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
									<select name="test_instruction[]" class="form-control chzn">
												
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
					<?php } ?>
						
						
						
						<div class="form-group input_fields_wrap1">
                        	<div class="row  ">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('medical_test');?></label>
									
								</div>
								
								<div class="col-md-4" >
									<div>
										<select name="report_id[]" class="form-control chzn">
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
									<select name="test_instruction[]" class="form-control chzn">
												<option value="">--<?php echo lang('medical_test_instruction'); ?>--</option>
												<?php foreach($test_ins as $new) {
														$sel = "";
														echo '<option value="'.$new->name.'" '.$sel.'>'.$new->name.'</option>';
													}
													
												?>
										</select>
								
								</div>
								<div class="col-md-2">
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
								<textarea name="remark" class="form-control redactor"><?php echo @$prescription->remark;?></textarea>
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
                        <button type="submit" class="btn btn-primary"><?php echo lang('update');?></button>
                    </div>
			</form>				

	
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close')?></button>  
      </div>
    </div>
  </div>
</div>
  <?php $i++;}?>
<?php endif;?>



























<?php if(isset($prescriptions)):?>
<?php $i=1;foreach ($prescriptions as $prescription){
?>

<!-- Modal -->
<div class="modal fade" id="myModal<?php echo $prescription->id?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="width:800px;">
      <div class="modal-header">
			
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo lang('view');?> <?php echo lang('prescription');?> </h4>
      </div>
      <div class="modal-body" >
			<table width="100%" border="0" id="printTable<?php echo $prescription->id ?>"  class="pt" style="padding-bottom:0px; height:100%;" >
						<thead>
						<tr>
							<td>
								<table width="100%" style="border-bottom:1px solid;">
									<tr>
										<td style="line-height:110%">
											<?php echo @$template->header;?>											
										</td>
										
									</tr>
								</table>
							</td>
						</tr>
						</thead>
						<tbody>	
						<tr>
							<td >
								<table width="100%">
									<tr>
										<td width="40%"><b><?php echo lang('name')?></b> : <?php echo substr($prescription->patient,0,20)?></td>
										<td width="18%"><b><?php echo lang('age')?></b> : <?php echo date("Y")-$prescription->dob?> Years</td>
										<td ><b><?php echo lang('sex')?></b> : <?php echo $prescription->gender?></td>
										<td ><b><?php echo lang('id')?></b> : <?php echo $prescription->prescription_id?></td>
										<td ><b><?php echo lang('date')?></b> : <?php echo date("d-m-y", strtotime($prescription->date_time))?></td>
									</tr>
								</table>	
							</td>
						</tr>
					
						<tr height="100%">
							<td valign="top">
								<table width="100%" border="0">
									<tr>
										<td width="51%" valign="top">
											<table width="80%" border="0">
												<tr>
														<td width="100%">
															<table border="0" >
																<tr>
																	<td><b>Medical History</b></td>
																</tr>
																<?php $c = json_decode($prescription->case_history_id);
																
																if(is_array($c)){
																	foreach($c as $new){
																		echo '<tr><td>'.$dis = $new .'</td></tr>';
																	}
																}else{
																	echo '<tr><td>'.$c.'</td></tr>';
																}
																?>
																<tr>
																	<td><?php echo $prescription->case_history ?></td>
																</tr>
															</table>
														</td>
												</tr>
												<tr>
													<td>
														<table border="0">
															<tr>
																<td><b>O/E</b></td>
															</tr>
															<?php $d = json_decode($prescription->disease);
																
																if(is_array($d)){
																	foreach($d as $new){
																		echo '<tr><td>'.$dis = $new .'</td></tr>';
																	}
																}else{
																	echo '<tr><td>'.$d.'</td></tr>';
																}
																?>
															<tr>
																<td><?php echo $prescription->oe_description;?></td>
														   </tr>		
														</table>
													</td>
												</tr>
												<tr>
													<td width="51%">
																<?php 
													$d = json_decode($prescription->tests);
													//echo '<pre>'; print_r($d);'</pre>';
													if(!empty($d[0])){?>
																	<table border="0" width="100%">
																		<tr>
																			<td><b><?php echo lang('test')?></b></td>
																		</tr>
																		<?php 
																			  $ins = json_decode($prescription->test_instructions);
																			if(is_array($d)){
																				$i=1;
																				foreach($d as $key => $new){
																				
																					echo '<tr><td>'.$i.'. '.$d[$key] .'<td></tr>';
																				if(!empty($ins[$key])){	
																					echo '<tr><td><p style="padding-left:14px;"><small>('.$ins[$key] .')</small></p><td></tr>';
																				}
																				 $i++;}
																			}else{
																				echo '<tr><td>'.$i.' '.$d.'<td></tr>';
																				echo '<tr><td><p style="padding-left:14px;"><small>( '.$ins.' )</small></p><td></tr>';
																			}	
																			?>
																	</table>	
															<?php } ?>		
																</td>
												</tr>
											</table>
										</td>
										<td valign="top">
											<table border="0" width="100%" >
												<tr>
													<td><p><span style="font-size:26px"><b>R</span ><sub style="font-size:18px">x</b></sub></p></td>
												</tr>
												<?php $d = json_decode($prescription->medicines);
													  $ins = json_decode($prescription->medicine_instruction);
													if(is_array($d)){
														$i=1;
														foreach($d as $key => $new){
														if(!empty($d[$key]))
															echo '<tr><td style="padding-left:18px;">'.$i.'. '.$d[$key] .'<td></tr>';
															echo '<tr><td><p style="padding-left:32px;"><small>'.@$ins[$key] .'</small></p><td></tr>';
														 $i++;}
													}else{
														echo '<tr><td style="padding-left:18px;">'.$i.' '.$d.'<td></tr>';
														echo '<tr><td><p style="padding-left:32px;"><small>'.$ins.'</small></p><td></tr>';
													}	
													?>
												<tr>
													<td>
														<?php if(!empty($prescription->remark)){?>
																<table width="100%" border="0">
																	<tr>
																		<td><b><?php echo lang('remark')?></b></td>
																	</tr>
																	<tr>
																		<td><?php echo $prescription->remark ?></td>
																	</tr>
																</table>
														<?php } ?>		
														</td>	
												</tr>	
											</table>	
										</td>
									</tr>
											
								</table>
							</td>
						</tr>
						
					</tbody>
					<tfoot>	
						<tr>	
							<td style="border-top:1px solid;" class="aligncenter">

								<?php echo @$template->footer;?>
							</td>
						</tr>
					</tfoot>	
						
					</table>
       	

			
			<div class="form-group no-print">		
    			 <div class="row no-print">
                        <div class="col-sm-4 pull-right">
		             <a href="#"class="btn btn-default yes-print no-print" id="print_p"  onclick="printData<?php echo $prescription->id ?>();" style="margin-right: 5px;"><i class="fa fa-print"></i> <?php echo lang('print') ?>
					 <a href="<?php echo site_url('admin/prescription/pdf/'.$prescription->id)?>" id="pdf" class="btn btn-primary  no-print" style="margin-right: 5px;"><i class="fa fa-download"></i> <?php echo lang('generate_pdf') ?></a>
                        </div>
						
                </div>
			</div>
		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close')?></button>  
      </div>
    </div>
  </div>
</div>
 <script>
    function printData<?php echo $prescription->id ?>()
{
   var divToPrint=document.getElementById("printTable<?php echo $prescription->id ?>");
   document.getElementById("print_p").style.display = 'none';
   document.getElementById("pdf").style.display = 'none';
   newWin= window.open("");
   newWin.document.write(divToPrint.outerHTML);
   newWin.print();
   newWin.close();
}

$('.yes-print').on('click',function(){
printData<?php echo $prescription->id ?>();
})
</script> 
 
  <?php $i++;}?>
<?php endif;?>








<?php if(isset($prescriptions)):?>
<?php $i=1;
foreach ($prescriptions as $pre){?>
<!-- Modal -->

<div class="modal fade" id="report<?php echo $pre->id?>" tabindex="-1" role="dialog" aria-labelledby="reportlabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
			
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="reportlabel"><?php echo lang('view_diagonsis_report');?></h4>
      </div>
      <div class="modal-body">
<form method="post" class="theform<?php echo $pre->id;?>" action="<?php echo site_url('admin/prescription/medical_history_report/'.$pre->id.'/'.$this->uri->segment(4))?>" enctype="multipart/form-data" >						
						<input type="hidden" name="p_id" value="<?php echo $pre->id?>" />								
        				<div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('type');?></label>
								</div>	
								
								<div class="col-md-6">
									<select name="type_id" class="form-control chzn">
											<option value="">--<?php echo lang('select_report') ?>--</option>
											<?php foreach($tests as $new) {
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
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('upload_file');?></label>
								</div>	
								
								<div class="col-md-6">
									<input type="file" name="file" class="form-control" />
								</div>	
                            </div>
                        </div>
						
				
						
						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('remark');?></label>
								</div>	
								<div class="col-md-6">
									<textarea name="remark" class="form-control" required="required"></textarea>
                                </div>
                            </div>
                        </div>
						
						 
		
						
						
					<div class="box-footer">
                       <input type="submit" name="save" id="save" value="<?php echo lang('save');?>" class="btn btn-primary" />
                    </div>
						
		</form>				
				 
					  <?php $reports 	 = $this->prescription_model->get_reports_by_id($pre->id);
						if(isset($reports)):?>	
						<table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo lang('date');?></th>
								 <th><?php echo lang('type');?></th>
								<th><?php echo lang('remark');?></th>
								<th><?php echo lang('from');?></th>
								<th><?php echo lang('to');?></th>
								<th width="20%"><?php echo lang('action');?></th>
                            </tr>
                        </thead>
                        
                      
                        <tbody>
                            <?php $i=1;foreach ($reports as $prescription){
							//if($prescription)
							?>
                                <tr class="gc_row">
                                    <td><?php echo date("d/m/y h:i", strtotime($prescription->date_time))?></td>
                                    <td><?php echo $prescription->type?></td>
									<td><?php echo $prescription->remark?></td>
									 <td><?php echo $prescription->from_user?></td>
									  <td><?php echo $prescription->to_user?></td>
								    <td width="20%">
                                        <div class="btn-group">
									<?php if(!empty($prescription->file)){?>	
                                         <a href="<?php echo base_url('assets/uploads/files/'.$prescription->file)?>" class="btn btn-default"  download>Download</a>
                                     <?php }else{?>
									 	<a href="#" class="btn btn-default" style="width:85px;">N/A</a>
									 <?php  } ?>  
									     <a class="btn btn-danger" style="margin-left:10px;" href="<?php echo site_url('admin/prescription/delete_report_history/'.$prescription->id.'/'.$this->uri->segment(4)); ?>" onclick="return areyousure()"><i class="fa fa-trash"></i> <?php echo lang('delete');?></a>
                                        </div>
                                    </td>
                                </tr>
                                <?php $i++;} ?>
                        </tbody>
                       
                    </table>
					 <?php endif;?>
		                             
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close')?></button>  
      </div>
    </div>
  </div>
</div>
  <?php $i++;}?>
<?php endif;?>



<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/chosen.jquery.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/redactor.min.js')?>"></script>
<script src="<?php echo base_url('assets/js/jquery.datetimepicker.js')?>" type="text/javascript"></script>
<script>
  $(document).ready(function(){
    $('.redactor').redactor({
			  // formatting: ['p', 'blockquote', 'h2','img'],
            minHeight: 100,
            imageUpload: '<?php echo site_url(config_item('admin_folder').'/wysiwyg/upload_image');?>',
            fileUpload: '<?php echo site_url(config_item('admin_folder').'/wysiwyg/upload_file');?>',
            imageGetJson: '<?php echo site_url(config_item('admin_folder').'/wysiwyg/get_images');?>',
            imageUploadErrorCallback: function(json)
            {
                alert(json.error);
            },
            fileUploadErrorCallback: function(json)
            {
                alert(json.error);
            }
      });
      
      $('.delete_activity').click(function(){
    $(this).closest('.row').remove();
});
});
</script>


<?php if(isset($prescriptions)):?>
<?php $i=1;
foreach ($prescriptions as $pre){?>

<script>
var check=false;
$(document).ready( function() {
	$('.theform<?php echo $pre->id;?>').submit(function(e) {
    	
			if(check==false){
			event.preventDefault();
			call_loader();
				setTimeout(function(){	
					check = true;
					$( ".theform<?php echo $pre->id;?>" ).submit();
					
				}, 2000);
		  }

	});
	
});

</script>
  <?php $i++;}?>
<?php endif;?>


<script type="text/javascript">
$(function() {
	$('#example1').dataTable({
	});
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
 <script>
    function printData()
{
   var divToPrint=document.getElementById("printTableView");
   newWin= window.open("");
   newWin.document.write(divToPrint.outerHTML);
   newWin.print();
   newWin.close();
}

$('.yes-print').on('click',function(){
printData();
})
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

function call_loader(){
	
	if($('#overlay').length == 0 ){
		var over = '<div id="overlay">' +
						'<img  style="padding-top:300px; padding-left:500px;"id="loading" src="<?php echo base_url('assets/img/green-ajax-loader.gif')?>"></div>';
		
		$(over).appendTo('body');
	}
}

</script>

