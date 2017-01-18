<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/chosen.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/jquery.datetimepicker.css')?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function areyousure()
{
	return confirm('<?php echo lang('are_you_sure');?>');
}
</script>
<style>
.chosen-container{width:100% !important
}


</style>
<section class="content-header">
        <h1>
            <?php echo $page_title; ?>
            <small><?php echo lang('list');?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin')?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard');?></a></li>
            <li class="active"><?php echo lang('payment_history');?></li>
        </ol>
</section>

<section class="content">
<?php 
	$admin = $this->session->userdata('admin');
	if($admin['user_role']==1 || $admin['user_role']==3){
?>
  	  	 <div class="row no-print" style="margin-bottom:10px;">
            <div class="col-xs-12">
                <div class="btn-group pull-right">
                    <a class="btn btn-default" href="#add" data-toggle="modal"><i class="fa fa-plus"></i> <?php echo lang('add') ." ". lang('payment');?></a>
                </div>
            </div>    
        </div>	
<?php } ?>		
        
  	  	<div class="row no-print">
          <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo lang('payment');?></h3>                                    
                </div><!-- /.box-header -->
				
                <div class="box-body table-responsive no-print" style="margin-top:40px;">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo lang('date');?></th>
								<th><?php echo lang('name');?></th>
								<th><?php echo lang('invoice_number');?></th>
								<th><?php echo lang('amount');?></th>
								
								<th width="30%"></th>
                            </tr>
                        </thead>
                        
                        <?php if(isset($payments)):?>
                        <tbody>
                            <?php $i=1;foreach ($payments as $new){?>
                                <tr class="gc_row">
                                    <td><?php echo date("d/m/y", strtotime($new->date))?></td>
                                    <td><?php echo $new->patient?></td>
                                    <td><?php echo $new->invoice?></td>
                                    <td><?php echo $new->amount?></td>
								    <td width="12%">
                                        <div class="btn-group">
										  <a class="btn btn-default" style="margin-left:10px;"  href="#invoice<?php echo $new->id; ?>" data-toggle="modal"><i class="fa fa-list"></i> <?php echo lang('invoice');?></a>
										 
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





<?php if(isset($payments)):?>
<?php $i=1;
foreach ($payments as $new){
$details = $this->invoice_model->get_detail($new->id);
?>
<!-- Modal -->
<div class="modal fade" id="invoice<?php echo $new->id?>" tabindex="-1" role="dialog" aria-labelledby="invoicelabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
			
        <button type="button" class="close no-print" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="invoicelabel"><?php echo lang('invoice');?></h4>
      </div>
      <div class="modal-body">
	  <div id="mydiv">
      					<section class="content invoice" >
                    <!-- title row -->
                    <div class="row">
                        <div class="col-xs-12">
							<div class="col-sm-3 ">
							<?php if($setting->image!=""){?>
                            	<img src="<?php echo base_url('assets/uploads/images/'.$setting->image)?>"  height="70" width="80" />
							<?php } ?>	
							</div>
							<div class="col-sm-4 invoice-col">	
								<h2 class="page-header">
									 <?php echo $setting->name ?>
									
								</h2>
								
							</div>
							<div class="col-sm-4 invoice-col">
								<small class="pull-right">Date: <?php echo date('d/m/Y')?></small>
							</div>
                        </div><!-- /.col -->
                    </div>
					
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            <?php echo lang('from')?>
                            <address>
                                <strong><?php echo $setting->name ?></strong><br>
                               <?php echo $setting->address ?><br>
                                <?php echo lang('phone') ?>: <?php echo $setting->contact ?><br/>
                                <?php echo lang('email') ?>: <?php echo $setting->email ?>
                            </address>
                        </div><!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            <?php echo lang('to')?>
                            <address>
                                <strong><?php echo $details->patient ?></strong><br>
                                <?php echo $details->address ?><br>
                                <?php echo lang('phone') ?>: <?php echo $details->contact ?><br/>
                                <?php echo lang('email') ?>: <?php echo $details->email ?>
                            </address>
                        </div><!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            <b><?php echo lang('invoice')?> #<?php echo $details->invoice ?></b><br/>
                            
                            <b><?php echo lang('payment_mode') ?>:</b> <?php echo $details->mode ?><br/>
                            
                        </div><!-- /.col -->
                    </div><!-- /.row -->

                    <!-- Table row -->
                    <div class="row">
                        <div class="col-xs-12 table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th><?php echo lang('date') ?></th>
										<th><?php echo lang('detail') ?></th>
                                        <th><?php echo lang('amount') ?></th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo date("d/m/Y", strtotime($details->date));?></td>
										 <td><?php echo lang('prescription_fee') ?></td>
                                        <td><?php echo $details->amount ?></td>
                                        
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div><!-- /.col -->
                    </div><!-- /.row -->

                    <?php $admin = $this->session->userdata('admin');
					 if($admin['user_role']==2){ ?>
					 <div class="row no-print">
                        <div class="col-xs-12">
                            <button class="btn btn-default" onclick="window.print()" ><i class="fa fa-print"></i> <?php echo lang('print') ?></button>
                          
                            <a href="<?php echo site_url('admin/invoice/pdf/'.$details->id)?>"class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> <?php echo lang('generate_pdf') ?></a>
							  <a href="<?php echo site_url('admin/invoice/mail/'.$details->id)?>"class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-mail-forward"></i> <?php echo lang('mail_to_patient') ?></a>
                        </div>
                    </div>
				<?php }else{?>	
				
                    <!-- this row will not appear when printing -->
                    <div class="row no-print">
                        <div class="col-xs-12">
                            <button class="btn btn-default"onclick="window.print()" ><i class="fa fa-print"></i> <?php echo lang('print') ?></button>
                          
                            <a href="<?php echo site_url('admin/invoice/pdf/'.$details->id)?>"class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> <?php echo lang('generate_pdf') ?></a>
							  <a href="<?php echo site_url('admin/invoice/mail/'.$details->id)?>"class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-mail-forward"></i> <?php echo lang('mail_to_patient') ?></a>
                        </div>
                    </div>
				<?php } ?>	
					
					
					
                </section><!-- /.content -->
	  	</div>
	  </div>		  
      <div class="modal-footer">
        <button type="button" class="btn btn-default no-print" data-dismiss="modal"><?php echo lang('close')?></button>  
      </div>
    </div>
  </div>
</div>
</form>
  <?php $i++;}?>
<?php endif;?>





<script src="<?php echo base_url('assets/js/chosen.jquery.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/jquery.datetimepicker.js')?>" type="text/javascript"></script>
<?php if(!empty($p_id)){?>
<script>
$(function() {
	$('#add').modal();
});
</script>

<?php } ?>

<script type="text/javascript">
$(function() {
	$('#example1').dataTable({
	});
	$('.chzn').chosen({search_contains:true});
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

$( "#add_form" ).submit(function( event ) {
	var form = $(this).closest('form');
	patient_id = $(form ).find('.patient_id').val();
	invoice_no = $(form ).find('.invoice_no').val();
	amount= $(form ).find('.amount').val();
	payment_mode_id = $(form ).find('.payment_mode_id').val();
	date = $(form ).find('.date').val();
	call_loader_ajax();
	$.ajax({
		url: '<?php echo site_url('admin/payment/add_payment/') ?>',
		type:'POST',
		data:{patient_id:patient_id,invoice_no:invoice_no,amount:amount,payment_mode_id:payment_mode_id,date:date},
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



$( ".update" ).click(function( event ) {
event.preventDefault();
//$(this).closest("form").submit();	
	
	var form = $(this).closest('form');
	id = $(form ).find('input[name=id]').val();
	patient_id = $(form ).find('.patient_id').val();
	invoice_no = $(form ).find('.invoice_no').val();
	amount= $(form ).find('.amount').val();
	payment_mode_id = $(form ).find('.payment_mode_id').val();
	date = $(form ).find('.date').val();
	//alert(amount);return false;
	call_loader_ajax();
	$.ajax({
		url: '<?php echo site_url('admin/payment/edit_payment') ?>/' + id,
		type:'POST',
		data:{patient_id:patient_id,invoice_no:invoice_no,amount:amount,payment_mode_id:payment_mode_id,date:date},
		success:function(result){
		//alert(result);return false;
			  if(result==1)
				{
					location.reload();
					// $('#edit'+id).modal('hide');
					 //window.close(); 
				}
				else
				{
					$("#overlay").hide();
					$('#err_edit'+id).html(result);
				}
		  
		  $(".chzn").chosen();
		 }
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
