<?if (!empty($data['error'])):?>
<div class="alert alert-danger" role="alert"><?=$data['error']?></div>
<?endif;?>
<form class="form-inline" method="post" action="/user/login">
    <div class="form-group">
        <label class="sr-only" for="login">Login / Email address</label>
        <input type="text" class="form-control" name="login" id="login" placeholder="Login/email" value="<?=$data['login']?>">
    </div>
    <div class="form-group">
        <label class="sr-only" for="password">Password</label>
        <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="<?=$data['password']?>">
    </div>
    <div class="checkbox">
        <label>
            <input type="checkbox" name="remember" value="<?=$data['remember']?>" checked="checked"> Remember me
        </label>
    </div>
    <button type="submit" class="btn btn-default">Sign in</button>
</form>