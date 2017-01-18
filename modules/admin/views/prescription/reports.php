<link href="<?php echo base_url('assets/css/chosen.css')?>" rel="stylesheet" type="text/css" />
<!-- Content Header (Page header) -->
<script type="text/javascript">
function areyousure()
{
	return confirm('<?php echo lang('are_you_sure');?>');
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
                                    <label for="name" style="clear:both;"> <?php echo lang('type');?></label>
								</div>	
								
								<div class="col-md-3">
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
                        
                        <?php  if(isset($reports)):?>
                        <tbody>
                            <?php $i=1;foreach ($reports as $prescription){?>
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
									     <a class="btn btn-danger" style="margin-left:10px;" href="<?php echo site_url('admin/prescription/delete_report/'.$prescription->id); ?>" onclick="return areyousure()"><i class="fa fa-trash"></i> <?php echo lang('delete');?></a>
                                        </div>
                                    </td>
                                </tr>
                                <?php $i++;}?>
                        </tbody>
                        <?php endif;?>
                    </table>
		                             
                                </div><!-- /.chat -->
                               
                            </div><!-- /.box (chat box) -->
						
						    
								
				 </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
     </div>
</section>  
<script src="<?php echo base_url('assets/js/chosen.jquery.min.js')?>" type="text/javascript"></script>
<script>
$(function() {
	
	$('.chzn').chosen({search_contains:true});
	
});  
</script>
