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
                             <a class="btn btn-success w-md m-b-5 pull-right" href="<?php echo base_url("backend/slider/info") ?>"><i class="fa fa-plus" aria-hidden="true"></i> <?php echo display('add_slider') ?></a>
                            <a href="" class="action-item"><i class="ti-reload"></i></a>
                        </div>
                    </div>
                </div>
            </div>            
            <div class="card-body">
                <table id="example" class="table display table-bordered table-striped table-hover">
                    <thead>
                        <tr> 
                            <th><?php echo display('sl_no') ?></th>
                            <th><?php echo display('slider_h1_en') ?></th>
                            <th><?php echo display('slider_h1')." ".$web_language->name ?></th>
                            <th><?php echo display('image') ?></th>
                            <th><?php echo display('status') ?></th>
                            <th><?php echo display('action') ?></th>
                        </tr>
                    </thead>    
                    <tbody>
                        <?php if (!empty($slider)) ?>
                        <?php $sl = 1; ?>
                        <?php foreach ($slider as $value) { ?>
                        <tr>
                            <td><?php echo $sl++; ?></td> 
                            <td><?php echo $value->slider_h1_en; ?></td>
                            <td><?php echo $value->slider_h1_fr; ?></td>
                            <td><img src="<?php echo base_url().$value->slider_img; ?>" width="150" /></td>
                            <td><?php echo (($value->status==1)?display('active'):display('inactive')); ?></td>
                            <td>
                                <a href="<?php echo base_url("backend/slider/info/$value->slider_id") ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="Update"><i class="fas fa-edit" aria-hidden="true"></i></a>
                                <a href="<?php echo base_url("backend/slider/delete/$value->slider_id") ?>" onclick="return confirm('<?php echo display("are_you_sure") ?>')" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="right" title="Delete "><i class="fas fa-trash-alt" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                        <?php } ?>  
                    </tbody>
                </table>
                <?php echo $pager; ?>
            </div> 
        </div>
    </div>
</div>