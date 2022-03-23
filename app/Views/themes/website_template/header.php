<?php $this->db = db_connect(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo  $settings->title ?> - <?php echo (!empty($title) ? esc($title) : null) ?></title>
    <link rel="shortcut icon" href="<?php echo base_url(esc($settings->favicon)); ?>">
    <!-- style css -->
    <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nanum+Myeongjo:400,700,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link href="<?php echo base_url('public/assets/website/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('public/assets/website/css/bootsnav.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('public/assets/website/css/owl.carousel.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('public/assets/website/css/owl.theme.default.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('public/assets/website/css/bootstrap-select.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('public/assets/website/flag-icons/css/flag-icon.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('public/assets/website/font-awesome/css/font-awesome.min.css'); ?>"
        rel="stylesheet">
    <link href="<?php echo base_url('public/assets/website/css/animate.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('public/assets/website/css/linearicons.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('public/assets/website/css/magnific-popup.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('public/assets/website/css/dataTables.bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('public/assets/website/css/responsive.bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('public/assets/website/css/style.css?v=1.1'); ?>" rel="stylesheet">
    <!--Chart-->
    <link href="<?php echo base_url('public/assets/website/amcharts/export.css'); ?>" rel="stylesheet">
    <!-- jQuery -->
    <script src="<?php echo base_url('public/assets/website/js/jquery.min.js?v=new'); ?>"></script>
    <input type="hidden" name="base_url" id="base_url" value="<?php echo esc(base_url()); ?>">
    <input type="hidden" name="seg1" id="seg1" value="<?php echo esc($segment_1); ?>">
    <input type="hidden" name="seg2" id="seg2" value="<?php echo esc($segment_2); ?>">
    <input type="hidden" name="language" id="language" value="<?php echo esc($settings->language); ?>">
    <input type="hidden" name="crypto_api" id="crypto_api"
        value="<?php if (!empty($crypto_api_key)) echo esc($crypto_api_key) ?>">
</head>

<body>
    <div id="loader-wrapper">
        <div id="loader"></div>
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>
    <!-- /.End of loader wrapper-->
    <nav class="navbar navbar-default navbar-fixed navbar-transparent bootsnav">
        <!-- Start Top Search -->
        <div class="top-search">
            <div class="container">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-search"></i></span>
                    <input type="text" class="form-control" placeholder="Search">
                    <span class="input-group-addon close-search"><i class="fa fa-times"></i></span>
                </div>
            </div>
        </div>
        <!-- End Top Search -->
        <div class="container">
            <!-- Start Atribute Navigation -->
            <div class="attr-nav">
                <ul>
                    <?php if (session('user_id') != NULL) { ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>
                            <?php echo display('account'); ?></a>
                        <ul class="dropdown-menu">
                            <li><a target="_blank"
                                    href="<?php echo base_url('customer/home'); ?>"><?php echo display('dashboard'); ?></a>
                            </li>
                            <li><a href="<?php echo base_url('logout'); ?>"><?php echo display('logout'); ?></a></li>
                        </ul>
                    </li>
                    <?php } else { ?>
                    <?php if (!session('isAdmin')) { ?>
                    <li><a href="<?php echo base_url('register'); ?>#tab2"
                            class="btn nav-btn btn-orange"><?php echo display('login_or_register'); ?></a></li>

                    <?php } else { ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>
                            <?php echo display('account'); ?></a>
                        <ul class="dropdown-menu">

                            <li> <a target="_blank"
                                    href="<?php echo base_url('backend/home') ?>"><?php echo display('dashboard'); ?></a>
                            </li>
                            <li><a href="<?php echo base_url('logout'); ?>"><?php echo display('logout'); ?></a></li>
                        </ul>
                    </li>
                    <?php }
                    } ?>

                </ul>
            </div>
            <!-- End Atribute Navigation -->
            <!-- Start Header Navigation -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="<?php echo base_url(); ?>"><img
                        src="<?php echo base_url(esc($settings->logo_web)); ?>" class="logo"
                        alt="<?php echo strip_tags(esc($settings->title)) ?>"></a>
            </div>
            <!-- End Header Navigation -->
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-menu">
                <ul class="nav navbar-nav" data-in="" data-out="">
                    <?php
                    foreach ($category as $cat_key => $cat_value) {
                        if ($cat_value->parent_id == 0 && ($cat_value->menu == 1 || $cat_value->menu == 3)) {
                            $cat_name = isset($lang) && $lang == "french" ? $cat_value->cat_name_fr : $cat_value->cat_name_en;

                    ?>
                    <?php
                            $where = "(status =1 OR status = 3)";
                            $builder = $this->db->table('web_category');
                            $child_cat = $builder->select("cat_name_en,cat_name_fr,slug,menu")->where('parent_id', $cat_value->cat_id)->where($where)->orderBy('position_serial', 'asc')->get()->getResult();
                            ?>
                    <li
                        class="<?php echo ($segment_1 == $cat_value->slug) ? "active " : null ?><?php echo $child_cat ? "dropdown" : null ?>">
                        <a
                            <?php echo $child_cat ? 'href="#" class="dropdown-toggle" data-toggle="dropdown"' : 'href="' . base_url(esc($cat_value->slug)) . '"'; ?>><?php echo esc($cat_name); ?></a>
                        <?php
                                if ($child_cat) { ?>

                        <ul class="dropdown-menu">
                            <?php
                                        foreach ($child_cat as $chi_key => $chi_value) {
                                            if ($chi_value->menu == 1 || $chi_value->menu == 3) {
                                                $chi_cat_name = isset($lang) && $lang == "french" ? $chi_value->cat_name_fr : $chi_value->cat_name_en;
                                        ?>
                            <li class=""><a
                                    href="<?php echo base_url(esc($chi_value->slug)) ?>"><?php echo esc($chi_cat_name); ?></a>
                            </li>
                            <?php
                                            }
                                        }
                                        ?>
                        </ul>
                        <?php
                                }
                                ?>
                    </li>

                    <?php
                        }
                    }
                    ?>

                </ul>
            </div><!-- /.navbar-collapse -->
        </div>
    </nav>