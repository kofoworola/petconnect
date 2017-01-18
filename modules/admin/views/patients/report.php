
<!-- Content Header (Page header) -->
<style>
.row{
	margin-bottom:10px;
}
</style>
 <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Report
        <small><?php echo lang('view')?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin')?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
        <li><a href="<?php echo site_url('admin/patients')?>"><?php echo lang('patients')?></a></li>
        <li class="active"><?php echo lang('report')?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <form method="post">
                    <div class="box-body">
                        <div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
                                    <label for="name" style="clear:both;"><?php echo lang('date')?></label>
								</div>
								 <div class="col-md-4">	
									<?php echo date("d/m/y h:i", strtotime($report->date_time))?>
                                </div>
                            </div>
                        </div>
						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
                                    <label for="name" style="clear:both;"><?php echo lang('type')?></label>
								</div>
								 <div class="col-md-4">	
									<?php echo $report->type?>
                                </div>
                            </div>
                        </div>
						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
                                    <label for="name" style="clear:both;"><?php echo lang('remark')?></label>
								</div>
								 <div class="col-md-4">	
									<?php echo $report->remark?>
                                </div>
                            </div>
                        </div>
						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
                                    <label for="name" style="clear:both;"><?php echo lang('from')?></label>
								</div>
								 <div class="col-md-4">	
									<?php echo $report->from_user?>
                                </div>
                            </div>
                        </div>
						
						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-12">
                                    <label for="name" style="clear:both;">Report</label>
									 <iframe src="http://docs.google.com/gview?url=<?php echo base_url('./assets/uploads/files/'.$report->file)?>?&embedded=true" style="width:100%; height:500px;" frameborder="0"></iframe>
                                </div>
                            </div>
                        </div>
						
				
                    </div><!-- /.box-body -->
    
                   
             <?php form_close()?>
            </div><!-- /.box -->
        </div>
     </div>
</section>  

<script src="<?php echo base_url('assets/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')?>" type="text/javascript"></script>
<script type="text/javascript">
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