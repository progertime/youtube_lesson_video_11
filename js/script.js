document.addEventListener('DOMContentLoaded', function(){
	const form = document.querySelector('.js--ajax-form')

	form.addEventListener('submit', function(e){
		e.preventDefault()


		var ob_form_mess = form.querySelector('.form__message')
		let ob_mess_list = form.querySelectorAll('.form__field-message')
		let ob_field_list = form.querySelectorAll('.form__field')

		// clear data
		for(let i=0; i < ob_mess_list.length; i++){
			ob_mess_list[i].innerHTML = '';
		}

		ob_form_mess.innerHTML = '';

		for(let i=0; i < ob_field_list.length; i++){
			ob_field_list[i].addEventListener("focusin", function(){
				if(this.parentElement){
					this.parentElement.classList.remove('form__field_error');
					if(this.parentElement.querySelector('.form__field-message')){
						this.parentElement.querySelector('.form__field-message').innerHTML = '';
					}
				}
			});
		}

		const XHR = new XMLHttpRequest();

		const FD = new FormData(form);

		// if successful load
		XHR.addEventListener( "load", function(event) {

			let response = JSON.parse(event.target.responseText);
			
			if(response.status == 'Y'){
				ob_form_mess.innerHTML = createMessageItemBox(response.message, 'success');
				form.reset();
			}else if(response.errors){
				var error_message = '';
				for(var key in response.errors) {

					let ob_field_parent = form.querySelector('[data-field="FIELDS__'+key+'"]');
					let ob_field_message = form.querySelector('[data-field-message="FIELDS__'+key+'"]');
					let ob_field = form.querySelector('[name="FIELDS['+key+']"]');

					if(response.mode_out_errors == 'every-field'){
						error_message = createMessageItemBox(response.errors[key]['text'], 'error');
						ob_field_message.innerHTML = error_message;
					}else{
						error_message += createMessageItemBox(response.errors[key]['text'], 'error');
					}

					if(response.hasOwnProperty('add_error_class') && response.add_error_class == 'Y'){
						ob_field_parent.classList.add('form__field_error');
					}
				}
				if(response.mode_out_errors != 'every-field') {
					ob_form_mess.innerHTML = error_message;
				}
			}
		});

		// if we have load error
		XHR.addEventListener( "error", function( event ) {
			alert( 'Oops! Something went wrong.' );
		} );

		// Set up our request
		XHR.open( "POST", "" );

		// The data sent is what the user provided in the form
		XHR.send( FD );
	})

})


function createMessageItemBox(message, status){
	if(!message) return message;
	var statuses = {
		'success' : 'form__message-item_success',
		'error' : 'form__message-item_error',
	};
	if(!status) status = 'error';

	return '<div class="form__message-item '+statuses[status]+'">'+message+'</div>';
}