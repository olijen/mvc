<div class="header">
    <a href="/">

        [<span style="color: red;">P</span>rism  MVC ]
        
    </a>
    <div class="login_status">
    <?php if (LOGGED) : ?>
    <div class="forms">
        <form method="POST" enctype="multipart/form-data"
        class="ajax_form"  action="javascript:void(null);"
        onsubmit="call('<?= '/tools/logout' ?>')">
          <b><?= Registry::get('user')->username ?> : </b>
          <input type="submit" class="deny" value="Выйти" />
        </form>
    </div>
    <?php else : ?>
    <div class="forms">
    <form method="POST" enctype="multipart/form-data"
    class="ajax_form"  action="javascript:void(null);"
    onsubmit="call('<?= '/tools/login' ?>')">
      
      <b>Введите логин</b>
      <input type="text" name="user[username]"/>      
      
      <b>Введите пароль</b>
      <input type="password" name="user[password]"/>

      <input type="submit" class="confirm" value="Войти" />
    </form>
    </div>
    <?php endif ?>
    
    </div>

	<div class="notices">
<!--------------------------------------------------------------------------------->
<?php
$notices = '';
if (!empty($this->notice['notice'])) {
    $notices .= "<div class='sub-notice notice'>".$this->notice['notice']."</div>";
}
if (!empty($this->notice['error'])) {
    $notices .= "<div class='sub-notice error'>".$this->notice['error']."</div>";
}
if (!empty($this->notice['access'])) {
    $notices .= "<div class='sub-notice access'>".$this->notice['access']."</div>";
}
echo $notices;
?>
	</div>
<!--------------------------------------------------------------------------------->
    <div id="topblock">
    	<ul class="topmenu">
    		<li><a href="/">Главная</a></li>
            <li><a href="/tools/register">Регистрация</a></li>
            <li><a href="/tools/migrate">Установка</a></li>
            <li><a href="/">Информация</a></li>
    	</ul>
    </div>
</div>