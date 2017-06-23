<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <div class="user-panel">
        <div class="pull-left image">
          <img src="<?= $user_info["picture"] ?>" class="img-circle" alt="<?= (isset($user_info["nama"]))?$user_info["nama"]:"No Name" ?>">
        </div>
        <div class="pull-left info">
          <p><?= (isset($user_info["nama"]))?$user_info["nama"]:"No Name" ?></p>
        </div>
      </div>
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li>
                <a href="<?= base_url() ?>">
                    <i class="fa fa-home"></i> <span>Home</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url("shop") ?>">
                <i class="fa fa-cart-arrow-down"></i><span>Crowdsale Shop</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url() ?>">
                    <i class="fa fa-car"></i> <span>Free Car Use Reddem</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url() ?>">
                    <i class="fa fa-globe"></i> <span>Roadmap</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url() ?>">
                    <i class="fa fa-check-circle-o"></i> <span>Voting</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url() ?>">
                    <i class="fa fa-ticket"></i> <span>Ticket</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url("page/account") ?>">
                    <i class="fa fa-user"></i> <span>Account Setting</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url("logout") ?>">
                    <i class="fa fa-sign-out"></i> <span>Logout</span>
                </a>
            </li>



        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
