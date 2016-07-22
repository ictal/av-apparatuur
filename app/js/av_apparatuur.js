(function() {
  var app = angular.module('av_apparatuur', []);

	app.controller('activeUser', function(){
		this.profile_picture = null;
		this.display_name = null
		this.student_nummber = null;
	});
	
	//maniging the statistics
	app.controller('statisticsManager', function($http){
		
		this.statistics = [];
		
		this.processData = function( JSONResponce ){
			var data = JSONResponce.data;
			this.statistics = data;
		}
		
		this.loadStatistic = function() {
			var that = this;;
			$http({
			  method: 'GET',
			  url: 'api.php/?q=statistic',
			  headers: {
				'Content-type': 'application/json'
			  }
			}).then(function successCallback(response) {
				that.processData(response);
				console.log( response );
			}, function errorCallback(response) {
				console.log(response);
			});
		}
		
		this.getAmountOf = function( item ){
			
			return this.statistics[item];
			
		}

	});
	//handle all the reservation
	app.controller('reservationManager', function( $http, $scope, $httpParamSerializerJQLike ){
		
		this.reservation_resquest = [];
		this.confirmed_reservations= [];
		
		this.showSerialForm = false;
		this.serialsList = [];
		this.selectedProducts = [];
		this.reservationId = 0;
		
		this.saveReservation = function(){
			if( this.validateReservation() ){
				var that = this;
				$http({
					method: 'POST',
					url: 'api.php/?q=updateReservation',
					data: $httpParamSerializerJQLike( { 'reservation_id' : that.reservationId, 'selectedProducts' : that.selectedProducts } ),
					headers: {'Content-Type': 'application/x-www-form-urlencoded'}
				}).then(function successCallback(response) {
					that.loadData();
					that.showSerialForm = false;
				}, function errorCallback(response) {
					console.log(response);
				});
			}
		}
		
		this.displayReservation = function( id ){
			console.log( id );
		}
		
		this.closePopup = function() {
			this.showSerialForm = false;
		}
		this.hasReservations = function() {
			if(this.confirmed_reservations){
				return this.confirmed_reservations.length <= 0;
			}
		}
		
		this.validateReservation = function() {
			var l = this.selectedProducts.length;
			var temp_array = [];
			for( var i = 0; i < l; i++ ){
				console.log( temp_array );
				
				var serial = this.selectedProducts[i].serial;
				
				if( temp_array.contains( 'undefined' ) || temp_array.contains( serial ) ){
					alert("U heeft 1 serialnummber bij meerderen apparaten geselecteerd Of u heeft een apparaat leeg gelaten.");
					return false;
				}
				
				temp_array.add( serial );
				

			}
			return true;
		}
		
		this.acceptReservation = function( reservationId ){
			this.loadProductSerial( reservationId );
		}
		this.deleteReservation = function( reservationId ){
			that = this;
			$http({
				method: 'POST',
				url: 'api.php/?q=deleteReservation',
				data: $httpParamSerializerJQLike( { 'reservation_id' : reservationId } ),
				headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			}).then(function successCallback(response) {
				that.loadData();
				alert('reservatie verwijdert');
			}, function errorCallback(response) {
				console.log(response);
			});
		}
		
		this.loadProductSerial = function ( reservationId ) {
			var that = this;
			
			$http({
				method: 'POST',
				url: 'api.php/?q=loadSerials',
				data: $httpParamSerializerJQLike( { 'reservation_id' : reservationId } ),
				headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			}).then(function successCallback(response) {
				that.processData( response, 'serial' );
				that.showSerialForm = true;
			}, function errorCallback(response) {
				console.log(response);
			});
			
			
		}
		
		this.processData  = function ( JSONResponce, TYPE ){
			var data = JSONResponce.data;
			
			switch( TYPE ){
				case 'serial':
					this.selectedProducts = data.slected_products;
					this.serialsList = data.serialList;
					this.reservationId = data.reservationId;
					break;
				case 'reservations':
					this.reservation_resquest = data.active_reservations;
					this.confirmed_reservations = data.confirmed_reservations;
					break;
			}
			
		}
		this.loadData = function() {
			var that = this;
			$http({
			  method: 'GET',
			  url: 'api.php/?q=reservations',
			  headers: {
				'Content-type': 'application/json'
			  }
			}).then(function successCallback(response) {
				that.processData(response , 'reservations' );
			}, function errorCallback(response) {
				console.log(response);
			});
			
		}
	});
	
	//Handle all the notifications.
	app.controller('notificationManager', function(){
		
	
	});
	
	app.controller("productManager", function($http, $httpParamSerializerJQLike){
		this.products = [];
		this.productAmount = 0;
		this.selectedProducts = [];
		this.selectedSerials = [];
		this.showEdit = false;
		this.showAdd = false;
		this.editAbleProduct;
		this.alert = false;
		this.aantal = 1;
		this.aantallen = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50];
		
		this.processData = function( JSONResponce ){
			var data = JSONResponce.data;
			this.products = data;
			this.productAmount = data.length;
		}
		
		this.selectAll = function(e)
		{
			var products = this.products;
			var list = this.selectedProducts;
			var length = products.length;
			for(var i = 0; i < length; i++)
			{
				
				if(!list.contains( products[ i ].id) && e.originalTarget.checked){
					list.add( products[ i ].id );
					document.getElementById( products[ i ].id ).checked = true;
				}else if( e.originalTarget.checked == false && list.contains( products[ i].id)){
					list.remove( products[ i].id );
					document.getElementById( products[ i ].id ).checked = false;
				}
			
			}
			
			
		}
		this.addToList = function( productId )
		{
			var list = this.selectedProducts;
			
			if( list.contains( productId ) )
			{
				list.remove( productId );
				this.showEdit = false;
			}
			else
			{
				if( this.showEdit)
					this.showEdit = false;
				list.add( productId );
			}
			
			//update selectedProducts
			this.selectedProducts = list;
			console.log( this.selectedProducts );
		}
		
		this.addSerialToList = function( id ){
			var list = this.selectedSerials;
			
			if( list.contains( id ) )
			{
				list.remove( id );
			}
			else
			{
				list.add( id );
			}
			
			//update selectedProducts
			this.selectedSerials = list;
			console.log( this.selectedSerials );
		}
		
		//look at line 412
		this.getselectedProduct = function( arg ){
			
			var products = this.products;
			var length = products.length;

			for(var i = 0; i < length; i++)
			{
			
				if( products[ i ].id == this.selectedProducts )
				{
					this.editAbleProduct = products[ i ];
				}
			
			}
			if(this.editAbleProduct)
			{
				
				return this.editAbleProduct[arg];
			}
			else
				return arg;
		}
		
		this.addSerial = function() {
			var l = this.editAbleProduct.serials.length;
			var id = new Date().valueOf();

			var serial = { 'id': 'NEW_' + id , 'serial' : ''};
			
			this.editAbleProduct.serials.add( serial );
		}
		
		this.removeSerials = function(){

			var keptSerials = [];
			
			for( var i  = 0; i <= this.selectedSerials.length; i++ ){

				//console.log( this.selectedSerials[ i ] );

				for( var _i = 0; _i < this.editAbleProduct.serials.length; _i++ ){

					console.log( this.editAbleProduct.serials[ _i ]['id'] );

					if( this.editAbleProduct.serials[ _i ]['id'] == this.selectedSerials[ i ] ) {
						var id = this.selectedSerials[ i ].split('_');

						//console.log( this );
						if(id[0] == 'NEW'){
							this.selectedSerials.splice( i, 1 );
							this.editAbleProduct.serials.splice( _i, 1 );
						}else{
							//uncheck
							document.getElementById( id.join('_') ).checked = false;
							this.selectedSerials.splice( i, 1 );
							this.editAbleProduct.serials[ _i ]['removed'] = true;
						}
					}


				}

				if(this.selectedSerials.length != 0 && i == this.selectedSerials) i = 0;

			}
		}
		
		this.hideAdd = function(){
			this.showAdd = false;
		}
		
		this.closeEdit = function () {
			this.showEdit = false;
		}
		
		this.editProduct = function(){
			if( this.selectedProducts.length != 1)
				alert( 'Je hebt geen of the veel producten geselecteerd. MAX toegestaan  is 1.');
			else{
				this.loadSerials( this.getselectedProduct('id') );
				this.showEdit = true;
			}
		}
		
		this.addProduct = function() {
			this.showAdd = true;
			this.aantal = 1;
		}
		
		this.NewArray = function( size ){
			var data = [];
			var length = size;

			for(var i = 1; i < length + 1; i++) {
				data.push( i );
			}
			return data;
		}
		
		this.popup = function()
		{
			if(this.selectedProducts.length != 0)
				this.alert = true;
			else
				alert( 'u heeft geen producten geselecteerd.' );
		}
		this.deleteProduct = function(){
			if(this.selectedProducts.length == 0)
				return false;
			var that = this;
			
			var data = {
				products : this.selectedProducts
			}
			
			$http({
				method: 'POST',
				url: 'api.php/?q=deleteProducts',
				data: $httpParamSerializerJQLike(data), 
				headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			}).then(function successCallback(response) {
				that.dismiss();
				that.loadProducts();
				that.selectedProducts = [];
			}, function errorCallback(response) {
				console.log(response);
			});
			
		}
		
		this.dismiss = function(){
			document.getElementById('popup1').classList.remove('scroll-up');
			this.alert = false;
		}
		
		this.updateProduct = function()
		{
			var that = this;
			$http({
				method: 'POST',
				url: 'api.php/?q=updateProduct',
				data: $httpParamSerializerJQLike(that.editAbleProduct), 
				headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			}).then(function successCallback(response) {

				that.showEdit = false;
			}, function errorCallback(response) {
				console.log(response);
			});
		}
		this.saveEditProduct = function() {
			var that = this;
			$http({
				method: 'POST',
				url: 'api.php/?q=saveEditProduct',
				data: $httpParamSerializerJQLike( that.editAbleProduct ), 
				headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			}).then(function successCallback(response) {

				that.showEdit = false;
			}, function errorCallback(response) {
				console.log(response);
			});
			
		}
		this.loadProducts = function(){
			var that = this;
			$http({
			  method: 'GET',
			  url: 'api.php/?q=loadProducts',
			  headers: {
				'Content-type': 'application/json'
			  }
			}).then(function successCallback(response) {
				that.processData(response);
				console.log( response );
			}, function errorCallback(response) {
				console.log(response);
			});
		}
		
		this.loadSerials = function( id ){
			var that = this;
			$http({
				method: 'POST',
				url: 'api.php/?q=loadProductSerial',
				data: $httpParamSerializerJQLike({'product_id' : id}), 
				headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			}).then(function successCallback(response) {
				that.editAbleProduct.serials = response.data;
			}, function errorCallback(response) {
				console.log(response);
			});
		}
		
	});
	
	
	app.controller("userManager", function($http, $httpParamSerializerJQLike){
		
		this.users = [];
		this.userAmount = this.users.length;
		this.showEdit = false;
		this.selectedUsers = [];
		this.editAbleUser;
		
		this.selectAll = function(e)
		{
			var users = this.users;
			var list = this.selectedUsers;
			var length = users.length;
			for(var i = 0; i < length; i++)
			{
				if(!list.contains( users[ i ].id) && e.originalTarget.checked){
					list.add( users[ i].id );
					document.getElementById( users[ i ].id ).checked = true;
				}else if( e.originalTarget.checked == false && list.contains( users[ i].id)){
					list.remove( users[ i].id );
					document.getElementById( users[ i ].id ).checked = false;
				}
			
			}
			
			
		}
		
		this.addToList = function( userId )
		{
			var list = this.selectedUsers;
			
			if( list.contains( userId) )
			{
				list.remove( userId);
				this.showEdit = false;
			}
			else
			{
				if( this.showEdit)
					this.showEdit = false;
				list.add( userId );
			}
			
			//update selectedProducts
			this.selectedUsers = list;
		}
		
		this.updateUser = function()
		{
			var that = this;
			$http({
				method: 'POST',
				url: 'api.php/?q=updateUser',
				data: $httpParamSerializerJQLike(that.editAbleUser), 
				headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			}).then(function successCallback(response) {

				that.showEdit = false;
			}, function errorCallback(response) {
				console.log(response);
			});
		}
		
		//returns selected users data example. getSelectedUser( name ) return name of user.
		this.getselectedUser = function( arg ){
			
			var users = this.users;
			var length = users.length;
		
			for(var i = 0; i < length; i++)
			{
			
				if( users[ i ].id == this.selectedUsers )
				{
					this.editAbleUser = users[ i ];
				}
			
			}
			if(this.editAbleUser)
			{
				
				return this.editAbleUser[arg];
			}
			else
				return arg;
		}
		
		this.editUser = function(){
			if( this.selectedUsers.length != 1 )
				alert( 'Je hebt geen of the veel gebruikers geselecteerd. MAX toegestaan  is 1.');
			else
				this.showEdit = true;
		}
		this.closeEdit = function () {
			this.showEdit = false;
		}
		this.delete = function(){
			if( this.selectedUsers.length != 1 ){ 
				alert( 'Je hebt geen of the veel gebruikers geselecteerd. MAX toegestaan  is 1.');
				return;
			}
			
			var id = this.getselectedUser( 'id' );
			var that = this;
			$http({
				method: 'POST',
				url: 'api.php/?q=deleteUser',
				data: $httpParamSerializerJQLike( {'id': id} ), 
				headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			}).then(function successCallback(response) {
				that.loadUsers();
				this.selectedUsers = null;
			}, function errorCallback(response) {
				console.log(response);
			});
			
			
		}
		
		this.processData = function( JSONResponce ){
			var data = JSONResponce.data;
			this.users = data;
		}
		
		this.loadUsers = function(){
			var that = this;
			this.products;
			$http({
			  method: 'GET',
			  url: 'api.php/?q=users',
			  headers: {
				'Content-type': 'application/json'
			  }
			}).then(function successCallback(response) {
				
				that.processData(response);

			}, function errorCallback(response) {
	
			});
		}
	});
	

})();

	Array.prototype.add = function(value) {
		if(!this.contains(value)){
			this.push(value);
			return true;
		}
		return false
	}
	
	Array.prototype.remove = function(value) {
		var val = this.indexOf( value );
		if(this.contains( value ))
		{
			this.splice(val, 1);
		}
	}	
	
	Array.prototype.contains = function( obj ) {
		var i = this.length;
		while (i--) {
			if (this[i] === obj) {
				return true;
			}
		}
	return false;
	}
function wait(ms){
   var start = new Date().getTime();
   var end = start;
   while(end < start + ms) {
     end = new Date().getTime();
  }
}

String.prototype.contains = function(it) { return this.indexOf(it) != -1; };