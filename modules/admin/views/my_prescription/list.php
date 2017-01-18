<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css')?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function areyousure()
{
	return confirm('<?php echo lang('are_you_sure');?>');
}
</script>
<style>
@media print {
    .btn {
        display: none;
    }
}
#overlay {
	position: fixed;
	left: 0;
	top: 0;
	bottom: 0;
	right: 0;
	background: #ffffff;
	opacity: 0.7;
	filter: alpha(opacity=80);
	-moz-opacity: 0.6;
	z-index: 10000;
}

</style>
<section class="content-header">
        <h1>
            <?php echo $page_title; ?>
            <small><?php echo lang('list');?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin')?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard');?></a></li>
            <li class="active"><?php echo lang('my_prescription');?></li>
        </ol>
</section>

<section class="content">
  	  	 <div class="row" style="margin-bottom:10px;">
            
        </div>	
        
  	  	<div class="row">
          <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo lang('my_prescription');?></h3>                                    
                </div><!-- /.box-header -->
				
                <div class="box-body table-responsive" style="margin-top:40px;">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo lang('serial_number');?></th>
								<th><?php echo lang('name');?></th>
								
								<th width="20%"></th>
                            </tr>
                        </thead>
                        
                        <?php if(isset($prescriptions)):?>
                        <tbody>
                            <?php $i=1;foreach ($prescriptions as $new){?>
                                <tr class="gc_row">
                                    <td><?php echo $i?></td>
                                    <td><?php echo $new->patient?></td>
								    <td width="40%">
                                        <div class="btn-group">
                                          <a class="btn btn-primary" style="margin-left:10px;"  href="#report<?php echo $new->id?>" data-toggle="modal"><i class="fa fa-file"></i> <?php echo lang('view_diagonsis_report');?></a>
										  <a class="btn btn-primary" style="margin-left:10px;" href="#myModal<?php echo $new->id?>" data-toggle="modal"); ><i class="fa fa-eye"></i> <?php echo lang('prescription');?></a>
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
		<?php //echo $pre->patient ?>
		<form method="post" class="theform<?php echo $pre->id;?>" action="<?php echo site_url('admin/prescription/reports/'.$pre->id)?>" enctype="multipart/form-data" >
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
									<textarea name="remark" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
						
						 
		
						
						
					<div class="box-footer">
                        <button type="submit" class="btn btn-primary"><?php echo lang('save');?></button>
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
                                         <a href="<?php echo site_url('assets/uploads/files/'.$prescription->file)?>" class="btn btn-default"  download>Download</a>
                                     <?php }else{?>
									 	<a href="#" class="btn btn-default" style="width:85px;">N/A</a>
									 <?php  } ?>  
									   
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
											<table width="100%" border="0">
												<tr>
														<td width="100%">
															<table border="0">
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
																					echo '<tr><td><small style="padding-left:14px;">('.$ins[$key] .')</small><td></tr>';
																				}
																				 $i++;}
																			}else{
																				echo '<tr><td>'.$i.' '.$d.'<td></tr>';
																				echo '<tr><td><small style="padding-left:14px;">( '.$ins.' )</small><td></tr>';
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
															echo '<tr><td><small style="padding-left:32px;">'.@$ins[$key] .'</small><td></tr>';
														 $i++;}
													}else{
														echo '<tr><td style="padding-left:18px;">'.$i.' '.$d.'<td></tr>';
														echo '<tr><td><small style="padding-left:32px;">'.$ins.'</small><td></tr>';
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







<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>

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
function call_loader(){
	
	if($('#overlay').length == 0 ){
		var over = '<div id="overlay">' +
						'<img  style="padding-top:300px; padding-left:500px;"id="loading" src="<?php echo base_url('assets/img/green-ajax-loader.gif')?>"></div>';
		
		$(over).appendTo('body');
	}
}


</script>

<script>
    function printData()
{
   var divToPrint=document.getElementById("printTable");
   newWin= window.open("");
   newWin.document.write(divToPrint.outerHTML);
   newWin.print();
   newWin.close();
}

$('.yes-print').on('click',function(){
printData();
})
</script>