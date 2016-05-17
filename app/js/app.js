(function(){

  var app = angular.module('av_apparatuur', []);
  
	app.controller('userProductActivityControler', function($http){
		this.activity = [];
		this.history  = [];
		
		this.loadData = function( JSONResponce){
			//console.log("[ RESERVATIONS ] : " , JSONResponce);
			var data = JSONResponce.data;
			
			this.activity = data['activity'];
			this.history = data['history'];
			
		}
		
		this.loadActivity = function (){
			var that = this;
			$http({
				
				url : 'api.php?q=userHistory',
				dataType: 'Json',
				method: 'GET',
				headers: {
					"Content-Type": "application/json"
				}
				
			}).then(function mySucces(response) {
				
				that.loadData( response );
				
			}, function myError(response)
			{	
				//console.log( response );
	
			});
			//console.log('Loaded');
		}
	});
	
	app.controller('productRentingControler', function($http, $httpParamSerializerJQLike ){
		
		this.rent_date;
		this.retour_date;
		
		this.products = [];
		this.product_amount = [];
		this.orderList = [];
		this.selectedProduct = null;
		
		this.showDate = true
		//this.showGif = false;
		this.showProducts = false;
		
		this.popup = {
			
			show : false,
			heading: 'null',
			message: 'null',
			type : null,
			action : null,
			close : function() {
				this.show = false;
			},
		}
		
		this.sendRequest = function(){
			if( this.orderList.length > 0 ){
				var that = this;
				
				var request = this.prepareRequest();
				
				$http({
					method: 'POST',
					url: 'api.php/?q=save',
					data: $httpParamSerializerJQLike({ 'orderList' : request }), //WTF...
					headers: {'Content-Type': 'application/x-www-form-urlencoded'}
				})
				
				this.displayPopup( 'Uw verzoek is verzonden.', 'U kunt weer een product lenen na een goedkeuring', 1);
				this.reset();
			}
			
		}
		
		this.makeArray = function( name )
		{
			var amount = this.product_amount[name];
			var temp_array = [];
			for( var i = 1; i < amount + 1; i++){
				temp_array.push( i );
			}
			return temp_array;
		}
		
		this.prepareRequest = function(){
			var date = [{
				rent_date : this.rent_date,
				retour_date : this.retour_date,
			}];
			
			var request = date.concat( this.orderList );
			
			return request;
		}
		
		this.reset = function(){
			this.showProducts = false;
			this.showDate = true;
			this.rent_date = null;
			this.retour_date = null;
			this.orderList = [];
			this.product = [];
			$('#datepicker_from').val('');
			$('#datepicker_to').val('');
		}
		
		this.addToBasket = function( item, $event ){
				this.stopPropagation( $event );
			if( this.orderList.contains( item) ){
				
				this.orderList[ item ] = item;
				
			}else{
				
				this.orderList.push( item );
				
			}
			
			this.selectedProduct = null;
		}
		
		this.inBasket = function( item ){
			return ( this.orderList.contains( item ) );
		}
		
		this.deSelectProduct = function( item, $event ){
			
			this.stopPropagation( $event );
			
			if( this.orderList.contains( item ) ){
				this.orderList.splice(item, 1);
				this.selectedProduct = null;
				console.log( item );
			}
			
		}
		
		this.selectProduct = function( item ) {
		
			if( this.selectedProduct == item.id ){
				this.selectedProduct = null;
				item.selected = false;
				
			}else if ( this.orderList.contains( item ) ){
				return;
			}else{
				this.selectedProduct = item.id;
				item.selected = true;
				
			}
			
			console.log( item.id, this.selectedProduct );
			
		}
		
		this.displayNoProducts = function() {
			this.displayPopup( 'Geen producten', 'Momenteel zinn er geen producten aanwezig', 1);
			this.reset();
		}
		
		this.getProducts = function() {
			
			if( validDate( $('#datepicker_from'), $('#datepicker_to') ) ){
				
				this.showDate = false;
				//this.showGif = true;
				this.rent_date = $('#datepicker_from').val();
				this.retour_date = $('#datepicker_to').val();
	
				this.loadProducts();
				
			}else {
				this.displayPopup( 'Alert', 'Het opgegeven datums zijn onjuist.', 0 );
			}

		}
		
		this.processData = function( JSONResponce ){
			var data = JSONResponce.data;		
			this.products = data.products;
			this.product_amount = data.amount;
			if( data.products.length > 0)
				this.displayProducts();
			else
				this.displayNoProducts();
		}
		
		this.displayProducts = function(){
			//this.showGif = false;
			this.showProducts = true;
		} 
		
		this.loadProducts = function(){
			var that = this;
			
			var request = {
				
				date_one : $('#datepicker_from').val(),
				date_two : $('#datepicker_to').val(),
				
			}
			
			$http({
				method: 'POST',
				url: 'api.php/?q=loadProductsForUsers',
				data: $httpParamSerializerJQLike(request), //WTF...
				headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			}).then(function successCallback(response) {
				that.processData(response);
			}, function errorCallback(response) {
				console.log(response);
			});
		}
		
		this.init = function() {
			
			$('#datepicker_from').datepicker();
			$('#datepicker_to').datepicker();
			
		}
		
		this.displayPopup = function( head, message, type ) {
			
			this.popup.heading = head;
			this.popup.message = message;
			this.popup.type = type;
			this.popup.show = true;
		}
		
		this.stopPropagation = function( $event ){
			$event.stopPropagation();
		}
		
	});
	
	function validDate( one, two ){
		console.log( one );
		if( validDateString ( one.val() ) && validDateString( two.val() ) ){
			
			var one = one.data('datepicker').date;
			var two = two.data('datepicker').date;
			var now = new Date();
			now.setHours(0,0,0,0);
			
			if( (one >= now ) && two > now && two > one ){
				return true;

			}else {
				return false;
			}
			
		}else{
			
			return false;
		}
		
	}
	
	function validDateString( StringDate ){
		var comp = StringDate.split('-');
		var m = parseInt(comp[1], 10);
		var d = parseInt(comp[2], 10);
		var y = parseInt(comp[0], 10);
		var date = new Date(y,m-1,d);
		if (date.getFullYear() == y && date.getMonth() + 1 == m && date.getDate() == d) {
			return true;
		} else {
			return false;
		}
		
	}
  

	Array.prototype.contains = function(obj) {
		var i = this.length;
		while (i--) {
			if (this[i] === obj) {
				return true;
			}
		}
		return false;
	}

})();