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
                    <div class="table-responsive border-top">
                        <table class="table table-striped table-hover table-bordered">
                            
                            <thead>
                                <tr>
                                    <th><?php echo display('package_amount');?></th>
                                    <th><?php echo display('package_name');?></th>
                                    <th><?php echo display('package_deatils');?></th>
                                    <th><?php echo display('weekly_roi');?></th>
                                    <th><?php echo display('date');?></th>
                                 </tr>
                            </thead>

                            <tbody>
                                <?php if($invest!=NULL){ 
                                    foreach ($invest as $key => $value) {  
                                ?>
                                <tr>
                                    <td><?php echo esc($value->amount);?></td>
                                    <td><?php echo esc($value->package_name);?></td>
                                    <td><?php echo htmlspecialchars_decode($value->package_deatils);?></td>
                                    <td>$<?php echo esc($value->weekly_roi);?></td>
                                    <td><?php echo esc($value->invest_date);?></td>
                                </tr>
                                <?php } } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>