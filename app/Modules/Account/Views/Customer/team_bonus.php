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
                <div class="table-responsive">
                    <table id="example" class="table display table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                 <th width="5%"><?php echo display('serial');?></th>
                                <th><?php echo display('date');?></th>
                                <th><?php echo display('level');?></th>
                                <th><?php echo display('team_bonus');?></th>
                                <th><?php echo display('status');?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($team_bonus){
                                $i=1;
                                foreach ($team_bonus as $key => $value) {
                            ?>
                            
                            <tr>
                                <td><?php echo esc($i++);?></td>
                                <td><?php echo esc($value->achive_date);?></td>
                                <td><?php echo esc($value->level_name);?></td>
                                <td><?php echo esc($value->team_bonous);?></td>
                                <td><?php  
                                if(esc($value->status)==1){
                                    echo "Completed";
                                }else {
                                    echo "Incompleted";
                                }
                                
                                ?></td>
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

<script src="<?php echo base_url("public/assets/plugins/datatables/dataTables.min.js") ?>"></script>
<script src="<?php echo base_url("public/assets/plugins/datatables/dataTables.bootstrap4.min.js") ?>"></script>
<script src="<?php echo base_url("public/assets/plugins/datatables/dataTables.responsive.min.js") ?>"></script>
<script src="<?php echo base_url("public/assets/plugins/datatables/responsive.bootstrap4.min.js") ?>"></script>
<script src="<?php echo base_url("public/assets/plugins/datatables/dataTables.buttons.min.js") ?>"></script>
<script src="<?php echo base_url("public/assets/plugins/datatables/buttons.bootstrap4.min.js") ?>"></script>
<script src="<?php echo base_url("public/assets/plugins/datatables/jszip.min.js") ?>"></script>

<script src="<?php echo base_url("public/assets/plugins/datatables/pdfmake.min.js") ?>"></script>
<script src="<?php echo base_url("public/assets/plugins/datatables/vfs_fonts.js") ?>"></script>
<script src="<?php echo base_url("public/assets/plugins/datatables/buttons.html5.min.js") ?>"></script>
<script src="<?php echo base_url("public/assets/plugins/datatables/buttons.print.min.js") ?>"></script>
<script src="<?php echo base_url("public/assets/plugins/datatables/buttons.colVis.min.js") ?>"></script>
<script src="<?php echo base_url("public/assets/plugins/datatables/data-bootstrap4.active.js") ?>"></script> 