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
                <?php echo form_open(base_url("backend/package/edit_package/".$package->package_id))?>
                <?php echo form_hidden('package_id', esc($package->package_id))?>
                <div class="row">
                    <div class="col-sm-6 col-lg-6">
                        <div class="form-group">
                            <label for="package_name" class="font-weight-600"><?php echo display('package_name') ?><span class="text-danger"> *</span></label>  
                            <div class="col-sm-12"> 
                                <input name="package_name" value="<?php echo esc($package->package_name) ?>" class="form-control" placeholder="<?php echo display('package_name') ?>" type="text" id="package_name" data-toggle="tooltip" title="<?php echo display('tooltip_package_name') ?> ">
                            </div>
                         </div>
                        <div class="form-group ">
                            <label for="daily_roi" class="font-weight-600"><?php echo display('daily_roi') ?><span class="text-danger"> *</span></label>
                            <div class="col-sm-12">
                                <input name="daily_roi" value="<?php echo  esc($package->daily_roi) ?>" class="form-control" placeholder="<?php echo display('daily_roi') ?>" type="text" id="daily_roi" data-toggle="tooltip" title="<?php echo display('tooltip_package_daily_roi') ?>">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="monthly_roi" class="font-weight-600"><?php echo display('monthly_roi') ?></label>
                            <div class="col-sm-12">
                                <input name="monthly_roi" value="<?php echo $package->monthly_roi ?>" class="form-control" placeholder="<?php echo display('monthly_roi') ?>" type="text" id="monthly_roi" data-toggle="tooltip" title="<?php echo display('tooltip_package_monthly_roi') ?> " readonly>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="total_percent" class="font-weight-600"><?php echo display('total_percent') ?> %</label>
                            <div class="col-sm-12">
                                <input name="total_percent" value="<?php echo $package->total_percent ?>" class="form-control" placeholder="<?php echo display('total_percent') ?>" type="text" id="total_percent" data-toggle="tooltip" title="<?php echo display('tooltip_package_total_percent_roi') ?> " readonly>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="package_deatils" class="font-weight-600"><?php echo display('package_deatils') ?> </label>
                            <div class="col-sm-12">
                                <textarea name="package_deatils" class="form-control" placeholder="<?php echo display('package_deatils') ?>" type="text" id="package_deatils" data-toggle="tooltip" title="<?php echo display('tooltip_package_details') ?>"><?php echo $package->package_deatils ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-6">
                        <div class="form-group ">
                            <label for="period" class="font-weight-600"><?php echo display('period') ?><span class="text-danger"> *</span></label>
                            <div class="col-sm-12">
                                <input name="period" value="<?php echo esc($package->period) ?>" class="form-control" placeholder="<?php echo display('period') ?>" type="text" id="period" data-toggle="tooltip" title="<?php echo display('tooltip_package_period') ?>">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="package_amount" class="font-weight-600"><?php echo display('package_amount') ?><span class="text-danger"> *</span></label>
                            <div class="col-sm-12">
                                <input name="package_amount" value="<?php echo esc($package->package_amount) ?>" class="form-control" placeholder="<?php echo display('package_amount') ?>" type="text" id="package_amount" data-toggle="tooltip" title="<?php echo display('tooltip_package_amount') ?>">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="weekly_roi" class="font-weight-600"><?php echo display('weekly_roi') ?><span class="text-danger"> *</span></label>
                            <div class="col-sm-12">
                                <input name="weekly_roi" value="<?php echo esc($package->weekly_roi) ?>" class="form-control" placeholder="<?php echo display('weekly_roi') ?>" type="text" id="weekly_roi" data-toggle="tooltip" title="<?php echo display('tooltip_package_weekly_roi') ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="yearly_roi" class="font-weight-600"><?php echo display('yearly_roi') ?></label>
                            <div class="col-sm-12">
                                <input name="yearly_roi" value="<?php echo esc($package->yearly_roi) ?>" class="form-control" placeholder="<?php echo display('yearly_roi') ?>" type="text" id="yearly_roi" data-toggle="tooltip" title="<?php echo display('tooltip_package_yearly_roi') ?> " readonly>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="status" class="font-weight-600"><?php echo display('status') ?><span class="text-danger"> *</span></label>
                            <div class="col-sm-12">
                                <label class="radio-inline">
                                    <?php echo form_radio('status', '1', (($package->status==1 || $package->status==null)?true:false)); ?><?php echo display('active') ?>
                                 </label>
                                <label class="radio-inline">
                                    <?php echo form_radio('status', '0', (($package->status=="0")?true:false) ); ?><?php echo display('inactive') ?>
                                 </label> 
                            </div>
                        </div>
                    </div>
                </div>
                <div align="center">
                     <div class="col-sm-9 col-sm-offset-3">
                         <a href="<?php echo base_url('backend/package/package_list'); ?>" class="btn btn-primary  w-md m-b-5"><?php echo display("cancel") ?></a>
                         <button type="submit" class="btn btn-success  w-md m-b-5"><?php echo $package->package_id?display("update"):display("create") ?></button>
                     </div>
                 </div>
                <?php echo form_close() ?>                                    
            </div>
        </div>
    </div>
</div>



<script src="<?php echo base_url("public/assets/js/main_custom.js?v=5.9") ?>" type="text/javascript"></script>
<script src="<?php echo base_url("app/Modules/Package/Assets/Admin/js/custom.js?v=1") ?>" type="text/javascript"></script>