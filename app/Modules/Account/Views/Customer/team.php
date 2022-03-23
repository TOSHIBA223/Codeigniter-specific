
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
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true"><?php echo display('generation_one');?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false"><?php echo display('generation_two');?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false"><?php echo display('generation_three');?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#level-4" role="tab" aria-controls="pills-contact" aria-selected="false"><?php echo display('generation_four');?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#level-5" role="tab" aria-controls="pills-contact" aria-selected="false"><?php echo display('generation_five');?></a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="panel-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th><?php echo display('user_id')?></th>
                                                <th><?php echo display('username')?></th>
                                                <th><?php echo display('name')?></th>
                                                <th><?php echo display('order_id')?></th>
                                                <th><?php echo display('amount')?></th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            if(isset($level_one['num']))
                                                for ($i=1; $i<=$level_one['num'] ; $i++) {
                                                    foreach ($level_one['amount_'.$i] as $key => $value1) {
                                            ?>
                                            <tr>
                                                <td><?php echo $level_one['user_id_'.$i]; ?></td>
                                                <td><?php echo $level_one['username_'.$i]; ?></td>
                                                <td><?php echo $level_one['name_'.$i]; ?></td>
                                                <td><?php echo $value1->order_id; ?></td>
                                                <td><?php echo $value1->amount; ?></td>
                                            </tr>
                                            <?php } } ?>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <div class="panel-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th><?php echo display('user_id')?></th>
                                                <th><?php echo display('username')?></th>
                                                <th><?php echo display('name')?></th>
                                                <th><?php echo display('order_id')?></th>
                                                <th><?php echo display('amount')?></th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            if(isset($level_two['num']))
                                                for ($i=1; $i<=$level_two['num']; $i++) { 
                                                    foreach ($level_two['amount_'.$i] as $key => $value2) {
                                            ?>
                                            <tr>
                                                <td><?php echo $level_two['user_id_'.$i]; ?></td>
                                                <td><?php echo $level_two['username_'.$i]; ?></td>
                                                <td><?php echo $level_two['name_'.$i]; ?></td>
                                                <td><?php echo $value2->order_id; ?></td>
                                                <td><?php echo $value2->amount; ?></td>
                                            </tr>
                                            <?php } } ?>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                            <div class="panel-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th><?php echo display('user_id')?></th>
                                                <th><?php echo display('username')?></th>
                                                <th><?php echo display('name')?></th>
                                                <th><?php echo display('order_id')?></th>
                                                <th><?php echo display('amount')?></th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            if(isset($level_three['num']))
                                                for ($i=1; $i<=$level_three['num']; $i++) {
                                                    foreach ($level_three['amount_'.$i] as $key => $value3) {
                                            ?>
                                            <tr>
                                                <td><?php echo esc($level_three['user_id_'.$i]); ?></td>
                                                <td><?php echo esc($level_three['username_'.$i]); ?></td>
                                                <td><?php echo esc($level_three['name_'.$i]); ?></td>
                                                <td><?php echo esc($value3->order_id); ?></td>
                                                <td><?php echo esc($value3->amount); ?></td>
                                            </tr>
                                            <?php } } ?>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="level-4" role="tabpanel" aria-labelledby="pills-home-tab">
                                               <div class="panel-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th><?php echo display('user_id')?></th>
                                                <th><?php echo display('username')?></th>
                                                <th><?php echo display('name')?></th>
                                                <th><?php echo display('order_id')?></th>
                                                <th><?php echo display('amount')?></th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            if(isset($level_four['num']))
                                                for ($i=1; $i<=$level_four['num']; $i++) { 
                                                    foreach ($level_four['amount_'.$i] as $key => $value4) {
                                            ?>
                                            <tr>
                                                <td><?php echo esc($level_four['user_id_'.$i]); ?></td>
                                                <td><?php echo esc($level_four['username_'.$i]); ?></td>
                                                <td><?php echo esc($level_four['name_'.$i]); ?></td>
                                                <td><?php echo esc($value4->order_id); ?></td>
                                                <td><?php echo esc($value4->amount); ?></td>
                                            </tr>
                                            <?php } } ?>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="level-5" role="tabpanel" aria-labelledby="pills-home-tab">
                                              <div class="panel-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th><?php echo display('user_id')?></th>
                                                <th><?php echo display('username')?></th>
                                                <th><?php echo display('name')?></th>
                                                <th><?php echo display('order_id')?></th>
                                                <th><?php echo display('amount')?></th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            if(isset($level_five['num']))
                                                for ($i=1; $i<=@$level_five['num']; $i++) { 
                                                    foreach ($level_five['amount_'.$i] as $key => $value5) {
                                            ?>
                                            <tr>
                                                <td><?php echo esc($level_five['user_id_'.$i]); ?></td>
                                                <td><?php echo esc($level_five['username_'.$i]); ?></td>
                                                <td><?php echo esc($level_five['name_'.$i]); ?></td>
                                                <td><?php echo esc($value5->order_id); ?></td>
                                                <td><?php echo esc($value5->amount); ?></td>
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
