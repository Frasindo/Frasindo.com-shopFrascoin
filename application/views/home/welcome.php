<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script>
    var base_url = "<?= base_url() ?>";
</script>

    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Welcome to Frashop</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3>Set Up Your NXT Account</h3>
                                    <div class="nav-tabs-custom">
                                        <ul class="nav nav-tabs">
                                            <li class="active"><a href="#have"  data-toggle="tab">I Have a NXT Account</a></li>
                                            <li class="nothave"><a href="#nothave"  data-toggle="tab">I Need a New NXT Account</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="have">
                                                <div class="row">
                                                <div class="col-lg-8">
                                                    <input class="form-control" id="nxt_acc" placeholder="NXT Account">
                                                </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                    <button class="btn btn-info" type="button" style="margin-top: 20px" id="save_nxt">Save</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="nothave">
                                                <div id="new_nxt">
                                                    <p style="font-size: 20px; padding-bottom: 12px">Creating Your Account . . .</p>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <button id="saveNewNXT" class="btn btn-info">Save</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
