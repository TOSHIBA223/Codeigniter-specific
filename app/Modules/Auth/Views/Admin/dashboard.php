<div class="row">
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats statistic-box mb-4">
            <div class="card-header card-header-success card-header-icon position-relative border-0 text-right px-3 py-0">
                <div class="card-icon d-flex align-items-center justify-content-center">
                    <i class="fas fa-user"></i>
                </div>
                <p class="card-category text-uppercase fs-10 font-weight-bold text-muted"><?php echo display('total_user')?></p>
                <h3 class="card-title fs-18 font-weight-bold"><?php echo (@$total_user?esc($total_user):'0'); ?>
                    <small>Person</small>
                </h3>
            </div>
            <div class="card-footer p-3">
                <div class="stats">
                    <i class="fas fa-user text-success mr-2"></i>
                    <a href="<?php echo base_url('backend/users/user_list')?>" class="warning-link">See All user's</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats statistic-box mb-4">
            <div class="card-header card-header-warning card-header-icon position-relative border-0 text-right px-3 py-0">
                <div class="card-icon d-flex align-items-center justify-content-center">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <p class="card-category text-uppercase fs-10 font-weight-bold text-muted"><?php echo display('total_roi')?></p>
                <h3 class="card-title fs-18 font-weight-bold"><small>$</small><?php echo (@$total_roi?number_format(esc($total_roi), 2):'0.0');?>
                </h3>
            </div>
            <div class="card-footer p-3">
                <div class="stats">
                   <i class="fas fa-file-invoice-dollar text-success mr-2"></i>
                    <a href="<?php echo base_url('backend/payout/all_payout')?>" class="warning-link">See All ROI's</a>
                </div>
            </div>
        </div>
    </div>
     <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats statistic-box mb-4">
            <div class="card-header card-header-info card-header-icon position-relative border-0 text-right px-3 py-0">
                <div class="card-icon d-flex align-items-center justify-content-center">
                    <i class="fas fa-hand-holding-usd"></i>
                   
                </div>
                <p class="card-category text-uppercase fs-10 font-weight-bold text-muted"><?php echo display('total_commission')?></p>
                <h3 class="card-title fs-18 font-weight-bold"><small>$</small><?php echo (@$commission?number_format(esc($commission), 2):'0.0');?>
                </h3>
            </div>
            <div class="card-footer p-3">
                <div class="stats">
                   <i class="fas fa-hand-holding-usd text-success mr-2"></i>
                    <a href="<?php echo base_url('backend/comission/all_comission')?>" class="warning-link">See All Comission's</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats statistic-box mb-4">
            <div class="card-header card-header-danger card-header-icon position-relative border-0 text-right px-3 py-0">
                <div class="card-icon d-flex align-items-center justify-content-center">
                    <i class="fas fa-funnel-dollar"></i>
                   
                </div>
                <p class="card-category text-uppercase fs-10 font-weight-bold text-muted"><?php echo display('total_investment');?></p>
                <h3 class="card-title fs-18 font-weight-bold"><small>$</small><?php echo (@$total_investment?number_format(esc($total_investment), 2):'0.0');?>
                </h3>
            </div>
            <div class="card-footer p-3">
                <div class="stats">
                   <i class="fas fa-funnel-dollar text-success mr-2"></i>
                    <a href="<?php echo base_url('backend/investment/all_investment')?>" class="warning-link">See All Investment's</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 d-flex">
        <div class="card mb-4 flex-fill w-100">
                <div class="card-body">
                <div class="header-body mb-4 pt-0">
                    <div class="row align-items-end">
                        <div class="col">
                            <!-- Pretitle -->
                            <h6 class="header-pretitle text-muted fs-11 font-weight-bold text-uppercase mb-1">
                                User Current Year Growth Rate
                            </h6>
                            
                        </div>
                    </div> <!-- / .row -->
                </div> <!-- / .header-body -->
                <div class="chart">
                    <canvas id="userchart" width="300" height="125"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 d-flex">
                        <!--Simple Donut Chart-->
        <div class="card mb-4 flex-fill w-100">
            <div class="card-body">
                <div class='row align-items-end'>
                    <div class="col-sm-9 col-md-7">
                        <h6 class="header-pretitle text-muted fs-11 font-weight-bold text-uppercase mb-1">Deposit, Withdraw & Investment</h6>
                    </div>
                    <div class="col-sm-3 col-md-5">
                        <?php echo form_open('#','id="depowith_form" name="depowith_form" '); ?>
                        <select class="form-control basic-single" name="depowith_year" id="depowith_year">                                        
                        <?php 
                            $years      =  date("Y", strtotime("-5 year"));
                            $years_now  =  date("Y");
                            for($i = $years_now; $i>=$years; $i--)
                                echo "<option value='".esc($i)."'>".esc($i)."</option>";
                        ?>                                                   
                        </select>
                    </div>
                </div>
                    <div class='row'>
                        <div class="col-sm-12 col-md-12">
                            <canvas id="pieChart" height="137"></canvas>
                        </div>
                    </div>
                </div>
             </div>
        </div> 
    </div>

<div class="row">
    <div class="col-lg-8 d-flex">
        <div class="card mb-4 flex-fill w-100">
            <div class="card-body">
                <div class='row'>
                    <div class='col-sm-8'>
                        <h2 class="header-pretitle text-muted fs-11 font-weight-bold text-uppercase mb-1"> Investmen, ROI, Comission & Refferal Bonus</h2>
                    </div>
                    <div class="col-sm-4">
                         <?php echo form_open('#','id="invest_date_form" name="invest_date_form" '); ?>
                            <select class="form-control basic-single" name="invest_date" id="invest_date">
                                <?php 

                                    $years =  date("Y", strtotime("-5 year"));
                                    $years_now =  date("Y");

                                    for($i = $years_now; $i>=$years; $i--)
                                        echo "<option value='".esc($i)."'>".esc($i)."</option>";
                                ?>

                            </select>
                        <?php echo form_close() ?>
                    </div>
                </div>
                <div class='row'>
                     <div class="col-sm-12 col-md-12">
                        <canvas id="barChart" height="147"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-lg-4 d-flex">
        <div class="card mb-4 flex-fill w-100">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="header-pretitle text-muted fs-11 font-weight-bold text-uppercase mb-1">Pending Withdraw</h6>
                    </div>
                    <div class="text-right">
                        <div class="actions">
                               <a href="" class="action-item"><i class="ti-reload"></i></a>
                        </div>
                    </div>
                </div>
            </div>            
            <div class="card-body">
                <div class="table-responsive">
                    <table  class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th><?php echo display('user_id') ?></th>
                                <th><?php echo display('payment_method') ?></th>
                                <th><?php echo display('amount') ?></th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($wrequest)) ?>
                            <?php $sl = 1; ?>
                            <?php foreach ($wrequest as $value) { ?>
                            <tr>
                                <td><?php echo esc($value->user_id); ?></td>
                                <td><?php echo esc($value->method); ?></td>
                                <td>$<?php echo esc($value->amount); ?></td>
                            </tr>
                            <?php } ?> 
                        </tbody>
                    </table>
                </div>
                <a href="<?php echo base_url()?>/backend/withdraw/pending_withdraw">See All | Pending Withdraw</a>
            </div>
        </div>
    </div>
</div>


<!-- Modal body load from ajax start-->
<div class="modal fade modal-success" id="newModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
   <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><?php echo display('profile');?></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <table>
                <tr><td><strong><?php echo display('name');?> : </strong></td> <td id="name"></td></tr>
                <tr><td><strong><?php echo display('email');?> : </strong></td> <td id="email"></td></tr>
                <tr><td><strong><?php echo display('mobile');?> : </strong></td> <td id="phone"></td></tr>
                <tr><td><strong><?php echo display('user_id');?> : </strong></td> <td id="user_id"></td></tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
    </div><!-- /.modal-content -->
  </div>
</div>
<!-- Modal body load from ajax end-->

<script src="<?php echo base_url()?>/public/assets/plugins/datatables/dataTables.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/responsive.bootstrap4.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/jszip.min.js"></script>

<script src="<?php echo base_url()?>/public/assets/plugins/datatables/pdfmake.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/vfs_fonts.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/buttons.html5.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/buttons.print.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/buttons.colVis.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/data-bootstrap4.active.js"></script>
<script src="<?php echo base_url("public/assets/js/main_custom.js?v=5.9") ?>" type="text/javascript"></script>
<script src="<?php echo base_url("public/assets/plugins/chartJs/Chart.min.js") ?>"></script>
<script src="<?php echo base_url("app/Modules/Auth/Assets/Admin/js/custom.js?v=1.1") ?>" type="text/javascript"></script>








