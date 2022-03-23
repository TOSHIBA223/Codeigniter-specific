
<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0"><?php echo (!empty($title)?$title:null) ?></h6>
                    </div>
                    <div class="text-right">
                        <div class="actions">
                            <a href=" " class="action-item"><i class="ti-reload"></i></a>
                        </div>
                    </div>
                </div>
            </div>            
            <div class="card-body" >
            <?php if ($latest_version!=$current_version) { ?>
                <?php echo form_open_multipart(base_url("backend/auto_update/update")) ?>
                    <div class="row">
                        <div class="form-group col-lg-12 col-sm-offset-2">
                            <blink class="text-success text-center autoupdate-text"><?php echo @htmlspecialchars_decode($message_txt) ?></blink>
                            <blink class="text-waring text-center autoupdate-text"><?php echo @htmlspecialchars_decode($exception_txt) ?></blink>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="alert alert-success text-center autoupdate-version">Latest version <br>V-<?php echo esc($latest_version) ?></div>
                                </div> 
                                <div class="col-lg-6">
                                    <div class="alert alert-danger text-center autoupdate-version">Current version <br>V-<?php echo esc($current_version) ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                     <div align="center">
                        <a href="<?php echo base_url('backend/download_database'); ?>" class="btn btn-success  w-md m-b-5"><?php echo display("download_backup") ?></a>
                         <button type="button" class="btn btn-danger col-offset-5" onclick="cancel_upnotification(<?php echo $settings_info->setting_id?>)"> <?php echo "Cancel Update Notification";?></button>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-3">
                            
                        </div>
                        <div class="form-group col-lg-6 col-sm-offset-3">
                            <p class="alert autoupdate-alert">note: strongly recomanded to backup your <b>SOURCE FILE</b> and <b>DATABASE</b> before update.</p>
                            <label>Licence/Purchase key <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="purchase_key">
                        </div>
                    </div> 
                    <div align="center">
                        <button type="submit" class="btn btn-success col-sm-offset-5" onclick="return confirm('are you sure want to update?')"><i class="fa fa-wrench" aria-hidden="true"></i> Update</button>
                    </div>
                <?php echo form_close() ?>

                <?php } else{  ?>
                    <div class="row">
                        <div class="form-group col-lg-4 offset-md-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="alert alert-success text-center autoupdate-version">Current version <br>V-<?php echo esc($current_version) ?></div>
                                    <h2 class="text-center">No Update available</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

            </div>
        </div>
    </div>
</div>