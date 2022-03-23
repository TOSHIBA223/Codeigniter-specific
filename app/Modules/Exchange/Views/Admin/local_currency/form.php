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
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="border_preview">
                <?php echo form_open_multipart(base_url("backend/currency/local_currency")) ?>
                <?php echo form_hidden('currency_id', esc($local_currency->currency_id)) ?> 
                    <div class="form-group row">
                        <label for="currency_name" class="col-sm-4 col-form-label"><?php echo display('currency_name') ?></label>
                        <div class="col-sm-8">
                            <input name="currency_name" value="<?php echo esc($local_currency->currency_name) ?>" class="form-control" type="text" id="currency_name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="currency_iso_code" class="col-sm-4 col-form-label"><?php echo display('currency_iso_code') ?></label>
                        <div class="col-sm-8">
                            <input name="currency_iso_code" value="<?php echo esc($local_currency->currency_iso_code) ?>" class="form-control" type="text" id="currency_iso_code">
                        </div>
                    </div> 
                    <div class="form-group row">
                        <label for="usd_exchange_rate" class="col-sm-4 col-form-label"><?php echo display('usd_exchange_rate') ?></label>
                        <div class="col-sm-8">
                            <input name="usd_exchange_rate" value="<?php echo esc($local_currency->usd_exchange_rate) ?>" class="form-control" type="text" id="usd_exchange_rate">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="currency_symbol" class="col-sm-4 col-form-label"><?php echo display('currency_symbol') ?></label>
                        <div class="col-sm-8">
                            <input name="currency_symbol" value="<?php echo esc($local_currency->currency_symbol) ?>" class="form-control" type="text" id="currency_symbol">
                        </div>
                    </div> 
                    <div class="form-group row">
                        <label for="currency_position" class="col-sm-4 col-form-label"><?php echo display('symbol_position') ?><i class="text-danger">*</i></label>
                        <div class="col-sm-8">
                            <select class="form-control basic-single" name="currency_position" id="currency_position">
                                <option value="l" <?php echo $local_currency->currency_position=='l'?'Selected':NULL ?>>Left</option>
                                <option value="r" <?php echo $local_currency->currency_position=='r'?'Selected':NULL ?>>Right</option>
                            </select>
                        </div>
                    </div>
                    <div class="row" align="center">
                        <div class="col-sm-12 col-sm-offset-3">
                            <a href="<?php echo base_url('backend/dashboard'); ?>" class="btn btn-primary  w-md m-b-5"><?php echo display("cancel") ?></a>
                            <button type="submit" class="btn btn-success  w-md m-b-5"><?php echo $local_currency->currency_id?display("update"):display("create") ?></button>
                        </div>
                    </div>
                <?php echo form_close() ?>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

 