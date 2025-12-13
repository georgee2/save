
const serviceBtns = document.querySelectorAll('.delete-service');

if(serviceBtns.length > 0){

	serviceBtns.forEach((btn) => {
		btn.addEventListener('click' , function(){
			document.querySelector('#' + this.dataset.target).remove();
			document.querySelector('.modal-backdrop').remove();
		});
	});

}