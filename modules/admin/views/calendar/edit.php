<?php
//echo '<pre>'; print_r($_GET);
//echo '<pre>'; print_r($_POST);die;
$ci =& get_instance();
$contacts = $this->patient_model->get_patients_by_doctor();
$contact = $this->contact_model->get_contact_by_doctor();
$hospitals = $this->hospital_model->get_hospital_by_doctor();
$college = $this->medical_college_model->get_medical_college_by_doctor();
function js2PhpTime($jsdate){
		  if(preg_match('@(\d+)/(\d+)/(\d+)\s+(\d+):(\d+)@', $jsdate, $matches)==1){
			$ret = mktime($matches[4], $matches[5], 0, $matches[1], $matches[2], $matches[3]);
			//echo $matches[4] ."-". $matches[5] ."-". 0  ."-". $matches[1] ."-". $matches[2] ."-". $matches[3];
		  }else if(preg_match('@(\d+)/(\d+)/(\d+)@', $jsdate, $matches)==1){
			$ret = mktime(0, 0, 0, $matches[1], $matches[2], $matches[3]);
			//echo 0 ."-". 0 ."-". 0 ."-". $matches[1] ."-". $matches[2] ."-". $matches[3];
		  }
		  return $ret;
		}
		
		function php2JsTime($phpDate){
			//echo $phpDate;
			//return "/Date(" . $phpDate*1000 . ")/";
			return date("m/d/Y H:i", $phpDate);
		}
		
		function php2MySqlTime($phpDate){
			return date("Y-m-d H:i:s", $phpDate);
		}
		
		function mySql2PhpTime($sqlDate){
			$arr = date_parse($sqlDate);
			return mktime($arr["hour"],$arr["minute"],$arr["second"],$arr["month"],$arr["day"],$arr["year"]);
		
		}
function getCalendarByRange($id){
  $ci =& get_instance();
	
  try{
    $sql = "select * from `jqcalendar` where `id` = " . $id;
    $handle = $ci->db->query($sql)->row();
    //echo $sql;
    $row =$handle;	// mysql_fetch_object($handle);
	}catch(Exception $e){
  }
  return $row;
}

if($_GET["type_id"]==1){
	$event	=	$this->to_do_list_model->get_list_by_id($_GET["id"]);
	$subject = $event->title;
	$id = $event->id;
	$color=1;
	$starttime=$event->date;
	$endtime=date("Y-m-d H:i:s", strtotime($event->date .'+ 30 minute'));
	$allday = 0;
	$location = "";
	$description="";
	$whom = '';
	$patient_id = '';
	$contact_id = '';
	$other = '';
	$motive = '';
	$is_paid = '';

}

if($_GET["type_id"]==2){
	$event	= $this->appointment_model->get_appointment_by_id($_GET["id"]);
	$subject = $event->title;
	$id = $event->id;
	$color=1;
	$starttime=$event->date;
	$endtime=$event->date;
	$allday =0;
	$location = "";
	$description="";
	$whom = $event->whom;
	$patient_id = $event->patient_id;
	$contact_id = $event->contact_id;
	$other = $event->other;
	$motive = $event->motive;
	$is_paid = $event->is_paid;
}
if($_GET["type_id"]==5){
if(isset($_GET["id"])){
  $event = getCalendarByRange($_GET["id"]);
  $subject= $event->Subject; 
  $id = $event->Id;
  $color=$event->Color;
  $starttime=$event->StartTime;
  $endtime=$event->EndTime;
  $allday = $event->IsAllDayEvent;
  $location = $event->Location;
  $description = $event->Description;
  $whom = '';
  $patient_id = '';
  $contact_id = '';
  $other ='';
  $motive = '';	
  $is_paid = '';
}


}

?>
<link href="<?php echo base_url('assets/css/jquery.datetimepicker.css')?>" rel="stylesheet" type="text/css" />

<script src="<?php echo base_url('assets/js/jquery.datetimepicker.js')?>" type="text/javascript"></script>
<link href="<?php echo base_url('assets/css/chosen.css')?>" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url('assets/js/chosen.jquery.min.js')?>" type="text/javascript"></script> 
<link href="<?php echo base_url('assets/wd/')?>/css/colorselect.css" rel="stylesheet" />   
<script src="<?php echo base_url('assets/wd/js/')?>/jquery.colorselect.js" type="text/javascript"></script>   
<script src="<?php echo base_url('assets/wd/js/')?>/jquery.validate.js" type="text/javascript"></script>     
<script src="<?php echo base_url('assets/wd/js/')?>/datepicker_lang_US.js" type="text/javascript"></script>        
<script src="<?php echo base_url('assets/wd/js/')?>/jquery.datepicker.js" type="text/javascript"></script>     
<script src="<?php echo base_url('assets/wd/js/')?>/jquery.dropdown.js" type="text/javascript"></script>     

<link href="<?php echo base_url('assets/wd/')?>/css/main.css" rel="stylesheet" type="text/css" />       
<link href="<?php echo base_url('assets/wd/')?>/css/dp.css" rel="stylesheet" />    

<?php /*<link href="<?php echo site_url('assets/')?>/css/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/wd/')?>/css/main.css" rel="stylesheet" type="text/css" />       
<link href="<?php echo site_url('assets/wd/')?>/css/dp.css" rel="stylesheet" />    
<link href="<?php echo site_url('assets/wd/')?>/css/dropdown.css" rel="stylesheet" />    


<script src="//code.jquery.com/jquery.min.js"></script> 
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo site_url('assets/js/')?>/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script> 
<script src="<?php echo site_url('assets/wd/js/')?>/Common.js" type="text/javascript"></script>        
<script src="<?php echo site_url('assets/wd/js/')?>/jquery.form.js" type="text/javascript"></script>     



 */ ?>
<style>
.chosen-container{width:60% !important} 
#divcalendarcolor{z-index:10000000000000000000000000000000 !important}
</style>    
    <script type="text/javascript">
        $(function() {
				$('.chzn').chosen({search_contains:true});
		});
		if (!DateAdd || typeof (DateDiff) != "function") {
            var DateAdd = function(interval, number, idate) {
                number = parseInt(number);
                var date;
                if (typeof (idate) == "string") {
                    date = idate.split(/\D/);
                    eval("var date = new Date(" + date.join(",") + ")");
                }
                if (typeof (idate) == "object") {
                    date = new Date(idate.toString());
                }
                switch (interval) {
                    case "y": date.setFullYear(date.getFullYear() + number); break;
                    case "m": date.setMonth(date.getMonth() + number); break;
                    case "d": date.setDate(date.getDate() + number); break;
                    case "w": date.setDate(date.getDate() + 7 * number); break;
                    case "h": date.setHours(date.getHours() + number); break;
                    case "n": date.setMinutes(date.getMinutes() + number); break;
                    case "s": date.setSeconds(date.getSeconds() + number); break;
                    case "l": date.setMilliseconds(date.getMilliseconds() + number); break;
                }
                return date;
            }
        }
        function getHM(date)
        {
             var hour =date.getHours();
             var minute= date.getMinutes();
             var ret= (hour>9?hour:"0"+hour)+":"+(minute>9?minute:"0"+minute) ;
             return ret;
        }
        $(document).ready(function() {
            //debugger;
            var DATA_FEED_URL = "<?php echo site_url('admin/datafeed')?>";
            var arrT = [];
            var tt = "{0}:{1}";
          
// changed the range from a full twenty four hours to from the hours 9a to 9p if (i >= 9 && i <= 21)
            var check = $("#IsAllDayEvent").click(function(e) {
                if (this.checked) {
                    $("#stparttime").val("00:00").hide();
                    $("#etparttime").val("00:00").hide();
                }
                else {
                    var d = new Date();
                    var p = 60 - d.getMinutes();
                    if (p > 30) p = p - 30;
                    d = DateAdd("n", p, d);
                    $("#stparttime").val(getHM(d)).show();
                    $("#etparttime").val(getHM(DateAdd("h", 1, d))).show();
                }
            });
            if (check[0].checked) {
                $("#stparttime").val("00:00").hide();
                $("#etparttime").val("00:00").hide();
            }
            $("#Savebtn").click(function() { $("#calendar_event_form").submit(); });
            $("#Closebtn").click(function() { CloseModelWindow(); });
            $("#Deletebtn").click(function() {
                 if (confirm("Are you sure to remove this event")) {  
				 	id =  $(".hidden_id").val();
					type_id =  $(".hidden_type_id").val();
                    var param = [{ "name": "id", value: id},{ "name": "type_id", value: type_id}];                
                   $.post(DATA_FEED_URL + "?method=remove",
                        param,
						
                        function(data){
                              if (data.IsSuccess) {
                                    alert(data.Msg); 
                                    CloseModelWindow(null,true);                            
                                }
                                else {
                                    alert("Error occurs.\r\n" + data.Msg);
                                }
                        }
                    ,"json");
                }
            });
         $(document).ready(function(){         
           $("#stpartdate,#etpartdate").datetimepicker({format:'m/d/Y',timepicker:false,});    
            var cv =$("#colorvalue").val() ;
            if(cv=="")
            {
                cv="-1";
            }
            $("#calendarcolor").colorselect({ title: "Color", index: cv, hiddenid: "colorvalue" });
            //to define parameters of ajaxform
            var options = {
                beforeSubmit: function() {
                    return true;
                },
                dataType: "json",
                success: function(data) {
                    alert(data.Msg);
                    if (data.IsSuccess) {
                        CloseModelWindow(null,true);  
                    }
                }
            };
		
            $.validator.addMethod("date", function(value, element) {                             
                var arrs = value.split(i18n.datepicker.dateformat.separator);
                var year = arrs[i18n.datepicker.dateformat.year_index];
                var month = arrs[i18n.datepicker.dateformat.month_index];
                var day = arrs[i18n.datepicker.dateformat.day_index];
                var standvalue = [year,month,day].join("-");
                return this.optional(element) || /^(?:(?:1[6-9]|[2-9]\d)?\d{2}[\/\-\.](?:0?[1,3-9]|1[0-2])[\/\-\.](?:29|30))(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?: \d{1,3})?)?$|^(?:(?:1[6-9]|[2-9]\d)?\d{2}[\/\-\.](?:0?[1,3,5,7,8]|1[02])[\/\-\.]31)(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?: \d{1,3})?)?$|^(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])[\/\-\.]0?2[\/\-\.]29)(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?: \d{1,3})?)?$|^(?:(?:16|[2468][048]|[3579][26])00[\/\-\.]0?2[\/\-\.]29)(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?: \d{1,3})?)?$|^(?:(?:1[6-9]|[2-9]\d)?\d{2}[\/\-\.](?:0?[1-9]|1[0-2])[\/\-\.](?:0?[1-9]|1\d|2[0-8]))(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?:\d{1,3})?)?$/.test(standvalue);
            }, "Invalid date format");
            $.validator.addMethod("time", function(value, element) {
                return this.optional(element) || /^([0-1]?[0-9]|2[0-3]):([0-5][0-9])$/.test(value);
            }, "Invalid time format");
            $.validator.addMethod("safe", function(value, element) {
                return this.optional(element) || /^[^$\<\>]+$/.test(value);
            }, "$<> not allowed");
            $("#calendar_event_form").validate({
                submitHandler: function(form) { $("#calendar_event_form").ajaxSubmit(options); },
                errorElement: "div",
                errorClass: "cusErrorPanel",
                errorPlacement: function(error, element) {
                    showerror(error, element);
                }
            });
            function showerror(error, target) {
                var pos = target.position();
                var height = target.height();
                var newpos = { left: pos.left, top: pos.top + height + 2 }
                var form = $("#calendar_event_form");             
                error.appendTo(form).css(newpos);
            }
        });
	});		
    </script>      
   
    <?php 
	  
	  	@$start =  explode(' ',$_GET['start']);
		@$end =  explode(' ',$_POST['end_date_time']);
	  //	echo '<pre>'; print_r($_GET);die;
	  ?>        
	  
	
	      
        <form action="<?php echo site_url('admin/datafeed')?>?method=adddetails<?php echo (!empty($event))?"&id=".$id."&type_id=".$_GET['type_id']:""; ?>" class="fform" id="calendar_event_form" method="post">                 
		<input type="hidden" name="hidden_id" class="hidden_id" value="<?php echo @$id;?>" />
		<input type="hidden" name="hidden_type_id" class="hidden_type_id" value="<?php echo $_GET['type_id'];?>" />
          <label>                    
            <span>                        *Subject:              
            </span>                    
          	<textarea class="required safe" id="Subject" name="Subject" style="width:60%;" ><?php echo (!empty($event))?$subject:"" ?></textarea>
            <input id="colorvalue" name="colorvalue" type="hidden" value="<?php echo (!empty($event))?$color:"" ?>" />                
          </label>                 
          <label>                    
            	<span>Color:</span>                    
           		 <div id="calendarcolor" class="containtdiv" title="Color"></div>
		</label>                 
          <br />

		  
		  <label>                    
            <span>*Time:
            </span>                    
            <div>  
              <?php 
			  if(!empty($event)){
                  $sarr = explode(" ", php2JsTime(mySql2PhpTime($starttime)));
                  $earr = explode(" ", php2JsTime(mySql2PhpTime($endtime)));
              }?>                    
			  <input MaxLength="10" class="required date" id="stpartdate" name="stpartdate"  type="text" value="<?php echo (!empty($event))?$sarr[0]:@$start[0]; ?>" />           
			  <input MaxLength="5" class="required time" id="stparttime" name="stparttime"  style="width:60px;"   type="text" value="<?php echo (!empty($event))?$sarr[1]:@$start[1]; ?>" />
			 <br /><br />
      
              <input MaxLength="10" class="required date" id="etpartdate" name="etpartdate" type="text" value="<?php echo (!empty($event))?$earr[0]:@$end[0]; ?>" />                       
              <input MaxLength="5" class="required time" id="etparttime" name="etparttime" style="width:60px;" type="text" value="<?php echo (!empty($event))?$earr[1]:@$end[1]; ?>" />                                            
              <label class="checkp"> 
                <input id="IsAllDayEvent" name="IsAllDayEvent" type="checkbox" value="1" <?php if(!empty($event)&&$allday!=0) {echo "checked";} ?>/>          All Day Event                      
              </label>                    
            </div>                
          </label>   
		   <div class="row">	
			<div class="control-group col-md-8">
			<label class="control-label" for="schedule_category">Schedule Category:</label>
			<div class="controls">
				<select name="schedule_category" class="schedule_category form-control chzn">
					<option value="">Select Schedule Category</option>
					<option value="1" <?php echo ($_GET['type_id']==1)?'selected="selected"':'';?> >To Do</option>
					<option value="2" <?php echo ($_GET['type_id']==2)?'selected="selected"':'';?> >Appointment</option>
					<option value="3">Hospital Schedule</option>
					<option value="4">Medical College Schedule</option>
					<option value="5" <?php echo ($_GET['type_id']==5)?'selected="selected"':'';?> >Other</option>
					
				</select>
			</div>
		  </div>	
		</div>              
		
		<div id="show_appointment">		
						 <div class="control-group">
                        	<div class="row">
                                <div class="col-md-8">
                                    <label for="name" style="clear:both;"><?php echo lang('with_whom');?></label>
									   <select name="whom" class="form-control chzn whom" >
											<option value="0">--<?php echo lang('with_whom');?>--</option>
											<option value="1" <?php echo (@$whom==1)?'selected="selected"':'';?> ><?php echo lang('patient');?></option>
											<option value="2" <?php echo (@$whom==2)?'selected="selected"':'';?>><?php echo lang('contact');?></option>
											<option value="3" <?php echo (@$whom==3)?'selected="selected"':'';?>><?php echo lang('other');?></option>
										
										</select>
                                </div>
							
                            </div>
                        </div>
						
						 <div class="control-group patient">
                        	<div class="row">
                                <div class="col-md-8">
                                    <label for="name" style="clear:both;"><?php echo lang('patient');?></label>
									   <select name="patient_id" class="form-control chzn patient_id ">
											<option value="">--<?php echo lang('select_patient');?>--</option>
											<?php foreach($contacts as $new) {
													$sel = "";
													if($patient_id==$new->id) $sel = "selected='selected'";
													echo '<option value="'.$new->id.'" '.$sel.'>'.$new->name.','.$new->username.','.$new->email.','.$new->contact.'</option>';
												}
											?>
										</select>
                                </div>
							
                            </div>
                        </div>
						
						<div class="control-group contact" >
                        	<div class="row">
                                <div class="col-md-8">
                                    <label for="name" style="clear:both;"><?php echo lang('contact');?></label>
									   <select name="contact_id" class="form-control chzn contact_id">
											<option value="">--<?php echo lang('select_contact');?>--</option>
											<?php foreach($contact as $new) {
													$sel = "";
													if($contact_id==$new->id) $sel = "selected='selected'";
													echo '<option value="'.$new->id.'" '.$sel.'>'.$new->name.','.$new->email.','.$new->contact.'</option>';
												}
											?>
										</select>
                                </div>
							
                            </div>
                        </div>
						
						<div class="control-group other" >
                        	<div class="row">
                                <div class="col-md-8">
                                    <label for="name" style="clear:both;"><?php echo lang('other');?></label>
									  <input type="text" name="other" class="form-control other_text" style="width:60%" value="<?php echo @$other; ?>"/>
                                </div>
							
                            </div>
                        </div>
						 <div class="control-group motive">
                        	<div class="row">
                                <div class="col-md-8">
                                    <label for="name" style="clear:both;"><?php echo lang('motive');?></label>
									<textarea name="motive" class="form-control motive" style="width:60%"><?php echo @$motive; ?> </textarea>
                                </div>
                            </div>
                        </div>
						
						<div class="control-group paid">
                        	<div class="row">
                                <div class="col-md-8">
                                    <label for="name" style="clear:both;">Is Paid</label>
									<input type="checkbox" name="is_paid" value="1" class="is_paid" <?php echo (@$is_paid==1)?'checked="checked"':'';?> />
					            </div>
                            </div>
                        </div>
				</div>		
				
				<div id="show_hospital">
					 <div class="control-group hospital">
                        	<div class="row">
                                <div class="col-md-8">
                                    <label for="name" style="clear:both;"><?php echo lang('hospital');?></label>
									   <select name="hospital_id" class="form-control chzn patient_id ">
											<option value="">--Select Hospital--</option>
											<?php foreach($hospitals as $new) {
													$sel = "";
													//if($patient_id==$new->id) $sel = "selected='selected'";
													echo '<option value="'.$new->id.'" '.$sel.'>'.$new->name.'</option>';
												}
											?>
										</select>
                                </div>
							
                            </div>
                        </div>
				</div>
				
				<div id="show_college">
					 <div class="control-group college">
                        	<div class="row">
                                <div class="col-md-8">
                                    <label for="name" style="clear:both;">Medical College</label>
									   <select name="college_id" class="form-control chzn patient_id ">
											<option value="">--Select Medical College--</option>
											<?php foreach($college as $new) {
													$sel = "";
													//if($patient_id==$new->id) $sel = "selected='selected'";
													echo '<option value="'.$new->id.'" '.$sel.'>'.$new->name.'</option>';
												}
											?>
										</select>
                                </div>
							
                            </div>
                        </div>
				</div>
				
	<?php /*			

          <label>                    
            <span>                        Location:
            </span>                    
            <input MaxLength="200" id="Location" name="Location" style="width:95%;" type="text" value="<?php echo (!empty($event))?$location:""; ?>" />                 
          </label>                 
          <label>                    
            <span>                        Remark:
            </span>                    
<textarea cols="20" id="Description" name="Description" rows="2" style="width:95%; height:70px">
<?php echo (!empty($event))?$description:""; ?>
</textarea>                
          </label>                
          <input id="timezone" name="timezone" type="hidden" value="" />           
        */ ?>
		</form>         
      </div>         
    </div>
<script>
$("#show_appointment").hide();
$("#show_hospital").hide()
$("#show_college").hide()
$(document).on('change', '.schedule_category', function(){
 var type_id = $(".schedule_category").val();
 if(type_id==1){
 
		$("#show_appointment").hide();
		$(".detail").show();
		//$(".contact").hide();
		//$(".other").hide();
 }	
 if(type_id==2){
 
		$("#show_appointment").show();
		$("#show_hospital").hide()
		$("#show_college").hide()
		$(".detail").hide();
		//$(".contact").hide();
		//$(".other").hide();
 }
 
 if(type_id==3){
 
		$("#show_appointment").hide();
		$("#show_hospital").show()
		$("#show_college").hide();
		$(".detail").hide();
		//$(".contact").hide();
		//$(".other").hide();
 }
 
 if(type_id==4){
 
		$("#show_appointment").hide();
		$("#show_hospital").hide()
		$("#show_college").show()
		$(".detail").hide();
		//$(".contact").hide();
		//$(".other").hide();
 }
 if(type_id==5){
 
		$("#show_appointment").hide();
		$("#show_hospital").hide()
		$("#show_college").hide()
		$(".detail").show();
		//$(".contact").hide();
		//$(".other").hide();
 }		

});

$(".patient").hide();
$(".detail").hide();
$(".paid").hide();
$(".contact").hide();
$(".other").hide();
$(document).on('change', '.whom', function(){
  vch = $(this).val();
  $( "div" ).removeClass( "block" );
	//alert(vch);  
	if(vch==1){
		$(".patient").show();
		$(".paid").show();
		$(".contact").hide();
		$(".other").hide();
		$(".detail").hide();
	}
	
	if(vch==2){
		$(".contact").show();
		$(".patient").hide();
		$(".paid").hide();
		$(".other").hide();
		$(".detail").hide();
	}
	if(vch==3){
		$(".contact").hide();
		$(".patient").hide();
		$(".paid").hide();
		$(".other").show();
		$(".show").hide();
	}

});
setTimeout(function(){ 
vch = $('.whom').val();
//alert(vch);
if(vch==1){
		
		$("#show_appointment").show();
		$(".patient").show();
		$(".paid").show();
		$(".contact").hide();
		$(".other").hide();
		$(".detail").hide();
	}
	
	if(vch==2){
		$("#show_appointment").show();
		$(".contact").show();
		$(".patient").hide();
		$(".paid").hide();
		$(".other").hide();
		$(".detail").hide();
	}
	if(vch==3){
		$("#show_appointment").show();
		$(".contact").hide();
		$(".patient").hide();
		$(".paid").hide();
		$(".other").show();
		$(".show").hide();
	}
 }, 100);
</script>
