<div class="container regwell">
	<div class="card card-body bg-light">
		<div class="float-left">
			<h4>Cписок: <?=$list['list_name'];?></h4>
		</div>

		<div class="float-right">
			<a href="/todo">Назад</a>
		</div>
		<div>
			<ul class="list" id="listBody">
				<? if (!empty($listItems)) { ?>
					<? foreach ($listItems as $item) { ?>
						<li class="list-item"><?=$item['text']?></li>
					<? } ?>
				<? } ?>
			</ul>
		</div>
		<form class="form-inline" name="listForm"  enctype="multipart/form-data">
			<div class="form-group mx-sm-3 mb-2">
				<input type="hidden" name="requestType" class="form-control" id="requestType" value="newItem">
				<input type="hidden" name="listId" class="form-control" id="listId" value="<?=$list['id'];?>">
				<input type="text" name="itemText" class="form-control" id="itemText" placeholder="Новый пункт списка">				
			</div>			
		</form>
		<button onclick="sendListItem()" id="button" class="btn btn-primary mb-2">создать новый элемент списка</button>
	</div>
</div>
<script type="text/javascript" src="/js/main.js"></script>
