<html>
	<head>
		<title>Strona główna</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link rel="stylesheet" href="global.css"/>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script type="text/javascript">
			var activeIndex = 1;
			var anchory= [];

			$(document).ready(function() { 
				anchory = $('a[href^="#"]').map(function() {
					return this.href.includes('#') ? '#' + this.href.split('#')[1] : this.href;
				}).get();

				$('a[href^="#"]').on('click', function(event) {
					const target = $( $(this).attr('href') );

					if( target.length ) {
						event.preventDefault();
						if(activeIndex==1){
							activeIndex--;
						}
						else{
							activeIndex++;
						}
						$('html, body').animate({
							scrollTop: target.offset().top
						}, 1000);
					}
				});

				$(window).bind('mousewheel', function(event) {
					event.preventDefault();
					if (event.originalEvent.wheelDelta >= 0) {
						if(activeIndex >= anchory.length-1) {
							return;
						}
						if(activeIndex<=2)
						activeIndex++;
					} else {
						if(activeIndex <= 0) {
							return;
						}
						if(activeIndex>=1){
							activeIndex--;
						}
					}
					const target = $(anchory[activeIndex]);
							
					if( target.length ) {
						$('html, body').animate({
							scrollTop: target.offset().top
						}, 1000);
					}
				});
			});
						
						
		</script>
	</head>
	<body>
		<div id="main">
			<div id="main_text">
				Kiedy biegniesz po ziemi <br/>i biegniesz razem z ziemią,<br/> możesz biec bez końca.
				<p>Christopher McDougall &bdquo;Urodzeni biegacze&rdquo;</p>
			</div>
					
		</div>
		
		<a class="arrow" href="#index_container"></a>
		
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
					<a href="panel/wyloguj.php">Wyloguj</a>
					<a href="panel/panel_biegacza.php">Panel</a>	
					<a href="index.php">Strona główna</a>
					
							<?php
						}
					?>
				</div>
				<div id="content">
					&nbsp;&nbsp;Na okładce naszej strony widnieje p. Kwaczor, przedstawia on początkującego biegacza.
					<br/>&nbsp;&nbsp;Treningi biegowe bowiem zaczynają się od szybkiego marszu. <br/>&nbsp;&nbsp;Zbyt szybkie tempo na początku,
					może doprowadzić do kontuzji lub innych temu podobnych.
				</div>
			
			</div>
			
		</div>
		<a class="arrow2" href="#main"></a>
		
	</body>
</html>