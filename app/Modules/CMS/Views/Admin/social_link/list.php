<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0"><?php echo (!empty($title)?esc($title):null) ?></h6>
                    </div>
                    <div class="text-right">
                        <div class="actions">
                            <a href="" class="action-item"><i class="ti-reload"></i></a>
                        </div>
                    </div>
                </div>
            </div>            
            <div class="card-body">
                <table id="example" class="table display table-bordered table-striped table-hover">
                    <thead>
                        <tr> 
                            <th><?php echo display('sl_no')?></th>
                            <th><?php echo display('name')?></th>
                            <th><?php echo display('link')?></th>
                            <th><?php echo display('icon')?></th>
                            <th><?php echo display('status')?></th>
                            <th><?php echo display('action')?></th>
                        </tr>
                    </thead>    
                    <tbody>
                        <?php if (!empty($social_link)) ?>
                        <?php $sl = 1; ?>
                        <?php foreach ($social_link as $value) { ?>
                        <tr>
                            <td><?php echo esc($sl++); ?></td> 
                            <td><?php echo esc($value->name); ?></td>
                            <td><?php echo esc($value->link); ?></td>
                            <td><h1><i class="fab fa-<?php echo $value->icon; ?>"></i></h1></td>
                            <td><?php echo (($value->status==1)?display('active'):display('inactive')); ?></td>
                            <td>
                                <a href="<?php echo base_url("backend/info/social_link/$value->id") ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="Update"><i class="fas fa-edit" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                        <?php } ?>  
                    </tbody>
                </table>
                <?php echo htmlspecialchars_decode($pager); ?>
            </div> 
        </div>
    </div>
</div>