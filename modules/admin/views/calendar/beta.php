<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<link href="<?php echo base_url('assets/css/jquery.datetimepicker.css') ?>" rel="stylesheet" type="text/css" />
<link rel='stylesheet' href='<?php echo base_url('assets/fullcalendar/fullcalendar.css'); ?>' />
<script src='<?php echo base_url('assets/fullcalendar/lib/jquery.min.js') ?>'></script>
<script src='<?php echo base_url('assets/fullcalendar/lib/moment.min.js') ?>'></script>
<script src='<?php echo base_url('assets/fullcalendar/fullcalendar.js') ?>'></script>
<script src="<?php echo base_url('assets/js/chosen.jquery.min.js') ?>" type="text/javascript"></script>

<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo base_url('assets/js/') ?>/custom.js" type="text/javascript"></script>   

<script type="text/javascript">
    $(document).ready(function () {

        $('#calendar').fullCalendar({
        header: {
        left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay,listWeek'
        },
                events: [
<?php
if (isset($appointments)) {
    foreach ($appointments as $appointment) {
        ?>
                        {
                        id:'<?php echo $appointment->id ?>',
                                title:'Appointment "<?php echo $appointment->title ?>',
                                start:'<?php echo $appointment->date ?>'
                        },
    <?php }
}
?>
                ]
        });

    });
</script>

<section class="content-header">
    <h1>
<?php echo $page_title; ?>

    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard') ?></a></li>
        <li class="active"><?php echo lang('event_calendar') ?></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="box-primary">
            <div style="padding: 10px 10px;">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</section>