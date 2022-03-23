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
                            <a href="" class="action-item"><i class="ti-reload"></i></a>
                        </div>
                    </div>
                </div>
            </div>            
            <div class="card-body">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="border_preview">
                <?php echo form_open_multipart(base_url("backend/info/social_link/$social_link->id")) ?>
                <?php echo form_hidden('id', esc($social_link->id)) ?> 
                    <div class="form-group row">
                        <label for="name" class="col-sm-4 col-form-label"><?php echo display("name") ?></label>
                        <div class="col-sm-8">
                            <input name="name" value="<?php echo esc($social_link->name) ?>" class="form-control" type="text" id="name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="link" class="col-sm-4 col-form-label"><?php echo display("link") ?></label>
                        <div class="col-sm-8">
                            <input name="link" value="<?php echo esc($social_link->link) ?>" class="form-control" type="text" id="link">
                        </div>
                    </div> 
                    <div class="form-group row">
                        <label for="icon" class="col-sm-4 col-form-label"><?php echo display("icon") ?></label>
                        <div class="col-sm-8">
                            <input name="icon" value="<?php echo esc($social_link->icon) ?>" class="form-control" type="text" id="icon">
                        </div>
                    </div> 
                    <div class="form-group row">
                        <label for="status" class="col-sm-4 col-form-label"><?php echo display('status') ?></label>
                        <div class="col-sm-8">
                            <label class="radio-inline">
                                <?php echo form_radio('status', '1', (($social_link->status==1 || $social_link->status==null)?true:false)); ?><?php echo display('active') ?>
                             </label>
                            <label class="radio-inline">
                                <?php echo form_radio('status', '0', (($social_link->status=="0")?true:false) ); ?><?php echo display('inactive') ?>
                             </label> 
                        </div>
                    </div>
                    <div class="row" align="center">
                        <div class="col-sm-12 col-sm-offset-3">
                            <a href="<?php echo base_url('backend/dashboard'); ?>" class="btn btn-primary  w-md m-b-5"><?php echo display("cancel") ?></a>
                            <button type="submit" class="btn btn-success  w-md m-b-5"><?php echo $social_link->id?display("update"):display("create") ?></button>
                        </div>
                    </div>
                <?php echo form_close() ?>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

 