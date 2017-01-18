<link href="<?php echo base_url('assets/css/chosen.css')?>" rel="stylesheet" type="text/css" />
<!-- Content Header (Page header) -->
<style>
.row{
	margin-bottom:10px;
}
</style>
 <!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo lang('invoice'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin/dashboard')?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard');?></a></li>
      
        <li class="active"><?php echo lang('invoice');?></li>
    </ol>
</section>

<section class="content">
<?php 
	if(validation_errors()){
?>
<div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
                                        <b><?php echo lang('alert');?>!</b><?php echo validation_errors(); ?>
                                    </div>

<?php  } ?>  
 <!-- Main content -->
                <section class="content invoice">
                    <!-- title row -->
                    <div class="row">
                        <div class="col-xs-12">
							<div class="col-sm-3 ">
							<?php if($setting->image!=""){?>
                            	<img src="<?php echo site_url('assets/uploads/images/'.$setting->image)?>"  height="70" width="80" />
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
                            <button class="btn btn-default" onClick="window.print();"><i class="fa fa-print"></i> <?php echo lang('print') ?></button>
                          
                            <a href="<?php echo site_url('admin/invoice/pdf/'.$details->id)?>"class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> <?php echo lang('generate_pdf') ?></a>
							  <a href="<?php echo site_url('admin/invoice/mail/'.$details->id)?>"class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-mail-forward"></i> <?php echo lang('mail_to_patient') ?></a>
                        </div>
                    </div>
				<?php }else{?>	
				
                    <!-- this row will not appear when printing -->
                    <div class="row no-print">
                        <div class="col-xs-12">
                            <button class="btn btn-default" onClick="window.print();"><i class="fa fa-print"></i> <?php echo lang('print') ?></button>
                          
                            <a href="<?php echo site_url('admin/invoice/pdf/'.$details->id)?>"class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> <?php echo lang('generate_pdf') ?></a>
							  <a href="<?php echo site_url('admin/invoice/mail/'.$details->id)?>"class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-mail-forward"></i> <?php echo lang('mail_to_patient') ?></a>
                        </div>
                    </div>
				<?php } ?>	
					
					
					
                </section><!-- /.content -->
<script src="<?php echo base_url('assets/js/chosen.jquery.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/bootstrap-datepicker.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')?>" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
	$('.chzn').chosen();
});

$(function() {
	//bootstrap WYSIHTML5 - text editor
	$(".txtarea").wysihtml5();
});

 $(function() {
    $( ".datepicker" ).pickmeup({
    format  : 'Y-m-d'
});
  });
</script>