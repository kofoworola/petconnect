<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css')?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function areyousure()
{
	return confirm('Are You Sure You Want Delete This Appointment');
}
</script>
<section class="content-header">
        <h1>
            <?php echo $page_title; ?>
            <small><?php echo lang('list');?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin')?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard');?></a></li>
            <li class="active"><?php echo lang('appointments');?> </li>
        </ol>
</section>

<section class="content">
  	  	 <div class="row" style="margin-bottom:10px;">
            <div class="col-xs-12">
              
            </div>    
        </div>	
        
  	  	<div class="row">
          <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo lang('view_all');?></h3>                                    
                </div><!-- /.box-header -->
				
                <div class="box-body table-responsive" style="margin-top:40px;">
                   <div class="box-body table-responsive" style="margin-top:40px;">
                    <table id="example1" class="table table-bordered table-striped">
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
									$val ='<a href="'.site_url('admin/appointments/approve/'.$new->id).'/1" class="btn btn-danger">'.lang('approve').'</a>';
								}else{
									$val ='<a href="'.site_url('admin/appointments/approve/'.$new->id).'/0" class="btn btn-success">'.lang('pending').'</a>';
								}
							?>
                                <tr class="gc_row">
                                   <td><?php echo date("d/m/Y h:i:a", strtotime($new->date))?></td>
                                   <td><?php echo $new->name?></td>
								   <td><?php echo $new->title?></td>
								   <td><?php echo $new->motive?></td>
								   <td><?php echo substr($new->notes, 0,50)?></td>
								   <td><?php echo $val?></td>
								   <td width="25%">
                                        <div class="btn-group">
										 <a class="btn btn-default" href="#view<?php echo @$new->id; ?>" data-toggle="modal" ><i class="fa fa-eye"></i> <?php echo lang('view');?></a>
										 <a class="btn btn-primary" href="#edit<?php echo @$new->id; ?>" data-toggle="modal"><i class="fa fa-eye"></i> <?php echo lang('edit');?></a>
                                         <a class="btn btn-danger" style="margin-left:20px;" href="<?php echo site_url('admin/appointments/delete/'.$new->id); ?>" onclick="return areyousure()"><i class="fa fa-trash"></i> <?php echo lang('delete');?></a>
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

<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
	$('#example1').dataTable({
	});
});

</script>