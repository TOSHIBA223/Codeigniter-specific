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
        <div class="currency-table">
            <div class="with-nav-tabs currency-tabs">
                <?php
                    foreach ($advertisement as $add_key => $add_value) { 
                        $ad_position = $add_value->serial_position;
                        $ad_link     = $add_value->url;
                        $ad_script   = $add_value->script;
                        $ad_image    = $add_value->image;
                        $ad_name     = $add_value->name;
                ?>

                <?php if (@$ad_position==1) { ?>
                    <div class="widget_banner">
                        <?php if ($ad_script=="") { ?>
                        <a target="_blank" href="<?php echo esc($ad_link) ?> "><img src="<?php echo base_url(esc($ad_image)) ?>" class="img-responsive center-block" alt="<?php echo strip_tags(esc($ad_name)) ?>"></a>
                        <?php } else { echo htmlspecialchars_decode($ad_script); } ?>
                    </div><!-- /.End of banner -->
                <?php } } ?>
                
                <div class="container">
                    <div class="tab-content">


                        <div class="table-responsive tab-pane fade in active" id="crypto">
                            <table class="table table-striped table-hover nowrap" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th><?php echo display('name'); ?></th>
                                        <th><?php echo display('ticker'); ?></th>
                                        <th><?php echo display('price'); ?></th>
                                        <th><?php echo display('24h_volume'); ?></th>
                                        <th><?php echo display('24h_change'); ?></th>
                                        <th><?php echo display('graph_24h'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                        foreach ($cryptocoins as $cry_key => $cry_value) {
                                            $id       = $cry_value->Id;
                                            $url      = $cry_value->Url;
                                            $image    = $cry_value->ImageUrl;
                                            $name     = $cry_value->Name;
                                            $symbol   = $cry_value->Symbol;
                                            $coinname = $cry_value->CoinName;
                                            $fullname = $cry_value->FullName;

                                    ?>
                                    <tr data-href="<?php echo base_url("coin-details/$symbol"); ?>" id="BGCOLOR_<?php echo esc($symbol); ?>">
                                        <td>
                                            <div class="logo-name">
                                                <div class="item-logo">
                                                    <img src="<?php echo base_url("$image"); ?>" class="img-responsive" alt="<?php echo strip_tags(esc($fullname)) ?>">
                                                </div>
                                                <span class="item_name_value"><?php echo esc($coinname); ?></span>
                                            </div>
                                        </td>
                                        <td><span class="value_ticker"><?php echo esc($symbol); ?></span></td>
                                        <td>$ <span class="price value_cap" id="PRICE_<?php echo $symbol; ?>">0</span></td>
                                        <td><span class="value_max_quantity" id="VOLUME24HOURTO_<?php echo esc($symbol); ?>"></span></td>
                                        
                                        <td><span id="CHANGE24HOUR_<?php echo esc($symbol); ?>"></span><span id="CHANGE24HOURPCT_<?php echo esc($symbol); ?>"></span></td>


                                        <td>
                                            <span class="bdtasksparkline value_graph" id="GRAPH_<?php echo esc($symbol); ?>"></span>
                                        </td>
                                    </tr>

                                    <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
                            <?php echo htmlspecialchars_decode($pager); ?>
                        </div>
                    </div>
                </div>
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
        <!-- /.End of table content -->