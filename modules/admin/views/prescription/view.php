<link href="<?php echo base_url('assets/css/chosen.css')?>" rel="stylesheet" type="text/css" />
<!-- Content Header (Page header) -->
<style>
.row{
	margin-bottom:10px;
}

.mg{
	margin-top:20px;
}
</style>

<?php 
$date = new DateTime($prescription->dob);
 $now = new DateTime();
 $interval = $now->diff($date);
  
?>
 <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo lang('prescription');?>
        <small><?php echo lang('view');?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin')?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard');?></a></li>
        <li><a href="<?php echo site_url('admin/prescription')?>"> <?php echo lang('prescription');?></a></li>
        <li class="active"><?php echo lang('view');?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
   	
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
               
				
                    <div class="box-body">
					
					<table width="100%" border="0">
						<tr>
							<td style="padding-bottom:10px;">
								<table width="100%" style="border-bottom:2px solid;">
									<tr>
										<td>
											<?php echo @$template->header;?>											
										</td>
										
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td style="padding-top:10px;">
								<table width="100%" >
									<tr>
										<td width="20%"><b><?php echo lang('name')?></b> : <?php echo $prescription->patient?></td>
										<td width="20%"><b><?php echo lang('age')?></b> : <?php echo @$interval->y;?></td>
										<td width="20%"><b><?php echo lang('sex')?></b> : <?php echo $prescription->gender?></td>
										<td width="20%"><b><?php echo lang('id')?></b> : <?php echo $prescription->patient_id?></td>
										<td width="20%"><b><?php echo lang('date')?></b> : <?php echo date("d-m-y h:i", strtotime($prescription->date_time))?></td>
									</tr>
								</table>	
							</td>
						</tr>
						<tr>
							<td style="padding-top:10px;">
								<table border="0">
									<tr>
										<td><b><?php echo lang('case_history')?></b></td>
									</tr>
									<tr>
										<td><?php echo $prescription->case_history ?></td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td style="padding-top:10px;">
								<table border="0">
									<tr>
										<td><b><?php echo lang('medical_history')?></b></td>
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
								</table>
							</td>
						</tr>
						<tr>	
							<td>
								<table border="0" width="100%">
									<tr>
										<td width="45%"><b>O/E</b></td>
										<td width="55%">
											<table border="0" width="100%">
												<tr>
													<td><p><span style="font-size:26px"><b>R</span ><sub style="font-size:18px">x</b></sub></p></td>
												</tr>
												<?php $d = json_decode($prescription->medicines);
													  $ins = json_decode($prescription->medicine_instruction);
													if(is_array($d)){
														$i=1;
														foreach($d as $key => $new){
														
															echo '<tr><td>'.$i.'. '.$d[$key] .'<td></tr>';
															echo '<tr><td><small>'.$ins[$key] .'</small><td></tr>';
														 $i++;}
													}else{
														echo '<tr><td>'.$d.'<td></tr>';
														echo '<tr><td><small>'.$ins.'</small><td></tr>';
													}	
													?>
											</table>	
										</td>	
									</tr>
								</table>
							</td>
						</tr>
						<tr>	
							<td>
								<table border="0" width="100%">
									<tr>
									
										<td width="55%">
											<table border="0" width="100%">
												<tr>
													<td><b><?php echo lang('test')?></b></td>
												</tr>
												<?php $d = json_decode($prescription->tests);
													  $ins = json_decode($prescription->test_instructions);
													if(is_array($d)){
														$i=1;
														foreach($d as $key => $new){
														
															echo '<tr><td>'.$i.'. '.$d[$key] .'<td></tr>';
															echo '<tr><td><small>'.$ins[$key] .'</small><td></tr>';
														 $i++;}
													}else{
														echo '<tr><td>'.$d.'<td></tr>';
														echo '<tr><td><small>'.$ins.'</small><td></tr>';
													}	
													?>
											</table>	
										</td>	
									</tr>
								</table>
							</td>	
						</tr>
						<tr>
							<td>
								<table border="0">
									<tr>
										<td><b><?php echo lang('remark')?></b></td>
									</tr>
									<tr>
										<td><?php echo $prescription->remark ?></td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>	
							<td>
								<?php echo @$template->footer;?>
							</td>
						</tr>
						
						
					</table>
                        
						
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
							  
                                <div class="col-md-2">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
								</div>
								<div class="col-md-4">	
							<?php  $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '".$doc->id."' AND table_id = '".$prescription->id."' AND form = '".$doc->form."' ")->row();?>		
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
                                <div class="col-md-2">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
								</div>
								<div class="col-md-4">
								<?php  $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '".$doc->id."' AND table_id = '".$prescription->id."'  ")->row();?>	
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
                                <div class="col-md-2">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
						
								</div>
								<div class="col-md-4">	
							<?php	
										foreach($values as $key=>$val) { ?>
							<?php 
							$x="";
							$result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '".$doc->id."' AND table_id = '".$prescription->id."' AND form = '".$doc->form."' ")->row();
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
                                <div class="col-md-2">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
								</div>
								<div class="col-md-4">
							<?php	
										foreach($values as $key=>$val) { ?>
							<?php 
							$x="";
							$result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '".$doc->id."' AND table_id = '".$prescription->id."' AND form = '".$doc->form."' ")->row();
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
                                <div class="col-md-2">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
								</div>
								<div class="col-md-6">
									<?php  $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '".$doc->id."' AND table_id = '".$prescription->id."' AND form = '".$doc->form."'")->row();?>	
									<?php echo @$result->reply;?>
								</div>
                            </div>
                        </div>
							
						
						
					<?php 
								}	
							}
						}
					?>	
					
                   
					
			<div class="form-group">		
    			 <div class="row no-print">
                        <div class="col-xs-12">
						<button class="btn btn-default" onClick="window.print();"><i class="fa fa-print"></i> <?php echo lang('print') ?></button>
                     <a href="<?php echo site_url('admin/prescription/pdf/'.$prescription->id)?>"class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> <?php echo lang('generate_pdf') ?></a>
                        </div>
						
                </div>
			</div>
				
				
				 </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
     </div>
</section>  
