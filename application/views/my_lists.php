<div class="container regwell">
	<div class="card card-body bg-light">
		<h4>Мои списки:</h4>

		<? if (!isset($lists)) { ?>
			<div>
				Пока ничего нету, создайте что-нибудь.
			</div>
		<? } else { ?>
		<ul>
			<? foreach ($lists as $list) { ?>
				<ul><?=$list['name'];?></ul>
			<? } ?>
		</ul>
		<? } ?>

		<hr>
		<form class="form-inline">
			<div class="form-group mx-sm-3 mb-2">
				<input type="password" class="form-control" id="inputPassword2" placeholder="Новый список">
			</div>
			<button type="submit" class="btn btn-primary mb-2">Создать</button>
		</form>
	</div>
</div>
