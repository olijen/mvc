<div class="forms">
    <form method="POST" enctype="multipart/form-data"
    class="ajax_form"  action="javascript:void(null);"
    onsubmit="call('<?= $this->path['site'].'/tools/login' ?>')">
      <p>
      <b>Введите логин</b> <br />
      <input type="text" name="user[username]"/>
      </p>
      <hr />
      <p><b>Введите логин</b> <br />
      <input type="password" name="user[password]"/>
      </p>
      <hr />
      <input class="confirm" type="submit" value="Войти" />
    </form>
</div>