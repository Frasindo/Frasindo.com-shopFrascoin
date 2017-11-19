<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <div class="user-panel">
          <div class="pull-left image">
            <img src="<?= $this->gravatar->get($this->session->email) ?>" class="img-circle" alt="<?= (isset($user_info["nama"]))?$user_info["nama"]:"No Name" ?>">
          </div>
          <div class="pull-left info">
            <p><?= $this->session->username ?></p>
          </div>
      </div>
        <ul class="sidebar-menu" data-widget="tree">

            <li class="header">Administrator Panel</li>
            <li >
                <a href="<?= base_url("admin") ?>">
                <i class="fa fa-gear"></i><span>Crowdsale Setting</span>
                </a>
            </li>
            <li  class="<?= ($this->uri->segment(2) == "ticket")?"active":"" ?>">
                <a href="<?= base_url("admin/page/ticket") ?>">
                    <i class="fa fa-ticket"></i> <span>Ticket Manager</span>
                </a>
            </li>
            <li  class="<?= ($this->uri->segment(3) == "testify")?"active":"" ?>">
                <a href="<?= base_url("admin/page/testify") ?>">
                    <i class="fa fa-user"></i> <span>Testimony</span>
                </a>
            </li>
            <li  class="<?= ($this->uri->segment(3) == "usermanage")?"active":"" ?>">
                <a href="<?= base_url("admin/page/usermanage") ?>">
                    <i class="fa fa-users"></i> <span>User Manager</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
