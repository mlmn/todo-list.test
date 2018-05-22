var listBody = document.querySelector('#listBody');
//var listBody = document.getElementById("#listBody");

function sendListItem() {
	// 1. Создаём новый объект XMLHttpRequest
	var xhr = new XMLHttpRequest();

	//var body = 'name=' + encodeURIComponent(listItem);
	var formData = new FormData(document.forms.listForm);

	xhr.open('POST', '', true);
	xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
	// 3. Отсылаем запрос
	xhr.send(formData);

	xhr.onreadystatechange = function() { // (3)
		if (xhr.readyState != 4) return;

		if (xhr.status != 200) {
			alert(xhr.status + ': ' + xhr.statusText);
		} else {

			var responce = JSON.parse(xhr.responseText)
			console.log(responce);
			//foreach (responce.listItems as )
			var bodyHtml = ''; 
			responce.items.forEach(function(item, i, arr) {
				//alert(i);
				bodyHtml += '<li class="list-item">' + item.text + '</li>';
			});
			document.querySelector('#itemText').value = '';
			listBody.innerHTML = bodyHtml;
			console.log(listBody);
			button.disabled = false;
		}

	}
	button.disabled = true;
}