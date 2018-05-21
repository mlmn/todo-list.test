<div class="container regwell">
	<div class="card card-body bg-light">
		<h4>Мои списки:</h4>

		<? if (empty($lists)) { ?>
			<div>
				Пока ничего нету, создайте что-нибудь.
			</div>
		<? } else { ?>
		<ul>
			<? foreach ($lists as $list) { ?>
				<li class="list-names">
					<div class="row">
						<div class="col-md-10">
							<a href="todo/list/<?=$list['id'];?>"><?=$list['list_name'];?></a>
						</div>
						<div class="col-md-2">
							<a class="float-right" href="/todo/deleteList/<?=$list['id'];?>">Удалить</a>
						</div>
					</div>

					
				</li>
				<hr>
			<? } ?>
		</ul>
		<? } ?>

		<hr>

		<div class="login-errors">
			<?php echo validation_errors(); ?>
		</div>

		<form class="form-inline" action="/todo" method="post">
			<div class="form-group mx-sm-3 mb-2">
				<input type="text" class="form-control" id="newList" name="newList" value="<?php echo set_value('newList'); ?>" placeholder="Новый список">
			</div>
			<button type="submit" class="btn btn-primary mb-2">Создать</button>
		</form>
	</div>
</div>
