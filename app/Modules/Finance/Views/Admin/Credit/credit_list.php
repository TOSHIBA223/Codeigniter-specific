<div class="row">
    <div class="col-md-12 col-lg-12">
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
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-hover table-bordered">
                            
                            <thead>
                                <tr>
                                    <th><?php echo display('sl_no')?></th>
                                    <th><?php echo display('user_id')?></th>
                                    <th><?php echo display('amount')?></th>
                                    <th><?php echo display('comment')?></th>
                                    <th><?php echo display('action')?></th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if($credit_info!=NULL){ 
                                    $i=1;
                                    foreach ($credit_info as $key => $value) {  
                                ?>
                                <tr>
                                    <td><?php echo esc($i++);?></td>
                                    <td><?php echo esc($value->user_id);?></td>
                                    <td>$<?php echo esc($value->deposit_amount);?></td>
                                    <td><?php echo esc($value->comments);?></td>
                                    <td>
                                        <a class="btn btn-success" href="<?php echo base_url()?>/backend/credit/credit_details/<?php echo $value->deposit_id;?>"><?php echo display('view');?></a>
                                    </td>
                                </tr>
                                <?php } } ?>
                            </tbody>
                        </table>
                    </div>
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
