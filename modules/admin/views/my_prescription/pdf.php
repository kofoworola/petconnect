<style>
th{text-align:left}
</style>
<?php 
if($setting->image!=""){
				$img ='<img src="'.base_url('assets/uploads/images/'.$data['setting']->image).'"  height="70" width="80" />';
			}else{
				$img ='';
			}
?>			
<table border="1" width="90%" align="center">
	<tr>
		<td colspan="3">
			<table border="0" width="100%"> 
				<tr>
					<td width="20%"><?php $img?></td>
					<td colspan="2"><h2><?php echo $setting->name ?></h2><b><?php echo lang('phone');?></b> : <?php echo $setting->contact ?><b> <?php echo lang('email');?></b> : <?php echo $setting->email?></td>
				
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<th colspan="3"><h3 ><?php echo lang('prescription');?></h3></td>
	</tr>
	<tr>
		<th><label for="name" style="clear:both;"> <?php echo lang('patient');?></label></td>
		<td><?php echo $prescription->patient?></td>
		<td width="20%"><label for="name" style="clear:both;"> <?php echo lang('date');?></label> - <?php echo date("d/m/Y", strtotime($prescription->date_time))?></td>
	</tr>
	<tr>
		<th><label for="name" style="clear:both;"> <?php echo lang('disease');?></label></td>
		<td colspan="2">
			<?php $d = json_decode($prescription->disease);
				
				if(is_array($d)){
					foreach($d as $new){
						echo	$dis = $new .',';
					}
				}else{
					echo $d;
				}
				?>
		</td>
	</tr>
	<tr>
		<th><label for="name" style="clear:both;"> <?php echo lang('medicine');?></label></td>
		<td colspan="2">
			<?php $d = json_decode($prescription->medicines);
										if(is_array($d)){
											foreach($d as $new){
												echo	$med = $new .',';
											}
										}else{
											echo $d;
										}	
							?>
		</td>
	</tr>
	<tr>
		<th><label for="name" style="clear:both;"> <?php echo lang('medical_test');?></label></td>
		<td colspan="2">
			<?php $d = json_decode($prescription->tests);
										if(is_array($d)){
											foreach($d as $new){
												echo	$test = $new .',';
											}
										}else{
											echo $d;
										}	
										?>
		</td>
	</tr>
	<tr>
		<th><label for="name" style="clear:both;"> <?php echo lang('remark');?></label></td>
		<td colspan="2"><?php echo $prescription->remark?></td>
	</tr>

</table>	   	
   
                   
								
						
						
					