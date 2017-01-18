<?php 
if($setting->image!=""){
				$img ='<img src="'.site_url('assets/uploads/images/'.$data['setting']->image).'"  height="70" width="80" />';
			}else{
				$img ='<img src="'.site_url('assets/img/doctor_logo.png').'"  height="70" width="80" />';
			}
			
?>   

<table width="100%" border="0"  id="print_inv<?php echo $new->id?>" class="bd" >
							<tr>
								<td>
									<table width="100%" style="border-bottom:1px solid #CCCCCC; padding-bottom:20px;">
										<tr>
											<td align="left"><?php if(@$setting->image!=""){?>
											<img src="<?php echo site_url('assets/uploads/images/'.@$setting->image)?>"  height="70" width="80" />
										<?php }else{?>
										<img src="<?php echo site_url('assets/img/doctor_logo.png/')?>"  height="70" width="80" />
											<?php } ?>	</td>
											<td align="right">
												<b><?php echo lang('invoice_number')?> #<?php echo $details->invoice ?></b><br />
												<b><?php echo lang('payment_date') ?>:</b> <?php echo date("d/m/Y", strtotime($details->date));?><br />
												<b><?php echo lang('payment_mode') ?>:</b> <?php echo ($details->payment_mode_id==1)?lang('cash'):lang('cheque'); ?><br/>
												<b><?php echo lang('issue_date') ?>:</b> <?php echo date('d/m/Y')?><br />
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td>
									<table width="100%" border="0" style="border-bottom:1px solid #CCCCCC; padding-bottom:30px;">
										<tr>
											<td align="left"><?php echo lang('payment_to') ?><br />
												 <strong><?php echo @$setting->name ?></strong><br>
										   <?php echo @$setting->address ?><br>
											<?php echo lang('phone') ?>: <?php echo @$setting->contact ?><br/>
											<?php echo lang('email') ?>: <?php echo @$setting->email ?>		
											
											</td>
											<td align="right" colspan="2"><?php echo lang('bill_to') ?><br />
											
											<strong><?php echo $details->doctor ?></strong><br>
											<?php echo $details->address ?><br>
											<?php echo lang('phone') ?>: <?php echo $details->contact ?><br/>
											<?php echo lang('email') ?>: <?php echo $details->email ?>
											</td>
											
										</tr>
									</table>
								</td>
							</tr>
							<tr >
								<th align="left" style="padding-top:10px;"><?php echo lang('invoice_entries') ?></th>
							</tr>
							<tr>  
								<td>
									<table  width="100%" style="border:1px solid #CCCCCC;" >
										<tr>
											<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="10%" align="left"><b>#</b></td>
											<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="75%" align="left"><b><?php echo lang('entry') ?></b></td>
											<td style="border-bottom:1px solid #CCCCCC;"  width="15%"><b><?php echo lang('price') ?></b></td>
										</tr>
										<tr>
											 <td width="10%" style="border-right:1px solid #CCCCCC" >1</td>
											 <td width="75%" style="border-right:1px solid #CCCCCC"><?php echo lang('payment') ?></td>
											 <td width="15%" ><?php echo $details->amount ?></td>
											
										</tr>
									</table>
								</td>
							</tr>
						</table>

<table width="100%" border="1" id="print_inv<?php echo $new->id?>" class="bd" >
							<tr>
								<td>
									<table width="100%">
										<tr>
											<td align="left"><?php if(@$setting->image!=""){?>
											<img src="<?php echo site_url('assets/uploads/images/'.@$setting->image)?>"  height="70" width="80" />
										<?php }else{?>
										<img src="<?php echo site_url('assets/img/doctor_logo.png/')?>"  height="70" width="80" />
											<?php } ?>	</td>
											<td align="right">
												<b><?php echo lang('invoice_number')?> #<?php echo $details->invoice ?></b><br />
												<b><?php echo lang('payment_date') ?>:</b> <?php echo date("d/m/Y", strtotime($details->date));?><br />
												<b><?php echo lang('payment_mode') ?>:</b> <?php echo ($details->payment_mode_id==1)?'Cash':'Cheque'; ?><br/>
												<b><?php echo lang('issue_date') ?>:</b> <?php echo date('d/m/Y')?><br />
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td>
									<table width="100%" border="0">
										<tr>
											<td align="left"><?php echo lang('payment_to') ?><br />
												 <strong><?php echo @$setting->name ?></strong><br>
										   <?php echo @$setting->address ?><br>
											<?php echo lang('phone') ?>: <?php echo @$setting->contact ?><br/>
											<?php echo lang('email') ?>: <?php echo @$setting->email ?>		
											
											</td>
											<td align="right" colspan="2"><?php echo lang('bill_to') ?><br />
											
											<strong><?php echo $details->doctor ?></strong><br>
											<?php echo $details->address ?><br>
											<?php echo lang('phone') ?>: <?php echo $details->contact ?><br/>
											<?php echo lang('email') ?>: <?php echo $details->email ?>
											</td>
											
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<th align="left"><?php echo lang('invoice_entries') ?></th>
							</tr>
							<tr>
								<td>
									<table border="0" width="100%">
										<tr>
											<th width="10%" align="left">#</th>
											<th width="75%" align="left"><?php echo lang('entry') ?></th>
											<th width="15%"><?php echo lang('price') ?></th>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td>
									<table border="0" width="100%">
										<tr>
											 <td width="10%" align="left">1</td>
											 <td width="75%"><?php echo lang('payment') ?></td>
											 <td width="15%" align="right"><?php echo $details->amount ?></td>
											
										</tr>
									</table>
								</td>
							</tr>
						</table>
