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
       <?php echo lang('fees')?>
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin')?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
        <li><a href="<?php echo site_url('admin/payment')?>"><?php echo lang('payment')?></a></li>
        <li class="active"><?php echo lang('add')?></li>
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
				<form method="post" action="<?php echo site_url('admin/payment/add_payment/'.@$p_id)?>" enctype="multipart/form-data">
			
			
				<input type="hidden" name="inr" id="inr" value="<?php echo @$case->fees?>" />
				<input type="hidden" name="bal" id="bal" value="<?php echo @$fees_all[0]->bal?>" />
                    <div class="box-body">
                      <div class="form-group" style="margin-top:20px;"> 
							 <legend><?php echo lang('add_payment_detail')?></legend>  
					    </div>
						<div class="form-group" style="margin-top:20px;">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('patient')?></b>
								</div>
								<div class="col-md-4">
								    <select name="patient_id" class="form-control chzn" <?php echo (!empty($p_id))?'disabled="disabled"':''; ?> >
											<option value="">--<?php echo lang('select_patient');?>--</option>
											<?php foreach($pateints as $new) {
													$sel = "";
													if($this->uri->segment(4)==$new->id) $sel = "selected='selected'";
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
                                    <input type="text" name="invoice_no" value="<?php echo $i_no;?>" readonly="readonly"  class="form-control" />
									
                                </div>
                            </div>
                        </div>
					  
					    <div class="form-group" style="margin-top:20px;">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('amount')?></b>
								</div>
								<div class="col-md-4">
                                    <input type="text" name="amount" value="" id="amount" class="form-control" />
									
                                </div>
                            </div>
                        </div>
						  <div class="form-group" >
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('payment_mode')?></b>
								</div>
								<div class="col-md-4">
                                   <select name="payment_mode_id" class="form-control" >
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
                                    <input type="text" name="date" value="" class="form-control datepicker" />
                                </div>
                            </div>
                        </div>
					   
					  	
						
			   			
                      
						
                    </div><!-- /.box-body -->
    
                    <div class="box-footer">
                        <button  type="submit" class="btn btn-primary"><?php echo lang('save')?></button>
                    </div>
					
					
					
			    </div><!-- /.box-body -->
             </form>
            </div><!-- /.box -->
        </div>
     </div>
</section>  


<script src="<?php echo base_url('assets/js/jquery.datetimepicker.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/chosen.jquery.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>


<script src="<?php echo base_url('assets/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')?>" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
	$('#example1').dataTable({
	});
	$('.chzn').chosen({search_contains:true});
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
