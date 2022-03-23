<?php 
$cat_title1  = isset($lang) && $lang =="french"?$cat_info->cat_title1_fr:$cat_info->cat_title1_en;
$cat_title2  = isset($lang) && $lang =="french"?$cat_info->cat_title2_fr:$cat_info->cat_title2_en;
?>
        <div class="page_header" data-parallax-bg-image="<?php echo base_url(esc($cat_info->cat_image)); ?>" data-parallax-direction="">
            <div class="header-content">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                            <div class="haeder-text">
                                <h1><?php echo htmlspecialchars_decode($cat_title1); ?></h1>
                                <p><?php echo htmlspecialchars_decode($cat_title2); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.End of page header -->

        <div class="buySell_content">
            <div class="container">
                <div class="row">
                    <div class="col-xs-6 col-sm-12 col-md-6 col-lg-6 col-xs-offset-3 col-md-offset-3 col-lg-offset-3">           
                        <div class="payment-process">                           
                            <?php if ($deposit->deposit_method=='bitcoin') { ?>
                            <!-- JS -->
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" crossorigin="anonymous"></script> 
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" crossorigin="anonymous"></script>
                            <script src="<?php echo base_url("gourl/js/support.min.js"); ?>" crossorigin="anonymous"></script> 
                            <!-- CSS for Payment Box -->
         
                            <?php   echo htmlspecialchars_decode($deposit_data['box']->display_cryptobox_bootstrap($deposit_data['coins'], $deposit_data['def_coin'], $deposit_data['def_language'], $deposit_data['custom_text'], $deposit_data['coinImageSize'], $deposit_data['qrcodeSize'], $deposit_data['show_languages'], $deposit_data['logoimg_path'], $deposit_data['resultimg_path'], $deposit_data['resultimgSize'], $deposit_data['redirect'], $deposit_data['method'], $deposit_data['debug'])); ?>


                            <?php } elseif ($deposit->deposit_method=='payeer') { ?>
                            <div class="col-lg-8 offset-lg-2">
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
                                        <td class="text-right">$<?php echo esc((float)@$deposit->fees) ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php echo display('total') ?></th>
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
                                    <a href="<?php echo base_url('deposit'); ?>" class="btn btn-primary  w-md m-b-5"><?php echo display("cancel") ?></a>
                                    <br>
                                    <br>
                                    <br>
                                </form>
                            </div>
                            <?php } elseif ($deposit->deposit_method=='paypal')  { ?>
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
                                    <td class="text-right">$<?php echo esc($deposit->fees) ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo display('total') ?></th>
                                    <td class="text-right">$<?php echo esc($deposit->deposit_amount)+esc($deposit->fees) ?></td>
                                </tr>
                            </table>
                            <a class="btn btn-success w-md m-b-5 text-right" href="<?php echo $deposit_data['approval_url'] ?>"><?php echo display('payment_process') ?></a>

                            <?php } elseif ($deposit->deposit_method=='paystack')  { ?>
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
                                    <td class="text-right">$<?php echo esc($deposit->fees) ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo display('total') ?></th>
                                    <td class="text-right">$<?php echo esc((float)@$deposit->deposit_amount)+esc((float)@$deposit->fees) ?></td>
                                </tr>
                            </table>
                            <a class="btn btn-success w-md m-b-5 text-right" href="<?php echo $deposit_data ?>"><?php echo display('payment_process') ?></a>

                            <?php } elseif ($deposit->deposit_method=='coinpayment')  { ?>
                            <table class="table table-bordered">
                                <tr>
                                    <td>
                                        <strong><?php echo display('important') ?></strong></br>
                                        <ul>
                                            <li>
                                            <strong><?php echo esc($deposit->currency_symbol);?></strong> 
                                            <?php echo display('send_only_deposit_address_sending_any_other_coin') ?></li>
                                        </ul>
                                        <br>
                                        <center>
                                        <div class="diposit-address">
                                            <div class="label">
                                                <?php echo esc($deposit->currency_symbol); ?> <?php echo display('deposit_address') ?>
                                            </div>
                                            <div class="dip_address">
                                                <strong><input type="text" id="copyed" value="<?php echo esc($deposit_data['result']['address']) ?>" readonly="readonly"/></strong>
                                            </div>
                                            <div class="copy_address">
                                                <button  class="btn btn-primary copy"><?php echo display('copy_address') ?></button>
                                            </div>
                                            <div class="diposit-qrcode">
                                                <div class="qrcode">
                                                    <img src="<?php echo esc($deposit_data['result']['qrcode_url']) ?>" />
                                                </div>
                                            </div>
                                            <div class="deposit-balance">
                                                <h2>$<?php echo number_format(esc((float)@$deposit->deposit_amount)+esc((float)@$deposit->fees),8,'.','')." <span>"; ?></span></h2>
                                            </div>
                                        </div>
                                        </center>

                                        <div class="please-note">
                                            <div class="label_note"><?php echo display('please_note') ?></div>
                                            <div class="textnote">
                                                <ul>
                                                    <li><?php echo display('coins_will_be_deposited_immediately_after') ?> <font color="#03a9f4"><?php echo esc($deposit_data['result']['confirms_needed']);?></font> <?php echo display('network_confirmations') ?></li>
                                                    <li><?php echo display('you_can_track_its_progress_on_the') ?> <a target="_blank" href="<?php echo esc($deposit_data['result']['status_url']);?>"><?php echo display('history') ?></a>  <?php echo display('page') ?></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="please-note">
                                            <div class="label_note">
                                                <a href="<?php echo base_url()?>"><button type="button" class="btn btn-success"><?php echo display('back') ?></button></a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <?php } elseif ($deposit->deposit_method=='token') { ?>
                            <?php  $gateway = $this->db->select('*')->from('payment_gateway')->where('identity', 'token')->where('status',1)->get()->row(); ?>
                            <table class="table table-bordered">
                                <tr>
                                    <td>
                                        <strong><?php echo display('important') ?></strong></br>
                                        <ul>
                                            <li>
                                            <strong><?php echo esc($deposit->currency_symbol);?></strong> <?php echo display('send_only_deposit_address_sending_any_other_coin') ?></li>
                                        </ul>
                                        <br>
                                        <center>
                                            <div class="diposit-address">
                                                <div class="label">
                                                    <?php echo esc($deposit->currency_symbol);?> <?php echo display('deposit_address') ?>
                                                </div>
                                                <div class="dip_address">
                                                    <strong><input type="text" id="copyed" value="<?php echo @$gateway->public_key ?>" readonly="readonly"/></strong>
                                                </div>
                                                <div class="copy_address">
                                                    <button  class="btn btn-primary copy"><?php echo display('copy_address') ?></button>
                                                </div>
                                                <?php if ($gateway->secret_key=='show') { ?>
                                                <div class="diposit-qrcode">
                                                    <div class="qrcode">
                                                        <img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=<?php echo @$gateway->public_key ?>&choe=UTF-8" />
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            </div>
                                            <div class="deposit-balance">
                                                <h2>$<?php echo number_format(esc((float)@$deposit->deposit_amount)+esc((float)@$deposit->fees),8)." <span>"; ?></span></h2>
                                            </div>
                                        </center>

                                        <div class="please-note">
                                            <div class="textnote">
                                                <?php echo esc(@$gateway->private_key) ?>
                                            </div>
                                        </div>
                                        <div class="please-note">
                                            <div class="label_note">
                                                <a class="btn btn-success w-md m-b-5 text-right" href="<?php echo esc($deposit_data['approval_url']) ?>"><?php echo display('payment_complete') ?></a>
                                                <a class="btn btn-danger w-md m-b-5 text-right" href="<?php echo esc($deposit_data['cancel_url']) ?>"><?php echo display('cancel') ?></a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <?php } elseif ($deposit->deposit_method=='stripe')  { ?>
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
                                        <td class="text-right">$<?php echo esc($deposit->fees) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Total</th>
                                        <td class="text-right">$<?php echo esc($deposit->deposit_amount)+(float)esc(@$deposit->fees) ?></td>
                                    </tr>
                                </table>
                                <?php echo form_open(base_url('customer/payment_callback/stripe_confirm'), 'method="post" '); ?>
                                <script src="https://checkout.stripe.com/checkout.js" class="stripe-button" data-key="<?php echo esc($deposit_data['stripe']['publishable_key']); ?>" data-description="<?php echo htmlspecialchars_decode($deposit_data['description']) ?>" data-amount="<?php $total = $deposit->deposit_amount+$deposit->fees; echo round(esc($total)*100) ?>" data-locale="auto">
                                </script>
                            <?php echo form_close();?>

                            <?php } elseif ($deposit->deposit_method=='phone')  { ?>
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
                                        <th><?php echo display('total') ?></th>
                                        <td class="text-right">$<?php echoesc( @$deposit->deposit_amount)+esc(@$deposit->fees) ?></td>
                                    </tr>
                                </table>
                                <a class="btn btn-success w-md m-b-5 text-right" href="<?php echo $deposit_data['approval_url'] ?>"><?php echo display('payment_process') ?></a>

                            <?php } elseif ($deposit->deposit_method=='bank')  { ?>
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
                                        <th><?php echo display('total') ?></th>
                                        <td class="text-right">$<?php echo esc(@$deposit->deposit_amount)+esc(@$deposit->fees) ?></td>
                                    </tr>
                                </table>
                                <a class="btn btn-success w-md m-b-5 text-right" href="<?php echo $deposit_data['approval_url'] ?>"><?php echo display('payment_process') ?></a>

                            <?php } elseif ($deposit->deposit_method=='ppay')  { ?>
                            <?php echo form_open($deposit_data['approval_url'], array('name'=>'ppay_form','class'=>'f1', 'id'=>'ppay_form'));?>
                                
                                <fieldset>
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label for="first_name" class="col-md-5 col-form-label"><?php echo display('firstname') ?><i class="text-danger">*</i></label>                                        
                                                <div class="col-md-7">
                                                    <input name="first_name" type="text" class="form-control" id="first_name" value="<?php echo esc(@$deposit_data['first_name']); ?>" required readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label for="last_name" class="col-md-5 col-form-label"><?php echo display('lastname') ?><i class="text-danger">*</i></label>
                                                <div class="col-md-7">
                                                    <input name="last_name" type="text" class="form-control" id="last_name" value="<?php echo esc(@$deposit_data['last_name']); ?>" required readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label for="user_email" class="col-md-5 col-form-label"><?php echo display('user_email') ?><i class="text-danger">*</i></label>                                        
                                                <div class="col-md-7">
                                                    <input name="user_email" type="text" class="form-control" id="user_email" value="<?php echo esc(@$deposit_data['email']); ?>" required readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label for="user_phone" class="col-md-5 col-form-label"><?php echo display('user_phone') ?><i class="text-danger">*</i></label>
                                                <div class="col-md-7">
                                                    <input name="user_phone" type="text" class="form-control" id="user_phone" value="<?php echo esc(@$deposit_data['phone']); ?>" required readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label for="address1" class="col-md-5 col-form-label"><?php echo display('Address1') ?><i class="text-danger">*</i></label>                                        
                                                <div class="col-md-7">
                                                    <input name="address1" type="text" class="form-control" id="address1" value="<?php echo esc(@$address1); ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label for="address2" class="col-md-5 col-form-label"><?php echo display('Address2') ?></label>
                                                <div class="col-md-7">
                                                    <input name="address2" type="text" class="form-control" id="address2" value="<?php echo esc(@$address2); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label for="city" class="col-md-5 col-form-label"><?php echo display('city') ?><i class="text-danger">*</i></label>                                        
                                                <div class="col-md-7">
                                                    <input name="city" type="text" class="form-control" id="city" value="<?php echo esc(@$city); ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label for="zip" class="col-md-5 col-form-label"><?php echo display('zip') ?><i class="text-danger">*</i></label>
                                                <div class="col-md-7">
                                                    <input name="zip" type="text" class="form-control" id="zip" value="<?php echo esc(@$zip); ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label for="country" class="col-md-5 col-form-label"><?php echo display('country') ?><i class="text-danger">*</i></label>                                        
                                                <div class="col-md-7">
                                                    <input name="country" type="text" class="form-control" id="country" value="<?php echo esc(@$country); ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label for="state" class="col-md-5 col-form-label"><?php echo display('state') ?><i class="text-danger">*</i></label>
                                                <div class="col-md-7">
                                                    <input name="state" type="text" class="form-control" id="state" value="<?php echo esc(@$state); ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="f1-buttons">
                                        <button type="button" class="btn btn-success btn-next"><?php echo display('next') ?></button>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label for="nameoncard" class="col-md-5 col-form-label"><?php echo display('name_on_card') ?><i class="text-danger">*</i></label>
                                                <div class="col-md-7">
                                                    <input name="nameoncard" type="text" class="form-control" id="nameoncard" value="<?php echo esc(@$deposit->nameoncard) ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label for="card_type" class="col-md-5 col-form-label"><?php echo display('card_type') ?><i class="text-danger">*</i></label>                                        
                                                <div class="col-md-7">
                                                    <input name="card_type" type="text" class="form-control" id="card_type" value="<?php echo esc(@$card_type); ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label for="card_number" class="col-md-5 col-form-label"><?php echo display('card_number') ?><i class="text-danger">*</i></label>
                                                <div class="col-md-7">
                                                    <input name="card_number" type="text" class="form-control" id="card_number" value="<?php echo esc(@$card_number); ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label for="card_exp_month" class="col-md-5 col-form-label"><?php echo display('card_exp_month') ?><i class="text-danger">*</i></label>                                        
                                                <div class="col-md-7">
                                                    <input name="card_exp_month" type="text" class="form-control" id="card_exp_month" value="<?php echo @esc($card_exp_month); ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label for="cvv" class="col-md-5 col-form-label"><?php echo display('CVV') ?><i class="text-danger">*</i></label>                                        
                                                <div class="col-md-7">
                                                    <input name="cvv" type="text" class="form-control" id="cvv" value="<?php echo esc(@$cvv); ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label for="card_exp_year" class="col-md-5 col-form-label"><?php echo display('card_exp_year') ?><i class="text-danger">*</i></label>
                                                <div class="col-md-7">
                                                    <input name="card_exp_year" type="text" class="form-control" id="card_exp_year" value="<?php echo esc(@$card_exp_year); ?>" required>
                                                </div>
                                            </div>
                                        </div>                                    
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label for="fees" class="col-md-5 col-form-label"><?php echo display('fees') ?><i class="text-danger">*</i></label>                                        
                                                <div class="col-md-7">
                                                    <input name="fees" type="text" class="form-control" id="fees" value="<?php echo @$deposit->fees?esc(@$deposit->fees):'0.00' ?>" required readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label for="total" class="col-md-5 col-form-label"><?php echo display('total_amount') ?><i class="text-danger">*</i></label>
                                                <div class="col-md-7">
                                                    <input name="total" type="text" class="form-control" id="total" value="<?php echo esc(@$deposit->deposit_method)+esc(@$deposit->fees) ?>" required readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="f1-buttons">
                                        <button type="button" class="btn btn-previous"><?php echo display('previous') ?></button>
                                        <button type="submit" class="btn btn-success w-md m-b-5 text-right"><?php echo display('payment_process') ?></button>
                                    </div>
                                </fieldset>
                                <?php echo form_close();?>
                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
 