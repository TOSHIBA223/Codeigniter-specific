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
                                <th><?php echo display('user_id') ?></th>
                                <th><?php echo display('payment_method') ?></th>
                                <th><?php echo display('wallet_id') ?></th>
                                <th><?php echo display('amount') ?></th>
                                <th><?php echo display('status') ?></th>
                                <th><?php echo display('action') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($withdraw)) ?>
                            <?php $sl = 1; ?>
                            <?php foreach ($withdraw as $value) { ?>
                            <tr>
                                <td><?php echo esc($value->user_id); ?></td>
                                <td><?php echo esc($value->method); ?></td>
                                <td><?php echo esc($value->walletid); ?></td>
                                <td><?php echo esc($value->amount); ?></td>
                                <td>
                                    <?php if($value->status==1){?>
                                      <i class="fas fa-spinner fa-spin text-warning" title="pending"></i>
                                     <?php } else if($value->status==2){?>
                                     <a class="btn btn-success btn-sm"><?php echo display('success')?></a>
                                     <?php } else{ ?>
                                     <a class="btn btn-danger btn-sm"><?php echo display('cancel')?></a>
                                     <?php } ?>
                                 </td>
                                 <td>
                                     <a href="<?php echo base_url()?>/backend/confirm_withdraw?id=<?php echo $value->withdraw_id;?>&user_id=<?php echo $value->user_id;?>&set_status=2" class="btn btn-success btn-sm"><?php echo display('confirm')?></a>
                                     <a href="<?php echo base_url()?>/backend/cancel_withdraw?id=<?php echo $value->withdraw_id;?>&user_id=<?php echo $value->user_id;?>&set_status=3" class="btn btn-danger btn-sm"><?php echo display('cancel')?></a>
                                     <a href="#<?php echo $value->user_id;?>" class="AjaxModal btn btn-info btn-sm" data-toggle="modal" data-target="#newModal"> Information</a>
                                 </td>
                                
                            </tr>
                            <?php } ?> 
                        </tbody>
                    </table>
                    <?php echo $pager; ?>
               
            </div> 
        </div>
    </div>
</div>

<!-- Modal body load from ajax start-->
<div class="modal fade modal-success" id="newModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
   <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><?php echo display('profile');?></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <table>
                <tr><td><strong><?php echo display('name');?> : </strong></td> <td id="name"></td></tr>
                <tr><td><strong><?php echo display('email');?> : </strong></td> <td id="email"></td></tr>
                <tr><td><strong><?php echo display('mobile');?> : </strong></td> <td id="phone"></td></tr>
                <tr><td><strong><?php echo display('user_id');?> : </strong></td> <td id="user_id"></td></tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
    </div><!-- /.modal-content -->
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
<script src="<?php echo base_url("app/Modules/Finance/Assets/Admin/js/custom.js?v=1.5") ?>"></script>