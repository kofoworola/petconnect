<link href="<?php echo site_url('assets/css/chosen.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/css/jquery.datetimepicker.css')?>" rel="stylesheet" type="text/css" />
<!-- Content Header (Page header) -->
<style>
.row{
	margin-bottom:10px;
}
</style>
 <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo lang('hospital');?>
        <small><?php echo lang('view');?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin')?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard');?></a></li>
        <li><a href="<?php echo site_url('admin/hospital')?>"><?php echo lang('hospital');?></a></li>
        <li class="active"><?php echo lang('view');?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"><?php echo lang('view');?></h3>
                </div><!-- /.box-header -->
                <!-- form start -->
				     <div class="box-body">
                        <div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('name');?></label>
									</div>
								<div class="col-md-4">
									<?php echo $hospital_details->name;?>
                                </div>
                            </div>
                        </div>
						
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"><?php echo lang('address');?></label>
									</div>
								<div class="col-md-4">
										<?php echo $hospital_details->address;?> 
                                </div>
                            </div>
                        </div>
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"><?php echo lang('phone');?></label>
								</div>
								<div class="col-md-4">
									 <?php echo $hospital_details->phone;?>
                                </div>
                            </div>
                        </div>
						
						
						
			   			
                      
						
                    </div><!-- /.box-body -->
    
                  
             <?php form_close()?>
            </div><!-- /.box -->
        </div>
     </div>
</section>  
<script src="<?php echo site_url('assets/js/chosen.jquery.min.js')?>" type="text/javascript"></script>

<script src="<?php echo site_url('assets/js/jquery.datetimepicker.js')?>" type="text/javascript"></script>


<script src="<?php echo site_url('assets/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')?>" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
	
	$('.chzn').chosen();
	
});


$(function() {
	//bootstrap WYSIHTML5 - text editor
	$(".txtarea").wysihtml5();
});

 $(function() {
   $('.datetimepicker').datetimepicker({
	//mask:'9999-19-39 29:59',
	format  : 'Y-m-d h:i'
	
	}
	
	);
  });
</script>