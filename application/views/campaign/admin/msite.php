<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
 <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="box box-info">
                        <div class="box-header with-border">
                             <h3 class="box-title">Site Setting</h3>
                        </div>
                        <div class="box-body">
                          <div class="col-md-12">
                              <?= ((isset($alert))?$alert:null) ?>
                          </div>
                            <form action="" method="post">
                                <div class="row">
                                  <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Last Trigger</label>
                                        <input class="form-control" value="<?= $last_trigger ?>" name="last_trigger" type="text" placeholder="" disabled/>
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Next Trigger</label>
                                        <input class="form-control dateNext" value="<?=$next_trigger ?>" name="next_trigger" type="text" placeholder="" />
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Trigger Jump</label>
                                        <input class="form-control" value="<?=$trigger_hops ?>" name="trigger_hops" type="text" placeholder="" />
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Allocated Funds</label>
                                        <input class="form-control" value="<?= $alloc ?>" name="allocated" type="text" placeholder="" />
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                        <button class="btn btn-success" name="save" type="submit">Save</button>
                                    </div>
                                  </div>
                                </div>
                            </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <style>
                .ui-datepicker{z-index: 99 !important};</style>
                <script>
                $(function(){
                  $('.dateNext').datepicker({
                    format: 'yyyy-mm-dd 00:00:00'
                  });
                });
                </script>
