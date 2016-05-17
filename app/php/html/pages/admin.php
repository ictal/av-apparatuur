<section class='dashboard-content clearfix'>
					<section class='clearfix' ng-controller='statisticsManager as statistics' ng-init='statistics.loadStatistic()'>
						<section class='dashboard-item'>
							<section class='icon-frame bg-orange'>
								<img src='img/banknote.png'><!-- icon -->
							</section>
							<section class='content'>
								<h1 class='c-orange' >Totaal verhuurd</h1>
								<p> {{ statistics.getAmountOf( "product.rented" ); }}</p>
							</section>
						</section>
						<section class='dashboard-item'>
							<section class='icon-frame bg-blue'>
								<img src='img/quot.png'><!-- icon -->
							</section>
							<section class='content'>
								<h1 class='c-blue'>Nieuwe verzoeken</h1>
								<p> {{ statistics.getAmountOf( "reservations.new" ) }}</p>
							</section>
						</section>
						<section class='dashboard-item'>
							<section class='icon-frame bg-purple'>
								<img src='img/order.png'><!-- icon -->
							</section>
							<section class='content'>
								<h1 class='c-purple'>Reservaties</h1>
								<p> {{ statistics.getAmountOf( 'reservations' ) }}</p>
						
							</section>
						</section>
						<section class='dashboard-item'>
							<section class='icon-frame bg-indigo'>
								<img src='img/product.png'><!-- icon -->
							</section>
							<section class='content'>
								<h1 class='c-indigo'>Producten</h1>
								<p> {{ statistics.getAmountOf( "product" ) }}</p>
							</section>
						</section>
					</section>
					<section class='notifications' ng-controller='reservationManager as rm' ng-init='rm.loadReservations();' >
						<h1>Verhuurde producten <a><img src='img/icon-show-1.png'></a></h1>
						<hr ng-show="rm.confirmedReservations.lenght">
						<table >
							<tr id='head'  ng-show='rm.reservationsList'>
								<th>Id</th>
								<th>Naam</th>
								<th>Product</th>
								<th>Ophaal datum</th>
								<th>Retour datum</th>
							</tr>
							<tr ng-repeat="reservation in rm.confirmedReservations">
							
								<td>{{ reservation.user_id }}</td>
								<td>{{ reservation.user_name }}</td>
								<td>{{ reservation.product_name }}</td>
								<td>{{ reservation.date_rented }}</td>
								<td>{{ reservation.date_retour }}</td>
							</tr>
							<p ng-hide="rm.confirmedReservations.lenght" style='font-size: 13px'>geen reservaties</p>
						</table>
						
					</section>
					<section class='notifications w-50' ng-controller='reservationManager as rm' ng-init='rm.loadReservations();' >
						<h1>Verzoeken <a><img src='img/icon-hide-1.png'></a></h1>
						<hr>
						<p ng-show="rm.activeReservations" style='font-size: 13px'>geen verzoeken</p>
						<section class='users clearfix' ng-repeat='reservation in rm.activeReservations'>
							
							<section class='img-holder clearfix' ng-hide='reservation'>
								<img ng-src='img/profile{{ reservation.profile_picture }}'>
							</section>
							<section class='desc clearfix'>
								<h1>{{ reservation.user_name }} <span id='date'>{{reservation.date_rented}}</span></h1>
								<p>Heeft verzoek ingediend voor '{{ reservation.product_name}}'</p>
							</section>
							<hr>{{reservation.user_id}}
							<section class='action'>
							<hr>
								<button ng-click="rm.acceptReservation(reservation.user_id, 121571 ); ">Accepteren</button> <button ng-click='rm.acceptReservation()'>weigeren</button>
							</section>
						</section>
						
						
					<!--	<section class='users clearfix'>
							<section class='img-holder clearfix'>
								<img src='http://findicons.com/files/icons/1072/face_avatars/300/a02.png'>
							</section>
							<section class='desc clearfix'>
								<h1>Furat Dash</h1>
								<p>Heeft verzoek ingediend voor 'Canon 4s 700D'</p>
							</section>
							<hr>
							<section class='action'>
							<hr>
								<a href='?accept=true&uid=121571&pid=1'>Accepteren</a> <a href='?accept=false&uid=121571&pid=1'>Weigeren</a>
							</section>
						</section> -->
						
						
						
					</section>
					
					<section class='notifications w-50'>
						<h1>Notificaties<a href='#'><img src='img/icon-show-1.png'></a></h1>
						<section class='list '>
					<!--		<hr>
							<section class='users clearfix'>
								<section class='img-holder clearfix'>
									<img src='http://findicons.com/files/icons/1072/face_avatars/300/j01.png'>
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