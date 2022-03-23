<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">     
        <div class="card mb-4">      
            <div class="card-body">
                <h2><?php echo $title; ?></h2>
                    <?php if ($deposit->deposit_method=='bitcoin') { ?>

    <script src="<?php echo base_url("app/Modules/Gourl/Libraries/gourl/js/support.min.js"); ?>" crossorigin="anonymous"></script> 
    <!-- CSS for Payment Box -->
        <?php
             
            // Display payment box  
            echo htmlspecialchars_decode($deposit_data['box']->display_cryptobox_bootstrap($deposit_data['coins'], $deposit_data['def_coin'], $deposit_data['def_language'], $deposit_data['custom_text'], $deposit_data['coinImageSize'], $deposit_data['qrcodeSize'], $deposit_data['show_languages'], $deposit_data['logoimg_path'], $deposit_data['resultimg_path'], $deposit_data['resultimgSize'], $deposit_data['redirect'], $deposit_data['method'], $deposit_data['debug']));

        ?>

                        <?php } ?>
                </div>
        </div>
    </div>
</div>