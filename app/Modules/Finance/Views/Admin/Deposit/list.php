<div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12">
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0"><?php echo (!empty($title)?esc($title):null) ?></h6>
                    </div>
                    <div class="text-right">
                        <div class="actions">
                             <a href="" class="action-item"><i class="ti-reload"></i></a>
                        </div>
                    </div>
                </div>
            </div>            
            <div class="card-body">
                <table id="example" class="table display table-bordered table-striped table-hover">
                    <thead>
                        <tr> 
                            <th><?php echo display('sl_no') ?></th>
                            <th><?php echo display('user_id') ?></th>
                            <th><?php echo display('amount') ?></th>
                            <th><?php echo display('payment_method') ?></th>
                            <th><?php echo display('fees') ?></th>
                            <th><?php echo display('comments') ?></th>
                            <th><?php echo display('date') ?></th>
                            <th><?php echo display('action')."/".display('status'); ?></th>
                            
                        </tr>
                    </thead> 
                    <tbody>
                        <?php if (!empty($deposit)) ?>
                        <?php $sl = 1; ?>
                        <?php foreach ($deposit as $value) { ?>
                        <tr>
                            <td><?php echo esc($sl++); ?></td>
                            <td><?php echo esc($value->user_id); ?></td>
                            <td><?php echo esc($value->deposit_amount); ?></td>
                            <td><?php echo esc($value->deposit_method); ?></td>
                            <td><?php echo esc($value->fees); ?></td>
                            <td>
                                <?php
                                    if (is_string($value->comments) && is_array(json_decode($value->comments, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false) {
                                       $mobiledata = json_decode($value->comments, true);
                                       echo '<b>OM Name:</b> '.esc($mobiledata['om_name']).'<br>';
                                       echo '<b>OM Phone No:</b> '.esc($mobiledata['om_mobile']).'<br>';
                                       echo '<b>Transaction No:</b> '.esc($mobiledata['transaction_no']).'<br>';
                                       echo '<b>ID Card No:</b> '.esc($mobiledata['idcard_no']);
                                    } else {
                                       echo esc($value->comments);
                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                    $date=date_create($value->deposit_date);
                                    echo date_format($date,"jS F Y"); 
                                ?>
                            </td>
                            <?php if ($value->status==1) { ?>
                            <td><i class="text-success fas fa-check fadeAnim" title="Confirm"></i></td>
                            <?php } else if($value->status==2){ ?>
                            <td><i class="text-danger fas fa-times fadeAnim" title="Cancel"></td>
                            <?php } else { ?>
                            <td width="150px">
                                <a href="<?php echo base_url()?>/backend/confirm_deposit?id=<?php echo $value->deposit_id;?>&user_id=<?php echo $value->user_id;?>&set_status=1" class="btn btn-success btn-sm"><?php echo display('confirm')?></a>
                                <a href="<?php echo base_url()?>/backend/cancel_deposit?id=<?php echo $value->deposit_id;?>&user_id=<?php echo $value->user_id;?>&set_status=2" class="btn btn-danger btn-sm"><?php echo display('cancel')?></a>

                            </td>
                           <?php } ?>
                        </tr>
                        <?php } ?>  
                    </tbody>
                </table>
                <?php echo $pager; ?>
            </div> 
        </div>
    </div>
</div>

 
<script src="<?php echo base_url("public/assets/plugins/datatables/dataTables.min.js") ?>"></script>
<script src="<?php echo base_url("public/assets/plugins/datatables/dataTables.bootstrap4.min.js") ?>"></script>
<script src="<?php echo base_url("public/assets/plugins/datatables/dataTables.responsive.min.js") ?>"></script>
<script src="<?php echo base_url("public/assets/plugins/datatables/responsive.bootstrap4.min.js") ?>"></script>
<script src="<?php echo base_url("public/assets/plugins/datatables/dataTables.buttons.min.js") ?>"></script>
<script src="<?php echo base_url("public/assets/plugins/datatables/buttons.bootstrap4.min.js") ?>"></script>
<script src="<?php echo base_url("public/assets/plugins/datatables/jszip.min.js") ?>"></script>

<script src="<?php echo base_url("public/assets/plugins/datatables/pdfmake.min.js") ?>"></script>
<script src="<?php echo base_url("public/assets/plugins/datatables/vfs_fonts.js") ?>"></script>
<script src="<?php echo base_url("public/assets/plugins/datatables/buttons.html5.min.js") ?>"></script>
<script src="<?php echo base_url("public/assets/plugins/datatables/buttons.print.min.js") ?>"></script>
<script src="<?php echo base_url("public/assets/plugins/datatables/buttons.colVis.min.js") ?>"></script>
<script src="<?php echo base_url("public/assets/plugins/datatables/data-bootstrap4.active.js") ?>"></script> 