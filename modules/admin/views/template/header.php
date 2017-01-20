<?php
$CI = get_instance();
$CI->load->model('setting_model');
$CI->load->model('notification_model');
$CI->load->model('message_model');
$CI->load->model('language_model');
$CI->load->model('prescription_model');

$admin = $this->session->userdata('admin');
$id = $admin['id'];
$user_type = $admin['user_type'];
$access = $admin['user_role'];
$rules_string = $CI->db->query("select rules from users where id = '" . $id . "'")->row()->rules;
$rules = explode(',', $rules_string);
$setting = $CI->setting_model->get_setting();
$user = $CI->setting_model->get_user();
$client_setting = $CI->setting_model->get_notification_setting_client();
$notification = $CI->notification_model->get_setting();
$to_do_alert = $CI->setting_model->get_to_do_alert();
//print_r($to_do_alert);die();
$appointment_alert = $CI->setting_model->get_appointment_alert();
$admin_messages = $this->message_model->get_message_count_by_id();
$user_messages = $this->message_model->get_user_message_count_by_id();
$langs = $this->language_model->get_all();
$reports = $this->prescription_model->get_reports_notification();
$fees = $this->prescription_model->get_fees_due();
$appointment_alert_patient = $CI->setting_model->get_appointment_alert_patient();
$template = $CI->notification_model->get_template();
//echo '<pre>'; print_r($appointment_alert);die;

$first = $this->uri->segment(1);
$second = $this->uri->segment(2);
$third = $this->uri->segment(3);
$fourth = $this->uri->segment(4);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" /> 

        <title><?php echo @$setting->name; ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="<?php echo base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="<?php echo base_url('assets/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="<?php echo base_url('assets/css/ionicons.min.css') ?>" rel="stylesheet" type="text/css" />
        <!-- Morris chart -->
        <link href="<?php echo base_url('assets/css/morris/morris.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/css/pickmeup.min.css') ?>" rel="stylesheet" type="text/css" />

        <!-- Theme style -->
        <link href="<?php echo base_url('assets/css/AdminLTE.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/css/redactor.css') ?>" rel="stylesheet" type="text/css" />

        <!-- jQuery 2.0.2 -->
        <script src="<?php echo base_url('assets/js/jquery.js') ?>"></script>
        <style>
            .pac-container {
                z-index: 1051 !important;
            }

            .navbar, div.navbar-right{
                background-color: #6461ab !important;
            }
            .modal{ overflow-y:hidden !important }

            .navbar-right{background-color: #3c8dbc !important}
            .modal-body{
                height: 450px !important;
                overflow-y: auto !important;
            }

            @media print
            {    
                .no-print
                {
                    display: none !important;
                }
                table{border:2px solid #999999 !important;}
            }


            @media screen
            {    
                .no-print
                {
                    display:block !important;
                }
            }	

            @font-face {
                font-family: Minimo;
                src: url("<?php echo base_url('assets/fonts/Minimo.otf') ?>") format("opentype");
            }


            #overlay {
                position: fixed;
                left: 0;
                top: 0;
                bottom: 0;
                right: 0;
                background: #ffffff;
                opacity: 0.7;
                filter: alpha(opacity=80);
                -moz-opacity: 0.6;
                z-index: 9999000000000;
            }

        </style>
        <script>
            function call_loader_ajax() {

                if ($('#overlay').length == 0) {
                    var over = '<div id="overlay">' +
                            '<img  style="padding-top:350px; padding-left:50%;"id="loading" src="<?php echo base_url('assets/img/ajax-loader2.gif') ?>"></div>';

                    $(over).appendTo('body');
                }
            }


        </script>	
    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <header class="header no-print">
            <a href="<?php echo site_url('admin/dashboard'); ?>" class="logo text-fill"  style="background-color: #45427d;font-family: Minimo; text-transform: lowercase">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                <span><?php echo @$setting->name; ?></span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only"><?php echo lang('toggle_navigation'); ?></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->

                        <li class="dropdown messages-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <?php echo lang('language') ?>
                                <span class="label label-success"></span>                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">






                                        <li><!-- start message -->
                                            <a href='<?php echo site_url('admin/languages/switch_language/'); ?>/english/<?php echo $first . '/' . $second . '/' . $third . '/' . $fourth ?>'>
                                                <div class="pull-left">
                                                    <img src="<?php echo base_url('assets/img/eng.png') ?>" class="img-circle" alt="User Image"/>
                                                </div>
                                                <h4>
                                                    ENGLISH

                                                </h4>

                                            </a>
                                        </li><!-- end message -->
                                        <?php foreach ($langs as $new) { ?>

                                            <li><!-- start message -->
                                                <a href='<?php echo site_url('admin/languages/switch_language/' . $new->name . '/' . $first . '/' . $second . '/' . $third . '/' . $fourth); ?>'>
                                                    <div class="pull-left">
                                                        <img src="<?php echo base_url('assets/uploads/images/' . $new->flag) ?>" class="img-circle" alt="User Image"/>
                                                    </div>
                                                    <h4>
                                                        <?php echo ucwords($new->name) ?>

                                                    </h4>

                                                </a>
                                            </li><!-- end message -->
                                        <?php } ?>        


                                    </ul>
                                </li>

                            </ul>
                        </li>



                        <?php if ($access == 1) { ?>





                            <!--  Appo Alert Start-->
                            <li class="dropdown tasks-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <?php echo lang('message'); ?>




                                    <?php
                                    if (!empty($admin_messages)) {
                                        echo '<span class="label label-danger">' . count($admin_messages) . '</span>';
                                    }
                                    ?>

                                </a>
                                <ul class="dropdown-menu">
                                    <!-- inner menu: contains the actual data -->
                                    <li>     <ul class="menu">
                                            <?php
                                            foreach ($admin_messages as $new) {
                                                echo'	<li>
                                            <a href="' . site_url('admin/message') . '" style="color:#666666">
                                                <i class="fa fa-chevron-circle-right"></i> ' . $new->from_user . ' On ' . date("d/m/Y h:i:a", strtotime($new->date_time)) . '</a>
                                       </li>
									';
                                            }
                                            ?>


                                        </ul>
                                    </li>
                                    <li class="footer">
                                        <a href="<?php echo site_url('admin/message') ?>"><?php echo lang('view_all') ?> </a>
                                    </li>
                                </ul>
                            </li>
                            <!-- Appo Alert End -->



                            <!--  Appo Alert Start-->
                            <li class="dropdown tasks-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <?php echo lang('appointments'); ?>




                                    <?php
                                    if (!empty($appointment_alert)) {
                                        echo '<span class="label label-danger">' . count($appointment_alert) . '</span>';
                                    }
                                    ?>

                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header"><?php echo count($appointment_alert) ?>  <?php echo lang('appointment_comming_in_next'); ?> <?php echo $notification->appointment_alert; ?> <?php echo lang('days') ?>.</li>
                                    <li>
                                        <!-- inner menu: contains the actual data -->
                                        <ul class="menu">
                                            <?php
                                            foreach ($appointment_alert as $new) {
                                                $with = "";
                                                if (($new->whom == 1)) {
                                                    $with = $new->name;

                                                    $url = '<a href="' . site_url('admin/patients/view/' . $new->patient_id) . '/appointment" style="color:#666666">';
                                                }
                                                if (($new->whom == 2)) {
                                                    $with = $new->contact;
                                                    $url = '<a href="' . site_url('admin/appointments/view_appointment/' . $new->id) . '" style="color:#666666">';
                                                }
                                                if (($new->whom == 3)) {
                                                    $with = $new->other;
                                                    $url = '<a href="' . site_url('admin/appointments/view_appointment/' . $new->id) . '" style="color:#666666">';
                                                }

                                                if (($new->is_paid == 1)) {
                                                    $st = '<i class="fa fa-check-circle text-green"></i>';
                                                } else {
                                                    $st = '<i class="fa fa-times-circle text-red"></i>';
                                                }

                                                echo'	<li>
                                            	' . $url . '
                                                ' . $st . ' 
											' . $with . ' On ' . date("d/m/Y h:i:a", strtotime($new->date)) . '</a>
                                       </li>
									';
                                            }
                                            ?>


                                        </ul>
                                    </li>
                                    <li class="footer">
                                        <a href="<?php echo site_url('admin/appointments') ?>"><?php echo lang('view_all') ?> </a>
                                    </li>
                                </ul>
                            </li>
                            <!-- Appo Alert End -->



                            <!--  To Do Alert End-->
                            <li class="dropdown tasks-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <?php echo lang('to_do'); ?>




                                    <?php
                                    if (!empty($to_do_alert)) {
                                        echo '<span class="label label-danger">' . count($to_do_alert) . '</span>';
                                    }
                                    ?>

                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header"><?php echo count($to_do_alert) ?> <?php echo lang('to_do_comming_in_next'); ?> <?php echo $notification->to_do_alert; ?> <?php echo lang('days') ?></li>

                                    <li>
                                        <!-- inner menu: contains the actual data -->
                                        <ul class="menu">
                                            <?php
                                            foreach ($to_do_alert as $new) {
                                                echo'	<li>
                                            <a href="' . site_url('admin/to_do_list/view_to_do/' . $new->id) . '" style="color:#666666">
                                                <i class="fa fa-tasks"></i>  ' . $new->title . ' On ' . $new->date . '</a>
                                       </li>
									';
                                            }
                                            ?>


                                        </ul>
                                    </li>
                                    <li class="footer">
                                        <a href="<?php echo site_url('admin/to_do_list'); ?>"><?php echo lang('view_all'); ?> </a>
                                    </li>
                                </ul>
                            </li>
                            <!-- To Do Alert End -->




                        <?php } //admin DOctor end ?>




                        <?php if ($access == 2) { ?>	

                            <li class="dropdown tasks-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <?php echo lang('message'); ?>




                                    <?php
                                    if (!empty($admin_messages)) {
                                        echo '<span class="label label-danger">' . count($admin_messages) . '</span>';
                                    }
                                    ?>

                                </a>
                                <ul class="dropdown-menu">
                                    <!-- inner menu: contains the actual data -->
                                    <li>     <ul class="menu">
                                            <?php
                                            foreach ($admin_messages as $new) {
                                                echo'	<li>
                                            <a href="' . site_url('admin/message/send_message/' . $admin['id']) . '" style="color:#666666">
                                                <i class="fa fa-chevron-circle-right"></i> ' . $new->from_user . ' On ' . date("d/m/Y h:i:a", strtotime($new->date_time)) . '</a>
                                       </li>
									';
                                            }
                                            ?>


                                        </ul>
                                    </li>
                                    <li class="footer">
                                        <a href="<?php echo site_url('admin/message/send_message/' . $admin['id']) ?>"><?php echo lang('view_all') ?> </a>
                                    </li>
                                </ul>
                            </li>



                            <!--  Appo Alert Start-->
                            <li class="dropdown tasks-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <?php echo lang('appointments'); ?>
                                    <?php
                                    if (!empty($appointment_alert_patient)) {
                                        echo '<span class="label label-danger">' . count($appointment_alert_patient) . '</span>';
                                    }
                                    ?>

                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header"><?php echo count($appointment_alert_patient) ?>  <?php echo lang('appointment_comming_in_next'); ?> <?php echo $notification->appointment_alert; ?> <?php echo lang('days') ?>.</li>
                                    <li>
                                        <!-- inner menu: contains the actual data -->
                                        <ul class="menu">
                                            <?php
                                            foreach ($appointment_alert_patient as $new) {
                                                echo'	<li>
                                            <a href="' . site_url('admin/book_appointment/view_appointment/' . $new->id) . '" style="color:#666666">
                                                <i class="fa fa-chevron-circle-right"></i>  On ' . date("d/m/Y h:i:a", strtotime($new->date)) . '</a>
                                       </li>
									';
                                            }
                                            ?>


                                        </ul>
                                    </li>
                                    <li class="footer">
                                        <a href="<?php echo site_url('admin/book_appointment') ?>"><?php echo lang('view_all') ?> </a>
                                    </li>
                                </ul>
                            </li>
                            <!-- Appo Alert End -->





                        <?php } ?> 
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo $user->name ?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue" style="background-color: #6461ab !important;">
                                    <?php
                                    if (!empty($user->image)) {
                                        ?>
                                        <img src="<?php echo base_url('assets/uploads/images/' . $user->image); ?>"class="img-circle" alt="User Image" />
                                        <?php
                                    } else {
                                        ?>	
                                        <img src="<?php echo base_url('assets/uploads/images/avatar5.png'); ?>"class="img-circle" alt="User Image" />
                                        <?php
                                    }
                                    ?>

                                    <p>
                                        <?php echo $admin['name'] ?>

                                    </p>
                                </li>
                                <!-- Menu Body -->

                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="<?php echo site_url('admin/account'); ?>" class="btn btn-default btn-flat"><?php echo lang('profile'); ?></a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?php echo site_url('admin/login/logout'); ?>" class="btn btn-default btn-flat"><?php echo lang('sign') . " " . lang('out'); ?></a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>




        <div class="wrapper row-offcanvas row-offcanvas-left ">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel no-print">
                        <div class="pull-left image">
                            <?php
                            if (!empty($admin['image'])) {
                                ?>
                                <img src="<?php echo base_url('assets/uploads/images/' . $admin['image']); ?>"class="img-circle" alt="User Image" />
                                <?php
                            } else {
                                ?>	
                                <img src="<?php echo base_url('assets/uploads/images/avatar5.png'); ?>"class="img-circle" alt="User Image" />
                                <?php
                            }
                            ?>
                        </div>
                        <div class="pull-left info">
                            <p><?php echo lang('hello'); ?>, <?php echo $admin['name'] ?></p>

                            <a href="#"><i class="fa fa-circle text-success"></i> <?php echo lang('online'); ?></a>
                        </div>
                    </div>
                    <!-- search form -->

                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="<?php echo($this->uri->segment(2) == 'dashboard' || $this->uri->segment(2) == '') ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('admin/dashboard'); ?>">
                                <i class="fa fa-dashboard"></i> <span></span><?php echo lang('dashboard'); ?></span>
                            </a>
                        </li>
                        <?php
                        $access = $admin['user_role'];
                        if ($access == "Admin") {
                            ?>
                            <li class="<?php echo($this->uri->segment(2) == 'business' || $this->uri->segment(2) == 'veterinary_clinics' || $this->uri->segment(2) == 'business') ? 'active' : ''; ?> treeview">
                                <a href="<?php echo site_url('admin/doctors'); ?>">
                                    <i class="fa fa-briefcase"></i> <span>Business Types</span> 
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="<?php echo site_url('admin/users') ?>">All Clients</a></li>
                                    <li><a href="<?php echo site_url('admin/business') ?>">Businesses </a></li>
                                    <li><a href="<?php echo site_url('admin/non_profit') ?>">Non-Profits</a></li>
                                    <li><a href="<?php echo site_url('admin/veterinary_clinics') ?>"><?php echo lang('vet_practices') ?></a></li>
                                </ul>
                            </li>

                            <li class="treeview <?php echo($this->uri->segment(2) == 'payment_screen' || $this->uri->segment(2) == 'payment_history') ? 'active' : ''; ?>">
                                <a href="<?php echo site_url('admin/payment_screen'); ?>">
                                    <i class="fa fa-credit-card"></i> <span>Payment</span> 
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="<?php echo site_url('admin/payment_screen'); ?>">Payment Details</a></li>
                                    <li><a href="<?php echo site_url('admin/payment_history') ?>">Payment History</a></li>
                                </ul>
                            </li>

                            <li class="<?php echo($this->uri->segment(2) == 'custom_fields') ? 'active' : ''; ?>">
                                <a href="<?php echo site_url('admin/custom_fields'); ?>">
                                    <i class="fa fa-columns"></i> <span><?php echo lang('custom_fields') ?></span>
                                </a>
                            </li>
                            <li class="<?php echo($this->uri->segment(2) == 'languages') ? 'active' : ''; ?>">
                                <a href="<?php echo site_url('admin/languages'); ?>">
                                    <i class="fa fa-globe"></i> <span><?php echo lang('language'); ?></span> 
                                </a>
                            </li>	
                            <li class="treeview <?php echo($this->uri->segment(2) == 'settings') ? 'active' : ''; ?>">
                                <a href="<?php echo site_url('admin/settings'); ?>">
                                    <i class="fa fa-cog"></i> <span><?php echo lang('settings'); ?></span> 
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="<?php echo site_url('admin/settings'); ?>"><?php echo lang('settings'); ?></a></li>
                                    <li><a href="<?php echo site_url('admin/sms') ?>">SMS</a></li>
                                </ul>
                            </li>			



                        <?php }if ($access == 1) { ?>				

                            <li class="<?php echo($this->uri->segment(2) == 'patients') ? 'active' : ''; ?>">
                                <a href="<?php echo site_url('admin/patients'); ?>">
                                    <i class="fa fa-group"></i> <span><?php echo lang('patients'); ?></span> 
                                </a>
                            </li>
                            <li class="<?php echo($this->uri->segment(2) == 'payment') ? 'active' : ''; ?>">
                                <a href="<?php echo site_url('admin/payment'); ?>">
                                    <i class="fa fa-credit-card"></i> <span><?php echo lang('payment'); ?></span> 
                                </a>
                            </li>

                            <li class="<?php echo($this->uri->segment(2) == 'prescription') ? 'active' : ''; ?>">
                                <a href="<?php echo site_url('admin/prescription'); ?>">
                                    <i class="fa fa-medkit"></i> <span><?php echo lang('prescription'); ?></span> 
                                </a>
                            </li>

                            <li class="<?php echo($this->uri->segment(2) == 'calendar') ? 'active' : ''; ?>">
                                <a href="<?php echo site_url('admin/calendar'); ?>">
                                    <i class="fa fa-calendar"></i> <span> Calendar</span> 
                                </a>
                            </li>

                            <li class="<?php echo($this->uri->segment(2) == 'calendar_beta') ? 'active' : ''; ?>">
                                <a href="<?php echo site_url('admin/calendar_beta'); ?>">
                                    <i class="fa fa-calendar"></i> <span> Calendar Beta</span> 
                                </a>
                            </li>
                            
                            <li class="treeview <?php echo($this->uri->segment(2) == 'message') ? 'active' : ''; ?>">
                                <a href="<?php echo site_url('admin/message'); ?>">
                                    <i class="fa fa-envelope"></i> <span><?php echo lang('message'); ?> </span>
                                    <?php if ((count($admin_messages) + count($user_messages)) > 0) { ?>
                                        <small class="badge pull-right bg-red"><?php echo count($admin_messages) + count($user_messages) ?></small>
                                    <?php } ?>
                                </a>
                                <ul class="treeview-menu">

                                    <li class="<?php echo($this->uri->segment(2) == 'message') ? 'active' : ''; ?>">
                                        <a href="<?php echo site_url('admin/message'); ?>">
                                            <i class="fa fa-envelope"></i> <span>Patient Messages</span>
                                            <?php if (count($admin_messages) > 0) {
                                                ?>
                                                <small class="badge pull-right bg-red"><?php echo count($admin_messages) ?></small>
                                            <?php } ?>
                                        </a>
                                    </li>
                                    <li class="<?php echo($this->uri->segment(2) == 'user_message') ? 'active' : ''; ?>">
                                        <a href="<?php echo site_url('admin/user_message'); ?>">
                                            <i class="fa fa-envelope"></i> <span>User Messages</span>
                                            <?php if (count($user_messages) > 0) {
                                                ?>
                                                <small class="badge pull-right bg-red"><?php echo count($user_messages) ?></small>
                                            <?php } ?>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="<?php echo($this->uri->segment(2) == 'to_do_list') ? 'active' : ''; ?>">
                                <a href="<?php echo site_url('admin/to_do_list'); ?>">
                                    <i class="fa fa-bars"></i> <span><?php echo lang('to_do_list'); ?></span>
                                    <small class="badge pull-right bg-red"><?php echo count($to_do_alert) ?></small>
                                </a>

                            </li>

                            <li class="<?php echo($this->uri->segment(2) == 'notes') ? 'active' : ''; ?>">
                                <a href="<?php echo site_url('admin/notes'); ?>">
                                    <i class="fa fa-file-text"></i> <span><?php echo lang('notes'); ?></span>

                                </a>
                            </li>
                            <li class="<?php echo($this->uri->segment(2) == 'contacts') ? 'active' : ''; ?>">
                                <a href="<?php echo site_url('admin/contacts'); ?>">
                                    <i class="fa fa-newspaper-o"></i> <span><?php echo lang('contacts') ?></span>
                                </a>
                            </li>

                            <li class="<?php echo($this->uri->segment(2) == 'appointments') ? 'active' : ''; ?>">
                                <a href="<?php echo site_url('admin/appointments'); ?>">
                                    <i class="fa fa-thumb-tack"></i> <span><?php echo lang('appointments') ?></span>
                                    <small class="badge pull-right bg-red"><?php echo count($appointment_alert) ?></small>
                                </a>
                            </li>

                            <li class="treeview <?php echo($this->uri->segment(2) == 'locations' || $this->uri->segment(3) == 'view_monthly_schedule' || $this->uri->segment(2) == 'languages') ? 'active' : ''; ?>">
                                <a href="#">
                                    <i class="fa fa-h-square"></i> <span>Locations</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">

                                    <li class="<?php echo($this->uri->segment(2) == 'hospital') ? 'active' : ''; ?>">
                                        <a href="<?php echo site_url('admin/locations/view_all'); ?>">
                                            <i class="fa fa-h-square"></i> <span>Locations</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="<?php echo($this->uri->segment(2) == 'appointments') ? 'active' : ''; ?>">


                                </a>
                            </li>



                            <?php /*
                              <li class="treeview <?php echo($this->uri->segment(2)=='schedule'|| $this->uri->segment(3)=='view_monthly_schedule' || $this->uri->segment(2)=='languages')?'active':'';?>">
                              <a href="#">
                              <i class="fa fa-clock-o"></i> <span><?php echo lang('schedules')?></span>
                              <i class="fa fa-angle-left pull-right"></i>
                              </a>
                              <ul class="treeview-menu">

                              <li class="<?php echo($this->uri->segment(2)=='schedule')?'active':'';?>">
                              <a href="<?php echo site_url('admin/schedule');?>">
                              <i class="fa fa-angle-double-right"></i> <span><?php echo lang('manage_schedule');?> </span>
                              </a>
                              </li>
                              <li class="<?php echo($this->uri->segment(3)=='view_schedule')?'active':'';?>">
                              <a href="<?php echo site_url('admin/schedule/view_schedule');?>">
                              <i class="fa fa-angle-double-right"></i> <span><?php echo lang('weekly_schedule');?> </span>
                              </a>
                              </li>

                              <li class="<?php echo($this->uri->segment(3)=='view_monthly_schedule')?'active':'';?>">
                              <a href="<?php echo site_url('admin/schedule/view_monthly_schedule');?>">
                              <i class="fa fa-angle-double-right"></i> <span><?php echo lang('monthly_schedule');?> </span>
                              </a>
                              </li>
                              <li class="<?php echo($this->uri->segment(3)=='view_specific_schedule')?'active':'';?>">
                              <a href="<?php echo site_url('admin/schedule/view_specific_schedule');?>">
                              <i class="fa fa-angle-double-right"></i> <span><?php echo lang('specific_schedule');?> </span>
                              </a>
                              </li>

                              </ul>
                              </li>
                             */ ?>

                            <li class="treeview <?php echo($this->uri->segment(2) == 'manufacturing_company' || $this->uri->segment(2) == 'medical_test' || $this->uri->segment(2) == 'medicine' || $this->uri->segment(2) == 'medicine_category' || $this->uri->segment(2) == 'disease' || $this->uri->segment(2) == 'case_history' || $this->uri->segment(2) == 'location' || $this->uri->segment(2) == 'payment_mode' || $this->uri->segment(2) == 'template') ? 'active' : ''; ?>">
                                <a href="#">
                                    <i class="fa fa-folder"></i> <span><?php echo lang('settings') ?></span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li class="<?php echo($this->uri->segment(2) == 'medicine') ? 'active' : ''; ?>">
                                        <a href="<?php echo site_url('admin/medicine'); ?>">
                                            <i class="fa fa-angle-double-right"></i> <span><?php echo lang('medicine') ?></span>
                                        </a>
                                    </li>
                                    <li class="<?php echo($this->uri->segment(2) == 'template') ? 'active' : ''; ?>">
                                        <a href="<?php echo site_url('admin/template'); ?>">
                                            <i class="fa fa-cogs"></i> <span> <?php echo lang('manage_prescription'); ?></span>
                                        </a>
                                    </li>
                                    <li class="<?php echo($this->uri->segment(2) == 'medicine_category') ? 'active' : ''; ?>">
                                        <a href="<?php echo site_url('admin/medicine_category'); ?>">
                                            <i class="fa fa-angle-double-right"></i> <span><?php echo lang('medicine_category') ?></span>
                                        </a>
                                    </li>

                                    <li class="<?php echo($this->uri->segment(2) == 'disease') ? 'active' : ''; ?>">
                                        <a href="<?php echo site_url('admin/disease'); ?>">
                                            <i class="fa fa-angle-double-right"></i> <span>O/E</span>
                                        </a>
                                    </li>

                                    <li class="<?php echo($this->uri->segment(2) == 'case_history') ? 'active' : ''; ?>">
                                        <a href="<?php echo site_url('admin/case_history'); ?>">
                                            <i class="fa fa-angle-double-right"></i> <span>Case History</span>
                                        </a>
                                    </li>

                                    <li class="<?php echo($this->uri->segment(2) == 'manufacturing_company') ? 'active' : ''; ?>">
                                        <a href="<?php echo site_url('admin/manufacturing_company'); ?>">
                                            <i class="fa fa-angle-double-right"></i> <span><?php echo lang('manufacturing_company') ?></span>
                                        </a>
                                    </li>

                                    <li class="<?php echo($this->uri->segment(2) == 'medical_test') ? 'active' : ''; ?>">
                                        <a href="<?php echo site_url('admin/medical_test'); ?>">
                                            <i class="fa fa-angle-double-right"></i> <span><?php echo lang('medical_test') ?></span>
                                        </a>
                                    </li>

                                    <li class="<?php echo($this->uri->segment(2) == 'instruction') ? 'active' : ''; ?>">
                                        <a href="<?php echo site_url('admin/instruction'); ?>">
                                            <i class="fa fa-angle-double-right"></i> <span><?php echo lang('instruction') ?></span>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li class="treeview <?php echo($this->uri->segment(2) == 'settings' || $this->uri->segment(2) == 'notification' || $this->uri->segment(2) == 'assistant_payment' || $this->uri->segment(2) == 'assistants' || $this->uri->segment(2) == 'languages') ? 'active' : ''; ?>">
                                <a href="#">
                                    <i class="fa fa-folder"></i> <span><?php echo lang('administrative'); ?></span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li class="<?php echo($this->uri->segment(2) == 'assistants') ? 'active' : ''; ?>">
                                        <a href="<?php echo site_url('admin/assistants'); ?>">
                                            <i class="fa fa-user"></i> <span> Users</span>
                                        </a>
                                    </li>	





                                    <li class="<?php echo($this->uri->segment(2) == 'settings') ? 'active' : ''; ?>">
                                        <a href="<?php echo site_url('admin/settings'); ?>">
                                            <i class="fa fa-cogs"></i> <span><?php echo lang('general'); ?> <?php echo lang('settings'); ?></span>
                                        </a>
                                    </li>
                                    <li class="<?php echo($this->uri->segment(2) == 'notification') ? 'active' : ''; ?>">
                                        <a href="<?php echo site_url('admin/notification'); ?>">
                                            <i class="fa fa-bell"></i> <span><?php echo lang('notification'); ?> <?php echo lang('settings'); ?></span>
                                        </a>
                                    </li>


                                </ul>
                            </li>





                            <?php
                        }
                        if ($access == 2) {
                            ?>

                            <li class="<?php echo($this->uri->segment(2) == 'my_prescription') ? 'active' : ''; ?>">
                                <a href="<?php echo site_url('admin/my_prescription'); ?>">
                                    <i class="fa fa-file"></i> <span><?php echo lang('my_prescription'); ?></span>
                                </a>
                            </li>

                            <li class="<?php echo($this->uri->segment(3) == 'send_message') ? 'active' : ''; ?>">
                                <a href="<?php echo site_url('admin/message/send_message/' . $admin['id']); ?>">
                                    <i class="fa fa-envelope"></i> <span><?php echo lang('message'); ?> </span><small class="badge pull-right bg-red"><?php echo count($admin_messages) ?></small>
                                </a>
                            </li>
                            <li class="<?php echo($this->uri->segment(2) == 'book_appointment') ? 'active' : ''; ?>">
                                <a href="<?php echo site_url('admin/book_appointment'); ?>">
                                    <i class="fa fa-thumb-tack"></i> <span><?php echo lang('appointments') ?></span>

                                </a>
                            </li>


                            <li class="treeview <?php echo($this->uri->segment(2) == 'settings' || $this->uri->segment(2) == 'notification') ? 'active' : ''; ?>">
                                <a href="#">
                                    <i class="fa fa-folder"></i> <span><?php echo lang('administrative'); ?></span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li class="<?php echo($this->uri->segment(2) == 'notification') ? 'active' : ''; ?>">
                                        <a href="<?php echo site_url('admin/notification'); ?>">
                                            <i class="fa fa-bell"></i> <span><?php echo lang('notification'); ?> <?php echo lang('settings'); ?></span>
                                        </a>
                                    </li>

                                </ul>
                            </li>




                            <?php
                        }if ($access == 3) {
                            ?>
                            <?php if (in_array('patients', $rules)) {
                                ?>
                                <li class="<?php echo($this->uri->segment(2) == 'patients') ? 'active' : ''; ?>">
                                    <a href="<?php echo site_url('admin/patients/patient'); ?>">
                                        <i class="fa fa-group"></i> <span><?php echo lang('patients'); ?></span> 
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (in_array('payments', $rules)) {
                                ?>
                                <li class="<?php echo($this->uri->segment(2) == 'payment') ? 'active' : ''; ?>">
                                    <a href="<?php echo site_url('admin/payment'); ?>">
                                        <i class="fa fa-credit-card"></i> <span><?php echo lang('payment'); ?></span> 
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if (in_array('prescriptions', $rules)) {
                                ?>
                                <li class="<?php echo($this->uri->segment(2) == 'prescription') ? 'active' : ''; ?>">
                                    <a href="<?php echo site_url('admin/prescription/assistant_prescription'); ?>">
                                        <i class="fa fa-medkit"></i> <span><?php echo lang('prescription'); ?></span> 
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (in_array('calendar', $rules)) { ?>
                                <li class="<?php echo($this->uri->segment(2) == 'calendar') ? 'active' : ''; ?>">
                                    <a href="<?php echo site_url('admin/calendar'); ?>">
                                        <i class="fa fa-calendar"></i> <span> Calendar</span> 
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (in_array('message', $rules)) { ?>
                                <li class="treeview <?php echo($this->uri->segment(2) == 'message') ? 'active' : ''; ?>">
                                    <a href="<?php echo site_url('admin/message'); ?>">
                                        <i class="fa fa-envelope"></i> <span><?php echo lang('message'); ?> </span>
                                        <?php if ((count($admin_messages) + count($user_messages)) > 0) { ?>
                                            <small class="badge pull-right bg-red"><?php echo count($admin_messages) + count($user_messages) ?></small>
                                        <?php } ?>
                                    </a>
                                    <ul class="treeview-menu">

                                        <li class="<?php echo($this->uri->segment(2) == 'message') ? 'active' : ''; ?>">
                                            <a href="<?php echo site_url('admin/message'); ?>">
                                                <i class="fa fa-envelope"></i> <span>Patient Messages</span>
                                                <?php if (count($admin_messages) > 0) {
                                                    ?>
                                                    <small class="badge pull-right bg-red"><?php echo count($admin_messages) ?></small>
                                                <?php } ?>
                                            </a>
                                        </li>
                                        <li class="<?php echo($this->uri->segment(2) == 'user_message') ? 'active' : ''; ?>">
                                            <a href="<?php echo site_url('admin/user_message/messages'); ?>">
                                                <i class="fa fa-envelope"></i> <span>User Messages</span>
                                                <?php if (count($user_messages) > 0) {
                                                    ?>
                                                    <small class="badge pull-right bg-red"><?php echo count($user_messages) ?></small>
                                                <?php } ?>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            <?php } else { ?>
                                <li class="<?php echo($this->uri->segment(2) == 'user_message') ? 'active' : ''; ?>">
                                    <a href="<?php echo site_url('admin/user_message/messages'); ?>">
                                        <i class="fa fa-envelope"></i> <span>User Messages</span> 
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (in_array('todo', $rules)) {
                                ?>
                                <li class="<?php echo($this->uri->segment(2) == 'to_do_list') ? 'active' : ''; ?>">
                                    <a href="<?php echo site_url('admin/to_do_list'); ?>">
                                        <i class="fa fa-bars"></i> <span><?php echo lang('to_do_list'); ?></span>

                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (in_array('notes', $rules)) {
                                ?>
                                <li class="<?php echo($this->uri->segment(2) == 'notes') ? 'active' : ''; ?>">
                                    <a href="<?php echo site_url('admin/notes'); ?>">
                                        <i class="fa fa-file-text"></i> <span><?php echo lang('notes'); ?></span>

                                    </a>
                                </li>
                            <?php } ?>

                            <?php if (in_array('contacts', $rules)) {
                                ?>
                                <li class="<?php echo($this->uri->segment(2) == 'contacts') ? 'active' : ''; ?>">
                                    <a href="<?php echo site_url('admin/contacts'); ?>">
                                        <i class="fa fa-newspaper-o"></i> <span><?php echo lang('contacts') ?></span>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if (in_array('appointments', $rules)) {
                                ?>
                                <li class="<?php echo($this->uri->segment(2) == 'appointments') ? 'active' : ''; ?>">
                                    <a href="<?php echo site_url('admin/appointments'); ?>">
                                        <i class="fa fa-thumb-tack"></i> <span><?php echo lang('appointments') ?></span>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if (in_array('locations', $rules)) {
                                ?>
                                <li class="treeview <?php echo($this->uri->segment(2) == 'hospital' || $this->uri->segment(3) == 'view_monthly_schedule' || $this->uri->segment(2) == 'languages') ? 'active' : ''; ?>">
                                    <a href="#">
                                        <i class="fa fa-h-square"></i> <span><?php echo lang('hospitals') ?></span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">

                                        <li class="<?php echo($this->uri->segment(2) == 'hospital') ? 'active' : ''; ?>">
                                            <a href="<?php echo site_url('admin/hospital/view_all'); ?>">
                                                <i class="fa fa-h-square"></i> <span><?php echo lang('hospital') ?></span>
                                            </a>
                                        </li>
                                        <li class="<?php echo($this->uri->segment(2) == 'hospital') ? 'active' : ''; ?>">
                                            <a href="<?php echo site_url('admin/hospital/select_hospital'); ?>">
                                                <i class="fa fa-plus"></i> <span><?php echo lang('add_hospital_routine') ?></span>
                                            </a>
                                        </li>
                                        <li class="<?php echo($this->uri->segment(2) == 'hospital') ? 'active' : ''; ?>">
                                            <a href="<?php echo site_url('admin/hospital/select_hospital/view'); ?>">
                                                <i class="fa fa-clock-o"></i> <span><?php echo lang('hospital_routine') ?></span>
                                            </a>
                                        </li>

                                    </ul>
                                </li>
                            <?php } ?>
                            <?php if ($user_type == 'management') { ?>
                                <li class="treeview <?php echo($this->uri->segment(2) == 'settings' || $this->uri->segment(2) == 'notification' || $this->uri->segment(2) == 'assistant_payment' || $this->uri->segment(2) == 'assistants' || $this->uri->segment(2) == 'languages') ? 'active' : ''; ?>">
                                    <a href="#">
                                        <i class="fa fa-folder"></i> <span><?php echo lang('administrative'); ?></span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li class="<?php echo($this->uri->segment(2) == 'assistants') ? 'active' : ''; ?>">
                                            <a href="<?php echo site_url('admin/assistants'); ?>">
                                                <i class="fa fa-user"></i> <span> Users</span>
                                            </a>
                                        </li>	

                                        <li class="<?php echo($this->uri->segment(2) == 'settings') ? 'active' : ''; ?>">
                                            <a href="<?php echo site_url('admin/settings'); ?>">
                                                <i class="fa fa-cogs"></i> <span><?php echo lang('general'); ?> <?php echo lang('settings'); ?></span>
                                            </a>
                                        </li>
                                        <li class="<?php echo($this->uri->segment(2) == 'notification') ? 'active' : ''; ?>">
                                            <a href="<?php echo site_url('admin/notification'); ?>">
                                                <i class="fa fa-bell"></i> <span><?php echo lang('notification'); ?> <?php echo lang('settings'); ?></span>
                                            </a>
                                        </li>


                                    </ul>
                                </li>
                            <?php } ?>

                            <?php if (in_array('settings', $rules)) {
                                ?>
                                <li class="treeview <?php echo($this->uri->segment(2) == 'manufacturing_company' || $this->uri->segment(2) == 'medical_test' || $this->uri->segment(2) == 'medicine' || $this->uri->segment(2) == 'medicine_category' || $this->uri->segment(2) == 'case_history' || $this->uri->segment(2) == 'disease' || $this->uri->segment(2) == 'location' || $this->uri->segment(2) == 'payment_mode') ? 'active' : ''; ?>">
                                    <a href="#">
                                        <i class="fa fa-folder"></i> <span><?php echo lang('settings') ?></span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li class="<?php echo($this->uri->segment(2) == 'medicine') ? 'active' : ''; ?>">
                                            <a href="<?php echo site_url('admin/medicine'); ?>">
                                                <i class="fa fa-angle-double-right"></i> <span><?php echo lang('medicine') ?></span>
                                            </a>
                                        </li>

                                        <li class="<?php echo($this->uri->segment(2) == 'medicine_category') ? 'active' : ''; ?>">
                                            <a href="<?php echo site_url('admin/medicine_category'); ?>">
                                                <i class="fa fa-angle-double-right"></i> <span><?php echo lang('medicine_category') ?></span>
                                            </a>
                                        </li>

                                        <li class="<?php echo($this->uri->segment(2) == 'disease') ? 'active' : ''; ?>">
                                            <a href="<?php echo site_url('admin/disease'); ?>">
                                                <i class="fa fa-angle-double-right"></i> <span>O/E</span>
                                            </a>
                                        </li>
                                        <li class="<?php echo($this->uri->segment(2) == 'case_history') ? 'active' : ''; ?>">
                                            <a href="<?php echo site_url('admin/case_history'); ?>">
                                                <i class="fa fa-angle-double-right"></i> <span>Case History</span>
                                            </a>
                                        </li>
                                        <li class="<?php echo($this->uri->segment(2) == 'manufacturing_company') ? 'active' : ''; ?>">
                                            <a href="<?php echo site_url('admin/manufacturing_company'); ?>">
                                                <i class="fa fa-angle-double-right"></i> <span><?php echo lang('manufacturing_company') ?></span>
                                            </a>
                                        </li>

                                        <li class="<?php echo($this->uri->segment(2) == 'medical_test') ? 'active' : ''; ?>">
                                            <a href="<?php echo site_url('admin/medical_test'); ?>">
                                                <i class="fa fa-angle-double-right"></i> <span><?php echo lang('medical_test') ?></span>
                                            </a>
                                        </li>



                                        <li class="<?php echo($this->uri->segment(2) == 'payment_mode') ? 'active' : ''; ?>">
                                            <a href="<?php echo site_url('admin/payment_mode'); ?>">
                                                <i class="fa fa-angle-double-right"></i> <span><?php echo lang('payment_mode') ?></span>
                                            </a>
                                        </li>
                                        <li class="<?php echo($this->uri->segment(2) == 'instruction') ? 'active' : ''; ?>">
                                            <a href="<?php echo site_url('admin/instruction'); ?>">
                                                <i class="fa fa-angle-double-right"></i> <span><?php echo lang('instruction') ?></span>
                                            </a>
                                        </li>

                                    </ul>
                                </li>
                            <?php } ?>


                        <?php } ?>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">

                <?php
                if ($this->session->flashdata('message'))
                    $message = $this->session->flashdata('message');
                if ($this->session->flashdata('error'))
                    $error = $this->session->flashdata('error');
                ?>

                <?php if (!empty($error) || !empty($message)) { ?>
                    <div class="container" style="margin-top:20px;">

                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger alert-dismissable col-md-11">
                                <i class="fa fa-ban"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <?php echo $error; ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($message)): ?>
                            <div class="alert alert-info alert-dismissable col-md-11">
                                <i class="fa fa-info"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <?php echo $message; ?>
                            </div>
                        <?php endif; ?>

                    </div>
                <?php } ?>



