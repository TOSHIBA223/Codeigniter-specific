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
                            <a href=" " class="action-item"><i class="ti-reload"></i></a>
                        </div>
                    </div>
                </div>
            </div>            
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <?php 
                        echo form_open_multipart(base_url("backend/setting/update_sender")) ?>

                        <fieldset>
                           <legend> Email Notification Settings </legend>
                            <div class="checkbox">
                               <input id="checkbox1" type="checkbox" value="1" <?php echo ($email->deposit!=NULL?'checked':'')?> name="deposit">
                               <label for="checkbox1">Deposit</label>
                           </div>
                           <div class="checkbox checkbox-primary">
                               <input id="checkbox2" type="checkbox" value="1" <?php echo ($email->transfer!=NULL?'checked':'')?> name="transfer">
                               <label for="checkbox2">Transfer</label>
                           </div>
                           <div class="checkbox checkbox-success">
                               <input id="checkbox3" type="checkbox" value="1" <?php echo ($email->payout!=NULL?'checked':'')?>  name="payout">
                               <label for="checkbox3">Payout</label>
                           </div>
                           <div class="checkbox checkbox-info">
                               <input id="checkbox4" type="checkbox" value="1" <?php echo ($email->commission!=NULL?'checked':'')?> name="commission">
                               <label for="checkbox4">Comission</label>
                           </div>
                           <div class="checkbox checkbox-warning">
                               <input id="checkbox5" type="checkbox" value="1" <?php echo ($email->team_bonnus!=NULL?'checked':'')?>  name="team_bonnus">
                               <label for="checkbox5">Team Bonnus</label>
                           </div>
                           <div class="checkbox checkbox-danger">
                               <input id="checkbox6" type="checkbox" value="1" <?php echo ($email->withdraw!=NULL?'checked':'')?>  name="withdraw">
                               <label for="checkbox6">Withdraw</label>
                           </div>
                           <input type="hidden" name="email" value="email">

                       </fieldset>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-success"><?php echo display("save") ?></button>
                        </div>
                    <?php echo form_close() ?>
                    </div>


                    <div class="col-sm-6 col-md-6 col-lg-6">
                         <?php 
                            echo form_open_multipart(base_url("backend/setting/update_sender")) ?>
                         <fieldset>
                            <legend> SMS Sending  </legend>
                             <div class="checkbox">
                                <input id="checkbox7" type="checkbox" value="1" <?php echo ($sms->deposit!=NULL?'checked':'')?> name="deposit">
                                <label for="checkbox7">Deposit</label>
                            </div>
                            <div class="checkbox checkbox-primary">
                                <input id="checkbox8" type="checkbox" value="1" <?php echo ($sms->transfer!=NULL?'checked':'')?> name="transfer">
                                <label for="checkbox8">Transfer</label>
                            </div>
                            <div class="checkbox checkbox-success">
                                <input id="checkbox9" type="checkbox" value="1" <?php echo ($sms->payout!=NULL?'checked':'')?> name="payout">
                                <label for="checkbox9">Payout</label>
                            </div>
                            <div class="checkbox checkbox-info">
                                <input id="checkbox10" type="checkbox" value="1" <?php echo ($sms->commission!=NULL?'checked':'')?> name="commission">
                                <label for="checkbox10">Commissin</label>
                            </div>
                            <div class="checkbox checkbox-warning">
                                <input id="checkbox11" type="checkbox" value="1" <?php echo ($sms->team_bonnus!=NULL?'checked':'')?> name="team_bonnus">
                                <label for="checkbox11">Team Bonnus</label>
                            </div>
                            <div class="checkbox checkbox-danger">
                                <input id="checkbox12" type="checkbox" value="1" <?php echo ($sms->withdraw!=NULL?'checked':'')?> name="withdraw">
                                <label for="checkbox12">Withdraw</label>
                            </div>
                            <input type="hidden" name="sms" value="sms">


                        </fieldset>
                        <div class="mt-2">
                        <button type="submit" class="btn btn-success"><?php echo display("save") ?></button>
                        </div>
                     <?php echo form_close() ?>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>




 