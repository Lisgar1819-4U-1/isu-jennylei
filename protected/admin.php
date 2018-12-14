<!DOCTYPE html>

<html>
	<head>
		<title>Lisgar Announcements</title>

		<link rel="stylesheet" type="text/css" href="../style.css">
		<link rel="stylesheet" type="text/css" href="../media-query.css">
	</head>
	<body>
		<?php include '../setup.php'?>

		<div class="color-strip"></div>

		<div class="header" id="header">
			<h1>Lisgar Announcements</h1>

			<div class="float-right">
				<p class="header-btn create" id="create" onclick="location.href='create.php'">Create</p>
				<!-- <p class="header-btn settings" id="settings">Settings</p> -->
				<a class="header-btn log-out" id="log-out" onclick="/logout">Log out</a>
			</div>
		</div>

		<div class="main-container">
			<?php include '../sidebar.php'?>

			<?php include '../main-content.php'?>
		</div>

		<div class="overlay" id="overlay"></div>
		<div class="expandable no-padding" id="expandable"></div>

		<div class="settings-container form-container" id="settings-container">
			<div class="float-left half flex">
				<h1>SETTINGS</h1>
			</div>
			<div class="float-left half flex">
				<fieldset>
					<legend>Settings</legend>

				</fieldset>
			</div>
		</div>

		<script src="../jquery-3.3.1.js"></script>
		<script src="../app.js"></script>
		<script type="text/javascript">
			//Detect the current browser type.
			var isIE = false || !!document.documentMode;
			var isEdge = !isIE && !!window.StyleMedia;
			if(navigator.userAgent.indexOf("Chrome") != -1 && !isEdge)
			{
				var isChrome = true;
			}
			else if(navigator.userAgent.indexOf("Safari") != -1 && !isEdge)
			{
				var isSafari = true;
			}
			else if(navigator.userAgent.indexOf("Firefox") != -1 ) 
			{
				var isFirefox = true;
			}
			else 
			{
				var isOthers = true;
			}

			function logout() {
				// alert("isOpera = " + isOpera + "/isFirefox = " + isFirefox + "/isSafari = " + isSafari + "/isIE = " + isIE + "/isEdge = " + isEdge + "/isChrome = " + isChrome );
				homePage = '/index.php'
				if ( isIE || isEdge) 
					// IE has a simple solution for it - API:
			    		try { outcome = document.execCommand("ClearAuthenticationCache") }catch(e){}
				else
					homePage = window.location.protocol + '//log:out@' + window.location.host + homePage;

				//alert("homePage = " + homePage );
				window.location.href = homePage ;
			}
		</script>
	</body>
</html>