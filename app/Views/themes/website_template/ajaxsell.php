<div class="row">
    <div class="col-sm-8 col-sm-offset-4">
        <h3 class="form-title"><?php echo display("rate") ?>:</h3>
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
                        <?php echo $price_usd; ?>
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
    </div>
</div>
<div class="form-group">
    <label class="col-sm-4 control-label"><?php echo display("your") ?> <i><?php echo isset($selectedexccurrency->coin_name)?esc($selectedexccurrency->coin_name):''; ?></i> <?php echo display("wallet_data") ?></label>
    <div class="col-sm-8">
        <input name="wallet_id" class="form-control" type="text" id="wallet_id" autocomplete="off">
    </div>
</div>
<div class="form-group">
    <label class="col-sm-4 control-label"><?php echo display("company") ?> <i><?php echo isset($selectedexccurrency->coin_name)?esc($selectedexccurrency->coin_name):''; ?></i> <?php echo display("wallet_data") ?></label>
    <div class="col-sm-8">
        <input name="cwallet_id" class="form-control" type="text" id="cwallet_id"  value="<?php echo isset($selectedexccurrency->wallet_data)?esc($selectedexccurrency->wallet_data):''; ?>" autocomplete="off" disabled>
    </div>
</div>