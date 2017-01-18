
<link href="<?php echo site_url('assets/css/datatables/dataTables.bootstrap.css')?>" rel="stylesheet" type="text/css" />


<style>
td{
text-transform:capitalize;
}
.chosen-container {width:60% !important; }

#not-active {
   pointer-events: none;
   cursor: default;
   
}
</style>
<section class="content-header">
    <h1>
        <?php echo lang('schedule');?>
        <small><?php echo lang('edit');?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin')?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard');?></a></li>
        <li><a href="<?php echo site_url('admin/schedule')?>"><?php echo lang('schedule');?></a></li>
        <li class="active"><?php echo lang('specific_schedule');?></li>
    </ol>
</section

><section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title"><?php echo lang('specific_schedule');?></h3><div style="float:right; margin-right:10px;"><br/><a href="<?php echo site_url('admin/schedule/other_schedule/');?>"><button class="btn btn-success"><?php echo lang('add');?> </button></a></div>
                                </div><!-- /.box-header -->
                              
		<div class="box-body table-responsive" style="margin-top:40px;">
                <table id="example1" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th><?php echo lang('serial_number');?></th>
						<th><?php echo lang('hospital');?></th>
						<th><?php echo lang('work');?></th>
						<th><?php echo lang('date');?></th>
						<th><?php echo lang('timing');?></th>
						<th><?php echo lang('action');?></th>
					</tr>
				</thead>
				
			<tbody>
			 <?php   $i=1;// echo '<pre>' ;print_r($specific_schedule); die;
			  foreach($specific_schedule as $data1){ ?>  
			
			<tr >
			<td ><?php echo $i.'.'; ?> </td>
			<td ><?php echo $data1->name; ?></td>
			<td ><?php echo $data1->work; ?></td>
			<td ><?php echo $data1->dates;?> </td>
			<td ><?php echo date("g:i a", strtotime("$data1->timing_from")); echo '-';echo date("g:i a", strtotime("$data1->timing_to")); echo '<br/>';?> </td>
			<td >
			<a href="<?php echo site_url('admin/schedule/delete_specific_schedule/'.$data1->id);?>" onclick="return confirm('ARE YOU SURE?')">
					<button class="btn btn-danger" > <i class="glyphicon glyphicon-trash" ></i></button></a>
				<a href="<?php echo site_url('admin/schedule/edit_specific_schedule/'.$data1->id);?>" onclick="return confirm('ARE YOU SURE?')"> 
				<button class="btn btn-success"> <i class="glyphicon glyphicon-pencil" ></i></button></a></td>
			</tr>
			<?php $i++; }?>
			</tbody>
			</table>
			
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section>

<script src="<?php echo site_url('assets/js/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/js/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
	$('#example1').dataTable({
	});
});

</script>