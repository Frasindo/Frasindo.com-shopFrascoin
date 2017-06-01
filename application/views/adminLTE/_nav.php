<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
     
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <?php $disabled = 'class="disabledLink"'; foreach($data as $menu){ ?>
        <li>
          <a href="<?= $menu->link ?>" <?= ($menu->disable == true)?$disabled:null ?>  >
            <i class="<?= $menu->icon ?>"></i> <span><?= $menu->nama_link ?></span>
          </a>
        </li>
        <?php } ?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>