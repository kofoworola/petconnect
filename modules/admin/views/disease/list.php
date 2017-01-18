<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css')?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function areyousure()
{
	return confirm('<?php echo lang('are_you_sure');?>');
}
</script>
<section class="content-header">
        <h1>
            <?php echo $page_title; ?>
            <small><?php echo lang('list');?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin')?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard');?></a></li>
            <li class="active"><?php echo lang('disease');?></li>
        </ol>
</section>

<section class="content">
  	  	 <div class="row" style="margin-bottom:10px;">
            <div class="col-xs-12">
                <div class="btn-group pull-right">
                    <a class="btn btn-default" href="#add" data-toggle="modal"><i class="fa fa-plus"></i> <?php echo lang('add_new');?></a>
                </div>
            </div>    
        </div>	
        
  	  	<div class="row">
          <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo lang('disease');?></h3>                                    
                </div><!-- /.box-header -->
				
                <div class="box-body table-responsive" style="margin-top:40px;">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo lang('serial_number');?></th>
								<th><?php echo lang('name');?></th>
								<th width="25%"></th>
                            </tr>
                        </thead>
                        
                        <?php if(isset($diseases)):?>
                        <tbody>
                            <?php $i=1;foreach ($diseases as $new){?>
                                <tr class="gc_row">
                                    <td><?php echo $i?></td>
                                    <td><?php echo $new->name?></td>
                                    <td>
                                        <div class="btn-group">
              							<a class="btn btn-default"  href="#view<?php echo $new->id; ?>" data-toggle="modal"><i class="fa fa-edit"></i> <?php echo lang('view');?></a>				
			                              <a class="btn btn-primary"  href="#edit<?php echo $new->id; ?>" data-toggle="modal"><i class="fa fa-edit"></i> <?php echo lang('edit');?></a>
                                         <a class="btn btn-danger"  href="<?php echo site_url('admin/disease/delete/'.$new->id); ?>" onclick="return areyousure()"><i class="fa fa-trash"></i> <?php echo lang('delete');?></a>
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





<?php if(isset($diseases)):?>
<?php $i=1;
foreach ($diseases as $new){
$disease = $this->disease_model->get_disease_by_id($new->id);
?>
<!-- Modal -->
<div class="modal fade" id="edit<?php echo $new->id?>" tabindex="-1" role="dialog" aria-labelledby="editlabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content ff">
      <div class="modal-header">
			
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="editlabel"><?php echo lang('edit');?> <?php echo lang('disease')?></h4>
      </div>
      <div class="modal-body">
             <div id="err_edit<?php echo $disease->id;?>">  
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
		   <?php echo form_open_multipart('admin/disease/edit/'.$disease->id); ?>
                 <input type="hidden" name="id" value="<?php echo $disease->id?>" />
				    <div class="box-body">
                         <div class="form-group">
                        	<div class="row">
                                <div class="col-md-4">
                                    <label for="name" style="clear:both;"> <?php echo lang('name');?></label>
									<input type="text" name="name" value="<?php echo set_value('name') . $disease->name?>" class="form-control name">
                                </div>
                            </div>
                        </div>
						
						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-4">
                                    <label for="name" style="clear:both;"> <?php echo lang('description');?></label>
									<textarea name="description" class="form-control description"><?php echo set_value('description'). $disease->description?></textarea>
                                </div>
                            </div>
                        </div>
						
						
                    </div><!-- /.box-body -->
    
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary update"><?php echo lang('update');?></button>
                    </div>

	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close')?></button>  
      </div>
    </div>
  </div>
</div>
</form>
 <?php $i++;}?>
<?php endif;?>




<?php if(isset($diseases)):?>
<?php $i=1;
foreach ($diseases as $new){
$disease = $this->disease_model->get_disease_by_id($new->id);
?>
<!-- Modal -->
<div class="modal fade" id="view<?php echo $new->id?>" tabindex="-1" role="dialog" aria-labelledby="editlabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content ff">
      <div class="modal-header">
			
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="editlabel"><?php echo lang('view');?> <?php echo lang('disease')?></h4>
      </div>
      <div class="modal-body">
                    <div class="box-body">
                         <div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('name');?></label>
								</div>
								<div class="col-md-6">
										<?php echo $disease->name?>
                                </div>
                            </div>
                        </div>
						
						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('description');?></label>
								</div>
								<div class="col-md-6">
									<?php echo $disease->description?>
                                </div>
                            </div>
                        </div>
						
						
                    </div><!-- /.box-body -->

	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close')?></button>  
      </div>
    </div>
  </div>
</div>
</form>
 <?php $i++;}?>
<?php endif;?>





<!-- Modal -->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="editlabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content ff">
      <div class="modal-header">
			
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="editlabel"><?php echo lang('add');?> <?php echo lang('disease')?></h4>
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
				 <form method="post" id="add_form">
				    <div class="box-body">
                        <div class="form-group">
                        	<div class="row">
                                <div class="col-md-4">
                                    <label for="name" style="clear:both;"> <?php echo lang('name');?></label>
									<input type="text" name="name" value="<?php echo set_value('name')?>" class="form-control name">
                                </div>
                            </div>
                        </div>
						
						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-4">
                                    <label for="name" style="clear:both;"> <?php echo lang('description');?></label>
									<textarea name="description" class="form-control description"><?php echo set_value('description')?></textarea>
                                </div>
                            </div>
                        </div>
						
			   			
                      
						
                    </div><!-- /.box-body -->
    
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary"><?php echo lang('save');?></button>
                    </div>
	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close')?></button>  
      </div>
    </div>
  </div>
</div>
</form>







<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
	$('#example1').dataTable({
	});
});


$( "#add_form" ).submit(function( event ) {
	var form = $(this).closest('form');
	name = $(form ).find('.name').val();
	description = $(form ).find('.description').val();
	call_loader_ajax();
	$.ajax({
		url: '<?php echo site_url('admin/disease/add/') ?>',
		type:'POST',
		data:{name:name,description:description},
		
		success:function(result){
		//alert(result);return false;
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
	name = $(form ).find('.name').val();
	description = $(form ).find('.description').val();
	
	//alert(date_time);return false;
	call_loader_ajax();
	$.ajax({
		url: '<?php echo site_url('admin/disease/edit') ?>/' + id,
		type:'POST',
		data:{name:name,description:description},
		
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
		  
		 }
	  });
	
	
});

</script>