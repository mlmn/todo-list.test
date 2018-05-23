<div class="container regwell">
	<div class="card card-body bg-light">
		<div class="row">
			<div class="col-md-11">
				<h4>Cписок: <?=$list['list_name'];?></h4>
			</div>
			<div class="col-md-1 float-right">
				<a href="/todo">Назад</a>
			</div>

		</div>

		<div>
			<ul class="list-body" id="listBody">
			</ul>
		</div>
		
		<div class="row">
			<div class="col-md-10">
				<form class="form" name="listForm"  enctype="multipart/form-data">
					<div class="form-group">
						<input type="hidden" name="requestType" class="form-control" id="requestType" value="newItem">
						<input type="hidden" name="listId" class="form-control" id="listId" value="<?=$list['id'];?>">
						<input type="text" name="itemText" class="form-control" id="itemText" placeholder="Новый пункт списка">				
					</div>			
				</form>
			</div>
			<div class="col-md-2">
				<button onclick="sendListItem('listForm')" id="button" class="btn btn-primary mb-2">Добавить пункт</button>
			</div>
		</div>
	
	</div>
</div>
<script type="text/javascript" src="/js/main.js"></script>
