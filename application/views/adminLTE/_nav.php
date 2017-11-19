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

            <li class="header">SHOP</li>
            <li class="<?= ($this->uri->segment(1) == "shop")?"active":"" ?>">
                <a href="<?= base_url("shop") ?>">
                <i class="fa fa-cart-arrow-down"></i><span>Crowdsale Shop</span>
                </a>
            </li>
            <li  class="<?= ($this->uri->segment(1) == "carcoin")?"active":"" ?>">
                <a href="<?= base_url("carcoin") ?>">
                    <i class="fa fa-plus-circle"></i> <span>Car Coin Bonus</span>
                </a>
            </li>
            <li  class="<?= ($this->uri->segment(1) == "freecar")?"active":"" ?>">
                <a href="<?= base_url("freecar") ?>">
                    <i class="fa fa-car"></i> <span>Free Car Usage</span>
                </a>
            </li>
            <li class="header">FUTURE DEVELOPMENT</li>
            <li  class="<?= ($this->uri->segment(1) == "")?"active":"" ?>">
                <a href="<?= base_url() ?>">
                    <i class="fa fa-tachometer"></i> <span>Dashboard</span>
                </a>
            </li>

            <li>
                <a target="_blank" href="https://drive.google.com/open?id=0BxfUoK7MHC0ZNFVxV1RzWk92STg">
                    <i class="fa fa-globe"></i> <span>Roadmap</span>
                </a>
            </li>
            <li>
                <a target="_blank" href="https://drive.google.com/open?id=0BxfUoK7MHC0ZUEo1SEZoc3FNOU0">
                    <i class="fa fa-file-text-o"></i> <span>White Paper</span>
                </a>
            </li>
            <li  class="<?= ($this->uri->segment(1) == "voting")?"active":"" ?>">
                <a href="<?= base_url("voting") ?>">
                    <i class="fa fa-check-circle-o"></i> <span>Voting</span>
                </a>
            </li>
            <li class="header">ACCOUNT</li>
            <li class="<?= ($this->uri->segment(2) == "ticket")?"active":"" ?>">
                <a href="<?= base_url("page/ticket") ?>">
                    <i class="fa fa-ticket"></i> <span>Ticket</span>
                </a>
            </li>
            <li class="<?= ($this->uri->segment(2) == "account")?"active":"" ?>">
                <a href="<?= base_url("page/account") ?>">
                    <i class="fa fa-user"></i> <span>Account Setting</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
