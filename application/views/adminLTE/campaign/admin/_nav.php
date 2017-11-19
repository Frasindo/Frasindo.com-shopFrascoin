<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <div class="user-panel">
          <div class="pull-left image">
            <img src="<?= $this->gravatar->get($this->session->email) ?>" class="img-circle" alt="<?= (isset($user_info["nama"]))?$user_info["nama"]:"No Name" ?>">
          </div>
          <div class="pull-left info">
            <p><?= $this->session->nama ?></p>
          </div>
      </div>
        <ul class="sidebar-menu" data-widget="tree">

            <li class="header">Campaign Admin</li>
            <li >
                <a href="<?= base_url("campaign/admin") ?>">
                <i class="fa fa-dashboard"></i><span>Dashboard</span>
                </a>
            </li>
            <li  class="<?= ($this->uri->segment(3) == "twitter")?"active":"" ?>">
                <a href="<?= base_url("campaign/admin/twitter") ?>">
                    <i class="fa fa-twitter"></i> <span>Twitter</span>
                </a>
            </li>
            <li  class="<?= ($this->uri->segment(3) == "youtube")?"active":"" ?>">
                <a href="<?= base_url("campaign/admin/youtube") ?>">
                    <i class="fa fa-youtube"></i> <span>Video Log</span>
                </a>
            </li>
            <li  class="<?= ($this->uri->segment(3) == "blogger")?"active":"" ?>">
                <a href="<?= base_url("campaign/admin/blogger") ?>">
                    <i class="fa fa-rss"></i> <span>Blogger</span>
                </a>
            </li>
            <li  class="<?= ($this->uri->segment(3) == "translate")?"active":"" ?>">
                <a href="<?= base_url("campaign/admin/translate") ?>">
                    <i class="fa fa-globe"></i> <span>Translator</span>
                </a>
            </li>
            <li  class="<?= ($this->uri->segment(3) == "signature")?"active":"" ?>">
                <a href="<?= base_url("campaign/admin/signature") ?>">
                    <i class="fa fa-check"></i> <span>Signature</span>
                </a>
            </li>
            <li  class="<?= ($this->uri->segment(3) == "madmin")?"active":"" ?>">
                <a href="<?= base_url("campaign/admin/madmin") ?>">
                    <i class="fa fa-users"></i> <span>Manage Admin</span>
                </a>
            </li>
            <li  class="<?= ($this->uri->segment(3) == "musers")?"active":"" ?>">
                <a href="<?= base_url("campaign/admin/musers") ?>">
                    <i class="fa fa-users"></i> <span>Manage Users</span>
                </a>
            </li>
            <li  class="<?= ($this->uri->segment(3) == "sbounty")?"active":"" ?>">
                <a href="<?= base_url("campaign/admin/sbounty") ?>">
                    <i class="fa fa-money"></i> <span>Bounty Settings</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
