<div id="nav-col">
  <section id="col-left" class="col-left-nano">
    <div id="col-left-inner" class="col-left-nano-content">
      <div class="collapse navbar-collapse navbar-ex1-collapse" id="sidebar-nav">
        <ul class="nav nav-pills nav-stacked">
            <?
            if (isset($menu)) {
            foreach ($menu->menu as $menuitem) {
            if (!$menuitem->type) {
            ?>
            <li <?if ($active_db==1){echo "class='active'";}?>><a href="<?echo $menuitem->url;?>"><img src="<?echo $config->img;?>/pointer.gif"><span><?echo $menuitem->caption;?></span></a></li>
            <?}}}?>
        </ul>
      </div>
    </div>
  </section>
  <div id="nav-col-submenu"></div>
</div>