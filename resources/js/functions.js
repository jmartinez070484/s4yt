function sendWelcomeEmail(_node){
	_node.value = 'Sending...';

	var formData = new FormData();
	var xhttp = new XMLHttpRequest();

	formData.append('_token',document.querySelector('meta[name="csrf-token"]').content);

	xhttp.onreadystatechange = function(){
		if(xhttp.readyState == 4){
			if(xhttp.status === 200){
				try{
	        		var response = JSON.parse(xhttp.response)
	        	}catch(e){
	        		var response = xhttp.response; 
	       		}

	       		console.log(response);
	       		_node.value = 'Send Welcome Email';
			}else{
				throw 'invalid HTTP request: ' + xhttp.status + ' response';
			}
		}
	};
						  
	xhttp.open('POST',document.location.pathname + '/email',true);
	xhttp.send(formData);

	return false;
}

function answerWinner(_node){
	if(modal){
		var data = _node.parentNode.parentNode.parentNode.getAttribute('data-scholarships');

		try{
			data = JSON.parse(data);
		}catch(e){
			data =[];
		}

		var totalData = data.length;

		if(totalData){
			modal.openModal();

			var title = document.createElement('strong');
			var select = document.createElement('select');
			var button = document.createElement('button');

			for(var x=0;x<totalData;x++){
				var option = document.createElement('option');

				option.setAttribute('value',data[x].id);
				option.innerText = data[x].name + ' - $' + data[x].amount;

				if(data[x].user_id){
					option.setAttribute('disabled',true);
				}
				
				select.appendChild(option);
			}

			button.addEventListener('click',function(){
				var value = this.previousElementSibling.value;

				if(value){
					var confirmDelete = confirm('Are you sure you want to select this answer as the winner?');

					if(confirmDelete){
						var secondConfirm = confirm('Once the winner is selected, this cannot be un-done, are you sure?');

						if(secondConfirm){
							var formData = new FormData();
							var xhttp = new XMLHttpRequest();

							formData.append('scholarship',value);
							formData.append('_token',document.querySelector('meta[name="csrf-token"]').content);

							xhttp.onreadystatechange = function(){
								if(xhttp.readyState == 4){
									if(xhttp.status === 200){
										try{
							        		var response = JSON.parse(xhttp.response)
							        	}catch(e){
							        		var response = xhttp.response; 
							       		}

							       		if(response.success){
							       			location.reload();
							       		}else{
							       			var error = response.error ? response.error : 'There was an error, please contact us!';
							       			alert(error);
							       		}
									}else{
										throw 'invalid HTTP request: ' + xhttp.status + ' response';
									}
								}
							};
												  
							xhttp.open('POST',document.location.pathname + '/winner',true);
							xhttp.send(formData);
						}
					}
				}else{
					alert('Please select a scholarship to award');
				}
			});

			button.innerText = 'Award';
			modal.className = 'modal scholarships';
			title.innerText = 'Select Schlarship to Award';
			modal.lastElementChild.lastElementChild.appendChild(title);
			modal.lastElementChild.lastElementChild.appendChild(select);
			modal.lastElementChild.lastElementChild.appendChild(button);
		}
	}

	return false;
}

/*function answerWinner(_node){
	var confirmDelete = confirm('Are you sure you want to select this answer as the winner?');

	if(confirmDelete){
		var secondConfirm = confirm('Once the winner is selected, this cannot be un-done, are you sure?');

		if(secondConfirm){
			_node.innerText = 'Please wait...';

			var xhttp = new XMLHttpRequest();
			var formData = new FormData();

			formData.append('_token',document.querySelector('meta[name="csrf-token"]').content);
			
			xhttp.onreadystatechange = function(){
				if(xhttp.readyState == 4){
					if(xhttp.status === 200){
						try{
			        		var response = JSON.parse(xhttp.response)
			        	}catch(e){
			        		var response = xhttp.response; 
			       		}

			       		if(response.success){
			       			location.reload();
			       		}else{
			       			var error = response.error ? response.error : 'There was an error, please contact us!';
			       			alert(error);
			       		}
					}else{
						alert('Invalid request - ' + xhttp.status);
						
						throw 'invalid HTTP request: ' + xhttp.status + ' response';
					}
				}
			};
								  
			xhttp.open('POST',_node.getAttribute('href') + '/winner',true);
			xhttp.send(formData);
		}
	}

	return false;
}*/

function itemWinners(_node){
	var confirmDelete = confirm('Are you sure you want to automatically generate winners for all items?');

	if(confirmDelete){
		var secondConfirm = confirm('Once winners are selected, this cannot be un-done, are you sure?');

		if(secondConfirm){
			var items = _node.parentNode.parentNode.querySelector('.items');

			if(items){
				_node.innerText = 'Please wait...';

				if(!items.generateWinner){
					items.generateWinner = function(_index){
						var thisNode = this;
						var list = thisNode.list[_index];
						var id = parseInt(list.firstElementChild.innerText);
						
						if(id){
							var xhttp = new XMLHttpRequest();
							var formData = new FormData();

							formData.append('id',id);
							formData.append('_token',document.querySelector('meta[name="csrf-token"]').content);
							
							xhttp.onreadystatechange = function(){
								if(xhttp.readyState == 4){
									if(xhttp.status === 200){
										try{
							        		var response = JSON.parse(xhttp.response)
							        	}catch(e){
							        		var response = xhttp.response; 
							       		}

							       		var current = thisNode.currentItem;
							       		var total = thisNode.list.length;

							       		if(current + 1 < total){
							       			thisNode.currentItem = current + 1;
							       			thisNode.generateWinner(thisNode.currentItem);
							       		}else{
							       			location.reload();
							       		}
									}else{
										alert('Invalid request - ' + xhttp.status);
										
										throw 'invalid HTTP request: ' + xhttp.status + ' response';
									}
								}
							};
												  
							xhttp.open('POST',window.location.pathname + '/' + id + '/winner',true);
							xhttp.send(formData);
						}
					}
				}

				var itemLists = items.querySelectorAll('.items ul');
				var totalItems = itemLists.length;
				
				if(totalItems){
					items.list = itemLists;
					items.currentItem = 0;
					items.generateWinner(items.currentItem);
				}
			}
		}
	}

	return false;
}

function setPasswords(_node){
	_node.parentNode.children[2].required = _node.checked ? true : false;
	_node.parentNode.children[3].required = _node.checked ? true : false;
}

function filePreview(_node){
	if(_node.files && _node.files[0]){
    	var reader = new FileReader();
    
    	reader.onload = function(e) {
      		_node.nextElementSibling.style.background = 'url(\'' + e.target.result + '\') no-repeat center center/contain #efefef';
   		}
    
    	reader.readAsDataURL(_node.files[0]);
  	}
}

function addTicket(_node){
	var confirmDelete = confirm('Are you sure you want to add a ticket to this user?');

	if(confirmDelete){
		var token = document.querySelector('meta[name="csrf-token"]').content;
		var xhttp = new XMLHttpRequest();

		xhttp.onreadystatechange = function(){
			if(xhttp.readyState == 4){
				if(xhttp.status === 200){
					try{
		        		var response = JSON.parse(xhttp.response)
		        	}catch(e){
		        		var response = xhttp.response; 
		       		}

		       		if(response.success){
		       			setTimeout(function(){
		       				location.reload();
		       			},250);
		       		}else{
		       			var error = response.error ? response.error : 'There was an error, please try again!';

		       			alert(error);
		       		}
				}else{
					alert('Invalid request - ' + xhttp.status);
					
					throw 'invalid HTTP request: ' + xhttp.status + ' response';
				}
			}
		};
							  
		xhttp.open('POST',_node.getAttribute('href')+'?_token='+token,true);
		xhttp.send();
	}

	return false;
}

function deleteRecord(_node){
	var confirmDelete = confirm('Are you sure you want to delete this record?');

	if(confirmDelete){
		var confirmMessage = _node.getAttribute('data-message');
		var secondConfirm = confirmMessage ? confirm(confirmMessage) : confirm('Upon deleting, all data associated with this record will be lost');

		if(secondConfirm){
			var token = document.querySelector('meta[name="csrf-token"]').content;
			var xhttp = new XMLHttpRequest();

			xhttp.onreadystatechange = function(){
				if(xhttp.readyState == 4){
					if(xhttp.status === 200){
						try{
			        		var response = JSON.parse(xhttp.response)
			        	}catch(e){
			        		var response = xhttp.response; 
			       		}

			       		if(response.success){
			       			setTimeout(function(){
			       				location.reload();
			       			},250);
			       		}else{
			       			var error = response.error ? response.error : 'There was an error, please try again!';

			       			alert(error);
			       		}
					}else{
						alert('Invalid request - ' + xhttp.status);
						
						throw 'invalid HTTP request: ' + xhttp.status + ' response';
					}
				}
			};
								  
			xhttp.open('DELETE',_node.getAttribute('href')+'?_token='+token,true);
			xhttp.send();
		}
	}

	return false;
}

function removeNote(_node){
	_node.parentNode.style.display = 'none';

	setCookie('itemNote',1);
}

function submitForm(_form){
	var validForm = validateForm(_form);

	if(validForm){
		var button = _form.querySelector('button');
		var formData = new FormData(_form);
		var xhttp = new XMLHttpRequest();

		if(button){
			button.style.opacity = 0.5;
			button.disabled = true;
		}

		xhttp.onreadystatechange = function(){
			if(xhttp.readyState == 4){
				if(xhttp.status === 200){
					try{
		        		var response = JSON.parse(xhttp.response)
		        	}catch(e){
		        		var response = xhttp.response; 
		       		}

		       		if(response.success){
		       			if(response.redirect){
		       				document.location.href = response.redirect;
		       			}else{
		       				button.innerText = 'Thank you!';
		       			}
		       		}else{
		       			var error = response.error ? response.error : 'There was an error, please try again!';

		       			alert(error);

		       			button.removeAttribute('style');
						button.removeAttribute('disabled');
		       		}
				}else{
					throw 'invalid HTTP request: ' + xhttp.status + ' response';
				}
			}
		};
							  
		xhttp.open(_form.getAttribute('method'),_form.getAttribute('action'),true);
		xhttp.send(formData);
	}

	return false;
}

function validateForm(_form){
	var fields = _form.querySelectorAll('input[type="text"], input[type="email"], input[type="date"], input[type="file"], input[type="hidden"], input[type="number"], input[type="password"], select, textarea');
	var totalFields = fields.length;
	var validForm = true;

	if(totalFields){
		for(var x=0;x<totalFields;x++){
			var fieldValidity = fields[x].validity.valid;
			
			fields[x].className = !fieldValidity ? fields[x].className = ' invalid' : fields[x].className.replace(' invalid','');

			if(!fieldValidity && validForm){
				validForm = !validForm;
			}
		}
	}

	return validForm;
}

function getCookie(cname){
	var name = cname + '=';
  	var decodedCookie = decodeURIComponent(document.cookie);
  	var ca = decodedCookie.split(';');
  	
  	for(var i = 0; i <ca.length; i++) {
    	var c = ca[i];
    	
    	while (c.charAt(0) == ' '){
      		c = c.substring(1);
    	}
    	
    	if(c.indexOf(name) == 0){
      		return c.substring(name.length,c.length);
    	}
  	}
  
  	return '';
}

function setCookie(cname,cvalue,exdays){
	var d = new Date();
  	
  	d.setTime(d.getTime() + (exdays*24*60*60*1000));
  	
  	var expires = 'expires='+ d.toUTCString();
  
  	document.cookie = cname + '=' + cvalue + ';' + expires + ';path=/';
}