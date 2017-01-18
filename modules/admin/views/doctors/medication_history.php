<link href="<?php echo base_url('assets/css/chosen.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/jquery.datetimepicker.css')?>" rel="stylesheet" type="text/css" />
<!-- Content Header (Page header) -->
<script type="text/javascript">
function areyousure()
{
	return confirm('<?php echo lang('are_you_sure')?>');
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
       <?php echo lang('medication_history')?>
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin')?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
        <li><a href="<?php echo site_url('admin/patients')?>"><?php echo lang('patients')?></a></li>
        <li class="active"><?php echo lang('medication_history')?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
<?php 
	if(validation_errors()){
?>
<div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
                                        <b><?php echo lang('alert')?>!</b><?php echo validation_errors(); ?>
                                    </div>

<?php  } ?>
                <!-- form start -->
				    <div class="box-body">
                 <div class="box-body table-responsive" style="margin-top:40px;">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo lang('serial_number');?></th>
								<th><?php echo lang('name');?></th>
								
								<th width="20%"></th>
                            </tr>
                        </thead>
                        
                        <?php if(isset($prescriptions)):?>
                        <tbody>
                            <?php $i=1;foreach ($prescriptions as $new){?>
                                <tr class="gc_row">
                                    <td><?php echo $i?></td>
                                    <td><?php echo $new->patient?></td>
								    <td width="33%">
                                        <div class="btn-group">
                                          <a class="btn btn-info"  href="<?php echo site_url('admin/prescription/fees/'.$new->id); ?>"> <?php echo lang('fees');?></a>
										  <a class="btn btn-primary" style="margin-left:10px;"  href="<?php echo site_url('admin/prescription/reports/'.$new->id); ?>"><i class="fa fa-file"></i> <?php echo lang('reports');?></a>
										  <a class="btn btn-primary" style="margin-left:10px;"  href="<?php echo site_url('admin/prescription/view/'.$new->id); ?>"><i class="fa fa-eye"></i> <?php echo lang('view');?></a>
										</div>
                                    </td>
                                </tr>
                                <?php $i++;}?>
                        </tbody>
                        <?php endif;?>
                    </table>
			    </div><!-- /.box-body -->
             </form>
            </div><!-- /.box -->
        </div>
     </div>
</section>  


<script src="<?php echo base_url('assets/js/jquery.datetimepicker.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>

<script src="<?php echo base_url('assets/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')?>" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
	$('#example1').dataTable({
	});
});

  jQuery('.datepicker').datetimepicker({
 lang:'en',
 i18n:{
  de:{
   months:[
    'Januar','Februar','März','April',
    'Mai','Juni','Juli','August',
    'September','Oktober','November','Dezember',
   ],
   dayOfWeek:[
    "So.", "Mo", "Di", "Mi", 
    "Do", "Fr", "Sa.",
   ]
  }
 },
 timepicker:false,
 format:'Y-m-d'
});
  
  
 $(document).on('blur', '#amount', function(){

 			var value1 = parseInt($('#inr').val());
            var value2 = parseInt($('#bal').val(), 10) || 0;
			var value3 = parseInt($('#amount').val());
			
			var bal = value2 - value1;
			if(bal > value3){
				alert("Current Filled Amount Is Greather Then Balance");
			 return false;
			}

});
 
</script>
