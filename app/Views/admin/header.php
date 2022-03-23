<!-- CONTENT -->
<div class="content-wrapper">
    <div class="main-content">
       <div class="page-loader-wrapper">
            <div class="loader">
                <div class="preloader">
                    <div class="spinner-layer pl-green">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
                <p>Please wait...</p>
            </div>
        </div>
        <nav class="navbar-custom-menu navbar navbar-expand-lg m-0">
            <div class="sidebar-toggle-icon" id="sidebarCollapse">
                sidebar toggle<span></span>
            </div>
            <!--/.sidebar toggle icon-->
            <div class="d-flex flex-grow-1">
                <ul class="navbar-nav flex-row align-items-center ml-auto">
                    <?php if($max_version > $current_version && $settings->update_notification == 1){?>
                            <?php  if(session('isAdmin') == 1){?> 
                    <li> <blink><a href="<?php echo base_url('backend/auto_update')?>" class="text-black  btn-warning update-btn"> <?php echo $max_version.' Version Available'; ?></a></blink>
                    </li>
                             <?php }?>
                  <?php }?>
                    <li class="nav-item dropdown user-menu">
                        <a class="nav-link" href="#" data-toggle="dropdown">
                            <i class="fas fa-user"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-header d-sm-none">
                                <a href="" class="header-arrow"><i class="icon ion-md-arrow-back"></i></a>
                            </div>
                            <div class="user-header">
                                <div class="img-user">
                                    <img src="<?php echo base_url() . session('image') ?>" alt="">
                                </div><!-- img-user -->
                                <h6><?php echo session('fullname') ?></h6>
                                <span><?php echo session('email') ?></span>
                            </div><!-- user-header -->
                            <a href="<?php echo base_url('backend/account/profile_info') ?>" class="dropdown-item"><i
                                    class="typcn typcn-user-outline"></i> My Profile</a>
                            <a href="<?php echo base_url('backend/account/edit_profile') ?>" class="dropdown-item"><i
                                    class="typcn typcn-edit"></i> Edit Profile</a>
                            <a href="<?php echo base_url('logout') ?>" class="dropdown-item"><i
                                    class="typcn typcn-key-outline"></i> Sign Out</a>
                        </div>
                        <!--/.dropdown-menu -->
                    </li>
                </ul>
                <!--/.navbar nav-->
                <div class="nav-clock">
                    <div class="time">
                        <span class="time-hours"></span>
                        <span class="time-min"></span>
                        <span class="time-sec"></span>
                    </div>
                </div><!-- nav-clock -->
            </div>
        </nav>
        <!--/.navbar-->
        <?php if($uri->getSegment(2) !='home') { ?>
        <div class="content-header row align-items-center m-0">
            <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
                <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                    <li class="breadcrumb-item"><a
                            href="#"><?php echo  display(ucwords( $uri->setSilent()->getSegment(2))); ?></a>
                            
                    </li>
                    <li class="breadcrumb-item active"><?php echo display(ucwords($uri->setSilent()->getSegment(3))); ?>
                    </li>
                </ol>
            </nav>
            <div class="col-sm-8 header-title p-0">
                <div class="media">
                    <div class="header-icon text-success mr-3"><i class="fab fa-pagelines"></i></div>
                    <div class="media-body">
                        <h5 class="font-weight-bold">
                            <?php echo display(ucwords($uri->setSilent()->getSegment(2))); ?>
                        </h5>
                        <small><?php echo display(ucwords($uri->setSilent()->getSegment(3))); ?></small>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>