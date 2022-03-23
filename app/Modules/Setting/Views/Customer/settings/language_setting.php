<div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12">
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0"><?php echo (!empty($title)?$title:null) ?></h6>
                    </div>
                    <div class="text-right">
                        <div class="actions">
                             <a href="" class="action-item"><i class="ti-reload"></i></a>
                        </div>
                    </div>
                </div>
            </div>            
        <div class="card-body">
                <?php echo form_open(base_url('customer/settings/update_language')) ?>
                        
                    <div class="row">
                     <div class="form-group col-lg-6">
                        <label><?php echo display('language') ?></label>
                        
                        <select name="language" class="form-control">
                            <?php 
                                foreach($languageList as $key => $val){
                                    echo '<option '.($lang->language==$key?'selected':'').' value="'.esc($key).'">'.esc($val).'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-2 col-sm-offset-2">
                            <button type="submit" class="btn btn-success w-md m-b-5"><?php echo display('update');?></button>
                        </div>
                    </div>
                </div>
                <?php echo form_close();?>
            </div>

        </div>
    </div>

 <!-- /.row -->

                           


