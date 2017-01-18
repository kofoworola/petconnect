
<link href="<?php echo site_url('assets/')?>/css/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/wd/')?>/css/dailog.css" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/wd/')?>/css/calendar.css" rel="stylesheet" type="text/css" /> 
<link href="<?php echo site_url('assets/wd/')?>/css/dp.css" rel="stylesheet" type="text/css" />   
<link href="<?php echo site_url('assets/wd/')?>/css/alert.css" rel="stylesheet" type="text/css" /> 
<link href="<?php echo site_url('assets/wd/')?>/css/main.css" rel="stylesheet" type="text/css" /> 


<style>
body{overflow-y: hidden !important;
height:100% !important}
.bbit-window{padding-top:100px !important} 
.bbit-window-plain{padding-top:100px !important}
.color-box {
    display: inline-block;
    width: 15px;
    height: 15px;
    border: solid 1px #555555;
    vertical-align: top;
    margin-top: 2px;
    margin-left: 5px;
}
</style>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<!--<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>-->
<script src="<?php echo site_url('assets/js/')?>/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script> 
<script src="<?php echo site_url('assets/wd/js/')?>/Common.js" type="text/javascript"></script>    
<script src="<?php echo site_url('assets/wd/js/')?>/datepicker_lang_US.js" type="text/javascript"></script>     
<script src="<?php echo site_url('assets/wd/js/')?>/jquery.datepicker.js" type="text/javascript"></script>

<script src="<?php echo site_url('assets/wd/js/')?>/jquery.alert.js" type="text/javascript"></script>    
<script src="<?php echo site_url('assets/wd/js/')?>/jquery.ifrmdailog.js" defer="defer" type="text/javascript"></script>
<script src="<?php echo site_url('assets/wd/js/')?>/wdCalendar_lang_US.js" type="text/javascript"></script>    
<script src="<?php echo site_url('assets/wd/js/')?>/jquery.calendar.js" type="text/javascript"></script>   

<section class="content-header">
        <h1>
            <?php echo $page_title; ?>
           
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin')?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
            <li class="active">Event Calendar</li>
        </ol>
</section>
 
<section class="content">
	<div class="row"> 	
 <div class="box box-primary">
 
      <div id="calhead" style="padding-left:1px;padding-right:1px;">          
            <div class="cHead"><div class="ftitle">My Calendar</div>
            <div id="loadingpannel" class="ptogtitle loadicon" style="display: none;">Loading data...</div>
             <div id="errorpannel" class="ptogtitle loaderror" style="display: none;">Sorry, could not load your data, please try again later</div>
            </div>          
            
            <div id="caltoolbar" class="ctoolbar">
              <div id="faddbtn" class="fbutton">
                <div><span title='Click to Create New Event' class="addcal">

                New Event                
                </span></div>
            </div>
            <div class="btnseparator"></div>
           <!--  <div id="showtodaybtn" class="fbutton">
                <div><span title='Click to back to today ' class="showtoday">
                Today</span></div>
            </div>
              <div class="btnseparator"></div>
-->
            <div id="showdaybtn" class="fbutton">
                <div><span title='Day' class="showdayview">Today</span></div>
            </div>
              <div  id="showweekbtn" class="fbutton fcurrent">
                <div><span title='Week' class="showweekview">Week</span></div>
            </div>
              <div  id="showmonthbtn" class="fbutton">
                <div><span title='Month' class="showmonthview">Month</span></div>

            </div>
            <div class="btnseparator"></div>
              <div  id="showreflashbtn" class="fbutton">
                <div><span title='Refresh view' class="showdayflash">Refresh</span></div>
                </div>
             <div class="btnseparator"></div>
            <div id="sfprevbtn" title="Prev"  class="fbutton">
              <span class="fprev"></span>

            </div>
            <div id="sfnextbtn" title="Next" class="fbutton">
                <span class="fnext"></span>
            </div>
            <div class="fshowdatep fbutton">
                    <div>
                        <input type="hidden" name="txtshow" id="hdtxtshow" />
                        <span id="txtdatetimeshow">Loading</span>

                    </div>
            </div>
			
			<div class="clear"></div>
            </div>
			
				
      </div>
      <div style="padding:1px;">

        <div class="t1 chromeColor">
            &nbsp;</div>
        <div class="t2 chromeColor">
            &nbsp;</div>
        <div id="dvCalMain" class="calmain printborder" >
            <div id="gridcontainer" style="overflow-y: visible;">
            </div>
        </div>
        <div class="t2 chromeColor">

            &nbsp;</div>
        <div class="t1 chromeColor">
            &nbsp;
        </div>   
        </div>
     
  </div>
   
  </div> <!--END ROW-->
 </section>   

<div id="calendar_event_popup" title="Calendar Event">
	<div id="calendar_event_popup_inner"></div>
</div>

<script type="text/javascript">

    // scripts to open the modal window for our event editing:


    var calendar_id = 0; // currently editing calendar event id?
    var calendar_data = []; // currently editing calendar event id?
    $(function(){
		$("#calendar_event_popup").dialog({
			autoOpen: false,
			height: 600,
			width: 500,
			modal: true,
			buttons: {
				'Save Event': function() {
					$.ajax({
						type: 'POST',
                        url: '<?php echo site_url('admin/datafeed')?>?method=adddetails&id='+calendar_data[0]+'&type_id='+calendar_data[10],
						data: $('#calendar_event_form').serialize(),
                        dataType: 'html',
						success: function(d){
                            // refresh the calender with these new changes
                            $("#calendar_event_popup").dialog('close');
                            $("#gridcontainer").reload();
						},
                        error: function (header, status, error) {
                            console.log('ajax answer post returned error ' + header + ' ' + status + ' ' + error);
                        }
					});
				},
                'Cancel': function() {
					$(this).dialog('close');
				}
			},
			open: function(){
                var calendar_data_for_post = {};
                if(typeof calendar_data[0] != 'undefined'){
                    calendar_data_for_post['calendar_id'] = calendar_data[0];
                }
                if(typeof calendar_data[1] != 'undefined'){
                    calendar_data_for_post['title'] = calendar_data[1];
                }
                if(typeof calendar_data[2] != 'undefined'){
                    calendar_data_for_post['start_date_time'] = calendar_data[2];
                }
                if(typeof calendar_data[3] != 'undefined'){
                    calendar_data_for_post['end_date_time'] = calendar_data[3];
                }
                if(typeof calendar_data[4] != 'undefined'){
                    calendar_data_for_post['is_all_day'] = calendar_data[4];
                }
				$.ajax({
					type: "POST",
                    url: '<?php echo site_url('admin/calendar/edit_form')?>?id='+calendar_data[0]+'&start='+calendar_data[2]+'&end='+calendar_data[2]+'&isallday='+calendar_data[4]+'&title='+calendar_data[1]+'&type_id='+calendar_data[10],
                    data: calendar_data_for_post,
					dataType: "html",
					success: function(d){
                        $('#calendar_event_popup_inner').html(d);
                        ucm.init_interface();
					}
				});
			},
			close: function() {
				$('#calendar_event_popup_inner').html('');
			}
		});

       var view="week";

        var DATA_FEED_URL = "<?php echo site_url('admin/datafeed')?>";
            var op = {
                view: view,
                theme:3,
                showday: new Date(),
                EditCmdhandler:Edit,
                DeleteCmdhandler:Delete,
                ViewCmdhandler:View,    
                onWeekOrMonthToDay:wtd,
                onBeforeRequestData: cal_beforerequest,
                onAfterRequestData: cal_afterrequest,
                onRequestDataError: cal_onerror, 
                autoload:true,
                url: DATA_FEED_URL + "?method=list",  
                quickAddUrl: DATA_FEED_URL + "?method=add", 
                quickUpdateUrl: DATA_FEED_URL + "?method=update",
                quickDeleteUrl: DATA_FEED_URL + "?method=remove"
            };
        var $dv = $("#calhead");
        var _MH = document.documentElement.clientHeight;
        var dvH = $dv.height() + 2;
        op.height = _MH - dvH + 30;
        op.eventItems =[];

        var p = $("#gridcontainer").bcalendar(op).BcalGetOp();
        if (p && p.datestrshow) {
            $("#txtdatetimeshow").text(p.datestrshow);
        }
        $("#caltoolbar").noSelect();

        $("#hdtxtshow").datepicker({ picker: "#txtdatetimeshow", showtarget: $("#txtdatetimeshow"),
            onReturn:function(r){
                var p = $("#gridcontainer").gotoDate(r).BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }
             }
        });
        function cal_beforerequest(type)
        {
            var t="Loading data...";
            switch(type)
            {
                case 1:
                    t="Loading data...";
                    break;
                case 2:
                case 3:
                case 4:
                    t="The request is being processed ...";
                    break;
            }
            $("#errorpannel").hide();
            $("#loadingpannel").html(t).show();
        }
        function cal_afterrequest(type)
        {
            if (p && p.datestrshow) {
                $("#txtdatetimeshow").text(p.datestrshow);
            }
            switch(type)
            {
                case 1:
                    $("#loadingpannel").hide();
                    break;
                case 2:
                case 3:
                case 4:
                    $("#loadingpannel").html("Success!");
                    window.setTimeout(function(){ $("#loadingpannel").hide();},2000);
                break;
            }

        }
        function cal_onerror(type,data)
        {
            $("#errorpannel").show();
        }
        function Edit(data)
        {
           //var eurl="http://demo2.ultimateclientmanager.com/?m=calendar&p=calendar_admin_edit&display_mode=iframe&id={0}&start={2}&end={3}&isallday={4}&title={1}";
            if(data)
            {
                calendar_id = data[0];
                calendar_data = data;
                $('#calendar_event_popup').dialog('open');
                /*var url = StrFormat(eurl,data);
                OpenModelWindow(url,{ width: 600, height: 400, caption:"Manage  The Calendar",onclose:function(){
                   $("#gridcontainer").reload();
                }});*/
            }
        }
        function View(data)
        {
            return false;
            var str = "";
            $.each(data, function(i, item){
                str += "[" + i + "]: " + item + "\n";
            });
            alert(str);
        }
        function Delete(data,callback)
        {

            $.alerts.okButton="Ok";
            $.alerts.cancelButton="Cancel";
            hiConfirm("Are You Sure to Delete this Event", 'Confirm',function(r){ r && callback(0);});
        }
        function wtd(p)
        {
           if (p && p.datestrshow) {
                $("#txtdatetimeshow").text(p.datestrshow);
            }
            $("#caltoolbar div.fcurrent").each(function() {
                $(this).removeClass("fcurrent");
            });
            $("#showdaybtn").addClass("fcurrent");
        }
        //to show day view
        $("#showdaybtn").click(function(e) {
            //document.location.href="#day";
            $("#caltoolbar div.fcurrent").each(function() {
                $(this).removeClass("fcurrent");
            });
            $(this).addClass("fcurrent");
            var p = $("#gridcontainer").swtichView("day").BcalGetOp();
            if (p && p.datestrshow) {
                $("#txtdatetimeshow").text(p.datestrshow);
            }
        });
        //to show week view
        $("#showweekbtn").click(function(e) {
            //document.location.href="#week";
            $("#caltoolbar div.fcurrent").each(function() {
                $(this).removeClass("fcurrent");
            });
            $(this).addClass("fcurrent");
            var p = $("#gridcontainer").swtichView("week").BcalGetOp();
            if (p && p.datestrshow) {
                $("#txtdatetimeshow").text(p.datestrshow);
            }

        });
        //to show month view
        $("#showmonthbtn").click(function(e) {
            //document.location.href="#month";
            $("#caltoolbar div.fcurrent").each(function() {
                $(this).removeClass("fcurrent");
            });
            $(this).addClass("fcurrent");
            var p = $("#gridcontainer").swtichView("month").BcalGetOp();
            if (p && p.datestrshow) {
                $("#txtdatetimeshow").text(p.datestrshow);
            }
        });

        $("#showreflashbtn").click(function(e){
            $("#gridcontainer").reload();
        });

        //Add a new event
        $("#faddbtn").click(function(e) {
            calendar_id = 0;
            calendar_data = [];
            $('#calendar_event_popup').dialog('open');
            //var url ="http://demo2.ultimateclientmanager.com/?m=calendar&p=calendar_admin_edit&display_mode=iframe";
            //OpenModelWindow(url,{ width: 500, height: 400, caption: 'Create New Calendar Event'});
        });
        //go to today
        $("#showtodaybtn").click(function(e) {
            var p = $("#gridcontainer").gotoDate().BcalGetOp();
            if (p && p.datestrshow) {
                $("#txtdatetimeshow").text(p.datestrshow);
            }


        });
        //previous date range
        $("#sfprevbtn").click(function(e) {
            var p = $("#gridcontainer").previousRange().BcalGetOp();
            if (p && p.datestrshow) {
                $("#txtdatetimeshow").text(p.datestrshow);
            }

        });
        //next date range
        $("#sfnextbtn").click(function(e) {
            var p = $("#gridcontainer").nextRange().BcalGetOp();
            if (p && p.datestrshow) {
                $("#txtdatetimeshow").text(p.datestrshow);
            }
        });

    });
</script>