<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                <div class="panel-title">
                    <h6 class="fs-17 font-weight-600 mb-0"><?php echo (!empty($title)?$title:null) ?></h6>
                </div>
            </div>
            <div class="card-body">

                <?php echo form_open_multipart(base_url("customer/profile/update")) ?>
                <?php echo form_hidden('uid', esc($profile->uid)) ?>
  
                    <div class="row">

                        <div class="form-group col-lg-6">
                            <label><?php echo display("username") ?><span class="text-danger"> *</span></label>
                            <input type="text" value="<?php echo esc($profile->username) ?>" class="form-control" name="username" placeholder="<?php echo display("username") ?>" disabled>
                        </div>

                        <div class="form-group col-lg-6">
                            <label><?php echo display("sponsor_id") ?><span class="text-danger"> *</span></label>
                            <input type="text" value="<?php echo esc($profile->sponsor_id) ?>" class="form-control" name="sponsor_id" placeholder="<?php echo display("sponsor_name") ?>" disabled>
                        </div>

                        <div class="form-group col-lg-6">
                            <label><?php echo display("firstname") ?><span class="text-danger"> *</span></label>
                            <input type="text" value="<?php echo esc($profile->f_name) ?>" class="form-control" name="f_name" placeholder="<?php echo display("firstname") ?>">
                        </div>

                        <div class="form-group col-lg-6">
                            <label><?php echo display("lastname") ?><span class="text-danger"> *</span></label>
                            <input type="text" value="<?php echo esc($profile->l_name) ?>" class="form-control" name="l_name" placeholder="<?php echo display("lastname") ?>">
                        </div>

                        <div class="form-group col-lg-6">
                            <label><?php echo display("email") ?><span class="text-danger"> *</span></label>
                            <input type="text" value="<?php echo esc($profile->email) ?>" class="form-control" name="email" placeholder="<?php echo display("email") ?>">
                        </div>

                        <div class="form-group col-lg-6">
                            <label><?php echo display("mobile") ?><span class="text-danger"> *</span></label>
                            <input type="text" value="<?php echo esc($profile->phone) ?>" id="mobile" class="form-control" name="mobile" placeholder="<?php echo display("mobile") ?>">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="preview" class="col-form-label">Preview</label>
                            <div class="">
                                <img src="<?php echo base_url(!empty($profile->image)?esc($profile->image): "./assets/images/icons/user.png") ?>" class="img-thumbnail" width="125" height="100">
                            </div>
                            <input type="hidden" name="old_image" value="<?php echo esc($profile->image) ?>">
                            <label for="image" class="col-form-label">Image</label>
                                <input type="file" name="image" id="image" aria-describedby="fileHelp">
                                <small id="fileHelp" class="text-muted"></small>
                            
                        </div>
                        <div class="form-group col-lg-6">
                                <label><?php echo display('language') ?></label>
                                
                                <select name="language" class="form-control">
                                    <?php 
                                        foreach($languageList as $key => $val){
                                            echo '<option '.($profile->language==$key?'selected':'').' value="'.esc($key).'">'.esc($val).'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        
                    </div> 

                    <div>
                        <button type="submit" class="btn btn-success"><?php echo display("update") ?></button>
                    </div>
                <?php echo form_close() ?>

            </div>
        </div>
    </div>
</div>

 