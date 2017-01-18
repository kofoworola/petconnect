<link href="<?php echo base_url('assets/css/datepicker/datepicker3.css') ?>" rel="stylesheet" type="text/css" />
<style type="text/css">
    .custom,
    .custom div,
    .custom span {
        border-color: rgb(0, 115, 183);
        background-color: rgb(0, 115, 183);

        color: white;           /* text color */
    }
    .fc-event-time {
        display:none !important;
    }

    .custom1,
    .custom1 div,
    .custom1 span {
        border-color: rgb(245, 105, 84);
        background-color: rgb(245, 105, 84);
        color: white;           /* text color */
    }
</style>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Home
        <small>

        </small>

    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard'); ?></a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- Small boxes (Stat box) -->

    <?php
    $admin = $this->session->userdata('admin');
    $access = $admin['user_role'];
    ?>
    <?php if ($access == "Admin") {
        ?>				
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-blue">
                    <div class="inner">
                        <h3>
                            <?php echo count($businesses) ?>
                        </h3>
                        <p>
                            <?php echo lang('businesses'); ?>
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-briefcase"></i>
                    </div>
                    <a href="<?php echo site_url('admin/business') ?>" class="small-box-footer">
                        <?php echo lang('more_info') ?><i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>
                            <?php echo count($non_profits) ?>
                        </h3>
                        <p>
                            <?php echo lang('profits'); ?>
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <a href="<?php echo site_url('admin/non_profit') ?>" class="small-box-footer">
                        <?php echo lang('more_info') ?><i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua" style="background-color:#9593c6 !important">
                    <div class="inner">
                        <h3>
                            <?php echo count($clinics) ?>
                        </h3>
                        <p>
                            <?php echo lang('clinics'); ?>
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-stethoscope"></i>
                    </div>
                    <a href="<?php echo site_url('admin/veterinary_clinics') ?>" class="small-box-footer" style="background-color: #6461ab;">
                        <?php echo lang('more_info') ?><i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            
        </div>

    <?php } ?>

    <?php if ($access == 2) {
        ?>				
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>
                            <?php echo count($patient_precription) ?>
                        </h3>
                        <p>
                            <?php echo lang('my_prescription'); ?>
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-list"></i>
                    </div>
                    <a href="<?php echo site_url('admin/my_prescription') ?>" class="small-box-footer">
                        <?php echo lang('more_info') ?><i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div><!-- ./col -->

            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>
                            <?php echo count($patient_appointments) ?>
                        </h3>
                        <p>
                            <?php echo lang('appointments'); ?>
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-list"></i>
                    </div>
                    <a href="<?php echo site_url('admin/book_appointment') ?>" class="small-box-footer">
                        <?php echo lang('more_info') ?><i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div><!-- ./col -->

        </div>

    <?php
    }
    if ($access == 1) {
        ?>		
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-maroon">
                    <div class="inner">
                        <h3>
    <?php echo count($doctor_patients); ?>
                        </h3>
                        <p>
    <?php echo lang('patients'); ?>
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <a href="<?php echo site_url('admin/patients') ?>" class="small-box-footer">
    <?php echo lang('more_info'); ?>  <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>
    <?php echo count($hospital); ?>
                        </h3>
                        <p>
    <?php echo lang('hospital'); ?>
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-h-square"></i>
                    </div>
                    <a href="<?php echo site_url('admin/hospital/view_all') ?>" class="small-box-footer">
    <?php echo lang('more_info'); ?>  <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div><!-- ./col -->
            <section class="col-lg-6 connectedSortable ui-sortable">	
                <div class="box box-primary ">
                    <div class="box-header ui-sortable-handle" style="cursor: move;">
                        <i class="ion ion-clipboard"></i>
                        <h3 class="box-title"><?php echo lang('todays_appointments'); ?></h3>
                        <div class="box-tools pull-right">

                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <ul class="todo-list ui-sortable">
                            <?php
                            if (isset($appointments)):
                                ?>
                                <?php
                                $i = 1;
                                foreach ($appointments as $new) {
                                    $with = "";
                                    if (($new->whom == 1)) {
                                        $with = $new->name;
                                    }
                                    if (($new->whom == 2)) {
                                        $with = $new->contact;
                                    }
                                    if (($new->whom == 3)) {
                                        $with = $new->other;
                                    }
                                    ?>
                                    <li>
                                        <!-- drag handle -->
                                        <span class="handle ui-sortable-handle">
                                            <i class="fa fa-ellipsis-v"></i>
                                            <i class="fa fa-ellipsis-v"></i>
                                        </span>
                                        <!-- todo text -->
                                        <span class="text"><a href="<?php echo site_url('admin/appointments/view_appointment/' . $new->id); ?>"><?php echo date("h:i:a", strtotime($new->date)) . " - " . $with; ?> </a></span>
                                        <!-- Emphasis label -->

                                        <!-- General tools such as edit or delete-->
                                        <div class="tools">
                                            <i class="fa fa-eye"></i>

                                        </div>
                                    </li>
                                    <?php $i++;
                                }
                                ?>
    <?php endif; ?>	
                        </ul>
                    </div><!-- /.box-body -->
                    <div class="box-footer clearfix no-border">
                        <button class="btn btn-default pull-right"><a href="<?php echo site_url('admin/appointments'); ?>"><i class="fa fa-plus"></i> <?php echo lang('view_all'); ?></a></button>
                    </div>
                </div>		
            </section>


        </div>
        <div class="row">	
            <section class="col-lg-6 connectedSortable">


                <!-- Custom tabs (Charts with tabs)-->
                <div class="nav-tabs-custom">
                    <!-- Tabs within a box -->
                    <ul class="nav nav-tabs pull-right">
                        <li class="pull-left header"><i class="fa fa-inbox"></i> <?php echo lang('patient_graph') ?></li>
                    </ul>
                    <div class="chart tab-pane" id="p-chart" style="position: relative; height: 300px;"></div>

                </div><!-- /.nav-tabs-custom -->

            </section>
            <section class="col-lg-6 connectedSortable ui-sortable">	
                    <div class="box box-primary ">
                        <div class="box-header ui-sortable-handle" style="cursor: move;">
                            <i class="fa fa-tasks"></i>
                            <h3 class="box-title"><?php echo lang('todays_to_do'); ?></h3>
                            <div class="box-tools pull-right">

                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <ul class="todo-list ui-sortable">
                                <?php if (isset($to_do)): ?>
        <?php $i = 1;
        foreach ($to_do as $new) {
            ?>
                                        <li>
                                            <!-- drag handle -->
                                            <span class="handle ui-sortable-handle">
                                                <i class="fa fa-ellipsis-v"></i>
                                                <i class="fa fa-ellipsis-v"></i>
                                            </span>
                                            <!-- todo text -->
                                            <span class="text"><a href="<?php echo site_url('admin/to_do_list/view_to_do/' . $new->id); ?>"><?php echo $new->title; ?> on <?php echo date("h:i:a", strtotime($new->date)); ?>    </a></span>
                                            <!-- Emphasis label -->

                                            <!-- General tools such as edit or delete-->
                                            <div class="tools">
                                                <i class="fa fa-eye"></i>

                                            </div>
                                        </li>
            <?php $i++;
        }
        ?>
    <?php endif; ?>	
                            </ul>
                        </div><!-- /.box-body -->
                        <div class="box-footer clearfix no-border">
                            <button class="btn btn-default pull-right"><a href="<?php echo site_url('admin/to_do_list/'); ?>"><i class="fa fa-plus"></i> <?php echo lang('view_all'); ?></a></button>
                        </div>
                    </div>
                </section>



<?php } if ($access == 3) { ?>		
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>
    <?php echo count($doctor_contacts) ?>
                            </h3>
                            <p>
    <?php echo lang('contacts'); ?>
                            </p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-group"></i>
                        </div>
                        <a href="<?php echo site_url('admin/contacts') ?>" class="small-box-footer">
    <?php echo lang('more_info'); ?> <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div><!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>
    <?php echo count($doctor_patients); ?>
                            </h3>
                            <p>
    <?php echo lang('patients'); ?>
                            </p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <a href="<?php echo site_url('admin/patients') ?>" class="small-box-footer">
            <?php echo lang('more_info'); ?>  <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div><!-- ./col -->
            </div>
<?php } ?>
</section><!-- /.content -->	
<?php
//echo $date6->count;die;
//echo '<pre>';print_r($months);die;
/*
  $graph_arr = array();
  foreach($months as $ind => $month) {
  $graph_arr[$ind]['date'] = date("Y-m-d", strtotime($month->add_date));
  $graph_arr[$ind]['patients'] = (empty($month->count))?0:$month->count;
  }

  //echo '<pre>';print_r($graph_arr);die;
 */
?>


<!-- Morris.js charts -->
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="<?php echo base_url('assets/js/plugins/morris/morris.min.js') ?>" type="text/javascript"></script>
<!-- Sparkline -->
<script src="<?php echo base_url('assets/js/plugins/sparkline/jquery.sparkline.min.js') ?>" type="text/javascript"></script>
<!-- jvectormap -->
<script src="<?php echo base_url('assets/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') ?>" type="text/javascript"></script>
<!-- fullCalendar -->
<script src="<?php echo base_url('assets/js/moment.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/fullcalendar.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datepicker/bootstrap-datepicker.js') ?>" type="text/javascript"></script>

<!-- jQuery Knob Chart -->
<script src="<?php echo base_url('assets/js/plugins/jqueryKnob/jquery.knob.js') ?>" type="text/javascript"></script>
<!-- daterangepicker -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php //echo base_url('assets/js/AdminLTE/dashboard.js')  ?>" type="text/javascript"></script>  
<script src="<?php echo base_url('assets/js/raphael-min.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/morris.min.js') ?>" type="text/javascript"></script>

<script>
    $(function () {
        $("#calendar").datepicker().datepicker("setDate", "0");    // Here the current date is set
    });

    var line = new Morris.Line({
        element: 'p-chart',
        resize: true,
        data: [

            {patients: '<?php echo (empty($date6->count)) ? 0 : $date6->count; ?>', date: '<?php echo date('Y-m-d', strtotime("-6 days")); ?>'},
            {patients: '<?php echo (empty($date5->count)) ? 0 : $date5->count; ?>', date: '<?php echo date('Y-m-d', strtotime("-5 days")); ?>'},
            {patients: '<?php echo (empty($date4->count)) ? 0 : $date4->count; ?>', date: '<?php echo date('Y-m-d', strtotime("-4 days")); ?>'},
            {patients: '<?php echo (empty($date3->count)) ? 0 : $date3->count; ?>', date: '<?php echo date('Y-m-d', strtotime("-3 days")); ?>'},
            {patients: '<?php echo (empty($date2->count)) ? 0 : $date2->count; ?>', date: '<?php echo date('Y-m-d', strtotime("-2 days")); ?>'},
            {patients: '<?php echo (empty($date1->count)) ? 0 : $date1->count; ?>', date: '<?php echo date('Y-m-d', strtotime("-1 days")); ?>'},
            {patients: '<?php echo (empty($date->count)) ? 0 : $date->count; ?>', date: '<?php echo date('Y-m-d'); ?>'},
        ],
        xkey: 'date',
        ykeys: ['patients'],
        labels: ['Patients'],
        lineColors: ['#3c8dbc'],
        hideHover: 'auto',
        parseTime: false,
        xLabelAngle: 45,

    });

</script>