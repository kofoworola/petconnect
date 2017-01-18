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
            <li class="active"><?php echo lang('appointments');?></li>
        </ol>
</section>

<section class="content">
  	  	     <div class="row" style="margin-bottom:10px;">
            <div class="col-xs-12">
                <div class="btn-group pull-right">
                    <a class="btn btn-default" href="<?php echo site_url('admin/book_appointment/add/'); ?>"><i class="fa fa-plus"></i> <?php echo lang('add');?></a>
                </div>
            </div>    
        </div>	
        
  	  	<div class="row">
          <div class="col-xs-12">
            <div class="box">
              
				<div class="box-body table-responsive">

		
					<div class="box-header">
                    <h3 class="box-title"><?php echo lang('my_appointments');?></h3>                                    
                </div>
					
						 <table id="example2" class="table table-bordered table-striped">
                         <thead>
                            <tr>
                                <th><?php echo lang('date');?></th>
								
								<th><?php echo lang('patient');?></th>
								<th><?php echo lang('title');?></th>
								<th><?php echo lang('motive');?></th>
								<th><?php echo lang('notes');?></th>
								<th><?php echo lang('status');?></th>
								<th width="20%"><?php echo lang('action');?></th>
                            </tr>
                        </thead>
                       
                        
                        <?php if(isset($appointments)):?>
                        <tbody>
                            <?php $i=1;foreach ($appointments as $new){
								
								if($new->status==0){
									$val ='<a href="#" class="btn btn-danger">'.lang('pending').'</a>';
								}else{
									$val ='<a href="#" class="btn btn-success">'.lang('approved').'</a>';
								}
							?>
						
                                <tr class="gc_row">
                                   <td><?php echo date("d/m/Y h:i:a", strtotime($new->date))?></td>
                                   <td><?php echo $new->patient?></td>
								   <td><?php echo $new->title?></td>
								   <td><?php echo $new->motive?></td>
								   <td><?php echo substr($new->notes, 0,50)?></td>
								   <td><?php echo $val?></td>	<td >
                                        <div class="btn-group">
                                       <a class="btn btn-default" href="#view<?php echo @$new->id; ?>" data-toggle="modal" ><i class="fa fa-eye"></i> <?php echo lang('view');?></a>
                                        </div>
                                    </td>
                                </tr>
                                <?php $i++;}?>
                        </tbody>
                        <?php endif;?>
                    </table>
                        </div>					
                   
					
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section>




<?php if(isset($appointments)):?>
<?php $i=1;
foreach ($appointments as $apps){

$app = $this->appointment_model->get_appointment_by_doctor_id($apps->id);
//echo '<pre>'; print_r($app);die;
?>
<!-- Modal -->
<div class="modal fade" id="view<?php echo $apps->id?>" tabindex="-1" role="dialog" aria-labelledby="viewlabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content ff">
      <div class="modal-header">
			
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="viewlabel"><?php echo lang('view');?> <?php echo lang('appointment')?></h4>
      </div>
      <div class="modal-body">
	  <form>
           		    <div class="box-body">
                        <div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"> <?php echo lang('title');?></label>
								</div>
								<div class="col-md-4">
									<?php echo $app->title; ?>
                                </div>
                            </div>
                        </div>
						
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"><?php echo lang('patient');?></label>
								</div>
								<div class="col-md-4">
									   <?php 
									 
									   foreach($contacts as $new) {
													if($new->id==$app->patient_id) echo $new->name;
												}
											?>
                                </div>
			                </div>
                        </div>
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"><?php echo lang('motive');?></label>
								</div>
								<div class="col-md-4">
									<?php echo $app->motive; ?>
                                </div>
                            </div>
                        </div>
						
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"><?php echo lang('date');?></label>
								</div>
								<div class="col-md-4">
									<?php echo $app->date; ?>
                                </div>
                            </div>
                        </div>
						
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-2">
                                    <label for="name" style="clear:both;"><?php echo lang('notes');?></label>
								</div>
								<div class="col-md-4">
									 <?php echo $app->notes; ?>
                                </div>
                            </div>
                        </div>
				
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



<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
	$('#example1').dataTable({
	});
});

$(function() {
	$('#example2').dataTable({
	});
});

</script>