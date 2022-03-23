<?php
    ini_set("allow_url_fopen", 1);   
    $this->uri = service('uri','<?php echo base_url(); ?>');
    $this->db =    db_connect();
    $cid =$this->uri->getSegment(2);

    if ($cid == '') { $cid = 'BTC'; }

    $test2 = file_get_contents('https://min-api.cryptocompare.com/data/v2/subs?fsym='.$cid.'&api_key='.$crypto_api_key);
   
    $history2 = json_decode($test2);

    foreach ($history2->Data->CoinInfo as $gen_key => $gen_value) {
        $general[$gen_key] = $gen_value;
    }

    $imgpath = "";
    if (!empty($general['ImageUrl'])) {
        $imginfo = pathinfo("https://www.cryptocompare.com".$general['ImageUrl']);
        $imgpath = "./public/uploads/coinlist/".$imginfo['basename'];
    }
  

    $test4 = file_get_contents('https://min-api.cryptocompare.com/data/pricemultifull?tsyms=USD'.'&fsyms='.$cid.'&api_key='.$crypto_api_key);
    $newscoin = file_get_contents('https://min-api.cryptocompare.com/data/v2/news/?lang=EN&api_key=c124160ff7c3fbab3d5aa4c077e52f777e5296c1959326227f4187b3f7d7a695');
    $newsData = json_decode($newscoin);
    $history4 = json_decode($test4, true);
    foreach (@$history4['DISPLAY'] as $dis_key => $dis_value) { 
    }

   
    
?>
<!-- Required for chart data -->
<script type="text/javascript">
    var Symbol = "<?php echo esc($history2->Data->CoinInfo->Internal); ?>";
</script>

<div class="page_header" data-parallax-bg-image="<?php echo base_url(esc($cat_info->cat_image)); ?>" data-parallax-direction="">
    <div class="header-content">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2">
                    <div class="haeder-text">
                        <div class="company-icon">
                            <img src="<?php echo base_url(esc($imgpath)); ?>" alt="<?php echo strip_tags(esc($history2->Data->CoinInfo->Name)) ?>" width="56">
                        </div>
                        <div class="company"><?php echo esc($history2->Data->CoinInfo->Name)." (".esc($history2->Data->CoinInfo->Internal).")" ?></div>
                        <div class="company-valu">
                            <div class="company-value-title"><?php echo display('current_price') ?></div>
                            <div class="company-value-current">
                                <?php echo esc($dis_value['USD']['PRICE']); ?>, 
                                <span class="<?php echo $dis_value['USD']['CHANGEPCTDAY']<0?'percent_negative':'company-value-change' ?>"><?php echo esc($dis_value['USD']['CHANGEPCTDAY']); ?>%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-bg-intro"><img src="<?php echo base_url('/assets/website/'); ?>img/mask.png" class="intro-round" alt=""></div>
</div>
<!--  /.End of page header -->
<div class="crypto-details">
    <div class="container">
        <div class="crypto-details-info">
            <div class="info-cell">
                <div class="info-cell-title"><?php echo display('hour_change') ?></div>
                <div class="info-cell-value">
                    <span class="<?php echo $dis_value['USD']['CHANGEPCT24HOUR']<0?'percent_negative':'percent_positive' ?>"><?php echo esc($dis_value['USD']['CHANGEPCT24HOUR']) ?>%</span>
                </div>
            </div>
            <div class="info-cell">
                <div class="info-cell-title"><?php echo display('day_change') ?></div>
                <div class="info-cell-value">
                    <span class="<?php echo $dis_value['USD']['CHANGEPCTDAY']<0?'percent_negative':'percent_positive' ?>"><?php echo esc($dis_value['USD']['CHANGEPCTDAY']) ?>%</span>
                </div>
            </div>
            <div class="info-cell">
                <div class="info-cell-title"><?php echo display('hour_change') ?></div>
                <div class="info-cell-value">
                    <span class="<?php echo substr($dis_value['USD']['CHANGE24HOUR'], '1')<0?'percent_negative':'percent_positive' ?>"><?php echo esc($dis_value['USD']['CHANGE24HOUR']); ?></span>
                </div>
            </div>
            <div class="info-cell">
                <div class="info-cell-title"><?php echo display('day_change') ?></div>
                <div class="info-cell-value">
                    <span class="<?php echo substr($dis_value['USD']['CHANGEDAY'], '1')<0?'percent_negative':'percent_positive' ?>"><?php echo esc($dis_value['USD']['CHANGEDAY']); ?></span>
                </div>
            </div>
        </div>
        <div class="crypto-details-info">
            <div class="info-cell">
                <div class="info-cell-title"><?php echo display('market_cap') ?></div>
                <div class="info-cell-value">
                    <span><?php echo esc($dis_value['USD']['MKTCAP']); ?></span>
                </div>
            </div>
            <div class="info-cell">
                <div class="info-cell-title"><?php echo display('volume_24h') ?></div>
                <div class="info-cell-value">
                    <span><?php echo esc($dis_value['USD']['TOTALVOLUME24H']) ?></span>
                </div>
            </div>
            <div class="info-cell">
                <div class="info-cell-title"><?php echo display('volumeto_24h') ?></div>
                <div class="info-cell-value">
                    <span><?php echo esc($dis_value['USD']['TOTALVOLUME24HTO']); ?></span>
                </div>
            </div>
            <div class="info-cell">
                <div class="info-cell-title"><?php echo display('supply') ?></div>
                <div class="info-cell-value">
                    <span><?php echo esc($dis_value['USD']['SUPPLY']); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="pricing-new">
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <?php
                    foreach ($advertisement as $add_key => $add_value) { 
                        $ad_position   = $add_value->serial_position;
                        $ad_link       = $add_value->url;
                        $ad_script     = $add_value->script;
                        $ad_image      = $add_value->image;
                        $ad_name      = $add_value->name;
                ?>

                        <?php if (@$ad_position==3) { ?>
                            <div class="widget_banner">
                                <?php if ($ad_script=="") { ?>
                                    <a target="_blank" href="<?php echo esc($ad_link) ?> "><img src="<?php echo base_url(esc($ad_image)) ?>" class="img-responsive center-block" alt="<?php echo strip_tags(esc($ad_name)) ?>"></a>
                                <?php } else { echo htmlspecialchars_decode($ad_script); } ?>
                            </div><!-- /.End of banner -->
                        <?php } } ?>

                        <div class="price-chart">
                            <div id="chartdiv"></div>   
                        </div>
                        <!-- /.End of chart -->
                        <?php
                            foreach ($advertisement as $add_key => $add_value) { 
                                $ad_position   = $add_value->serial_position;
                                $ad_link       = $add_value->url;
                                $ad_script     = $add_value->script;
                                $ad_image      = $add_value->image;
                                $ad_name      = $add_value->name;
                        ?>

                            <?php if (@$ad_position==4) { ?>
                                <div class="widget_banner">
                                    <?php if ($ad_script=="") { ?>
                                        <a target="_blank" href="<?php echo esc($ad_link) ?> "><img src="<?php echo base_url(esc($ad_image)) ?>" class="img-responsive center-block" alt="<?php echo strip_tags(esc($ad_name)) ?>"></a>
                                    <?php } else { echo htmlspecialchars_decode($ad_script); } ?>
                                </div><!-- /.End of banner -->
                            <?php } } ?>

                            <!-- /.End of banner widget -->
                            <h4 class="widget_title"><?php echo display('news'); ?></h4>

                            <?php  
                                foreach ($news as $news_key => $news_value) {
                                    $article_id         =   $news_value->article_id;
                                    $cat_id             =   $news_value->cat_id;
                                    $slug               =   $news_value->slug;
                                    $news_headline      =   isset($lang) && $lang =="french"?$news_value->headline_fr:$news_value->headline_en;
                                    $news_article1      =   isset($lang) && $lang =="french"?$news_value->article1_fr:$news_value->article1_en;
                                    $news_article_image =   $news_value->article_image;
                                    $publish_date       =   $news_value->publish_date;
                                    $builder = $this->db->table('web_category');
                                    $cat_slug = $builder->select("slug, cat_name_en, cat_name_fr")->where('cat_id', $cat_id)->get()->getRow();
                                    $cat_name      =   isset($lang) && $lang =="french"?$cat_slug->cat_name_fr:$cat_slug->cat_name_en;
                            ?>
                                <div class="post post_list post_list_md">
                                    <div class="post_img">
                                        <a href="<?php echo base_url('news/'.esc($cat_slug->slug)."/$slug"); ?>"><img src="<?php echo base_url(esc($news_article_image)); ?>" alt="<?php echo strip_tags(esc($news_headline)); ?>"></a>
                                    </div>
                                    <div class="post_body">
                                        <div class="post-cat"><a href="<?php echo base_url('news/'.esc($cat_slug->slug)); ?>"><?php echo esc($cat_name) ?></a></div>
                                        <h3 class="post_heading"><a href="<?php echo base_url('news/'.esc($cat_slug->slug)."/$slug"); ?>"><?php echo strip_tags(esc($news_headline)); ?></a></h3>
                                        <p><?php echo substr(strip_tags(htmlspecialchars_decode($news_article1)), 0, 110); ?></p>
                                        <div class="post_meta">
                                            <span class="post_date"><i class="fa fa-calendar-o"></i><time datetime="<?php echo $publish_date ?>">
                                                <?php
                                                $date=date_create($publish_date);
                                                echo esc(date_format($date,"jS, F Y"));
                                                ?>                                            
                                            </time></span>
                                        </div>
                                    </div>
                                </div><!-- /.End of post list -->
                                <?php } ?>
                        <!-- /.End of pagination -->
                        <?php
                            foreach ($advertisement as $add_key => $add_value) { 
                                $ad_position   = $add_value->serial_position;
                                $ad_link       = $add_value->url;
                                $ad_script     = $add_value->script;
                                $ad_image      = $add_value->image;
                                $ad_name      = $add_value->name;
                        ?>

                            <?php if (@$ad_position==5) { ?>
                                <div class="widget_banner">
                                    <?php if ($ad_script=="") { ?>
                                        <a target="_blank" href="<?php echo esc($ad_link) ?> "><img src="<?php echo base_url(esc($ad_image)) ?>" class="img-responsive center-block" alt="<?php echo strip_tags(esc($ad_name)) ?>"></a>
                                    <?php } else { echo htmlspecialchars_decode($ad_script); } ?>
                                </div><!-- /.End of banner -->
                            <?php } } ?>

                        </div>
                        <?php echo (!empty($content)?htmlspecialchars_decode($content):null) ?>
                    </div>
                </div>
            </div>