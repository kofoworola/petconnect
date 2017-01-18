
<!-- Content Header (Page header) -->
<style>
.row{
	margin-bottom:10px;
}
</style>
 <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo lang('patient')?>
        <small><?php echo lang('view')?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin')?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
        <li><a href="<?php echo site_url('admin/patients')?>"><?php echo lang('patients')?></a></li>
        <li class="active"><?php echo lang('view')?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"><?php echo lang('view')?></h3>
                </div><!-- /.box-header -->
                <!-- form start -->
				<form method="post">
                    <div class="box-body">
                        <div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
                                    <label for="name" style="clear:both;"><?php echo lang('name')?></label>
								</div>
								 <div class="col-md-4">	
									<?php echo $patient->name?>
                                </div>
                            </div>
                        </div>
						
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
                                    <label for="name" style="clear:both;"><?php echo lang('profile')?> <?php echo lang('picture')?></label>
									
                               </div>
								 <div class="col-md-4">	
								 <?php 
								 if(!empty($patient->image)){
								 ?>
								 <img src="<?php echo site_url('assets/uploads/images/'.$patient->image);?>" height="90" width="110" />
								 <?php 
								 	}
								?>	
								 </div>
                            </div>
                        </div>
						
						
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
                                    <label for="gender" style="clear:both;"><?php echo lang('gender')?></label>
									</div>
								 <div class="col-md-4">	
									<?php echo $patient->gender?>
                                </div>
                            </div>
                        </div>
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
                                    <label for="name" style="clear:both;"><?php echo lang('blood_type');?></label>
								</div>
								 <div class="col-md-4">		  
									
											<?php foreach($groups as $new) {
													$sel = "";
													if($new->id==$patient->blood_group_id){
													echo	$new->name;
													}
												}
												
											?>
									</div>
                            </div>
                        </div>
               
			   			 <div class="form-group">
                              <div class="row">
                                <div class="col-md-3">
                                    <label for="dob" style="clear:both;"><?php echo lang('date_of_birth')?></label>
									
								</div>
								 <div class="col-md-4">	
								 	<?php echo $patient->dob?>
									
                                </div>
                            </div>
                        </div>
						
                        <div class="form-group">
                              <div class="row">
                                <div class="col-md-3">
                                    <label for="email" style="clear:both;"><?php echo lang('email')?></label>
								</div>
								 <div class="col-md-4">		
									<?php echo $patient->email?>
									
                                </div>
                            </div>
                        </div>
						
						<div class="form-group">
                              <div class="row">
                                <div class="col-md-3">
                                    <label for="username" style="clear:both;"><?php echo lang('username')?></label>
									</div>
								 <div class="col-md-4">	
									<?php echo $patient->username?>
							   </div>
                            </div>
                        </div>
						
						
						
						
						 <div class="form-group">
                              <div class="row">
                                <div class="col-md-3">
                                    <label for="contact" style="clear:both;"><?php echo lang('phone')?></label>
								</div>
								 <div class="col-md-4">		
								 	<?php echo $patient->contact?>
                                </div>
                            </div>
                        </div>
						
						 <div class="form-group">
                              <div class="row">
                                <div class="col-md-3">
                                    <label for="contact" style="clear:both;"><?php echo lang('address')?></label>
								</div>
								 <div class="col-md-4">		
									<?php echo $patient->address?>
                                </div>
                            </div>
                        </div>

										<?php 
					$CI = get_instance();
						if($fields){
							foreach($fields as $doc){
							$output = '';
							if($doc->field_type==1) //testbox
							{
						?>
						<div class="form-group">
                              <div class="row">
							  
                                <div class="col-md-3">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
								</div>
								<div class="col-md-4">	
							<?php  $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '".$doc->id."' AND table_id = '".$patient->id."' AND form = '".$doc->form."' ")->row();?>		
							<?php echo @$result->reply; ?>
								</div>
                            </div>
                        </div>
					 <?php 	}	
							if($doc->field_type==2) //dropdown list
							{
								$values = explode(",", $doc->values);
					?>	<div class="form-group">
                              <div class="row">
                                <div class="col-md-3">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
								</div>
								<div class="col-md-4">
								<?php  $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '".$doc->id."' AND table_id = '".$patient->id."'  ")->row();?>	
										<?php 
										$values = array();
										foreach($values as $key=>$val) {
											$sel='';
											if($val==$result->reply) echo $val;
										}
							?>			
								</div>
                            </div>
                        </div>
						<?php	}	
								if($doc->field_type==3) //radio buttons
							{
								$values = explode(",", $doc->values);
					?>	<div class="form-group">
                              <div class="row">
                                <div class="col-md-3">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
						
								</div>
								<div class="col-md-4">	
							<?php	
										foreach($values as $key=>$val) { ?>
							<?php 
							$x="";
							$result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '".$doc->id."' AND table_id = '".$patient->id."' AND form = '".$doc->form."' ")->row();
							if(!empty($result->reply)){
								if($result->reply==$val){
									$x= 'checked="checked"';
								}else{
									$x='';
								}
							}
							?>			
						
						<input type="radio" name="reply[<?php echo $doc->id ?>]"disabled="disabled" value="<?php echo $val;?>" <?php echo $x;?> />	<?php echo $val;?> &nbsp; &nbsp; &nbsp; &nbsp;
 							<?php 			}
							?>			
								</div>
                            </div>
                        </div>
						
						<?php }
						if($doc->field_type==4) //checkbox
							{
								$values = explode(",", $doc->values);
					?>	<div class="form-group">
                              <div class="row">
                                <div class="col-md-3">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
								</div>
								<div class="col-md-4">
							<?php	
										foreach($values as $key=>$val) { ?>
							<?php 
							$x="";
							$result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '".$doc->id."' AND table_id = '".$patient->id."' AND form = '".$doc->form."' ")->row();
							if(!empty($result->reply)){
								if($result->reply==$val){
									$x= 'checked="checked"';
								}else{
									$x='';
								}
							}
							?>	
										
										<input type="checkbox" disabled="disabled" name="reply[<?php echo $doc->id ?>]"  <?php echo $x;?> value="<?php echo $val;?>" class="form-control" />	&nbsp; &nbsp; &nbsp; &nbsp;
 							<?php 			}
							?>			
								</div>
                            </div>
                        </div>
					<?php }	if($doc->field_type==5) //Textarea
						  {		?>	<div class="form-group">
                              <div class="row">
                                <div class="col-md-3">
                                    <label for="contact" style="clear:both;"><?php echo $doc->name; ?></label>
								</div>
								<div class="col-md-4">
									<?php  $result = $CI->db->query("select * from rel_form_custom_fields where custom_field_id = '".$doc->id."' AND table_id = '".$patient->id."' AND form = '".$doc->form."'")->row();?>	
									<?php echo @$result->reply;?>
								</div>
                            </div>
                        </div>
							
						
						
					<?php 
								}	
							}
						}
					?>		

                    </div><!-- /.box-body -->
    
                   
             <?php form_close()?>
            </div><!-- /.box -->
        </div>
     </div>
</section>  

<script src="<?php echo site_url('assets/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')?>" type="text/javascript"></script>
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