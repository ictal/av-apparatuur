<section class='dashboard-content clearfix'>
					<section class='clearfix' ng-controller='statisticsManager as statistics' ng-init='statistics.loadStatistic()'>
						<section class='dashboard-item'>
							<section class='icon-frame bg-orange'>
								<img src='img/banknote.png'><!-- icon -->
							</section>
							<section class='content'>
								<h1 class='c-orange' >Totaal verhuurd</h1>
								<p> {{ statistics.getAmountOf( "rentedProducts" ) }}</p>
							</section>
						</section>
						<section class='dashboard-item'>
							<section class='icon-frame bg-blue'>
								<img src='img/quot.png'><!-- icon -->
							</section>
							<section class='content'>
								<h1 class='c-blue'>Nieuwe verzoeken</h1>
								<p> {{ statistics.getAmountOf( "newReservations" ) }}</p>
							</section>
						</section>
						<section class='dashboard-item'>
							<section class='icon-frame bg-purple'>
								<img src='img/order.png'><!-- icon -->
							</section>
							<section class='content'>
								<h1 class='c-purple'>Reservaties</h1>
								<p> {{ statistics.getAmountOf( 'reservationsList' ) }}</p>
						
							</section>
						</section>
						<section class='dashboard-item'>
							<section class='icon-frame bg-indigo'>
								<img src='img/product.png'><!-- icon -->
							</section>
							<section class='content'>
								<h1 class='c-indigo'>Producten</h1>
								<p> {{ statistics.getAmountOf( "productsList" ) }}</p>
							</section>
						</section>
					</section>
					
					<section class='notifications' ng-controller='reservationManager as rm' ng-init='rm.loadData()'>
						<h1>Verhuurde producten <a><img src='img/icon-show-1.png'></a></h1>
						<hr>
						<table >
							<tr id='head' ng-hide='rm.hasReservations()' >
								<th>Id</th>
								<th>Naam</th>
								<th>Product</th>
								<th>Aantal</th>
								<th>Ophaal datum</th>
								<th>Retour datum</th>
								<th>Info</th>
							</tr>
							<tr ng-repeat='reservation in rm.confirmed_reservations'>
							
								<td> {{ $index }} </td>
								<td> {{ reservation.username }} </td>
								<td> {{ reservation.product }} </td>
								<td> {{ reservation.product_amount}} </td>
								<td> {{ reservation.date_rented }} </td>
								<td> {{ reservation.date_retour }} </td>
								<td> <a href='' ng-click='rm.displayReservation( reservation.id )' ><img src='img/icon-i.png' width='12px'></a>
								
								
							</tr>
							<p style='font-size: 13px' ng-show='rm.hasReservations()'>geen reservaties</p>
						</table>
					</section>
					<section class='notifications w-50' ng-controller='reservationManager as rm' ng-init='rm.loadData()'>
						<h1>Verzoeken <a><img src='img/icon-hide-1.png'></a></h1>
						<hr>
						<section class='users clearfix' ng-repeat='reservation in rm.reservation_resquest' >
							<section class='img-holder clearfix'>
								<img ng-src='img/profile/{{ reservation.user_img }}'>
							</section>
							<section class='desc clearfix'>
								<h1><span id='date'>{{ reservation.date_rented }}</span></h1>
								<p>{{ reservation.user_name +' '}} heeft een verzoek ingediend voor {{ reservation.product_amount +" "}} {{ reservation.product_name }} </p>
							</section>
							<hr>
							<section class='action'>
							<hr>
							
								<button ng-click='rm.acceptReservation( reservation.id )'>Accepteren</button> <button ng-click='rm.deleteReservation( reservation.id )' >weigeren</button>
							</section>
						</section>
						<section class='popup form-reservation ' ng-show='rm.showSerialForm'>
							<section class='popup-body clearfix'>
								<h1 style='font-size: 17px'>Ashna wiar Reservatie<button class='btn-x' ng-click='rm.closePopup()'>X</button></h1>
								<hr>
								<section class='product_container'>
								<table>
								
									<tr class='product' ng-repeat='product in rm.selectedProducts'>
										<td><img ng-src='assets/{{ product.img }}' width='75px'></td>
										<td>{{ product.name }}</td>
										<td><select ng-model='product.serial' ng-options="key.id as key.value for key in rm.serialsList[{{ product.productId }}]" >
										</select></td>
									</tr>
								</table>
								</section>
								<button class='btn btn-default pull-right' ng-click='rm.saveReservation()'>Opslaan</button>
							</section>
						</section>
						
						
						
					</section>
					
					<section class='notifications w-50'>
						<h1>Notificaties<a href='#'><img src='img/icon-show-1.png'></a></h1>
						<section class='list '>
					<!--		<hr>
							<section class='users clearfix'>
								<section class='img-holder clearfix' >
									<img src='http://findicons.com/files/icons/1072/face_avatars/300/j01.png' >
								</section>
								<section class='desc clearfix'>
									<h1>Marvin Loninghing <a><img src='img/icon-x-1.png'></a></h1>
									<p>Moet zijn 'Canon 4s 700D' Vandaag ingeleverd. </p>
								</section>
								<hr>
							</section>
						
							<section class='users clearfix'>
								<section class='img-holder clearfix'>
									<img src='http://findicons.com/files/icons/1072/face_avatars/300/a01.png'>
								</section>
								<section class='desc clearfix'>
									<h1>Jerry Beij <a href='?notifi=remove?ui=0'><img src='img/icon-x-1.png'></a><img src='img/icon-alert-2.png'></h1>
									<p>Is te laat met inleveren van zijn 'Canon 4s 700D'. </p>
								</section>
								<hr>
							</section>
							<section class='users clearfix'>
								<section class='img-holder clearfix'>
									<img src='http://www.iconarchive.com/download/i59027/hopstarter/superhero-avatar/Avengers-Nick-Fury.ico'>
								</section>
								<section class='desc clearfix'>
									<h1>Reda Tis  <a><img src='img/icon-x-1.png'></a><img src='img/icon-alert-2.png'></h1>
									<p>Heeft Zijn geleende 'Canon 4s 700D' opgegeten.</p>
								</section>
								<hr>
							
							</section>
							<section class='users clearfix'>
								<section class='img-holder clearfix'>
									<img src='http://findicons.com/files/icons/1072/face_avatars/300/a02.png'>
								</section>
								<section class='desc clearfix'>
									<h1>Sergen <a><img src='img/icon-x-1.png'></a><img src='img/icon-alert-2.png'></h1>
									<p>Heeft zijn 'Canon 4s 700D' gepikt.</p>
								</section>
								<hr>
							</section>
						</section>  -->
					</section>
					
				</section>