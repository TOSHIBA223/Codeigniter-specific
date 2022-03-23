<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                         <?php echo  form_open(base_url('backend/language/add_phrase'), ' class="form-inline" ') ?> 
                        <div class="form-group">
                            <label class="sr-only" for="addphrase"> Phrase Name</label>
                            <input name="phrase[]" type="text" class="form-control" id="addphrase" placeholder="Phrase Name">
                        </div>
                          
                        <button type="submit" class="btn btn-primary">Save</button>
                    <?php echo  form_close(); ?>
                         </div>
                    <div class="">
                        <div class="actions">
                             <a class="btn btn-primary" href="<?php echo base_url("backend/language/language_list") ?>"> <i class="fa fa-list"></i>  Language List </a> 
                            <a href="" class="action-item"><i class="ti-reload"></i></a>
                        </div>
                    </div>
                </div>
            </div>            
            <div class="card-body">
      <table class="table table-striped">
        <thead>
           
            <tr>
                <th><i class="fa fa-th-list"></i></th>
                <th>Phrase</th> 
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($phrases)) {?>
                <?php $sl = 1 ?>
                <?php foreach ($phrases as $value) {?>
                <tr>
                    <td><?php echo  esc($sl++) ?></td>
                    <td><?php echo  esc($value->phrase) ?></td>
                </tr>
                <?php } ?>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr><td colspan="2"><?php echo (!empty($links)?htmlspecialchars_decode($links):null) ?></td></tr>
        </tfoot>
      </table>
        <?php echo $pager ?>
    </div>
 

</div>

