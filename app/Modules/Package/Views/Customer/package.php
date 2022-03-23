<link href="<?php echo base_url("public/assets/plugins/OwlCarousel2-2.2.1/owl.theme.default.min.css") ?>"rel="stylesheet" type="text/css" />
<link href="<?php echo base_url("public/assets/plugins/OwlCarousel2-2.2.1/owl.carousel.min.css") ?>" rel="stylesheet" type="text/css" />

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
            <div class="card-body">
                            <div class="owl-carousel owl-theme">

                                <?php if($package!=NULL){ 
                                    $i=1;
                                    foreach ($package as $key => $value) {  
                                ?>

                                <div class="item">
                                    <div class="pricing__item shadow navy__blue_<?php echo esc($i++);?>">
                                        <h3 class="pricing__title"><?php echo esc($value->package_name);?></h3>
                                        <div class="pricing__price"><span class="pricing__currency">$</span><?php echo esc($value->package_amount);?></div>
                                        <ul class="pricing__feature-list">
                                            <li class="pricing__feature"><?php echo display('period');?> <span><?php echo esc($value->period);?> days</span></li>
                                            <li class="pricing__feature"><?php echo display('yearly_roi');?><span>$<?php echo esc($value->yearly_roi);?></span></li>
                                            <li class="pricing__feature"><?php echo display('monthly_roi');?> <span>$<?php echo esc($value->monthly_roi);?></span></li>
                                            <li class="pricing__feature"><?php echo display('weekly_roi');?> <span>$<?php echo esc($value->weekly_roi);?></span></li>
                                            <li class="pricing__feature"><?php echo display('daily_roi');?> <span>$<?php echo esc($value->daily_roi);?></span></li>
                                        </ul>
                                        <a href="<?php echo base_url('customer/package/confirm_package/'.esc($value->package_id));?>" class="pricing__action center-block"><?php echo display('buy');?></a>
                                    </div>
                                    <!-- /.End of price item -->
                                </div>
                                <?php } }?>

                            </div>
                            <!-- /.Packages -->
                    </div>
                </div>
            </div>
        </div>

<script src="<?php echo base_url("public/assets/js/jquery-ui-sliderAccess.js") ?>" type="text/javascript"></script>

<script src="<?php echo base_url("public/assets/plugins/OwlCarousel2-2.2.1/owl.carousel.min.js") ?>" type="text/javascript"></script>
<script src="<?php echo base_url("app/Modules/Package/Assets/Customer/js/custom.js?v=1") ?>" type="text/javascript"></script>