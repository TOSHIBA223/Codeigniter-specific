<link href="<?php echo base_url("app/Modules/Gourl/Assets/Admin/css/custom.css?v=1.1") ?>" rel="stylesheet" type="text/css" />
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
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                
                    <div class="form-group row">
                        <div class="col-form-label col-sm-4">
                            <label class="col-form-label ">Callback Url</label>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <input type="text" class="form-control" id="copyed1" value="<?php echo base_url('customer/payment_callback/gourl_callback'); ?>" readonly>
                                <span class="input-group-btn">
                                    <button class="btn btn-primary copy1" type="button">Copy</button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <?php echo form_open_multipart("backend/payment_gateway/gourl_setting") ?>
                <?php echo form_hidden('id', esc($payment_gateway->id)) ?> 
                <div class="form-group row">
                        <label for="agent" class="col-sm-4 col-form-label"><?php echo display('gateway_name') ?></label>
                        <div class="col-sm-6">
                            <input name="agent" value="<?php echo esc($payment_gateway->agent) ?>" class="form-control" type="text" id="agent">
                        </div>
                        <div class='col-sm-2'>
                           <a href='https://gourl.io/view/registration' target='_blank'>Create Account</a>
                        </div>
                </div>
                <div class="form-group row">
                            <label for="public_key" class="col-sm-4 col-form-label"><?php echo esc(display('public_key')); ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input name="public_key" value="<?php echo esc($payment_gateway->public_key) ?>" class="form-control" type="text" id="public_key" required>
                            </div>
                        </div> 
                        <div class="form-group row">
                            <label for="private_key" class="col-sm-4 col-form-label"><?php echo esc(display('private_key')); ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input name="private_key" value="<?php echo esc($payment_gateway->private_key) ?>" class="form-control" type="text" id="private_key" required>
                            </div>
                        </div>
                        <div class="form-group row">
                        <label for="status" class="col-sm-4 col-form-label"><?php echo display('status') ?></label>
                        <div class="col-sm-6">
                            <label class="radio-inline">
                                <?php echo form_radio('status', '1', (($payment_gateway->status==1 || $payment_gateway->status==null)?true:false)); ?><?php echo display('active') ?>
                             </label>
                            <label class="radio-inline">
                                <?php echo form_radio('status', '0', (($payment_gateway->status=="0")?true:false) ); ?><?php echo display('inactive') ?>
                             </label> 
                        </div>
                    </div>
                    <div class="row" align="center">
                        <div class="col-sm-12 col-sm-offset-3">
                            <a href="<?php echo base_url('admin'); ?>" class="btn btn-primary  w-md m-b-5"><?php echo display("cancel") ?></a>
                            <button type="submit" class="btn btn-success  w-md m-b-5"><?php echo display("update") ?></button>
                        </div>
                    </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>
</div>
<script src="<?php echo base_url("app/Modules/Payeer/Assets/Admin/js/custom.js?v=1.1") ?>" type="text/javascript"></script>