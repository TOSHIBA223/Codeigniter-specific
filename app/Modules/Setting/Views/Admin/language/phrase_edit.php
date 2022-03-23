<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <a class="btn btn-primary" href="<?php echo base_url("backend/language/language_list") ?>"> <i class="fa fa-list"></i>  Language List </a> 
                    </div>
                    <div class="">
                        <div class="actions">
                             <a class="btn btn-success" href="<?php echo base_url("backend/language/phrase_list") ?>"> <i class="fa fa-plus"></i> Add Phrase</a>
          
                             <a href="" class="action-item"><i class="ti-reload"></i></a>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="card-body">           
            <?php echo  form_open(base_url('backend/language/add_lebel')) ?>
            <table class="table table-striped">
                <thead> 
                    <tr>
                        <th><i class="fa fa-th-list"></i></th>
                        <th>Phrase</th>
                        <th>Label</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php echo  form_hidden('language', $language) ?>
                    <?php if (!empty($phrases)) {?>
                        <?php $sl = 1 ?>
                        <?php foreach ($phrases as $value) {?>
                        <tr class="<?php echo  (empty($value->$language)?"bg-danger":null) ?>">
                        
                            <td><?php echo  esc($sl++) ?></td>
                            <td><input type="text" name="phrase[]" value="<?php echo  esc($value->phrase) ?>" class="form-control" readonly></td>
                            <td><input type="text" name="lang[]" value="<?php echo  esc($value->$language) ?>" class="form-control"></td> 
                        </tr>
                        <?php } ?>
                    <?php } ?> 
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" align="center"> 
                            
                            <button type="submit" class="btn btn-success">Save</button>
                        </td>
                       
                    </tr>
                </tfoot>
            </table>
        <?php echo $pager ?>
        <?php echo  form_close() ?>
        </div>
    </div>
</div>