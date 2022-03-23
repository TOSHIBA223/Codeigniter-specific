<?php
$cat_title1  = isset($lang) && $lang =="french"?$cat_info->cat_title1_fr:$cat_info->cat_title1_en;
$cat_title2  = isset($lang) && $lang =="french"?$cat_info->cat_title2_fr:$cat_info->cat_title2_en;
$this->session = \Config\Services::session();
?>
        <div class="page_header" data-parallax-bg-image="<?php echo base_url(esc($cat_info->cat_image)); ?>" data-parallax-direction="">
            <div class="header-content">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                            <div class="haeder-text">
                                <h1><?php echo esc($cat_title1); ?></h1>
                                <p><?php echo esc($cat_title2); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--  /.End of page header -->

        <div class="page_content">
            <div class="container">
                <div class="row">

                    <div class="col-sm-8 col-md-6 col-md-offset-3 col-sm-offset-2">
                        <div class="form-content">
                            <h2><?php echo display('reset_your_password'); ?></h2>
                            <div class="row">
                                <!-- alert message -->
                                <?php if ($this->session->getFlashdata('message') != null) {  ?>
                                <div class="alert alert-info alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <?php echo $this->session->getFlashdata('message'); ?>
                                </div> 
                                <?php } ?>                                
                                <?php if ($this->session->getFlashdata('exception') != null) {  ?>
                                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <?php echo $this->session->getFlashdata('exception'); ?>
                                </div>
                                <?php } ?>                                
                          
                            </div>

                            <?php echo form_open(base_url('resetPassword'),'id="resetPassword" novalidate'); ?>
                                <div class="form-group">
                                    <input class="form-control" name="verificationcode" id="verificationcode" placeholder="<?php echo display('verification_code') ?>" type="text" autocomplete="off">
                                </div>
                                
                                <div class="form-group">
                                    <input class="form-control" name="newpassword" id="pass" placeholder="<?php echo display('new_password') ?>" type="password" autocomplete="off">
                                    <label class="input__label" for="pass">
                                       <span class="input__label-content" data-content="<?php echo display('new_password'); ?>"><?php echo display('new_password'); ?></span>
                                    </label>
                                    <div id="password_msg">
                                      <p id="letter" class="invalid"><?php echo display('a_lowercase_letter') ?></p>
                                      <p id="capital" class="invalid"><?php echo display('a_capital_uppercase_letter') ?></p>
                                      <p id="special" class="invalid"><?php echo display('a_special') ?></p>
                                      <p id="number" class="invalid"><?php echo display('a_number') ?></p>
                                      <p id="length" class="invalid"><?php echo display('minimum_8_characters') ?></p>
                                    </div>
                                </div>
                            	<div class="form-group">
                            		<input class="form-control" name="r_pass" id="r_pass" placeholder="<?php echo display('conf_password'); ?>" type="password" >
                            	</div>

                                <button  type="submit" class="btn btn-success btn-block" id="reset-pass"><?php echo display('reset_password'); ?></button>
                            <?php echo form_close();?>
                        </div>
                    </div>
                    <!-- /.End of Page -->
                </div>
            </div>
        </div>
