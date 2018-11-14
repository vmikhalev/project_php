function in1(){
	var a = document.getElementById('inbox');
	var b = document.getElementById('outbox');

	a.style.height = 'auto';
	b.style.height = '0';
}

function out1(){
	var a = document.getElementById('inbox');
	var b = document.getElementById('outbox');

	b.style.height = 'auto';
	a.style.height = '0px';
	a.style.overflow = 'hidden';
}