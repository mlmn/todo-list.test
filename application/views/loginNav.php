<div class="container-fluid greyhead">
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<div class="login-errors">
					<? if (isset($this->loginError)) {?>
						<div class="login-error">Неправильный логин или пароль</div>
					<? } ?>
					<?php echo validation_errors(); ?>
				</div>
			</div>
			<div class="col-md-8">
				<form action="/user/login" method="post">
					<div class="form-row">
						<span class="header-notice">Вы не залогинены, <a href="/user/register">зарегистрироваться</a> или войти:</span>
						<div class="col-md-2">
							<input type="text" name="login" value="<?php echo set_value('login'); ?>" class="form-control form-control-sm" placeholder="Логин">
						</div>
						<div class="col-md-2">
							<input type="password" name="password" value="<?php echo set_value('password'); ?>" class="form-control form-control-sm" placeholder="Пароль">
						</div>
						<div class="col-auto">
							<button type="submit" class="btn btn-primary btn-sm mb-2">Войти</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>