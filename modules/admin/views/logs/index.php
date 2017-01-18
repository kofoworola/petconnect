<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/chosen.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/jquery.datetimepicker.css') ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    function areyousure()
    {
        return confirm('Are You Sure');
    }
</script>
<style>
    .chosen-container{width:100% !important}
</style>
<section class="content-header">
    <h1>
        <?php echo $page_title; ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard') ?></a></li>
        <li class="active"><?php echo lang('patients') ?></li>
    </ol>
</section>
<section class="content">
    <div class="row no-print">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo lang('logs'); ?></h3>                                    
                </div><!-- /.box-header -->

                <div class="col-md-4"  style="float:right">
                    <form method="post">
                        <div class="col-xs-5">
                            <input type="text" name="date" class="form-control datepicker date" value="<?php echo date('Y-m-d')?>">
                        </div>
                        <div class="col-xs-2">
                            <input type="submit" name="ok" value="<?php echo lang('search'); ?>" class="btn btn-default" />
                        </div>
                    </form>		
                    <div class="btn-group pull-right">
                        <?php if (isset($search)) { ?>
                            <a class="btn btn-danger" style="margin-left:12px;" href="<?php echo site_url('admin/payment_history/export/' . $search); ?>"><i class="fa fa-download"></i> <?php echo lang('export') ?></a>
                        <?php } else { ?>
                            <a class="btn btn-danger" style="margin-left:12px;" href="<?php echo site_url('admin/payment_history/export/'); ?>"><i class="fa fa-download"></i> <?php echo lang('export') ?></a>
                        <?php } ?>
                    </div>
                </div>
                <div class="box-body" style="padding-top: 50px">
                    <p style="font-weight: bold"><?php echo nl2br($text)?></p>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="<?php echo base_url('assets/js/chosen.jquery.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/jquery.datetimepicker.js') ?>" type="text/javascript"></script>
<script type="text/javascript">
    jQuery('.datepicker').datetimepicker({
        lang: 'en',
        i18n: {
            de: {
                months: [
                    'Januar', 'Februar', 'M�rz', 'April',
                    'Mai', 'Juni', 'Juli', 'August',
                    'September', 'Oktober', 'November', 'Dezember',
                ],
                dayOfWeek: [
                    "So.", "Mo", "Di", "Mi",
                    "Do", "Fr", "Sa.",
                ]
            }
        },
        timepicker: false,
        format: 'Y-m-d'
    });
</script>
