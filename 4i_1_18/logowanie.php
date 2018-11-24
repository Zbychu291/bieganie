<html>
	<head>
		<title>Panel logowania</title>
		<meta http-equiv="Content-Type" content="type=text/html; charset=utf-8"/>
		<link rel="stylesheet" type="text/css" href="global.css"/>
		<script type="text/javascript">
			function validate(form){	
				if(form.login.value ==""){
						document.getElementById("error_log").innerHTML = "Nazwa użytkownika musi być wpisana.";
						return false;
					}
					else if(form.password.value ==""){
							document.getElementById("error_log").innerHTML = "Hasło nie może być puste.";
							return false;
						}
						return true;
				}
			
		</script>
	</head>
	<body>
	<div id="index_container">		
			<div id="container">
				<div id="menu">
					<h3>Treningi biegowe</h3>
				
					<?php 
						session_start();
						if(!isSet($_SESSION['ID'])){
					?>
					<a href="logowanie.php">Logowanie</a>
					<a href="rejestracja.php">Rejestracja</a>
					<a href="index.php">Strona główna</a>
					<?php 
						}
						else{
							?>
					<a href="wyloguj.php">Wyloguj</a>
					<a href="panel/panel_biegacza.php">Panel</a>	
					<a href="index.php">Strona główna</a>
					
							<?php
						}
					?>
				</div>
				<div id="content">
				<form id="login_form" action="logowanie.php" method="POST" onsubmit="return validate(this);"/>
					<h5>Logowanie</h5>
					<div id="error_log">
					<?php 
						if(!$connect = mysqli_connect("localhost", "root", "")){
							echo "Błąd połączenia z serwerem. <br/>";
						}
						else{
							if(!$create = mysqli_query($connect,"CREATE DATABASE IF NOT EXISTS global_base;")){
								echo "Błąd utworzenia bazy danych.<br/>";
							}
							else{
								if(!$select = mysqli_select_db($connect,"global_base")){
									echo "Błąd wyboru bazy danych.<br/>";
								}
								else{
									if(!$create = mysqli_query($connect,"CREATE TABLE IF NOT EXISTS login_data(id_biegacza int AUTO_INCREMENT NOT NULL PRIMARY KEY, login varchar(30) NOT NULL, password varchar(30) NOT NULL, mail varchar(30))")){
										echo "Błąd utworzenia bazy użytkowników.";
									}
									else{
										if(isSet($_POST['login']) && isSet($_POST['password'])){
											$login = $_POST['login'];
											$password = $_POST['password'];
											$login_search = "SELECT COUNT(*)  AS ilosc FROM login_data WHERE login='".$login."'AND password='".$password."';";
											$ilosc = mysqli_query($connect,$login_search);
											$zap_id_content = "SELECT id_biegacza FROM login_data WHERE login='".$login."' AND password='".$password."';";
											$zap_id= mysqli_query($connect,$zap_id_content);
											$id = mysqli_fetch_row($zap_id)[0];
											
											
											if(mysqli_fetch_row($ilosc)[0]>0){
												echo "<font color='green'>Zalogowano.</font><br/>";
												session_start();
												if (!isSet($_SESSION['ID'])) { // jeśli ID nie jest zarejestrowana
													$_SESSION['ID'] = $id;       // przypisz
												} 
												header("Location: panel/panel_biegacza.php");
											}
											else
												echo "Użytkownik nie odnaleziony, zarejestruj się.<br/>";

											
										}
									}
								}
							}
						}
					?>
					</div>
				<input type="text" name="login" placeholder="Nazwa użytkownika"/>
				<input type="password" name="password" placeholder="Hasło"/>
				<input type="submit" value="Zaloguj"/>
				<a href="rejestracja.php">Jeżeli nie masz jeszcze konta, kliknij tutaj.</a>
			</form>
			</div>
			</div>
		</div>
	</body>
</html>






