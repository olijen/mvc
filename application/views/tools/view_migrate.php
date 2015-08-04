<h1>Установка БД</h1>
<?php if (Registry::get('mysql_error')) : ?>
    <h3 style="color: red;">Нет соединения с базой. Установите стартовую миграцию!</h3>
<?php else : ?>
    <h3  style="color: green;">Соединение с базой установлено.</h3>
<?php endif ?>

Для установки демо фреймворка нужно установить базу. <br />
Имя базы и атрибуты доступа укажите в файле: <br />
[<strong>~/path/to/root/</strong>application/config.php] <br /><br />

<strong>ИМЯ БАЗЫ ::::::::::::::::::::</strong> <?= DB_NAME ?> <br />
<strong>ХОСТ ::::::::::::::::::::::::::::</strong> <?= DB_HOST ?> <br />
<strong>ПОЛЬЗОВАТЕЛЬ ::::::::::::</strong> <?= DB_USER ?> <br />
<strong>ПАРОЛЬ :::::::::::::::::::::::</strong> <?php $r = ''; for ($i=0; $i < strlen(DB_PWD); $i++) $r.='*'; echo $r ? $r : '<Без пароля>'; ?> <br />

<h4>Миграция: [<strong>~/path/to/root/</strong>application/migration.sql] </h4>

<a href="#" id="showSql">[Показать SQL]</a> <br />
<div id="sqlBlock" style="display: none; border: 1px solid #ccc; width: 40%;">
    <span>
        <?= $migration ?>
    </span>
</div>


<br />
<a id="up" href="#">[УСТАНОВИТЬ БАЗУ]</a> <hr />

<script type="text/javascript">
    var show = false;
    window.onload = function() {
        
        showSql.onclick = function() {
            if (show === true) {
                sqlBlock.style.display = 'none';
                show = false;
                return;
            }
            sqlBlock.style.display = 'block';
            show = true;
        }
        
        up.onclick = function() {
            $.ajax({
                url: '/tools/migrate?up',
                success: function(data) {
                    content.innerHTML = data;
                }
            });
        }
    }
</script>