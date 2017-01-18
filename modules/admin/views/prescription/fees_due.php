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
            <li class="active"><?php echo lang('fees_due');?></li>
        </ol>
</section>

<section class="content">
<?php 
	$admin = $this->session->userdata('admin');
	if($admin['user_role']==1){
?>
  	  	 <div class="row" style="margin-bottom:10px;">
            <div class="col-xs-12">
                <div class="btn-group pull-right">
                    <a class="btn btn-default" href="<?php echo site_url('admin/prescription/add/'); ?>"><i class="fa fa-plus"></i> <?php echo lang('add_new');?></a>
                </div>
            </div>    
        </div>	
<?php } ?>		
        
  	  	<div class="row">
          <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo lang('fees_due');?></h3>                                    
                </div><!-- /.box-header -->
				
                <div class="box-body table-responsive" style="margin-top:40px;">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo lang('serial_number');?></th>
								<th><?php echo lang('name');?></th>
								
								<th width="22%"></th>
                            </tr>
                        </thead>
                        
                        <?php if(isset($prescriptions)):?>
                        <tbody>
                            <?php $i=1;foreach ($prescriptions as $new){?>
                                <tr class="gc_row">
                                    <td><?php echo $i?></td>
                                    <td><?php echo $new->patient?></td>
								    <td width="22%">
                                        <div class="btn-group">
                                          <a class="btn btn-info"  href="<?php echo site_url('admin/prescription/fees/'.$new->id); ?>"> <?php echo lang('fees');?></a>
										  <a class="btn btn-primary" style="margin-left:10px;"  href="<?php echo site_url('admin/prescription/view/'.$new->id); ?>"><i class="fa fa-eye"></i> <?php echo lang('view');?></a>
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
