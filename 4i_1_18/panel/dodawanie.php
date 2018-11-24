<html>
	<head>
		<title>Dodawanie treningu</title>
		<meta http-equiv="Content-Type" content="type=text/html; charset=utf-8"/>
		<link rel="stylesheet" type="text/css" href="../global.css"/>
		<script type="text/javascript">
			function validate(form){
				//miejsce, data_d, data_r, czas_h, czas_m, czas_s, dystans
				if(form.miejsce.value == ""){
					document.getElementById("error_log").innerHTML = "Pole miejsce musi być uzupełnione.";
					return false;
				}
					else if(form.data_d.value ==""){
						document.getElementById("error_log").innerHTML = "Dzień miesiąca musi być wpisany.";
						return false;
					}
						else if(form.data_r.value ==""){
						document.getElementById("error_log").innerHTML = "Rok musi być wpisany.";
						return false;
						}
							else if((form.data_r.value).length != 4 ){
							document.getElementById("error_log").innerHTML = "Rok musi mieć 4 cyfry.";	
							return false;
							}
								else if(form.czas_h.value ==""){
								document.getElementById("error_log").innerHTML = "Ilość godzin musi być wpisana.";
								return false;
								}
									else if(form.czas_m.value ==""){
									document.getElementById("error_log").innerHTML = "Ilość minut musi być wpisana.";
									return false;
									}
										else if(form.czas_s.value ==""){
										document.getElementById("error_log").innerHTML = "Ilość sekund musi być wpisana.";
										return false;
										}
											else if(form.dystans.value ==""){
											document.getElementById("error_log").innerHTML = "Dystans musi być wpisany.";
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
					<a href="wyloguj.php">Wyloguj</a>
					<a href="panel_biegacza.php">Panel</a>
					<a href="../index.php">Strona główna</a>
				</div>
				<div id="content">
					<div id="dodawanie_box">
						<span id="dodawanie_title">Nowy trening</span>
						<div id="error_log">
						<?php 
							session_start();
							if(!isSet($_SESSION['ID'])){
								echo "<br/>Nie jesteś zalogowany<br/>";
							}
							else{
								if(isSet($_POST['miejsce'])){
									$miejsce = $_POST['miejsce'];
									$dzien = $_POST['data_d'];
									$miesiac = $_POST['data_m'];
									$rok = $_POST['data_r'];
									$czas = $_POST['czas_s'] + $_POST['czas_m']*60 + $_POST['czas_h']*60*60;
									$dystans = $_POST['dystans']*$_POST['jednostka'];
									if(!$connect = mysqli_connect("localhost", "root", "")){
										echo "Błąd połączenia z serwerem. <br/>";
									}
									else{
										if(!$select = mysqli_select_db($connect,"global_base")){
											echo "Błąd wyboru bazy danych.<br/>";
										}
										else{
											
											$zap_content = "INSERT INTO `treningi` (`id`, `miejsce`, `dzien`, `miesiac`, `rok`, `czas`, `dystans`, `id_biegacza`) VALUES (NULL, '".$miejsce."', '".$dzien."', '".$miesiac."', '".$rok."', '".$czas."', '".$dystans."', '".$_SESSION['ID']."');";
											if(!$zap = mysqli_query($connect,$zap_content)){
												echo "Błąd dodawania treningu.";
											}
											else{
												header("Location: lista.php");
											}
										}
									}
								}
						?></div>
						<form id="nowy_trening" action="dodawanie.php" method="POST" onsubmit="return validate(this);">
							Miejsce treningu:<input type="text" name="miejsce" maxlength=30/><br/>
							Data:
							<input type="text" name="data_d" placeholder="dd" style="width: 40px;" maxlength=2 />.
							<select name="data_m" form="nowy_trening" style="width: 50px; height: 35px; text-align: center; border:0; outline: 1px solid black;">
								<option value="1">sty</option>
								<option value="2">lut</option>
								<option value="3">mar</option>
								<option value="4">kwi</option>
								<option value="5">maj</option>
								<option value="6">cze</option>
								<option value="7">lip</option>
								<option value="8">sie</option>
								<option value="9">wrz</option>
								<option value="10">paź</option>
								<option value="11">lis</option>
								<option value="12">gru</option>
							</select>
							
							<input type="text" name="data_r" placeholder="rrrr" style="width: 50px;"maxlength=4 />r.<br/>
							Czas treningu: <input type="text" name="czas_h" placeholder="hh" style="width: 35px;" maxlength=2 />:
							<input type="text" name="czas_m" placeholder="mm" style="width: 35px;" maxlength=2/>:
							<input type="text" name="czas_s" placeholder="ss" style="width: 35px;" maxlength=2/><br/>
							Dystans:<input type="text" name="dystans"  style="width: 40px;" maxlength=3/>
							<select name="jednostka" form="nowy_trening" style="border:0; outline: 1px solid black;">
								<option value="1000">km</option>
								<option value="1">m</option>
							</select>
							<hr>
							<input type="submit" value="Dodaj trening"/>
						</form>
					</div>
					<?php 
							}
					?>
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






