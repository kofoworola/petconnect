                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo lang('date');?></th>
								<th><?php echo lang('name');?></th>
								<th width="50%"></th>
                            </tr>
                        </thead>
                        
                        <?php if(isset($prescriptions)):?>
                        <tbody>
                            <?php $i=1;foreach ($prescriptions as $prescription){
							$date = new DateTime($prescription->dob);
 							$now = new DateTime();
 							$interval = $now->diff($date);
  
							?>
                                <tr class="gc_row">
                                    <td><?php echo date("d/m/y h:i:a", strtotime($prescription->date_time))?></td>
                                    <td><?php echo $prescription->patient?></td>
								    <td width="50%">
                                        <div class="btn-group">
                                          <a class="btn btn-primary" style="margin-left:10px;"  href="#report<?php echo $prescription->id?>" data-toggle="modal"><i class="fa fa-file"></i> <?php echo lang('view_diagonsis_report');?></a>
										  <a class="btn btn-primary" style="margin-left:10px;"  href="#myModal<?php echo $prescription->id?>"  data-toggle="modal"><i class="fa fa-eye"></i> <?php echo lang('view');?> <?php echo lang('prescription');?></a>
										  <a class="btn btn-primary" style="margin-left:10px;"  href="#edit<?php echo $prescription->id; ?>" data-toggle="modal"><i class="fa fa-edit"></i> <?php echo lang('edit');?></a>
                                         <a class="btn btn-danger" style="margin-left:20px;" href="<?php echo site_url('admin/prescription/delete/'.$prescription->id); ?>" onclick="return areyousure()"><i class="fa fa-trash"></i> <?php echo lang('delete');?></a>
                                        </div>
                                    </td>
                                </tr>
                                <?php $i++;}?>
                        </tbody>
                        <?php endif;?>
                    </table>
