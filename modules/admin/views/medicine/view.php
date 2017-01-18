<link href="<?php echo site_url('assets/css/chosen.css')?>" rel="stylesheet" type="text/css" />
<!-- Content Header (Page header) -->
<style>
.row{
	margin-bottom:10px;
}
</style>
 <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
       <?php echo lang('medicine');?>
        <small><?php echo lang('view');?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin/dashboard')?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard');?></a></li>
        <li><a href="<?php echo site_url('admin/medicine')?>"> <?php echo lang('medicine');?></a></li>
        <li class="active"> <?php echo lang('view');?></li>
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
				
				<?php echo form_open_multipart('admin/medicine/edit/'.$id); ?>
                    <div class="box-body">
                        <div class="box-body">
                         <div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('name');?></label>
								</div>	
								 <div class="col-md-4">
							<?php echo  $medicine->name?>
                                </div>
                            </div>
                        </div>
						
						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('medicine_category');?></label>
								</div>	
								 <div class="col-md-4">	
											<?php foreach($category as $new) {
													if($new->id==$medicine->category_id) echo $new->name;
												}
												
											?>
							    </div>
                            </div>
                        </div>
						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('manufacturing_company');?></label>
								</div>	
								 <div class="col-md-4">	
											<?php foreach($company as $new) {
													if($new->id==$medicine->company_id) echo $new->name;
												}
												
											?>
								</div>
                            </div>
                        </div>
						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('price');?></label>
								</div>	
								 <div class="col-md-4">	
								<?php echo $medicine->price?>
                                </div>
                            </div>
                        </div>
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('description');?></label>
								</div>	
								 <div class="col-md-4">	
								<?php echo $medicine->description?>
                                </div>
                            </div>
                        </div>
						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('status');?></label>
								</div>	
								 <div class="col-md-4">	
									<input type="checkbox" name="status" disabled="disabled" value="1" <?php echo ($medicine->status==1)?'checked="checked"' : '' ?> class="form-control">
                                </div>
                            </div>
                        </div>
				
					<?php 
					$admin = $this->session->userdata('admin');
					if($admin['user_role']=="Admin"){
				?>			
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('doctor');?></label>
								</div>	
								 <div class="col-md-4">	
											<?php foreach($doctors as $new) {
													if($new->id==$medicine->doctor_id) echo $new->name;	
												}
											?>	
								   </div>
                            </div>
                        </div>
					<?php } ?>	
			   			
                     	
                    </div><!-- /.box-body -->
    
             <?php form_close()?>
            </div><!-- /.box -->
        </div>
     </div>
</section>  
<script src="<?php echo site_url('assets/js/chosen.jquery.min.js')?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/js/bootstrap-datepicker.js')?>" type="text/javascript"></script>


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
    $( "#datepicker" ).pickmeup({
    format  : 'Y-m-d'
});
  });
</script>