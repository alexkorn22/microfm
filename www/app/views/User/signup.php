<?
/**
 * @var \app\models\User $user
 * @var string $errors
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
<form action="/user/signup" method="post" role="form">

    <div class="form-group">
        <label for="email">Email</label>
        <input type="text" name="email" id="email" class="form-control" placeholder="" aria-describedby="helpId" value="<?=$user->email?>">
    </div>
    <div class="form-group">
        <label for="login">Логин</label>
        <input type="text" name="login" id="login" class="form-control" placeholder="" aria-describedby="helpId" value="<?=$user->login?>">
    </div>
    <div class="form-group">
        <label for="password">Пароль</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="" aria-describedby="helpId">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>