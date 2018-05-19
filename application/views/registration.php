<div class="container regwell">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<div class="card card-body bg-light">

				<div class="login-errors">
					<?php echo validation_errors(); ?>
				</div>

				<form action="/user/register" method="post">
					<div class="form-group">
						<label for="loginInput">Логин</label>
						<input type="text" name="login" value="<?php echo set_value('login'); ?>" class="form-control" id="loginInput" aria-describedby="loginHelp" placeholder="Имя юзера">
						<small id="loginHelp" class="form-text text-muted">минимум 5 символов</small>
					</div>
						<div class="form-group">
						<label for="passwordInput">Пароль</label>
						<input type="password" name="password" value="<?php echo set_value('password'); ?>" class="form-control" id="passwordInput" placeholder="Пароль">
					</div>
					<button type="submit" class="btn btn-primary">Регистрация</button>
					<a class="float-right" href="/">Вернуться на главную</a>
				</form>
			</div>
		</div>
		<div class="col-md-3"></div>
	</div>
</div>