<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">     
        <div class="card mb-4">      
            <div class="card-body">
                <h2><?php echo $title; ?></h2>
                   <?php if ($deposit->deposit_method=='phone')  { ?>
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
                                    <td class="text-right">$<?php echo esc(@$deposit->deposit_amount) ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo display("fees") ?></th>
                                    <td class="text-right">$<?php echo esc(@$deposit->fees) ?></td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td class="text-right">$<?php echo esc(@$deposit->deposit_amount)+esc(@$deposit->fees) ?></td>
                                </tr>
                            </table>
                            <a class="btn btn-success w-md m-b-5 text-right" href="<?php echo $deposit_data['approval_url'] ?>">Payment Process</a>

                        <?php }  ?>
                </div>
        </div>
    </div>
</div>
