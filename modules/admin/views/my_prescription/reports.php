<link href="<?php echo base_url('assets/css/chosen.css')?>" rel="stylesheet" type="text/css" />
<!-- Content Header (Page header) -->
<style>
.row{
	margin-bottom:10px;
}


</style>
 <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo lang('prescription');?>
        <small><?php echo lang('reports');?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin')?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard');?></a></li>
        <li><a href="<?php echo site_url('admin/prescription')?>"> <?php echo lang('prescription');?></a></li>
        <li class="active"><?php echo lang('reports');?></li>
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
                    <h3 class="box-title"><?php echo lang('reports_for');?> : <?php echo $prescription->patient?> </h3>
                </div><!-- /.box-header -->
                <!-- form start -->
				
				<?php echo form_open_multipart('admin/prescription/reports/'.$id); ?>
                    <div class="box-body">
                        <div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('upload_file');?></label>
								</div>	
								
								<div class="col-md-3">
									<input type="file" name="file" class="form-control" />
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
				
				<div class="box-body chat" id="chat-box">
                                    <!-- chat item -->
							<?php $admin = $this->session->userdata('admin'); ?>		
							<?php if(isset($reports)):?>		
							 <?php $i=1;foreach ($reports as $new){?>		
                                    <div class="item">
									<?php 
										if(empty($new->image)){
									?>
                                        <img src="<?php echo base_url('assets/uploads/images/avatar5.png')?>" alt="user image" class="online"/>
									<?php }else{ ?>
									 <img src="<?php echo base_url('assets/uploads/images/'.$new->image)?>" alt="user image" class="online"/>
									<?php }?>	
									
									
									
                                    <p class="message" style="padding-top:12px;">
                                            <a href="#" class="name">
                                                <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> <?php echo $new->date_time ?></small>
                                        <?php if($new->from_id== $admin['id']){?>     
											
										<span style="color:#FF0000">	 <?php echo $new->from_user ?></span> 
									<?php }else	{ echo $new->from_user ;
									}?>	 
                                            </a>
									<?php if(!empty($new->file)){?>		
                            			<b><?php echo lang('file')?>	</b> : <a href="<?php echo site_url('assets/uploads/files/'.$new->file)?>" class="btn btn-danger"  download>Download</a><br />
									<?php }?>		
            						<div style="margin-top:20px;">	
                                 		 <b><?php echo lang('remark')?></b>  :  <?php echo $new->remark ?> 
									</div>	 
									    </p>
                                    </div><!-- /.item -->
									
								<hr />	
        				   <?php $i++;}?>
                        <?php endif;?> 
		                             
                                </div><!-- /.chat -->
                               
                            </div><!-- /.box (chat box) -->
						
						    
								
				 </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
     </div>
</section>  