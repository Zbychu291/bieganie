<html>
	<head>
		<title>Panel rejestracji</title>
		<meta http-equiv="Content-Type" content="type=text/html; charset=utf-8"/>
		<link rel="stylesheet" type="text/css" href="global.css"/>
		<script type="text/javascript">
			function validate(form){
				if(form.mail.value == ""){
					document.getElementById("error_log").innerHTML = "Pole e-mail musi być uzupełnione.";
					return false;
				}
				else if(form.mail.value.indexOf('@') < 0){
					document.getElementById("error_log").innerHTML = "Pole e-mail musi zawierać @, np. jankowalski@poczta.pl";
					return false;
				}
				else if(form.login.value == ""){
					document.getElementById("error_log").innerHTML = "Nazwa użytkownika musi być wpisana.";
					return false;
				}
				else if(form.password.value == ""){
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
			<form id="login_form" action="rejestracja.php" method="POST" onsubmit="return validate(this);"/>
				<h5>Rejestracja</h5>
				<!-- Maksymalnie 48 znaków w error_log -->
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
									if(isSet($_POST['login']) && isSet($_POST['password']) && isSet($_POST['mail'])){
										$login = $_POST['login'];
										$password = $_POST['password'];
										$mail = $_POST['mail'];
										$login_search = "SELECT COUNT(*)  AS ilosc FROM login_data WHERE login='".$login."'AND password='".$password."';";
										$ilosc = mysqli_query($connect,$login_search);
									
										 if(mysqli_fetch_row($ilosc)[0]>0){
											echo "Takie konto już istnieje zmień wartości.<br/>";
										}
										else{
											$wstaw = "INSERT INTO `login_data` (`id_biegacza`, `login`, `password`, `mail`) VALUES (NULL,'".$login."', '".$password."', '".$mail."');";
											if(!$wstaw_query = mysqli_query($connect,$wstaw))
												echo "ERROR.";
											else{
												echo "<font color='green'>Zarejestrowano.</font>";
												
												header("Location: logowanie.php"); 
											}
										}
									}
								}
							}
						}
					}
				?></div>
				<input type="text" name="mail" placeholder="Adres e-mail"/>
				<input type="text" name="login" placeholder="Nazwa użytkownika"/>
				<input type="password" name="password" placeholder="Hasło"/>
				<input type="submit" value="Zarejestruj"/>
				<a href="logowanie.php">Jeżeli masz już konto, kliknij tutaj.</a>
			</form>
			</div></div>
		</div>
	</body>
</html>






