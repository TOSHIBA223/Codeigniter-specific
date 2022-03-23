<?php
    $cat_title1  = isset($lang) && $lang =="french"?$cat_info->cat_title1_fr:$cat_info->cat_title1_en;
    $cat_title2  = isset($lang) && $lang =="french"?$cat_info->cat_title2_fr:$cat_info->cat_title2_en;
?>
<div class="page_header" data-parallax-bg-image="<?php echo base_url($cat_info->cat_image); ?>" data-parallax-direction="">
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
<!--  /.End of page header -->
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <?php
            foreach ($advertisement as $add_key => $add_value) { 
                $ad_position   = $add_value->serial_position;
                $ad_link       = $add_value->url;
                $ad_script     = $add_value->script;
                $ad_image      = $add_value->image;
                $ad_name      = $add_value->name;
                ?>

                <?php if (@$ad_position==1) { ?>
                    <div class="widget_banner">
                        <?php if ($ad_script=="") { ?>
                            <a target="_blank" href="<?php echo esc($ad_link) ?> "><img src="<?php echo base_url(esc($ad_image)) ?>" class="img-responsive center-block" alt="<?php echo strip_tags(esc($ad_name)) ?>"></a>
                        <?php } else { echo htmlspecialchars_decode($ad_script); } ?>
                    </div><!-- /.End of banner -->
                <?php } } ?>

            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <div class="exchange-wrapper">
                    <iframe src="https://widget.changelly.com?from=*&to=*&amount=1&address=&fromDefault=btc&toDefault=eth&theme=default&merchant_id=<?php if(!empty($marcent_id)) echo $marcent_id;?>&payment_id=&v=2" width="100%" height="600" class="changelly" scrolling="no" onLoad="function de(e){var t=e.target,n=t.parentNode,r=t.contentWindow,o=function(){return r.postMessage({width:n.offsetWidth},'https://widget.changelly.com')};window.addEventListener('resize',o),o()};de.apply(this, arguments);" id="#iframe">Can't load widget</iframe>
                </div> 
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php
                foreach ($advertisement as $add_key => $add_value) { 
                    $ad_position   = $add_value->serial_position;
                    $ad_link       = $add_value->url;
                    $ad_script     = $add_value->script;
                    $ad_image      = $add_value->image;
                    $ad_name      = $add_value->name;
                    ?>

                    <?php if (@$ad_position==2) { ?>
                        <div class="widget_banner">
                            <?php if ($ad_script=="") { ?>
                                <a target="_blank" href="<?php echo esc($ad_link) ?> "><img src="<?php echo base_url(esc($ad_image)) ?>" class="img-responsive center-block" alt="<?php echo strip_tags(esc($ad_name)) ?>"></a>
                            <?php } else { echo htmlspecialchars_decode($ad_script); } ?>
                        </div><!-- /.End of banner -->
                    <?php } } ?> 
                </div>
            </div>
        </div> 
        <!-- /.End of Exchange content -->