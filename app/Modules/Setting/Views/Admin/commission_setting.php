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
            <?php echo form_open(base_url('backend/setting/commission_update')) ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                                <th><?php echo display('level')?></th>
                                <th><?php echo display('personal_investment')?></th>
                                <th><?php echo display('total_investment')?></th>
                                <th><?php echo display('team_bonous')?></th>
                                <th><?php echo display('referral_bonous')?>%</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($setup_commission!=NULL){ 
                                foreach ($setup_commission as $key => $value) {  
                            ?>
                            <input type="hidden" name="id[]" value="<?php echo $value->level_id;?>">
                            <tr>
                                <td><input class="form-control" type="number" name="level[]" value="<?php echo $value->level_name;?>"></td>
                                <td><input class="form-control" type="number" name="personal_invest[]" value="<?php echo $value->personal_invest;?>"></td>
                                <td><input class="form-control" type="number" name="total_invest[]" value="<?php echo $value->total_invest;?>"></td>
                                <td><input class="form-control" type="number" name="team_bonous[]" value="<?php echo $value->team_bonous;?>"></td>
                                <td><input class="form-control" type="number" name="referral_bonous[]" value="<?php echo $value->referral_bonous;?>"></td>
                            </tr>
                            <?php } } ?>
                        </tbody>
                    </table>
                </div>
                <div align="right">
                    <button class="btn btn-success"> <?php echo display('update');?></button>
                </div>
                    <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>