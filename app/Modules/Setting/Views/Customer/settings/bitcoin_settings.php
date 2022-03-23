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
                            <a href=" " class="action-item"><i class="ti-reload"></i></a>
                        </div>
                    </div>
                </div>
            </div>            
            <div class="card-body">
                <div class="row">
                    
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="border_preview">
                            <?php echo form_open(base_url('customer/settings/payment_method_update'));?>

                                <div class="form-group row">
                                    <label class="col-form-label"><?php echo display('payment_method');?><span class="text-danger"> *</span></label>
                                    <div class="col-sm-12">
                                        <input class="form-control" type="text" disabled value="bitcoin">
                                        <input name="bitcoin" class="form-control" type="hidden" value="bitcoin">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label  class="col-form-label"><?php echo display('bitcoin_wallet_id');?><span class="text-danger"> *</span></label>
                                    <div class="col-sm-12">
                                        <input class="form-control" name="bitcoin_wallet_id" value="<?php echo esc(@$bitcoin->wallet_id); ?>" required type="text">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-8">
                                       <button type="submit" class="btn btn-success"><?php echo display("update") ?></button>
                                    </div>
                                </div>
                            <?php echo form_close();?>
                        </div>
                    </div>


                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="border_preview">
                            <?php echo form_open(base_url('customer/settings/payment_method_update'));?>

                                <div class="form-group row">
                                    <label class="col-form-label"><?php echo display('payment_method');?><span class="text-danger"> *</span></label>
                                    <div class="col-sm-12">
                                        <input  class="form-control" type="text" disabled value="payeer">
                                        <input name="payeer" class="form-control" type="hidden" value="payeer">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label  class="col-form-label"><?php echo display('payeer_wallet_id');?> <span class="text-danger"> *</span></label>
                                    <div class="col-sm-12">
                                        <input class="form-control" name="payeer_wallet_id" value="<?php echo esc(@$payeer->wallet_id); ?>" required type="text">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-8">
                                       <button type="submit" class="btn btn-success"><?php echo display("update") ?></button>
                                    </div>
                                </div>
                            <?php echo form_close();?>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="border_preview">
                            <?php echo form_open(base_url('customer/settings/payment_method_update'));?>

                                <div class="form-group row">
                                    <label class="col-form-label"><?php echo display('payment_method');?><span class="text-danger"> *</span></label>
                                    <div class="col-sm-12">
                                        <input  class="form-control" type="text" disabled value="paypal">
                                        <input name="paypal" class="form-control" type="hidden" value="paypal">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label  class="col-form-label">Paypal <span class="text-danger"> *</span></label>
                                    <div class="col-sm-12">
                                        <input class="form-control" name="phone_no" value="<?php echo esc(@$paypal->wallet_id); ?>" required type="text">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-8">
                                       <button type="submit" class="btn btn-success"><?php echo display("update") ?></button>
                                    </div>
                                </div>
                            <?php echo form_close();?>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="border_preview">
                            <?php echo form_open(base_url('customer/settings/payment_method_update'));?>

                                <div class="form-group row">
                                    <label class="col-form-label"><?php echo display('payment_method');?><span class="text-danger"> *</span></label>
                                    <div class="col-sm-12">
                                        <input  class="form-control" type="text" disabled value="stripe">
                                        <input name="stripe" class="form-control" type="hidden" value="stripe">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label  class="col-form-label">Stripe <span class="text-danger"> *</span></label>
                                    <div class="col-sm-12">
                                        <input class="form-control" name="phone_no" value="<?php echo esc(@$stripe->wallet_id); ?>" required type="text">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-8">
                                       <button type="submit" class="btn btn-success"><?php echo display("update") ?></button>
                                    </div>
                                </div>
                            <?php echo form_close();?>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="border_preview">
                            <?php echo form_open(base_url('customer/settings/payment_method_update'));?>

                                <div class="form-group row">
                                    <label class="col-form-label"><?php echo display('payment_method');?><span class="text-danger"> *</span></label>
                                    <div class="col-sm-12">
                                        <input  class="form-control" type="text" disabled value="phone">
                                        <input name="phone" class="form-control" type="hidden" value="phone">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label  class="col-form-label"><?php echo display('mobile');?><span class="text-danger"> *</span></label>
                                    <div class="col-sm-12">
                                        <input class="form-control" name="phone_no" value="<?php echo esc(@$phone->wallet_id); ?>" required type="text">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-8">
                                       <button type="submit" class="btn btn-success"><?php echo display("update") ?></button>
                                    </div>
                                </div>
                            <?php echo form_close();?>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="border_preview">
                            <?php echo form_open(base_url('customer/settings/payment_method_update'));?>

                                <div class="form-group row">
                                    <label class="col-form-label"><?php echo display('payment_method');?><span class="text-danger"> *</span></label>
                                    <div class="col-sm-12">
                                        <input  class="form-control" type="text" disabled value="paystack">
                                        <input name="paystack" class="form-control" type="hidden" value="paystack">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label  class="col-form-label">Paystack<span class="text-danger"> *</span></label>
                                    <div class="col-sm-12">
                                        <input class="form-control" name="phone_no" value="<?php echo esc(@$paystack->wallet_id); ?>" required type="text">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-8">
                                       <button type="submit" class="btn btn-success"><?php echo display("update") ?></button>
                                    </div>
                                </div>
                            <?php echo form_close();?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div> <!-- /.row -->