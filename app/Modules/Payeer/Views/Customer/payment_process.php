<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">     
        <div class="card mb-4">      
            <div class="card-body">
                <h2><?php echo $title; ?></h2>
                   <?php if ($deposit->deposit_method=='payeer') { ?>
                        
                            <table class="table table-bordered">
                                <tr>
                                    <th><?php echo display("user_id") ?></th>
                                    <td class="text-right"><?php echo esc($deposit->user_id) ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo display("payment_gateway") ?></th>
                                    <td class="text-right"><?php echo esc($deposit->deposit_method) ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo display("amount") ?></th>
                                    <td class="text-right">$<?php echo esc($deposit->deposit_amount) ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo display("fees") ?></th>
                                    <td class="text-right">$<?php echo (float)esc(@$deposit->fees) ?></td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td class="text-right">$<?php echo esc($deposit->deposit_amount)+esc((float)@$deposit->fees) ?></td>
                                </tr>
                            </table>
                            <form method="post" action="https://payeer.com/merchant/">
                                <input type="hidden" name="m_shop" value="<?php echo esc($deposit_data['m_shop']) ?>">
                                <input type="hidden" name="m_orderid" value="<?php echo esc($deposit_data['m_orderid']) ?>">
                                <input type="hidden" name="m_amount" value="<?php echo esc($deposit_data['m_amount']) ?>">
                                <input type="hidden" name="m_curr" value="<?php echo esc($deposit_data['m_curr']) ?>">
                                <input type="hidden" name="m_desc" value="<?php echo esc($deposit_data['m_desc']) ?>">
                                <input type="hidden" name="m_sign" value="<?php echo esc($deposit_data['sign']) ?>">                               
                                <input type="submit" name="m_process" value="Payment Process" class="btn btn-success w-md m-b-5" />
                                <a href="<?php echo base_url('customer/deposit/add_deposit'); ?>" class="btn btn-primary  w-md m-b-5"><?php echo display("cancel") ?></a>
                                
                                <br>
                                <br>
                                <br>
                            </form>
                       
                        <?php } ?>
                </div>
        </div>
    </div>
</div>
