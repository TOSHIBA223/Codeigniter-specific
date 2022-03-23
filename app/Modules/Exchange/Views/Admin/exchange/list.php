<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0"><?php echo (!empty($title)?$title:null) ?></h6>
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
                            <th><?php echo display('coin_name') ?></th>
                            <th><?php echo display('fullname') ?></th>
                            <th><?php echo display('wallet_data') ?></th>
                            <th><?php echo display('transection_type') ?></th>
                            <th><?php echo display('coin_amount') ?></th>
                            <th><?php echo display('usd_amount') ?></th>
                            <th><?php echo display('local_amount') ?></th>
                            <th><?php echo display('status') ?></th>
                            <th><?php echo display('action') ?></th>
                        </tr>
                    </thead>    
                    <tbody>
                        <?php if (!empty($exchange)) ?>
                        <?php $sl = 1; ?>
                        <?php foreach ($exchange as $value) { ?>
                        <tr>
                            <td><?php echo esc($sl++); ?></td> 
                            <td>
                                <?php 
                                    foreach ($currency as $ckey => $cvalue) {
                                         echo ($value->coin_id==$cvalue->cid)?esc($cvalue->name):'';
                                    }
                                ?>
                            </td>
                            <td>
                                <?php 
                                    foreach ($userinfo as $ukey => $uvalue) {
                                        echo ($value->user_id==$uvalue->user_id)?esc($uvalue->f_name)." ".esc($uvalue->l_name):'';
                                    }
                                ?>
                            </td>
                            <td><?php echo esc($value->coin_wallet_id); ?></td>
                            <td><?php echo esc($value->transection_type); ?></td>
                            <td><?php echo esc($value->coin_amount); ?></td>
                            <td><?php echo esc($value->usd_amount); ?></td>
                            <td><?php echo esc($value->local_amount); ?></td>
                            <td><?php echo (($value->status==0)?display('cancel'):(($value->status==1)?display('request'):display('complete'))); ?></td>
                            <td>
                                <a href="<?php echo base_url("backend/exchange/edit_exchange/$value->ext_exchange_id") ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="Update"><i class="fas fa-edit" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                        <?php } ?>  
                    </tbody>
                </table>
                <?php echo htmlspecialchars_decode($pager); ?>
            </div> 
        </div>
    </div>
</div>

 <script src="<?php echo base_url()?>/public/assets/plugins/datatables/dataTables.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/responsive.bootstrap4.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/jszip.min.js"></script>

<script src="<?php echo base_url()?>/public/assets/plugins/datatables/pdfmake.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/vfs_fonts.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/buttons.html5.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/buttons.print.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/buttons.colVis.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/data-bootstrap4.active.js"></script>