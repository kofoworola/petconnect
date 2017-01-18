<?php
header('Content-Type: "text/csv"');
header('Content-Disposition: attachment; filename="payment_history.csv"');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header("Content-Transfer-Encoding: binary");
header('Pragma: public');
?>
<?php echo lang('serial_number')?>,<?php echo lang('invoice_number'); ?>,<?php echo 'Patient Name'?>,<?php echo 'Name Of Business'?>,<?php echo 'Amount Paid'?>,<?php echo 'Date Issued'?>,
							<?php $i=1;
							foreach ($payments as $new)
							{?><?php echo $i .","?>
									<?php echo $new->invoice .","?>
									<?php echo $new->patient .","?>
									<?php echo $new->name .","?>
									<?php echo $new->amount .","?>
									<?php echo date("d/m/y", strtotime($new->date)) .","?>
									
									<?php echo ",\n";?>
                                <?php $i++;}?>