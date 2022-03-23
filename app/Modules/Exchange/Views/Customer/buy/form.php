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
                             <a class="btn btn-success w-md m-b-5 " href="<?php echo base_url("customer/buy/buy_list") ?>"><i class="fa fa-list" aria-hidden="true"></i> <?php echo display('buy_list') ?></a>
                            <a href=" " class="action-item"><i class="ti-reload"></i></a>
                        </div>
                    </div>
                </div>
            </div>            
            <div class="card-body">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                    <div class="border_preview">
                    <?php echo form_open_multipart(base_url("customer/buy/buy_form"),array('id'=>'buy_form')); ?>
                        <div class="form-group row">
                            <label for="cid" class="col-sm-4 col-form-label"><?php echo display("cryptocurrency") ?></label>
                            <div class="col-sm-8">
                                <select class="form-control basic-single" name="cid" id="cid">
                                    <option value=""><?php echo display("select_cryptocurrency") ?></option>
                                    <?php foreach ($currency as $key => $value) {  ?>
                                         <option value="<?php echo esc($value->coin_id); ?>"><?php echo esc($value->coin_name); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="buy_amount" class="col-sm-4 col-form-label"><?php echo display("buy_amount") ?></label>
                            <div class="col-sm-8">
                                <input name="buy_amount" class="form-control buy_amount" type="text" id="buy_amount" disabled>
                            </div>
                        </div>
                        <span class="buy_payable">
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <fieldset>
                                        <legend><?php echo display("payable") ?>:</legend>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th><?php echo display("currency") ?></th>
                                                    <th><?php echo display("payable") ?></th>
                                                    <th><?php echo display("rate") ?></th>
                                                </tr>
                                                <tr>
                                                    <td>USD</td>
                                                    <td>$</td>
                                                    <td>0</td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo esc($selectedlocalcurrency->currency_name); ?></td>
                                                    <td><?php echo esc($selectedlocalcurrency->currency_symbol); ?></td>
                                                    <td>0</td>
                                                </tr>
                                            </table>
                                        </div>
                                     </fieldset>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="wallet_id" class="col-sm-4 col-form-label">Your <i></i> <?php echo display("wallet_data") ?></label>
                                <div class="col-sm-8">
                                    <input name="wallet_id" class="form-control" type="text" id="wallet_id" autocomplete="off">
                                </div>
                            </div>
                        </span>
                        <div class="form-group row">
                            <label for="payment_method" class="col-sm-4 col-form-label"><?php echo display("payment_method") ?></label>
                            <div class="col-sm-8">
                                <select class="form-control basic-single" name="payment_method" id="payment_method">
                                    <option value=""><?php echo display("select_payment_method") ?></option>
                                    <?php foreach ($payment_gateway as $key => $value) {  ?>
                                    <option value="<?php echo esc($value->identity); ?>"><?php echo esc($value->agent); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <span class="payment_info">
                            <div class="form-group row">
                                <label for="comments" class="col-sm-4 col-form-label"><?php echo display("comments") ?></label>
                                <div class="col-sm-8">
                                    <textarea name="comments" class="form-control editor" placeholder="" type="text" id="comments" autocomplete="off"></textarea>
                                </div>
                            </div>
                        </span>
                        <div class="row" align="center">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-success w-md m-b-5"><?php echo display("buy") ?></button>
                                <a href="<?php echo base_url('customer/dashboard'); ?>" class="btn btn-primary  w-md m-b-5"><?php echo display("cancel") ?></a>
                            </div>
                        </div>
                        <?php echo form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url("public/assets/js/main_custom.js?v=5.9") ?>" type="text/javascript"></script>
<script src="<?php echo base_url("app/Modules/Exchange/Assets/Customer/js/custom.js?v=1.1") ?>" type="text/javascript"></script>