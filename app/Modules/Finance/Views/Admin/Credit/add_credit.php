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
               
                <?php echo form_open(base_url('backend/credit/send_credit'),array('name'=>'credit_form','class'=>'form-inner')); ?>

                   

                    <div class="form-group row">
                        <label for="user_id" class="col-sm-4 col-form-label"><?php echo display('user_id') ?><span class="text-danger"> *</span></label>
                        <div class="col-sm-6">
                            <input name="user_id"  type="text" class="form-control" id="user_id" placeholder="<?php echo display('user_id') ?>" ><span class="suc"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="amount" class="col-sm-4 col-form-label"><?php echo display('amount') ?><span class="text-danger"> *</span></label>
                        <div class="col-sm-6">
                            <input name="amount" type="number" class="form-control" id="amount" placeholder="<?php echo display('amount') ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="notes" class="col-sm-4 col-form-label"><?php echo display('notes') ?><span class="text-danger"> *</span></label>
                        <div class="col-sm-6">
                            <textarea name="note" class="form-control" placeholder="<?php echo display('notes') ?>"  rows="4"></textarea>
                        </div>
                    </div>  
                    

                    <div class="form-group  text-center">
                        <a href="<?php echo base_url('admin/credit/credit_list'); ?>" class="btn btn-primary w-md m-b-5"><?php echo display("cancel") ?></a>
                        <button type="submit" class="btn btn-success w-md m-b-5"><?php echo display('send') ?></button>
                    </div>

                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>







 