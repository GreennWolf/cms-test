window.onerror = null;

function revisaSource() {

	var s = document.getElementById('source');
	var w = document.getElementById('save');
	
	s.style.display =	'';
	s.focus();
	w.style.display	=	'none';
	
	tinyMCE.get('source').show();
	
	return false;
}
