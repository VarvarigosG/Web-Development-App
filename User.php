<?php
include('DBconnect.php');
include('functions.php');
?>
<html>

<head>
	<title>User Page</title>
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Ubuntu:700&display=swap" rel="stylesheet">
	<link type="text/css" href="https://getbootstrap.com/1.0.0/assets/css/bootstrap-1.0.0.min.css">
	<link rel="stylesheet" type="text/css" href="userScreen1.css" />
	<script src="https://cdn.anychart.com/js/8.0.1/anychart-core.min.js"></script>
	<script src="https://cdn.anychart.com/js/8.0.1/anychart-pie.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
	<title>Home</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<title>Create Dynamic Column Chart using PHP Ajax with Google Charts</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<title>Home</title>
	<meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no" />
	<script src="https://api.tiles.mapbox.com/mapbox-gl-js/v1.6.1/mapbox-gl.js"></script>
	<link href="https://api.tiles.mapbox.com/mapbox-gl-js/v1.6.1/mapbox-gl.css" rel="stylesheet" />
	<script type="text/javascript" src="js/geojson.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.debug.js"></script>
	<div align="center" class="header">
		<div class="imgcontainer">
			<img src="leaf.jpg" alt="Avatar" class="avatar">
			<div class="welcome">
				.welcome
			</div>
		</div>

	</div>
</head>

<body>
	<div class="container">
		<div align="center" class="content">
			<!-- notification message -->
			<?php if (isset($_SESSION['success'])) : ?>
				<div class="error success">
					<h3>
						<?php
						echo $_SESSION['success'];
						unset($_SESSION['success']);
						?>
					</h3>
				</div>
			<?php endif ?>
			<!-- logged in user information -->
			<div class="general_wrap">
				<div class="profinfo_wrap">
					<div class="profile_info">
						<!-- <img src="user_profile.png" height="85" width="85"> -->
						<?php if (isset($_SESSION['user'])) : ?>
							<strong>
								<h4><?php echo "Welcome, ", $_SESSION['user']['username']; ?>
									<small><i style="color: #888;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i></small>
							</strong></h4>
							<i style="color: #86CC8E;"><strong> <?php echo "Your ID is: " ?></strong>
								<?php echo $_SESSION['user']['id']; ?>
								<br>
								<button type="button" class="btn2">
									<a href="login.php?logout='1'"> Log Out! </a>
								</button>


							<?php endif ?>
					</div>
				</div>
				<div class="submit1wrap">
					<div class="submit1">
						<form id="Upform" method="post" enctype="multipart/form-data">
							<input type="file" class="inputfile" name="jfile" id="jfile">
							<button class="btn3" name="Submit" id="Submit"> Submit </button>
							<input type="reset" class="btnreset" value="Reset">
							<div id="loader-icon" style="display:none;"><img src="loader.gif" /></div>

						</form>
					</div>
					<script>
						$('#Submit').click(function() {
							if (document.getElementById("jfile").files.length != 0) {
								$('#loader-icon').show();
								var name = document.getElementById("jfile").files[0].name;
								var form_data = new FormData();
								var ext = name.split('.').pop().toLowerCase();
								if (jQuery.inArray(ext, ['json']) == -1) {
									alert("Invalid File Type");
								}
								form_data.append("jfile", document.getElementById('jfile').files[0]);
								$.ajax({
									url: 'upload.php',
									method: 'POST',
									cache: false,
									contentType: false,
									processData: false,
									data: form_data,
									success: function(data) {
										$('#loader-icon').hide();
										alert("Upload succesfull");
									}
								});
							} else {
								$("#Upform").submit(function(e) {
									e.preventDefault();
								});
							}
						});
					</script>
				</div>
			</div>
		</div>

		<div>
			<?php
			$_SESSION['var'] = $_SESSION['user']['id'];
			?>
		</div>
		<!-- SUBMIT -->

		<div class="grid-container">
			<div class="item1">
				<h4>LEADERBOARD</h4>
				<t id="leaderdata">
					<tbody id="leaders"></tbody>
				</t>
			</div>
			<div class="item2">
				<h4>Oικολογικό Σκορ</h4>
				<t id="pdata">
					<tbody id="percent"></tbody>
				</t>
			</div>
			<div class="item3">
				<h4>Περιοδος Εγγραφών</h4>
				<t id="udata">
					<tbody id="userdata"></tbody>
				</t>
			</div>
			<div class="item4">
				<h4>Τελευταία Εγγραφή</h4>
				<t id="ldata">
					<tbody id="lastrecord"></tbody>
				</t>
			</div>
			<div class="item5">
				<h4>Η Θέση Σας</h4>
				<t id="positiondata">
					<tbody id="leaders1"></tbody>
				</t>
			</div>
		</div>
		<div class="wrapper">
			<button class="btn1">
				<a type="button"> <span href="#" id="map">Απεικόνηση δραστηριότητας χρήστη σε χάρτη και σε διαγράμματα</span> </a>
			</button>
		</div>
		<!-- ------------------ SCORE GRAPH PER MONTH K------------------------>
		<div id="displays">

			<div class="scorewrap">
				<div id="chart_area" style="width: 1000px; height: 500px;">
					<canvas id="score-chart" width="1000" height="450"></canvas></div>
			</div>
			<div class="mapwrap">
				<div id="mapid"></div>
			</div>
		</div>
		<div id="chart_area1" style="width: 650px; height: 320px;"></div>
	</div>

	<script>
		function isEmpty(obj) {
			for (var prop in obj) {
				if (obj.hasOwnProperty(prop))
					return false;
			}
			return true;
		}
	</script>
	<!--------- AJAX GIA GRAPH --------->
	<script>
		$('body').ready(function() {
			var log = $('#log');
			var title;
			var urls;
			$('#score-chart').remove();
			$('#chart_area').append('<canvas id="score-chart"><canvas>');
			urls = "getUserQuery.php?QN=1";
			title = "Το Οικολογικό Σκορ Σας ανά Μήνα!";
			// AJAX REQUEST
			$.ajax({
				url: urls,
				success: function(userdata) {
					const objuser = JSON.parse(userdata);
					console.log(objuser);
					if (isEmpty(objuser)) {
						alert("Συγνώμη, δεν υπάρχουν εγγραφές για τους τελευταίους 12 μήνες.")
					} else {
						var x = [];
						var value = [];
						var colour = [];
						var mychart;
						for (var i in objuser) {
							x.push(objuser[i].M);
							switch (objuser[i].M) {
								case '1':
									x[i] = "Ιανουάριος"
									break;
								case '2':
									x[i] = "Φεβρουάριος"
									break;
								case '3':
									x[i] = "Μάρτιος"
									break;
								case '4':
									x[i] = "Απρίλιος"
									break;
								case '5':
									x[i] = "Μάιος"
									break;
								case '6':
									x[i] = "Ιούνιος"
									break;
								case '7':
									x[i] = "Ιούλιος"
									break;
								case '8':
									x[i] = "Αύγουστος"
									break;
								case '9':
									x[i] = "Σεπτέμβριος"
									break;
								case '10':
									x[i] = "Οκτώβριος"
									break;
								case '11':
									x[i] = "Νοέμβριος"
									break;
								case '12':
									x[i] = "Δεκέμβριος"
									break;
							}
							value.push(objuser[i].Y);
							var letters = '0123456789ABCDEF';
							var color = '#';
							for (let i = 0; i < 6; i++) {
								color += letters[Math.floor(Math.random() * 16)];
							}
							colour.push(color);
						}
						// CHART
						mychart = new Chart(document.getElementById("score-chart"), {
							type: 'bar',
							data: {
								labels: x,
								datasets: [{
									label: [title],
									backgroundColor: colour,
									data: value
								}]
							},
							options: {
								legend: {
									display: false
								},
								title: {
									display: true,
									text: [title]
								}
							}
						});
					}
					// ENDOFCHART
				}
			});
		});
		$('body').ready(function() {
			// AJAX REQUEST DATA DATE RANGE
			$('#userdata').remove();
			$('#udata').append('<tbody id="userdata"><tbody>');
			urls = "getUserQuery.php?QN=2";
			$.ajax({
				url: urls,
				success: function(userdata) {
					const objuser = JSON.parse(userdata);
					if (isEmpty(objuser)) {
						alert("Συγνώμη, δεν υπάρχουν εγγραφές.")
					} else {
						console.log(objuser);
						var html = "";

						html += objuser[1].F + "  -  " + objuser[0].F;
						document.getElementById("userdata").innerHTML += html;
					}
				} //success
			});
		}); //ajax
		$('body').ready(function() {
			$('#lastrecord').remove();
			$('#ldata').append('<tbody id="lastrecord"><tbody>');
			urls = "getUserQuery.php?QN=3";
			$.ajax({
				url: urls,
				success: function(userdata) {
					const objuser = JSON.parse(userdata);
					if (isEmpty(objuser)) {
						alert("Συγνώμη, δεν έχετε ανεβάσει κανένα αρχείο εγγραφών.")
					} else {
						console.log(objuser);
						var html = "";
						html += objuser[0].R;
						document.getElementById("lastrecord").innerHTML += html;
					} //success
				}
			});
		});
		$('body').ready(function() {
			// AJAX REQUEST percent
			$('#percent').remove();
			$('#pdata').append('<tbody  id="percent"><tbody>');
			urls = "getUserQuery.php?QN=4";
			$.ajax({
				url: urls,
				success: function(userdata) {
					const objuser = JSON.parse(userdata);
					if (isEmpty(objuser)) {
						alert("Συγνώμη, δεν υπάρχουν εγγραφες για να υπολογιστεί το συνολικό σας σκορ.")
					} else {
						console.log(objuser);
						var html = "";
						html += objuser[0].PERCENT + "%";
						document.getElementById("percent").innerHTML += html;
					} //success
				}
			}); //ajax
		});
		$('body').ready(function() {
			// LEADERBOARDS !
			$('#leaderdata').append('<tbody  id="leaders"><tbody>');
			urls = "getUserQuery.php?QN=5";
			$.ajax({
				url: urls,
				success: function(userdata) {
					const objuser = JSON.parse(userdata);
					console.log(objuser);
					var html = "";


					i = -1;
					for (var LEADER in objuser) {

						++i;
						html += objuser[i].row_num + "ος: " + objuser[i].LEADER + " με σκορ " + objuser[i].S + "%<br>";

					}

					document.getElementById("leaders").innerHTML += html;
					//success
				}
			}); //ajax

		});
		$('body').ready(function() {
			// thesi user !
			$('#positiondata').append('<tbody  id="leaders1"><tbody>');
			urls = "getUserQuery.php?QN=6";
			$.ajax({
				url: urls,
				success: function(userdata) {
					const objuser = JSON.parse(userdata);
					console.log(objuser);
					var html = "";
					html += "Είστε " + objuser[0].row_num + "ος στην κατάταξη με σκορ " + objuser[0].S + "%!"
					document.getElementById("leaders1").innerHTML += html;
					//success
				}
			}); //ajax

		});
	</script>

	<script>
		$('body').click(function() {
			var log = $('#log');
			if ($(event.target).is('#map')) {
				$('#chart_area').remove();
				// style="width: 1000px; height: 620px;
				$('#displays').append('<div id="chart_area">');
				$('#score-chart').remove();

				$.ajax({
					url: 'userstatsForm.php',
					success: function(html) {
						$("#chart_area").append(html);
					}
				});
				//$('#chart_area').append('<div id="mapid"></div>');
				mapboxgl.accessToken = 'pk.eyJ1Ijoib3JpZ2FudGFzIiwiYSI6ImNrNGUwM3VpajA3dXYzdG8yMnZqZDhuNGMifQ.tjLUyCqoGt2IA5dtrctG5Q';
				var map = new mapboxgl.Map({
					container: 'mapid', // container id
					style: 'mapbox://styles/mapbox/streets-v11', // stylesheet location
					center: [21.753150, 38.230462], // starting position [lng, lat]
					zoom: 13 // starting zoom
				});

				$('#chart_area').on('click', '#search', (function() {
					var year1 = document.getElementById("year1").value;
					var year2 = document.getElementById("year2").value;
					var month1 = document.getElementById("month1").value;
					var month2 = document.getElementById("month2").value;

					// ------------HEATMAP-----------------
					$.ajax({
						url: 'getUserStats.php?Q=1&val1=' + year1 + '&val2=' + year2 + '&val3=' + month1 + '&val4=' + month2,
						success: function(data) {
							const obj = JSON.parse(data);
							console.log(obj);
							var geojson = {};
							geojson['type'] = 'FeatureCollection';
							geojson['features'] = [];
							for (var i in obj) {
								var newFeature = {
									"type": "Feature",
									"geometry": {
										"type": "Point",
										"coordinates": [parseFloat(obj[i].lon), parseFloat(obj[i].lat)]
									},
									"properties": null
								}
								geojson['features'].push(newFeature);
							}
							mapboxgl.accessToken = 'pk.eyJ1Ijoib3JpZ2FudGFzIiwiYSI6ImNrNGUwM3VpajA3dXYzdG8yMnZqZDhuNGMifQ.tjLUyCqoGt2IA5dtrctG5Q';
							var map = new mapboxgl.Map({
								container: 'mapid', // container id
								style: 'mapbox://styles/mapbox/streets-v11', // stylesheet location
								center: [21.753150, 38.230462], // starting position [lng, lat]
								zoom: 13 // starting zoom
							});
							map.on('load', function() {
								map.addSource('heatmap', {
									'type': 'geojson',
									'data': geojson
								});
								map.addLayer({
									"id": "heatmap",
									"type": "heatmap",
									"source": "heatmap",
									"paint": {
										"heatmap-radius": 13,
										"heatmap-weight": {
											"stops": [
												[0, 0.5],
												[4, 2]
											]
										},
										"heatmap-intensity": 0.7,
										"heatmap-color": [
											"interpolate",
											["linear"],
											["heatmap-density"],
											0, "rgba(0, 0, 255, 0)",
											0.1, "royalblue",
											0.3, "cyan",
											0.5, "lime",
											0.7, "yellow",
											1, "rgb(178,24,43)"
										]
									}
								}, 'waterway-label');
							});

							// AJAX REQUEST
							$('#user-chart').remove();
							$('#user-chart2').remove();
							$('#user-chart1').remove();
							$('#chart_area1').append('<canvas id="user-chart" width="200" height="100"></canvas>');
							$('#chart_area1').append('<canvas id="user-chart1" width="200" height="100"></canvas>');
							$('#chart_area1').append('<canvas id="user-chart2" width="200" height="100"></canvas>');
							$("user-chart").css("left", "0px");
							$("user-chart1").css("left", "210px");
							$("user-chart2").css("left", "420px");
							$.ajax({
								url: 'getUserStats.php?Q=2&val1=' + year1 + '&val2=' + year2 + '&val3=' + month1 + '&val4=' + month2,
								success: function(userdata) {
									title = "Το Ποσοστό σας ανα Δραστηριότητα";
									const objuser = JSON.parse(userdata);
									console.log(objuser);
									var x = [];
									var value = [];
									var colour = [];
									var mychart;
									for (var i in objuser) {
										x.push(objuser[i].M);
										value.push(objuser[i].Y);
										var letters = '0123456789ABCDEF';
										var color = '#';
										for (var i = 0; i < 6; i++) {
											color += letters[Math.floor(Math.random() * 16)];
										}
										colour.push(color);
									}
									// CHART
									mychart = new Chart(document.getElementById("user-chart"), {
										type: 'bar',
										data: {
											labels: x,
											datasets: [{
												label: [title],
												backgroundColor: colour,
												data: value
											}]
										},
										options: {
											legend: {
												display: false
											},
											title: {
												display: true,
												text: [title]
											}
										}
									});
									// ENDOFCHART
									$.ajax({
										url: 'getUserStats.php?Q=3&val1=' + year1 + '&val2=' + year2 + '&val3=' + month1 + '&val4=' + month2,
										success: function(userdata) {
											title = "Η Ώρα με τις Περισσότερες Εγγραφές ανά Δραστηριότητα.";
											const objuser = JSON.parse(userdata);
											console.log(objuser);
											var x = [];
											var value = [];
											var colour = [];
											var mychart;
											for (var i in objuser) {
												x.push(objuser[i].ACT);
												value.push(objuser[i].H);
												var letters = '0123456789ABCDEF';
												var color = '#';
												for (var i = 0; i < 6; i++) {
													color += letters[Math.floor(Math.random() * 16)];
												}
												colour.push(color);
											}
											// CHART
											mychart = new Chart(document.getElementById("user-chart1"), {
												type: 'pie',
												data: {
													labels: x,
													datasets: [{
														label: [title],
														backgroundColor: colour,
														data: value
													}]
												},
												options: {
													legend: {
														display: false
													},
													title: {
														display: true,
														text: [title]
													}
												}
											});

											// ENDOFCHART

											$.ajax({
												url: 'getUserStats.php?Q=4&val1=' + year1 + '&val2=' + year2 + '&val3=' + month1 + '&val4=' + month2,
												success: function(userdata) {
													title = "Η Ημέρα με τις Περισσότερες Εγγραφές ανά Δραστηριότητα.";
													const objuser = JSON.parse(userdata);
													console.log(objuser);

													var x = [];
													var value = [];
													var colour = [];
													var mychart;
													for (var i in objuser) {
														x.push(objuser[i].ACT);
														value.push(objuser[i].D);
														var letters = '0123456789ABCDEF';
														var color = '#';
														for (var i = 0; i < 6; i++) {
															color += letters[Math.floor(Math.random() * 16)];
														}
														colour.push(color);
													}
													// CHART

													mychart = new Chart(document.getElementById("user-chart2"), {
														type: 'doughnut',
														data: {
															labels: x,
															datasets: [{
																label: [title],
																backgroundColor: colour,
																data: value
															}]
														},
														options: {
															legend: {
																display: false
															},
															title: {
																display: true,
																text: [title]
															}
														}
													});

													// ENDOFCHART
												}
											});
										}
									});

								}
							});



						}
					});
				}));





			}
		});
	</script>
	<footer class="footer">
		Tsagketas Oresths, AM 6238 |
		Varvarigos Georgios, AM 5999 |
		Georgakopoulos Georgios, AM 6014 .
	</footer>
</body>

</html>