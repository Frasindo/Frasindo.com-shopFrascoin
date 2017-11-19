<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

    <div class="content-wrapper">
      <section class="content">
        <div class="row">
            <div class="col-md-8 col-md-offset-2  ">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Account Settings</h3>
                </div>
                <div class="box-body">
                  <div class="col-md-12">
                      <?= (isset($alert))?$alert:null ?>
                  </div>
                  <div class="col-md-12">
                    <center><img class="img-responsive img-circle" src="<?= $this->gravatar->get($this->session->email) ?>"></img><p>*Use Grvatar to Change your Avatar</p></center>
                  </div>
                  <form action="" method="post">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Your Name</label>
                      <input class="form-control" name="nama" value="<?= $infouser["nama"] ?>" placeholder="Your Name"/>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Username</label>
                      <input class="form-control" value="<?= $this->campaign_model->whois($this->session->id_users) ?>" name="username" placeholder="Username" disabled/>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Email</label>
                      <input class="form-control" value="<?= $infouser["email"] ?>" name="email" placeholder="Email"/>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Password</label>
                      <input class="form-control"  name="pass" placeholder="Leave Blank if not want to change"/>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>ARDOR Address</label>
                      <input class="form-control" name="ardor_addr" value="<?= $infouser["ardor_addr"] ?>"  placeholder="ARDR-XXX-XXX-XXX"/>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>BTC Address</label>
                      <input class="form-control" name="btc_addr" value="<?= $infouser["btc_addr"] ?>"  placeholder="BTC Address"/>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Youtube Channel ID (How to Get It ? )</label>
                      <input class="form-control" value="<?= $infouser["youtube"] ?>"  name="youtube" placeholder="XXX-XXX-XXX-XXX"/>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Twitter Screen Name (How to Get It ? )</label>
                      <input class="form-control" value="<?= $infouser["twitter"] ?>"  name="twitter" placeholder="XXX-XXX-XXX-XXX"/>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Blog Unique Code</label>
                        <input class="form-control" name="blog" value="<?= $infouser["blog_unique"] ?>"  placeholder="SDSAS" disabled/>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <center><button class="btn btn-success" name="save" type="submit">Save</button></center>
                    </div>
                  </div>
                </form>
                </div>
              </div>
            </div>
        </div>
      </section>
    </div>
