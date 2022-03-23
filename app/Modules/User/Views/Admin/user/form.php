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
                <?php echo form_open_multipart(base_url("backend/users/user_info/$user->uid")) ?>
                <?php echo form_hidden('uid', esc($user->uid)) ?>
                <?php echo form_hidden('user_id', esc($user->user_id)) ?>
                <?php 
                    $db         = db_connect();
                    $user_id    = $db->query("select user_id from user_registration where sponsor_id=0" )->getRow();
                ?>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label><?php echo display("username") ?><span class="text-danger"> *</span></label>
                            <input type="text" value="<?php echo esc($user->username) ?>" class="form-control" name="username" placeholder="<?php echo display("username") ?>">
                        </div>
                        <div class="form-group col-lg-6">
                            <label><?php echo display("sponsor_id") ?><span class="text-danger"> *</span></label>
                            <input type="text" value="<?php echo $user->sponsor_id!=''?@$user->sponsor_id:esc(@$user_id->user_id) ?>" class="form-control" <?php echo $user->uid?'readonly':'' ?> name="sponsor_id" placeholder="<?php echo display("sponsor_name") ?>">
                        </div>
                        <div class="form-group col-lg-6">
                            <label><?php echo display("firstname") ?><span class="text-danger"> *</span></label>
                            <input type="text" value="<?php echo esc($user->f_name) ?>" class="form-control" name="f_name" placeholder="<?php echo display("firstname") ?>">
                        </div>
                        <div class="form-group col-lg-6">
                            <label><?php echo display("lastname") ?><span class="text-danger"> *</span></label>
                            <input type="text" value="<?php echo esc($user->l_name) ?>" class="form-control" name="l_name" placeholder="<?php echo display("lastname") ?>">
                        </div>
                        <div class="form-group col-lg-6">
                            <label><?php echo display("email") ?><span class="text-danger"> *</span></label>
                            <input type="text" value="<?php echo esc($user->email) ?>" class="form-control" name="email" placeholder="<?php echo display("email") ?>">
                        </div>
                        <div class="form-group col-lg-6">
                            <label><?php echo display("mobile") ?><span class="text-danger"> *</span></label>
                            <input type="text" value="<?php echo esc($user->phone) ?>" id="mobile" class="form-control" name="phone" placeholder="<?php echo display("mobile") ?>">
                        </div>
                        <div class="form-group col-lg-6">
                            <label><?php echo display("password") ?><span class="text-danger"> *</span></label>
                            <input type="password" value="" class="form-control" name="password" placeholder="<?php echo display("password") ?>">
                        </div>
                        <div class="form-group col-lg-6">
                            <label><?php echo display("conf_password") ?><span class="text-danger"> *</span></label>
                            <input type="password" value="" class="form-control" name="conf_password" placeholder="<?php echo display("conf_password") ?>">
                        </div>

                        <div class="form-group ">
                            <label for="status" class=" col-form-label">Status<span class="text-danger"> *</span></label>
                            <div class="col-sm-12">
                                <label class="radio-inline">
                                    <?php echo form_radio('status', '1', (($user->status==1 || $user->status==null)?true:false)); ?><?php echo display('active') ?>
                                </label>
                                <label class="radio-inline">
                                    <?php echo form_radio('status', '0', (($user->status=="0")?true:false) ); ?><?php echo display('inactive') ?>
                                </label> 
                            </div>
                        </div>

                    </div> 
                    <div align="center">
                        <a href="<?php echo base_url('backend/users/user_list'); ?>" class="btn btn-primary"><?php echo display("cancel") ?></a>
                        <button type="submit" class="btn btn-success"><?php echo $user->uid?display("update"):display("register") ?></button>
                    </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>
 