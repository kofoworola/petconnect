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
</style>
 <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
       <?php echo lang('payment_history')?>
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin')?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
        <li><a href="<?php echo site_url('admin/assistants')?>"><?php echo lang('assistants')?></a></li>
        <li class="active"><?php echo lang('payment_history')?></li>
    </ol>
</section>

<section class="content">
	
	<div class="row no-print" style="margin-bottom:10px;">
            <div class="col-xs-12">
                <div class="btn-group pull-right">
                   <a class="btn btn-default" href="#add" data-toggle="modal"><i class="fa fa-plus"></i> <?php echo lang('add') ." ". lang('payment');?></a>
                </div>
            </div>    
        </div>	
	
    <div class="row no-print">
        <!-- left column -->
        <div class="col-md-12 no-print">
            <!-- general form elements -->
            <div class="box box-primary no-print">
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
                    <table id="example1" class="table table-bordered table-striped table-mailbox">
                        <thead>
                            <tr>
                                <th width="5%" style="display:none"><?php echo lang('serial_number')?></th>
								<th><?php echo lang('invoice_number');?></th>
								<th><?php echo lang('date')?></th>
								
								<th><?php echo lang('amount')?></th>
								<th><?php echo lang('payment_mode')?></th>
								<th width="10%"></th>
                            </tr>
                        </thead>
                        
                        <?php if(isset($fees_all)):?>
                        <tbody>
                            <?php $i=1;foreach ($fees_all as $new){?>
                                <tr class="gc_row">
                                    <td style="display:none"><?php echo $i?></td>
									<td><?php echo $new->invoice?></td>
									<td><?php echo $new->date ?></td>
									 
								    <td><?php echo $new->amount?></td>
									<td><?php echo $new->mode?></td>
									
                                    <td width="30%">
										 <a class="btn btn-default" style="margin-left:20px;" href="#invoice<?php echo $new->id; ?>"  data-toggle="modal"><i class="fa fa-list"></i> <?php echo lang('invoice')?></a>
										 <a class="btn btn-danger" style="margin-left:20px;" href="<?php echo site_url('admin/assistant_payment/delete/'.$new->id); ?>" onclick="return areyousure()"><i class="fa fa-trash"></i> <?php echo lang('delete')?></a>
                                        
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






<?php if(isset($fees_all)):?>
<?php $i=1;
foreach ($fees_all as $new){
$details = $this->invoice_model->get_detail_assistant($new->id);
?>
<!-- Modal -->
<div class="modal fade" id="invoice<?php echo $new->id?>" tabindex="-1" role="dialog" aria-labelledby="invoicelabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content ff">
      <div class="modal-header">
			
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="invoicelabel"><?php echo lang('invoice');?></h4>
      </div>
      <div class="modal-body">
	  	
      					<section class="content invoice">
			    	<table width="100%" border="0"  id="print_inv<?php echo $new->id?>" class="bd" >
							<tr>
								<td>
									<table width="100%" style="border-bottom:1px solid #CCCCCC; padding-bottom:20px;">
										<tr>
											<td align="left"><?php if(@$setting->image!=""){?>
											<img src="<?php echo base_url('assets/uploads/images/'.@$setting->image)?>"  height="70" width="80" />
										<?php }else{?>
										<img src="<?php echo base_url('assets/img/doctor_logo.png/')?>"  height="70" width="80" />
											<?php } ?>	</td>
											<td align="right">
												<b><?php echo lang('invoice_number')?> #<?php echo $details->invoice ?></b><br />
												<b><?php echo lang('payment_date') ?>:</b> <?php echo date("d/m/Y", strtotime($details->date));?><br />
												<b><?php echo lang('payment_mode') ?>:</b> <?php echo $details->mode ?><br/>
												<b><?php echo lang('issue_date') ?>:</b> <?php echo date('d/m/Y')?><br />
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td>
									<table width="100%" border="0" style="border-bottom:1px solid #CCCCCC; padding-bottom:30px;">
										<tr>
											<td align="left"><?php echo lang('payment_to');?> <br />
												 <strong><?php echo @$setting->name ?></strong><br>
										   <?php echo @$setting->address ?><br>
											<?php echo lang('phone') ?>: <?php echo @$setting->contact ?><br/>
											<?php echo lang('email') ?>: <?php echo @$setting->email ?>		
											
											</td>
											<td align="right" colspan="2"><?php echo lang('bill_to');?> <br />
											
											<strong><?php echo $details->assistant ?></strong><br>
											<?php echo $details->address ?><br>
											<?php echo lang('phone') ?>: <?php echo $details->contact ?><br/>
											<?php echo lang('email') ?>: <?php echo $details->email ?>
											</td>
											
										</tr>
									</table>
								</td>
							</tr>
							<tr >
								<th align="left" style="padding-top:10px;"><?php echo lang('invoice_entries');?> </th>
							</tr>
							<tr>  
								<td>
									<table  width="100%" style="border:1px solid #CCCCCC;" >
										<tr>
											<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="10%" align="left"><b>#</b></td>
											<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="75%" align="left"><b><?php echo lang('entry');?> </b></td>
											<td style="border-bottom:1px solid #CCCCCC;"  width="15%"><b><?php echo lang('price');?> </b></td>
										</tr>
										<tr >
											 <td width="10%" style="border-right:1px solid #CCCCCC" >1</td>
											 <td width="75%" style="border-right:1px solid #CCCCCC"><?php echo lang('payment') ?></td>
											 <td width="15%" ><?php echo $details->amount ?></td>
											
										</tr>
									</table>
								</td>
							</tr>
						</table>

                    <?php $admin = $this->session->userdata('admin');
					 if($admin['user_role']==2){ ?>
					 <div class="row no-print" style="padding-top:20px;">
                        <div class="col-xs-12">
                            <button class="btn btn-default" onclick="printData<?php echo $new->id?>()" ><i class="fa fa-print"></i> <?php echo lang('print') ?></button>
                          
                            <a href="<?php echo site_url('admin/assistant_payment/pdf/'.$details->id)?>"class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> <?php echo lang('generate_pdf') ?></a>
							  <a href="<?php echo site_url('admin/assistant_payment/mail/'.$details->id)?>"class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-mail-forward"></i> <?php echo lang('mail_to_assistant') ?></a>
                        </div>
                    </div>
				<?php }else{?>	
				
                    <!-- this row will not appear when printing -->
                    <div class="row no-print" style="padding-top:20px;">
                        <div class="col-xs-12">
                            <button class="btn btn-default"onclick="printData<?php echo $new->id?>()" ><i class="fa fa-print"></i> <?php echo lang('print') ?></button>
                          
                            <a href="<?php echo site_url('admin/assistant_payment/pdf/'.$details->id)?>"class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> <?php echo lang('generate_pdf') ?></a>
							  <a href="<?php echo site_url('admin/assistant_payment/mail/'.$details->id)?>"class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-mail-forward"></i> <?php echo lang('mail_to_assistant') ?></a>
                        </div>
                    </div>
				<?php } ?>	
					
					
					</section><!-- /.content -->
	  
	  </div>		  
      <div class="modal-footer">
        <button type="button" class="btn btn-default no-print" data-dismiss="modal"><?php echo lang('close')?></button>  
      </div>
    </div>
  </div>
</div>
</form>

<script>
function printData<?php echo $new->id?>()
{
   var divToPrint=document.getElementById("print_inv<?php echo $new->id?>");
   newWin= window.open("");
   newWin.document.write(divToPrint.outerHTML);
   newWin.print();
   newWin.close();
}
</script>
  <?php $i++;}?>
<?php endif;?>




<!-- Add Payment-->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="addlabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content ff">
      <div class="modal-header">
			
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="addlabel"><?php echo lang('add');?> <?php echo lang('payment');?></h4>
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
      				   <!-- form start -->
				<form method="post" action="<?php echo site_url('admin/assistant_payment/add_payment/'.@$p_id)?>" enctype="multipart/form-data" id="add_form">
			
			        <div class="box-body">
                      <div class="form-group" style="margin-top:20px;"> 
							 <legend><?php echo lang('add_payment_detail')?></legend>  
					    </div>
						<div class="form-group" style="margin-top:20px;">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('assistant')?></b>
								</div>
								<div class="col-md-4">
                                    <select name="assistant_id" class="form-control chzn patient assistant_id" >
											<option value="">--<?php echo lang('select') ?> <?php echo lang('assistant') ?>--</option>
											<?php foreach($assistants as $new) {
													$sel = "";
													if($a_id==$new->id) $sel = "selected='selected'";
													echo '<option value="'.$new->id.'" '.$sel.'>'.$new->name.','.$new->username.','.$new->contact.'</option>';
												}
												
											?>
									</select>
                                </div>
                            </div>
                        </div>
						<div class="form-group" style="margin-top:20px;">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('invoice_number')?></b>
								</div>
								<div class="col-md-4">
                                    <input type="text" name="invoice_no" value="<?php echo $i_no;?>" readonly="readonly"  class="form-control invoice_no" />
									
                                </div>
                            </div>
                        </div>
					  
					    <div class="form-group" style="margin-top:20px;">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('amount')?></b>
								</div>
								<div class="col-md-4">
                                    <input type="text" name="amount" value="" id="amount" class="form-control amount" />
									
                                </div>
                            </div>
                        </div>
						  <div class="form-group" >
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('payment_mode')?></b>
								</div>
								<div class="col-md-4">
                                   <select name="payment_mode_id" class="form-control payment payment_mode_id" >
										<option value="">--<?php echo lang('select')?> <?php echo lang('payment_mode')?> --</option>
										<?php foreach($payment_modes as $new) {
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
                                <div class="col-md-3">
                                	<b><?php echo lang('date')?></b>
								</div>
								<div class="col-md-4">
                                    <input type="text" name="date" value="" class="form-control datepicker date" />
                                </div>
                            </div>
                        </div>
					   
						
            
                    <div class="box-footer">
                        <button  type="submit" class="btn btn-primary"><?php echo lang('save')?></button>
                    </div>
			</form>
	  </div>		  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close')?></button>  
      </div>
    </div>
  </div>
</div>



<script src="<?php echo base_url('assets/js/jquery.datetimepicker.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>


<script src="<?php echo base_url('assets/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')?>" type="text/javascript"></script>
<script type="text/javascript">
$( "#add_form" ).submit(function( event ) {
	var form = $(this).closest('form');
	assistant_id = $(form ).find('.assistant_id').val();
	invoice_no = $(form ).find('.invoice_no').val();
	amount= $(form ).find('.amount').val();
	payment_mode_id = $(form ).find('.payment_mode_id').val();
	date = $(form ).find('.date').val();
	//alert(patient_id);
	call_loader_ajax();
	$.ajax({
		url: '<?php echo site_url('admin/assistant_payment/add_payment/') ?>',
		type:'POST',
		data:{assistant_id:assistant_id,invoice_no:invoice_no,amount:amount,payment_mode_id:payment_mode_id,date:date},
		success:function(result){
			  if(result==1)
				{
					//alert("value=0");
					//$('#myModal').fadeOut(500);
					 $('#add').modal('hide');
					 window.close();
					 location.reload(); 
				}
				else
				{
					$("#overlay").hide();
					$('#err').html(result);
				}
		  
		 }
	  });
	
	event.preventDefault();
});



    function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data) 
    {
        var mywindow = window.open('', 'my div', 'height=400,width=600');
        mywindow.document.write('<html><head><title>my div</title>');
        /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10

        mywindow.print();
        mywindow.close();

        return true;
    }


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
  
  
 $(document).on('blur', '#amount', function(){

 			var value1 = parseInt($('#inr').val());
            var value2 = parseInt($('#bal').val(), 10) || 0;
			var value3 = parseInt($('#amount').val());
			
			var bal = value2 - value1;
			if(bal > value3){
				alert("Current Filled Amount Is Greather Then Balance");
			 return false;
			}

});
 
</script>
