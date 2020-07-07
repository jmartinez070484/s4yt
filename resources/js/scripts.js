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
var items = document.querySelectorAll('.items .container .row .col-12 .item .item-tickets form, .account .container .row .col-12:last-child .cart-items .item .item-tickets form');
var totalItems = items.length;

if(totalItems){
		if(!getCookie('itemNote')){
		var note = document.querySelector('.items .container .row .col-12 .note');

		if(note){
			note.style.display = 'block';
		}
	}

	for(var x=0;x<totalItems;x++){
		items[x].updateQty = function(_change){
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
		
		var arrows = items[x].parentNode.querySelectorAll('i');
		var totalArrows = arrows.length;

		for(var y=0;y<totalArrows;y++){
			arrows[y].addEventListener('click',function(){
				var change = this.parentNode.lastElementChild === this ? 1 : -1;
				
				this.parentNode.updateQty(change);
			});
		}
	}
}