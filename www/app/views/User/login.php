<?
/**
 * @var string $errors
 * @var string $login
 */
?>
<?if ($errors):?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?=$errors?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?endif;?>
<form action="/user/login" method="post" role="form">

    <div class="form-group">
        <label for="login">Логин/email</label>
        <input type="text" name="login" id="login" class="form-control" placeholder="" aria-describedby="helpId" value="<?=$login?>">
    </div>
    <div class="form-group">
        <label for="password">Пароль</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="" aria-describedby="helpId">
    </div>

    <button type="submit" class="btn btn-primary">Login</button>
</form>