<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
 <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="box box-info">
                        <div class="box-header with-border">
                             <h3 class="box-title">Bounty Setting</h3>
                        </div>
                        <div class="box-body">
                          <div class="col-md-12">
                              <?= ((isset($alert))?$alert:null) ?>
                          </div>
                            <form action="" method="post">
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Twitter Bonus</label>
                                        <input class="form-control b_twitter" value="<?= $bs->b_twitter ?>" name="b_twitter" type="number" placeholder="Bonus Twitter in Percent "/>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Twitter Require</label>
                                        <input class="form-control b_twitter" value="<?= $bs->r_twitter ?>" name="r_twitter" type="number" placeholder="Bonus Twitter in Percent "/>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>Vlog Bonus</label>
                                        <input class="form-control b_vlog" name="b_vlog" value="<?= $bs->b_vlog ?>" type="number" placeholder="Bonus Vlog in Percent "/>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>Vlog Require</label>
                                        <input class="form-control b_vlog" name="r_vlog" value="<?= $bs->r_vlog ?>" type="number" placeholder="Vlog Requirement "/>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>Blog Bonus</label>
                                        <input class="form-control b_blog" name="b_blog" value="<?= $bs->b_blog ?>" type="number" placeholder="Bonus Blog in Percent "/>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>Blog Require</label>
                                        <input class="form-control b_blog" name="r_blog" value="<?= $bs->r_blog ?>" type="number" placeholder="Blog Requirement "/>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>Translate Bonus</label>
                                        <input class="form-control b_trans" name="b_translate" value="<?= $bs->b_translate ?>" type="number" placeholder="Bonus Translate in Percent "/>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>Translate Require</label>
                                        <input class="form-control b_trans" name="r_translate" value="<?= $bs->r_translate ?>" type="number" placeholder="Translate Require "/>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Signature Bonus</label>
                                        <input class="form-control b_sign" name="b_signature" value="<?= $bs->b_signature ?>" type="number" placeholder="Bonus Signature in Percent "/>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Signature Require</label>
                                        <input class="form-control b_sign" name="r_signature" value="<?= $bs->r_signature ?>" type="number" placeholder="Signature Require "/>
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
