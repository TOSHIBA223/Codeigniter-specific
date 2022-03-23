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
                <div class="border_preview">
                    <div class="table-responsive">
                        <table id="example" class="table display table-bordered table-striped table-hover">
                            
                            <thead>
                                <tr>
                                    <th width="5%"><?php echo display('serial');?></th>
                                    <th><?php echo display('user_id');?></th>
                                    <th><?php echo display('package_id');?></th>
                                    <th><?php echo display('amount');?></th>
                                    <th><?php echo display('date');?></th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php if($my_payout){
                                    $i=1;
                                    foreach ($my_payout as $key => $value) {
                                ?>
                                
                                <tr>
                                    <td><?php echo esc($i++);?></td>
                                    <td><?php echo esc($value->user_id);?></td>
                                    <td><?php echo esc($value->package_id);?></td>
                                    <td>$<?php echo esc($value->amount);?></td>
                                    <td><?php echo esc($value->invest_date);?></td>
                                    
                                </tr>

                                <?php  } }?>
                                
                            </tbody>
                        </table>
                        <?php echo htmlspecialchars_decode($pager); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>