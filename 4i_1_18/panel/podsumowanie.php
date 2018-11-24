<html>
	<head>
		<title>Podsumowanie treningów</title>
		<meta http-equiv="Content-Type" content="type=text/html; charset=utf-8"/>
		<link rel="stylesheet" type="text/css" href="../global.css"/>
	</head>
	<body>
		<div id="index_container">		
			<div id="container">
				<div id="menu">
					<h3>Treningi biegowe</h3>
					<a href="wyloguj.php">Wyloguj</a>
					<a href="panel_biegacza.php">Panel</a>
					<a href="../index.php">Strona główna</a>
					
				</div>
				<div id="content">
					<?php
					session_start();
							if(!isSet($_SESSION['ID'])){
								echo "<br/>Nie jesteś zalogowany<br/>";
							}
							else{
								$id_biegacza = $_SESSION['ID'];
					?>
						<h5>Podsumowanie treningów</h5>
					<div id="podsumowanie_content">
					<?php 
								if(!$connect = mysqli_connect("localhost", "root", "")){
									echo "Błąd połączenia z serwerem. <br/>";
								}
								else{
									if(!$select = mysqli_select_db($connect,"global_base")){
										echo "Błąd wyboru bazy danych.<br/>";
									}
									else{
										$zap_content="SELECT COUNT(*) FROM treningi WHERE id_biegacza='".$_SESSION['ID']."';";
										if(!$zap = mysqli_query($connect,$zap_content)){
											echo "Błąd sprawdzenia treningów.<br/>";
										}
										else{
											if(mysqli_fetch_row($zap)[0] == 0){
												echo "<span id='lista_error'>Brak treningów.</span>";
											}
											else{
												$zap_content = "SELECT SUM(dystans) FROM treningi WHERE id_biegacza='$id_biegacza'";
												if(!$zap = mysqli_query($connect,$zap_content))
													echo "Błąd zapytania o łączny dystans.<br/>";
												$dystans = mysqli_fetch_row($zap)[0] / 1000;
												
												echo "<b>Dystans łączny:</b> ";
												echo round($dystans,2);
												echo " km<br/>";
												
												
												$zap_content = "SELECT czas,dystans FROM treningi WHERE id_biegacza='$id_biegacza'";
												if(!$zap = mysqli_query($connect,$zap_content))
													echo "Błąd zapytania o średni czas na km";
												$suma_dyst = 0;
												$suma_czas = 0;
												$ilosc =0;
												while($x = mysqli_fetch_row($zap)){
													$ilosc++;
													$suma_dyst += $x[1];
													$suma_czas += $x[0];
												}
												$oblicz = ($suma_czas*1000)/$suma_dyst; //czas na 1km
												
												$czas_na_km = round($oblicz,0);
												$godziny = $czas_na_km/3600;
												$minuty = $czas_na_km/60%60;
												$sekundy = $czas_na_km%60;
												settype($godziny, 'integer');
												settype($minuty, 'integer');
												settype($sekundy, 'integer');
												if($minuty<10) $minuty="0".$minuty;
												if($sekundy<10) $sekundy="0".$sekundy;
												echo "<b>Średni czas przebycia 1 km:</b> ".$godziny.":".$minuty.":".$sekundy."<br/>";
												
												
												
												$oblicz = ($suma_czas*1000*10)/$suma_dyst; //czas na 10km
												$czas_na_km = round($oblicz,0);
												$godziny = $czas_na_km/3600;
												$minuty = $czas_na_km/60%60;
												$sekundy = $czas_na_km%60;
												settype($godziny, 'integer');
												settype($minuty, 'integer');
												settype($sekundy, 'integer');
												if($minuty<10) $minuty="0".$minuty;
												if($sekundy<10) $sekundy="0".$sekundy;
												echo "<b>Średni czas przebycia 10 km:</b> ".$godziny.":".$minuty.":".$sekundy."<br/>";
												
												//V = S/t, V = x m/s; 
												echo"<b>Średnia prędkość: </b>";
												$ilosc = 0;
												$predkosc_suma = 0;
												
												//$zap_content = "SELECT czas,dystans FROM treningi WHERE id_biegacza='$id_biegacza'";
												if(!$zap = mysqli_query($connect,$zap_content))
													echo "Błąd zapytania o średnia predkosc";
												while($y = mysqli_fetch_row($zap)){
													$droga = $y[1];
													$czas = $y[0];
													$predkosc_suma += $y[1]/$y[0];
													$ilosc++;
												}
												$srednia = $predkosc_suma / $ilosc;
												$srednia2 = $srednia * 3.6;
												echo round($srednia,2)." m/s,  ".round($srednia2,2)." km/h<br/>";
											}
										}
									}
								}
							}
					?></div>
					<img src="../images/running_guy.gif"/>
				</div>
			</div>
			<div id="nickname">
				<?php 
						if(!isSet($_SESSION['ID'])){
							echo "NIE JESTEŚ ZALOGOWANY";
						}
						else{
							if(!$connect = mysqli_connect("localhost", "root", "")){
								echo "Błąd połączenia z serwerem. <br/>";
							}
							else{
								if(!$select = mysqli_select_db($connect,"global_base")){
									echo "Błąd wyboru bazy danych.<br/>";
								}
								else{
									$zap_content = "SELECT login FROM login_data WHERE id_biegacza='".$_SESSION['ID']."';";
									if(!$zap = mysqli_query($connect,$zap_content))
										echo "Błąd sprawdzenia nazwy użytkownika.";
									echo "Zalogowany jako: ".mysqli_fetch_row($zap)[0];
								}
							}
						}
				?>
			</div>
		</div>
	</body>
</html>