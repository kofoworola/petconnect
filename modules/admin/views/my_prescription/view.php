<link href="<?php echo site_url('assets/css/chosen.css')?>" rel="stylesheet" type="text/css" />
<!-- Content Header (Page header) -->
<style>
.row{
	margin-bottom:10px;
}

.mg{
	margin-top:20px;
}
</style>
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
                    <h3 class="box-title"><?php echo lang('prescription');?></h3>
                </div><!-- /.box-header -->
                <!-- form start -->
				
				
                    <div class="box-body">
                        <div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('patient');?></label>
								</div>	
								<div class="col-md-6">
									<?php echo $prescription->patient?>
                                </div>
								<div class="col-md-1">
                                    <label for="name" style="clear:both;"> <?php echo lang('date');?></label>
								</div>	
								<div class="col-md-2">
									<?php echo date("d/m/Y", strtotime($prescription->date_time))?>
                                </div>
                            </div>
                        </div>
						
						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('disease');?></label>
								</div>	
								<div class="col-md-6">
										<?php $d = json_decode($prescription->disease);
										
										if(is_array($d)){
											foreach($d as $new){
												echo	$dis = $new .',';
											}
										}else{
											echo $d;
										}
										?>
                                </div>
                            </div>
                        </div>
						
						
						<div class="form-group input_fields_wrap">
                        	<div class="row  ">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('medicine');?></label>
									
								</div>
								
								<div class="col-md-6">
										<?php $d = json_decode($prescription->medicines);
										if(is_array($d)){
											foreach($d as $new){
												echo	$med = $new .',';
											}
										}else{
											echo $d;
										}	
										?>
                                </div>
								
                            </div>
                        </div>
						
						
						
						<div class="form-group input_fields_wrap1">
                        	<div class="row  ">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('medical_test');?></label>
									
								</div>
								<div class="col-md-6">
										<?php $d = json_decode($prescription->tests);
										if(is_array($d)){
											foreach($d as $new){
												echo	$test = $new .',';
											}
										}else{
											echo $d;
										}	
										?>
                                </div>
								
                            </div>
                        </div>
					
					
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('remark');?></label>
								</div>	
								<div class="col-md-8">
								<?php echo $prescription->remark?>
                                </div>
                            </div>
                        </div>
					
                   
					
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
</section





