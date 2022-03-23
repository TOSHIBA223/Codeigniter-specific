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
                             <a class="btn btn-success w-md m-b-5" href="<?php echo base_url("customer/sell/sell_form") ?>"><i class="fa fa-plus" aria-hidden="true"></i> <?php echo display("sell") ?></a>
                            <a href=" " class="action-item"><i class="ti-reload"></i></a>
                        </div>
                    </div>
                </div>
            </div>            
            <div class="card-body">
                <table id="example" class="table  table-bordered table-striped table-hover">

                    <thead>
                        <tr> 
                            <th><?php echo display('sl_no') ?></th>
                            <th><?php echo display('coin_name') ?></th>
                            <th><?php echo display('coin_amount') ?></th>
                            <th><?php echo display('rate_coin') ?></th>
                            <th><?php echo display('usd_amount') ?></th>
                            <th><?php echo display('local_amount') ?></th>
                        </tr>
                    </thead>    
                    <tbody>
                        <?php if (!empty($sell)) ?>
                        <?php $sl = 1; 
                        $this->db =  db_connect();
                        $builder = $this->db->table('ext_exchange_wallet'); 
                        ?>
                        <?php foreach ($sell as $value) { ?>
                        <tr>
                            <td><?php echo esc($sl++); ?></td> 
                            <td><?php echo $builder->select("coin_name")->where('coin_id', $value->coin_id)->get()->getRow()->coin_name; ?></td>
                            <td><?php echo esc($value->coin_amount); ?></td>
                            <td><?php echo esc($value->rate_coin); ?></td>
                            <td><?php echo esc($value->usd_amount); ?></td>
                            <td><?php echo esc($value->local_amount); ?></td>
                        </tr>
                        <?php } ?>  
                    </tbody>
                </table>
                <?php echo htmlspecialchars_decode($pager); ?>
            </div> 
        </div>
    </div>
</div>

 