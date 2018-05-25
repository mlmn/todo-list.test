var listBody = document.querySelector('#listBody');
//var listBody = document.getElementById("#listBody");
sendListItem('listForm');

function sendListItem(itemid) {
	// 1. Создаём новый объект XMLHttpRequest
	var xhr = new XMLHttpRequest();

	//var body = 'name=' + encodeURIComponent(listItem);
	//console.log(document.forms);
	var formData = new FormData(document.forms[itemid]);
	//console.log(formData);
	xhr.open('POST', '/todo/ajax', true);
	xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
	// 3. Отсылаем запрос
	xhr.send(formData);

	xhr.onreadystatechange = function() { // (3)
		if (xhr.readyState != 4) return;

		if (xhr.status != 200) {
			//alert(xhr.status + ': ' + xhr.statusText);
		} else {

			//alert(xhr.responseText);

			var responce = JSON.parse(xhr.responseText);
			//console.log(responce);
			var bodyHtml = ''; 
			responce.items.forEach(function(item, i, arr) {
				bodyHtml += '<li class="list-item" id="itemid' + item.id + '">';
				if (item.image_name != '') {
					bodyHtml += '<div class="item-image-container"><a href="/uploads/' + item.image_name + item.image_ext +'" target="_blank">'+
						'<img class="item-image" src="/uploads/' + item.image_name + item.image_ext +'">' +
						'</a></div>';
				}

				bodyHtml +=	'<div class="item-body-container"><div class="item-text-container">' + 
					'<span id="textid' + item.id + '" class="item-text" onclick="editListItem(' + item.list_id +',' + item.id + ')">' + item.text + '</span></div>';
				
				if (item.item_tags != null) {
					tagsArr = item.item_tags.split(",");
					bodyHtml +=	'<div class="item-tags-container"><span class="item-tags">';
					tagsArr.forEach(function(tagItem, j, tegarr) {
						bodyHtml += '<a href="/todo/list/' + item.list_id + '?tag=' + tagItem + '">' + tagItem + '</a> ';
					});

					bodyHtml += '</span></div>';
				}

				bodyHtml += '</div></li><hr>';
			});
			document.querySelector('#itemText').value = '';
			listBody.innerHTML = bodyHtml;
			//console.log(listBody);
			button.disabled = false;
		}

	}

	button.disabled = true;
}

function editListItem(listid, itemid) {
	var itemBody = document.querySelector('#itemid' + itemid);
	var itemText = document.querySelector('#textid' + itemid);
	console.log(itemText);
		//у этой формы есть дубликат во вьюхе('listItems'), нужно избавиться.
		var itemEdit =  '<div class="row">' +
							'<div class="col-md-10">' +
								'<form name="formItem'+ itemid + '"><div class="form-group">' +
									'<input type="hidden" name="requestType" class="form-control" id="requestType" value="updateItem">' +
									'<input type="hidden" name="itemId" class="form-control" value="' + itemid + '">' +
									'<input type="hidden" name="listId" class="form-control" value="' + listid + '">' +
									
									'<div class="form-group">' +
										'<input type="text" name="itemText" class="form-control" value="' + itemText.innerText + '">' +
									'</div>' +
									'<div class="form-group">' +
										'<input type="text" name="itemTags" class="form-control form-control-sm" placeholder="добавить теги(через пробел)">' +
									'</div>' +
									'<input type="file" name="fileUpload" class="form-control-file" >' +
								'</div></form>' +
							'</div>' +
							'<div class="col-md-2">' +
								'<button onclick="sendListItem(\'formItem'+ itemid + '\')" id="button" class="btn btn-primary mb-2">сохранить</button>' +
							'</div>' +
						'</div>';
	
	itemBody.innerHTML = itemEdit;
	//console.log(document.forms);
}