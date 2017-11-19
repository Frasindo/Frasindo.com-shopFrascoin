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

            <li class="header">Campaign Panel</li>
            <li >
                <a href="<?= base_url("campaign") ?>">
                <i class="fa fa-dashboard"></i><span>Dashboard</span>
                </a>
            </li>
            <li  class="<?= ($this->uri->segment(3) == "twitter")?"active":"" ?>">
                <a href="<?= base_url("campaign/page/twitter") ?>">
                    <i class="fa fa-twitter"></i> <span>Twitter</span>
                </a>
            </li>
            <li  class="<?= ($this->uri->segment(3) == "yt")?"active":"" ?>">
                <a href="<?= base_url("campaign/page/yt") ?>">
                    <i class="fa fa-youtube"></i> <span>Video Log</span>
                </a>
            </li>
            <li  class="<?= ($this->uri->segment(3) == "blogger")?"active":"" ?>">
                <a href="<?= base_url("campaign/page/blogger") ?>">
                    <i class="fa fa-rss"></i> <span>Blogger</span>
                </a>
            </li>
            <li  class="<?= ($this->uri->segment(3) == "translate")?"active":"" ?>">
                <a href="<?= base_url("campaign/page/translate") ?>">
                    <i class="fa fa-globe"></i> <span>Translator</span>
                </a>
            </li>
            <li  class="<?= ($this->uri->segment(3) == "signature")?"active":"" ?>">
                <a href="<?= base_url("campaign/page/signature") ?>">
                    <i class="fa fa-check"></i> <span>Signature</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
