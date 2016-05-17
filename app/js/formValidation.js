var error = new Array();

window.onload = function(){
	
	var Elements = document.forms[0].elements;
	var form = new Form (Elements);
	var size = Elements.length;
	
	for(var i = 0; i < size; i++ ){
		
		var validateType = Elements[i].attributes['av-validate'];
		var name = Elements[i].attributes['name'];
		console.log(validateType, name);
		
		if(validateType){
			switch(validateType.value){
				
				case 'string':
					var regex = /^[a-zA-Z]+$/
					form.addListner(Elements[i], regex);
				break;
				case 'int':
					var regex = /^[0-9]{0,10}$/;
					form.addListner(Elements[i], regex);
				break;
			}
		}
	}
	
	
	window.setTimeout(function() {
		getDoc('login').classList.add('fade-in');
	},500);
	
	
	function getDoc( name ){
		return document.getElementById( name );
	}
};
console.log('document loaded');
function Form (elements) {

	this.elements = elements;
	this.size = elements.length;
	
	
	/* get Element by id in the form element */
	this.getElementsById = function(arg){
		for(var i = 0; i < this.Elements.length; i++){
			if(this.Elements[i].attributes['id'].value.equals(arg))
				return(this.Elements[i]);
		}
	}
	
	this.addListner = function( element, regex){
		var fm = this; // fm stands for the class form.
		
		element.addEventListener('change', function(event){
			fm.validateElement(this, regex);
						
		});
	}
	
	this.regex = function( value, regex){
		return regex.test(value);
	}
	
	this.validateElement = function(el, regex){
		
		if(el.name.value = 'tsn-voegsel' && el.value.length == 0 )
		{
			return;
		}
		
		if(this.regex( el.value, regex )){
			el.classList.remove('error');
		}else{
			el.classList.add('error');
		}
	}

}