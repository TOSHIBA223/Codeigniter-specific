<?php
$this->db =db_connect();
$settings = $this->db->table('setting')->select("*")
            ->get()
            ->getRow();
$this->uri = service('uri','<?php echo base_url(); ?>');
?>
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
                            <a href="" class="action-item"><i class="ti-reload"></i></a>
                        </div>
                    </div>
                </div>
            </div>            
            <div class="card-body" id="printableArea">
                <div class="row">
                    <div class="col-sm-6">
                        <img src="<?php echo base_url(!empty($settings->logo)?$settings->logo:"assets/images/icons/logo.png"); ?>" class="img-responsive" alt="">
                        <br>
                        <address>
                            <strong><?php echo $settings->title ?></strong><br>
                            <?php echo $settings->description;?><br>
                            
                        </address>
                        
                    </div>
                    <div class="col-sm-6 text-right">
                        <h1 class="m-t-0">Credit No : <?php echo $this->uri->getSegment(4)?></h1>
                        <div><?php echo date('d-M-Y');?></div>
                        <address>
                            <strong><?php echo esc(@$credit_info->f_name).' '.esc(@$credit_info->l_name);?></strong><br>
                            <?php echo esc(@$credit_info->email);?><br>
                            <?php echo esc(@$credit_info->phone);?><br>
                            <abbr title="Phone"><?php echo display('account')?> :</abbr> <?php echo esc(@$credit_info->user_id);?>
                        </address>
                    </div>
                </div> <hr>
                <div class="table-responsive m-b-20">
                    <table class="table table-border table-bordered ">
                        <thead>
                            <tr>
                                <th><?php echo display('user_id')?></th>
                                <th><?php echo display('amount')?></th>
                                <th><?php echo display('date')?></th>
                                <th><?php echo display('comments')?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><div><strong><?php echo esc(@$credit_info->user_id);?></strong></div>
                                <td>$<?php echo esc(@$credit_info->deposit_amount);?></td>
                                <td><?php echo esc(@$credit_info->deposit_date);?></td>
                                <td><?php echo esc(@$credit_info->comments);?></td>
                            </tr>
                           
                        </tbody>
                    </table>
                    <?php 
                        if (!@$credit_info->user_id) {
                            echo "<h1 align='center' class='text-danger'>User Not Found !!!</h1>";
                        }  
                    ?>                 
                </div>
            </div>

            <div class="panel-footer text-right">
               <button type="button" class="btn btn-info print"><span class="fa fa-print"></span></button>
            </div>
        </div>
    </div>
</div>

