<?php
    $this->db =    db_connect();
    $builder = $this->db->table('setting');
    $settings = $builder->select("*")
                        ->get()
                        ->getRow();
    $this->uri = service('uri','<?php echo base_url(); ?>');
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card mb-4">
            <div class="card-body"  id="printableArea">
                <div class="row">
                    <div class="col-sm-6">
                        <img src="<?php echo base_url(!empty($settings->logo)?$settings->logo:"assets/images/icons/logo.png"); ?>" class="img-responsive" alt="">
                        <br>
                        <address>
                            <strong><?php echo  esc($settings->title) ?></strong><br>
                            <?php echo htmlspecialchars_decode($settings->description);?><br>
                            
                        </address>
                        
                    </div>
                    <div class="col-sm-6 text-right">
                        <h1 class="m-t-0">Commission No : <?php echo $this->uri->getSegment(4)?></h1>
                        <div><?php echo date('d-M-Y');?></div>
                        <address>
                            <strong><?php echo esc($my_info->f_name).' '.esc($my_info->l_name); ?></strong><br>
                            <?php echo esc($my_info->email);?><br>
                            <?php echo esc($my_info->phone);?><br>
                            <abbr title="Phone">Account :</abbr> <?php echo esc($my_info->user_id); ?>
                        </address>
                    </div>
                </div> <hr>
                <div class="table-responsive m-b-20">
                    <table class="table table-border table-bordered ">
                       
                        <tbody>
                            <tr>
                                <th><?php echo display('name')?></th>
                                <td><?php echo esc($my_commission->f_name).' '. esc($my_commission->l_name);?></td>
                            </tr>
                            <tr>
                                <th><?php echo display('package_name');?></th>
                                <td><?php echo htmlspecialchars_decode($my_commission->package_deatils);?></td>
                            </tr>
                            <tr>
                                <th><?php echo display('amount');?></th>
                                <td>$<?php echo esc($my_commission->amount); ?></td>
                            </tr>
                           
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="panel-footer text-right">
               <button type="button" class="btn btn-info print"><span class="fa fa-print"></span></button>
            </div>
        </div>
    </div>
</div>