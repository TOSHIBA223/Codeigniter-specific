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
                        <td>$
                            <?php echo esc($payableusd); ?>
                            <?php echo form_hidden('usd_amount', esc($payableusd)) ?>
                        </td>
                        <td>
                            <?php echo esc($price_usd); ?>
                            <?php echo form_hidden('rate_coin', esc($price_usd)) ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo esc($selectedlocalcurrency->currency_name); ?></td>
                        <td><?php echo ($selectedlocalcurrency->currency_position=='l')?esc($selectedlocalcurrency->currency_symbol)." ".esc($payablelocal):esc($payablelocal)." ".esc($selectedlocalcurrency->currency_symbol); ?>
                            <?php echo form_hidden('local_amount', esc($payablelocal)) ?>
                        </td>
                        <td><?php echo esc($selectedlocalcurrency->usd_exchange_rate) ?></td>
                    </tr>
                </table>
            </div>
         </fieldset>
    </div>
</div>
<div class="form-group row">
    <label for="wallet_id" class="col-sm-4 col-form-label">Your <i><?php echo isset($selectedexccurrency->coin_name)?esc($selectedexccurrency->coin_name):''; ?></i> <?php echo display("wallet_data") ?></label>
    <div class="col-sm-8">
        <input name="wallet_id" class="form-control" type="text" id="wallet_id" autocomplete="off">
    </div>
</div>