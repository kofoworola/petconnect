<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<link href="<?php echo base_url('assets/css/jquery.datetimepicker.css') ?>" rel="stylesheet" type="text/css" />
<link rel='stylesheet' href='<?php echo base_url('assets/fullcalendar/fullcalendar.css'); ?>' />
<script src='<?php echo base_url('assets/fullcalendar/lib/jquery.min.js') ?>'></script>
<script src='<?php echo base_url('assets/fullcalendar/lib/moment.min.js') ?>'></script>
<script src='<?php echo base_url('assets/fullcalendar/fullcalendar.js') ?>'></script>
<script src="<?php echo base_url('assets/js/chosen.jquery.min.js') ?>" type="text/javascript"></script>

<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo base_url('assets/js/') ?>/custom.js" type="text/javascript"></script>   

<style>
    #calendar{
        max-width: 1000px;
        margin: 0 auto;
    }
</style>

<script type="text/javascript">
    $(document).ready(function () {

    $('#calendar').fullCalendar({
    header: {
    left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay,listWeek'
    },
            navLinks: true,
            editable: true,
            eventLimit: true,
            eventDrop: function (event, delta, revertFunc) {

            if (!confirm("Are you sure about this change?")) {
            revertFunc();
            } else
            {
                $("#status").text('Loading...');
                $.post('<?php echo site_url('admin/calendar_beta/move_event') ?>/' + event.id, {date: event.start.format()}, function (data) {
                    if (data === '1')
                    {
                        $("#status").text('Moved Sucessfully');
                    }
                    else
                    {
                        $("#status").text('Failed');
                    }
                });
            }
            },
            events: [
<?php
if (isset($appointments)) {
    foreach ($appointments as $appointment) {
        ?>
                    {
                    id: 'A-<?php echo $appointment->id ?>',
                            title: 'Appointment: "<?php echo $appointment->title ?>',
                            start: '<?php echo $appointment->date ?>'
                    },
        <?php
    }
}
?>
<?php
if (isset($todos)) {
    foreach ($todos as $todo) {
        ?>
                    {
                    id: 'T-<?php echo $todo->id ?>',
                            title: 'Todo: "<?php echo $todo->title ?>',
                            start: '<?php echo $todo->date ?>'
                    },
        <?php
    }
}
?>
            ]
    }
    );
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
        <div class="col-md-4">
            <p id="status"></p>
        </div>
    </div>
    <div class="row">
        <div class="box-primary">
            <div style="padding: 10px 10px;">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</section>