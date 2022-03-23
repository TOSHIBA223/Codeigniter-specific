<div class="row">
    <div class="col-md-6 col-lg-6 d-flex">
        <div class="card mb-4 flex-fill w-100">
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
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group row">
                        <label for="cid" class="col-sm-4 col-form-label"><?php echo display('user_id') ?></label>
                        <div class="col-sm-8">
                            <?php echo esc($user->user_id) ?></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="cid" class="col-sm-4 col-form-label"><?php echo display('username') ?></label>
                        <div class="col-sm-8">
                            <?php echo esc($user->username) ?></span>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="cid" class="col-sm-4 col-form-label"><?php echo display('sponsor_id') ?></label>
                        <div class="col-sm-8">
                            <?php echo esc($user->sponsor_id) ?></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="cid" class="col-sm-4 col-form-label"><?php echo display('language') ?></label>
                        <div class="col-sm-8">
                            <?php echo esc($user->language) ?></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="cid" class="col-sm-4 col-form-label"><?php echo display('firstname') ?></label>
                        <div class="col-sm-8">
                            <?php echo esc($user->f_name) ?></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="cid" class="col-sm-4 col-form-label"><?php echo display('lastname') ?></label>
                        <div class="col-sm-8">
                            <?php echo esc($user->l_name) ?></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="cid" class="col-sm-4 col-form-label"><?php echo display('email') ?></label>
                        <div class="col-sm-8">
                            <?php echo esc($user->email) ?></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="cid" class="col-sm-4 col-form-label"><?php echo display('mobile') ?></label>
                        <div class="col-sm-8">
                            <?php echo esc($user->phone) ?></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="cid" class="col-sm-4 col-form-label"><?php echo display('registered_ip') ?></label>
                        <div class="col-sm-8">
                            <?php echo esc($user->reg_ip) ?></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="cid" class="col-sm-4 col-form-label"><?php echo display('status') ?></label>
                        <div class="col-sm-8">
                            <?php echo ($user->status==1)?display('active'):display('inactive'); ?></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="cid" class="col-sm-4 col-form-label">Registered Date</label>
                        <div class="col-sm-8">
                            <?php 
                                $date=date_create($user->created);
                                echo date_format($date,"jS F Y");  
                            ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-6 d-flex">
        <div class="card mb-4 flex-fill w-100">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0"><?php echo display("deposit");?></h6>
                    </div>
                    <div class="text-right">
                        <div class="actions">
                           <h6 class="fs-17 font-weight-600 mb-0">  <?php echo display("balance");?>: $<?php echo esc($balance['balance']) ?> </h6>
                        </div>
                    </div>
                </div>
            </div>            
            <div class="card-body">
                <?php echo form_open('#',array('id'=>'ajaxdeposittableform','name'=>'ajaxdeposittableform')); ?>
                <input type="hidden" name="user_id" id="user_id" value="<?php echo esc($user->user_id) ?>">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <table id="deposittable" class="table  table-bordered table-striped table-hover">
                        <thead>
                            <tr> 
                                <th><?php echo display('sl_no') ?></th>
                                <th><?php echo display('deposit_amount') ?></th> 
                                <th><?php echo display('deposit_method') ?></th> 
                                <th><?php echo display('date') ?></th> 
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-6 d-flex">
        <div class="card mb-4 flex-fill w-100">
            <div class="card-header">

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0"><?php echo display("investment");?></h6>
                    </div>
                    <div class="text-right">
                        <div class="actions">
                             <a href="" class="action-item"><i class="ti-reload"></i></a>
                        </div>
                    </div>
                </div>
            </div>            
            <div class="card-body">
                <?php echo form_open('#',array('id'=>'ajaxinvesttableform','name'=>'ajaxinvesttableform')); ?>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <table id="investable" class="table  table-bordered table-striped table-hover">
                        <thead>
                            <tr> 
                                <th><?php echo display('sl_no') ?></th>
                                <th><?php echo display('order_id') ?></th> 
                                <th><?php echo display('package_name') ?></th> 
                                <th><?php echo display('amount') ?></th> 
                                <th><?php echo display('date') ?></th> 
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 d-flex">
        <div class="card mb-4 flex-fill w-100">
            <div class="card-header">

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0"><?php echo display("withdraw");?></h6>
                    </div>
                    <div class="text-right">
                        <div class="actions">
                             <a href="" class="action-item"><i class="ti-reload"></i></a>
                        </div>
                    </div>
                </div>
            </div>            
            <div class="card-body">
                <?php echo form_open('#',array('id'=>'ajaxwithdrawtableform','name'=>'ajaxwithdrawtableform')); ?>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <table id="withdrawtable" class="table  table-bordered table-striped table-hover">
                        <thead>
                            <tr> 
                                <th><?php echo display('sl_no') ?></th>
                                <th><?php echo display('wallet_id') ?></th> 
                                <th><?php echo display('amount') ?></th> 
                                <th><?php echo display('fees') ?></th> 
                                <th><?php echo display('date') ?></th> 
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 d-flex">
        <div class="card mb-4 flex-fill w-100">
            <div class="card-header">

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0"><?php echo display("transfer_send");?></h6>
                    </div>
                    <div class="text-right">
                        <div class="actions">
                             <a href="" class="action-item"><i class="ti-reload"></i></a>
                        </div>
                    </div>
                </div>
            </div>            
            <div class="card-body">
                <?php echo form_open('#',array('id'=>'ajaxtransfertableform','name'=>'ajaxtransfertableform')); ?>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <table id="transfertable" class="table  table-bordered table-striped table-hover">
                        <thead>
                            <tr> 
                                <th><?php echo display('sl_no') ?></th>
                                <th><?php echo display('receive_id') ?></th> 
                                <th><?php echo display('amount') ?></th> 
                                <th><?php echo display('fees') ?></th> 
                                <th><?php echo display('date') ?></th> 
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 d-flex">
        <div class="card mb-4 flex-fill w-100">
            <div class="card-header">

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0"><?php echo display("transfer_receive");?></h6>
                    </div>
                    <div class="text-right">
                        <div class="actions">
                             <a href="" class="action-item"><i class="ti-reload"></i></a>
                        </div>
                    </div>
                </div>
            </div>            
            <div class="card-body">
                <?php echo form_open('#',array('id'=>'transferreceivetableform','name'=>'transferreceivetableform')); ?>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <table id="transferreceivetable" class="table  table-bordered table-striped table-hover">
                        <thead>
                            <tr> 
                                <th><?php echo display('sl_no') ?></th>
                                <th><?php echo display('sender_id') ?></th> 
                                <th><?php echo display('amount') ?></th> 
                                <th><?php echo display('fees') ?></th> 
                                <th><?php echo display('date') ?></th> 
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
                <?php echo form_close(); ?>
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
<script src="<?php echo base_url("app/Modules/User/Assets/Admin/js/custom.js") ?>"></script>