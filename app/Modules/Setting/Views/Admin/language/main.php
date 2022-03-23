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
                              <a class="btn btn-success" href="<?php echo base_url("backend/language/phrase_list") ?>"> <i class="fa fa-plus"></i> Add Phrase</a>
                              <a href="" class="action-item"><i class="ti-reload"></i></a>
                        </div>
                    </div>
                </div>
            </div>            
            <div class="card-body">
      <table class="table table-striped">
           
        <thead>
            <tr>
                <td colspan="3">
                    <?php echo  form_open(base_url('backend/language/add_language'), ' class="form-inline" ') ?> 
                        <div class="form-group">
                            <label class="sr-only" for="addLanguage"> Language Name</label>
                            <input name="language" type="text" class="form-control" id="addLanguage" placeholder="Language Name">
                        </div>
                          
                        <button type="submit" class="btn btn-primary">Save</button>
                    <?php echo  form_close(); ?>
                </td>
            </tr>
            <tr>
                <th><i class="fa fa-th-list"></i></th>
                <th>Language</th>
                <th><i class="fa fa-cogs"></i></th>
            </tr>
        </thead>


        <tbody>
            <?php if (!empty($languages)) {?>
                <?php $sl = 1 ?>
                <?php foreach ($languages as $key => $language) {?>
                <tr>
                    <td><?php echo  esc($sl++) ?></td>
                    <td><?php echo  esc($language) ?></td>
                    <td><a href="<?php echo  base_url("backend/language/edit_phrase/".$key) ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>  
                    </td> 
                </tr>
                <?php } ?>
            <?php } ?>
        </tbody>

      </table>
            </div>
        </div>
    </div>
</div>

