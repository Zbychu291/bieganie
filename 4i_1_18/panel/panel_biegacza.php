<html>
	<head>
		<title>Panel biegacza</title>
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
					<p id="panel_title">Panel biegacza</p>
					<div id="panel_menu">
						<a href="lista.php">Lista treningów</a>
						<a href="dodawanie.php">Dodaj trening</a>
						<a href="podsumowanie.php">Podsumowanie</a>
					</div>
				</div>
			</div>
			<div id="nickname">
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






