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
//modal
var modal = document.querySelector('.modal');

if(modal){
	modal.openModal = function(_element){
		var node = this;
		
		if(node.parentNode.className.indexOf('modal-view') === -1){
			node.parentNode.className += ' modal-view';
			node.className = 'modal loading';
		}

		if(_element){
			var formData = new FormData();
			var xhttp = new XMLHttpRequest();

			formData.append('element',_element);
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
			       			node.className = 'modal ' + _element;
			       			node.lastElementChild.lastElementChild.innerHTML = response.element;
			       		}else{
			       			alert(response.error ? response.error : 'There was an error, please contact us!');
			       			node.clearModal();
			       		}
					}else{
						throw 'invalid HTTP request: ' + xhttp.status + ' response';
					}
				}
			};
								  
			xhttp.open('POST',node.getAttribute('data-url'),true);
			xhttp.send(formData);
		}
	}
	modal.clearModal = function(){
		if(this.parentNode.className.indexOf('modal-view') !== -1){
			this.parentNode.className = this.parentNode.className.replace(' modal-view','');
			this.className = 'modal';

			var content = this.firstElementChild.firstElementChild;

			while(content.lastElementChild){
				content.removeChild(content.lastElementChild);
			}
		}
	};
}

var businessMap = document.querySelector('.enterprise');

if(businessMap){
	var legend = getCookie('businessLegend');

	if(!legend){
		modal.openModal('legend');
		setCookie('businessLegend',1);
	}
}

var question = document.querySelector('.question .container .row .col-12 .answer form');

if(question){
	var save = question.querySelector('fieldset input[value="Save"]');
	var discard = question.querySelector('fieldset input[value="Discard"]');

	if(save){
		save.addEventListener('click',function(){
			this.parentNode.parentNode.save()
		});
	}

	if(discard){
		discard.addEventListener('click',function(){
			this.parentNode.parentNode.discard()
		});
	}

	question.save = function(){
		this.submitForm('save');
	}
	
	question.discard = function(){
		if(modal){
			modal.openModal('discard');
		}
	}

	question.removeAnswer = function(){
		var xhttp = new XMLHttpRequest();

		xhttp.onreadystatechange = function(){
			if(xhttp.readyState == 4){
				if(xhttp.status === 200){
					try{
		        		var response = JSON.parse(xhttp.response)
		        	}catch(e){
		        		var response = xhttp.response; 
		       		}

		       		if(!response.success){
		       			alert(response.error ? response.error : 'There was an error, please try again or contact us!');
		       		}else{
		       			document.location.href = response.redirect;
		       		}
				}else{
					throw 'invalid HTTP request: ' + xhttp.status + ' response';
				}
			}
		};
							  
		xhttp.open('delete',this.getAttribute('action') + '?_token=' + this.querySelector('input[name="_token"]').value,true);
		xhttp.send();
	}

	question.submitForm = function(_element,_status){
		var formValidation = validateForm(this);

		if(formValidation){
			var formData = new FormData(this);
			var xhttp = new XMLHttpRequest();

			if(_status){
				formData.append('status',2);
			}

			modal.openModal();

			xhttp.onreadystatechange = function(){
				if(xhttp.readyState == 4){
					if(xhttp.status === 200){
						try{
			        		var response = JSON.parse(xhttp.response)
			        	}catch(e){
			        		var response = xhttp.response; 
			       		}

			       		if(!response.success){
			       			alert(response.error ? response.error : 'There was an error, please try again or contact us!');
			       		}else if(_element){
			       			modal.openModal(_element);
			       		}
					}else{
						throw 'invalid HTTP request: ' + xhttp.status + ' response';
					}
				}
			};
								  
			xhttp.open(this.getAttribute('method'),this.getAttribute('action'),true);
			xhttp.send(formData);
		}
	}
	question.addEventListener('submit',function(e){
		e.preventDefault();
		modal.openModal('submit');
		return false;
	});
}

//items
var items = document.querySelectorAll('.itemswinners .results .container .row .col-12 .item, .items .container .row .col-12 .item');
var totalItems = items.length;

if(totalItems){
	for(var x=0;x<totalItems;x++){
		var itemImg = items[x].querySelector('.item-preview img');
			
		if(itemImg){
			itemImg.parentNode.style.backgroundImage = 'url(\''+itemImg.getAttribute('src')+'\')';
		}	

		var itemTickets = items[x].querySelectorAll('.item-tickets form');
		var totalItemTickets = itemTickets.length;
		
		if(totalItemTickets){
			if(!getCookie('itemNote')){
				var note = document.querySelector('.items .container .row .col-12 .note');

				if(note){
					note.style.display = 'block';
				}
			}

			for(var y=0;y<totalItemTickets;y++){
				itemTickets[y].updateQty = function(_change){
					var form = this;
					var formData = new FormData(form);
					var xhttp = new XMLHttpRequest();

					formData.append('change',_change);

					if(modal){
						modal.openModal();
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
					       			form.firstElementChild.setAttribute('value',response.change === 1 ? parseInt(form.firstElementChild.value) + 1 : parseInt(form.firstElementChild.value) - 1);
					       		}else{
					       			alert(response.error ? response.error : 'There was an error, please try again or contact us!');
					       		}

					       		if(modal){
									modal.clearModal();
								}
							}else{
								throw 'invalid HTTP request: ' + xhttp.status + ' response';
							}
						}
					};
										  
					xhttp.open(form.getAttribute('method'),form.getAttribute('action'),true);
					xhttp.send(formData);
				};
				
				var arrows = itemTickets[y].parentNode.querySelectorAll('i');
				var totalArrows = arrows.length;

				for(var y=0;y<totalArrows;y++){
					arrows[y].addEventListener('click',function(){
						var change = this.parentNode.lastElementChild === this ? 1 : -1;
						
						this.parentNode.updateQty(change);
					});
				}
			}
		}
	}
}