
window.onload = function() {
	
	
	
	
	
	window.setTimeout(function() {
		getDoc('login').classList.add('fade-in');
	},500);
	
	
	function getDoc( name ){
		return document.getElementById( name );
	}
}

