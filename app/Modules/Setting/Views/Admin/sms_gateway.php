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
                            <a href="#" class="action-item"><i class="ti-reload"></i></a>
                        </div>
                    </div>
                </div>
            </div>            
            <div class="card-body">
            <div class="panel-body">
                <div class="row">
                   
                    <div class="col-md-6 col-sm-6">
                         <?php echo form_open_multipart(base_url("backend/setting/update_sms_gateway")) ?>
                    <?php echo form_hidden('es_id', esc($sms->es_id)) ?>
                        <div class="form-group row">
                            <label for="gatewayname" class="col-xs-3 col-sm-3 col-form-label">Gateway <i class="text-danger">*</i></label>
                            <div class="col-xs-9 col-sm-9">
                                <select class="form-control basic-single" name="gatewayname" id="gatewayname" required>
                                    <option>Select Option</option>
                                    <option value="budgetsms" <?php echo ($sms->gatewayname=="budgetsms")?'Selected':'' ?> >BudgetSMS</option>
                                    <option value="infobip" <?php echo ($sms->gatewayname=="infobip")?'Selected':'' ?>>Infobip</option>
                                    <option value="nexmo" <?php echo ($sms->gatewayname=="nexmo")?'Selected':'' ?>>Nexmo</option>
                                </select>
                            </div>
                        </div>                        
                        <div class="form-group row">
                            <label for="title" class="col-xs-3 col-sm-3 col-form-label"><?php echo display('title') ?> <i class="text-danger">*</i></label>
                            <div class="col-xs-9 col-sm-9">
                                <input name="title" type="text" class="form-control" id="title" placeholder="<?php echo display('title') ?>" value="<?php echo $sms->title ?>" required>
                            </div>
                        </div>
                        <span id="sms_field"> </span>                    
                        <div align='center'>
                            <button type="submit" class="btn btn-success"><?php echo display("save") ?></button>
                            <?php echo form_close(); ?>
                        </div>
                        

                        <div class="form-group row">
                            <div class="col-xs-12">
                            <br>
                            <br>
                                <p>For SMS Gateway Use <a href="https://www.budgetsms.net" target="_blank"><b>budgetsms</b></a>/<a href="https://www.infobip.com" target="_blank"><b>infobip</b></a>/<a href="https://www.nexmo.com" target="_blank"><b>nexmo</b></a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <?php echo form_open_multipart(base_url("backend/setting/test_sms")) ?>
                        <div class="form-group row">
                            <div class="col-xs-12">
                                <h3 class="text-center">Test Your SMS</h3>
                            </div>
                        </div>                        
                       
                        <div class="form-group row">
                             
                            <label for="mobile_num" class="col-xs-3 col-sm-3 col-form-label">Mobile No. <i class="text-danger">*</i></label>
                            <div class="col-xs-9 col-sm-9">
                                <input type="text" class="form-control" name="mobile_num" id="mobile_num" placeholder="e. 88xxxxxxxx">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="test_message" class="col-xs-3 col-sm-3 col-form-label">Message <i class="text-danger">*</i></label>
                            <div class="col-xs-9 col-sm-9">
                                <textarea rows="5" class="form-control" name="test_message" id="test_message" placeholder="Test Message"></textarea>
                            </div>
                        </div>
                        <div class="form-group row" align='center'>
                            <div class="col-xs-12 col-sm-12 col-md-offset-3">
                                <button type="submit" class="btn btn-success"><?php echo display("send") ?></button>
                            </div>
                             <?php echo form_close(); ?>
                        </div>
                       
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>
</div>
<script src="<?php echo base_url("public/assets/js/main_custom.js?v=5.9") ?>" type="text/javascript"></script>
<script src="<?php echo base_url("app/Modules/Setting/Assets/Admin/js/custom.js?v=1.3") ?>" type="text/javascript"></script>

    
    
