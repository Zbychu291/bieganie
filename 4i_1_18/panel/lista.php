<html>
	<head>
		<title>Lista treningów</title>
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
					<span id="lista_title">Lista twoich treningów<br/></span>
					<?php 
					session_start();
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
								if(!$create = mysqli_query($connect,"CREATE TABLE IF NOT EXISTS treningi(id int AUTO_INCREMENT NOT NULL PRIMARY KEY, miejsce varchar(30) NOT NULL, dzien varchar(2) NOT NULL, miesiac varchar(2) NOT NULL, rok varchar(4) NOT NULL, czas varchar(10) NOT NULL, dystans varchar(10) NOT NULL, id_biegacza int NOT NULL)")){
									echo "Błąd utworzenia bazy użytkowników.";
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
											$zap_content = "SELECT * FROM treningi WHERE id_biegacza='".$_SESSION['ID']."';";
											if(!$zap = mysqli_query($connect,$zap_content)){
												echo "Błąd pobrania treningów.<br/>";
											}
											else{
												echo "<table id='lista'> <tr><th>Lp.</th><th>Miejsce</th><th>Data</th><th>Czas</th><th>Dystans</th></tr>";
												$lp = 1;
												while($x = mysqli_fetch_row($zap)){
													echo "<tr><td>$lp.</td><td>$x[1]</td><td>$x[2].";
													if($x['3']<10) $x['3'] = "0".$x['3'];
													echo $x['3'];
													echo".$x[4]r.</td><td>";
													$czas = round($x[5]);
													$godziny = $czas/3600;
													$minuty = $czas/60%60;
													$sekundy = $czas%60;
													settype($godziny, 'integer');
													settype($minuty, 'integer');
													settype($sekundy, 'integer');
													if($minuty<10) $minuty="0".$minuty;
													if($sekundy<10) $sekundy = "0".$sekundy;
													echo $godziny.":".$minuty.":".$sekundy;
													echo "</td><td>";
													$dystans = $x['6']/1000;
													echo round($dystans,2)." km";
													echo "</td></tr>";
													$lp++;
												}
												echo "</table>";
											}
										}
									}
								}
							}
						}
					}
					?>
					<a id="a_lista" href="dodawanie.php">Dodaj trening</a>
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






