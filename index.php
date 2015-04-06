<html>
<head>
	<title>PaperFloat</title>
	<link rel="stylesheet" href="css/homePage.css">
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
	<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="http://code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
	<script>
  		$(function() {
  		  var availableTags = [ //CHANGE TO AUTOCOMPLETE ARTIST SUGGESTIONS!
  		    //No auto-complete for this iteration. 
  		  ];
  		  $( "#inputBox" ).autocomplete({
  		    source: availableTags
  		  });
  		});
  	</script>
</head>

<body>
	<header>
		<div id="header">PaperFloat</div>
	</header>
	<div id="cloudPane">
		<div id="cloudBox"></div>
	</div>	
	<div id ="inputPane">
		<input id="inputBox" type="text" name="text" placeholder="Input Text Here">
		<button id="addMoreButton">Add More To Cloud</button>
			<a href="http://www.facebook.com/sharer.php?u=LyricFloat.com" id="shareButton" target="_blank"><img src="img/fb.png" alt="Facebook" /></a>
			<button id="submitButton">Submit</button>
		<div id="buttons">
		<div id="articleLimit">
			<span>Article Limit:</span>
			<select id="limit">
				<?php
					for($i = 0; $i < 20; $i++) {
						echo "<option id=$i>$i</option>";
					}
				?>
			</select>
		</div>
		</div>
	</div>
</body>
</html>

<script>
	$("#submitButton").click(function(){
		$.ajax({
				beforeSend: function() {
					$('#cloudBox').html("<div id=\"generating\">Generating Cloud...</div>");
				},
				type: "post",
				url: "getCloud.php",
				data: {
					prev: '',
					keyword: $('#inputBox').val(),
					limit: $('#limit').val()
				},
				success: function(msg){
					$('#cloudBox').html(msg);
					$('#addMoreButton').css("visibility", "visible");
					$('#shareButton img').css("visibility", "visible");
				}
		});
	});
	
	
	$("#addMoreButton").click(function(){
		$.ajax({
				beforeSend: function() {
					$('#cloudBox').html("<div id=\"generating\">Generating Cloud...</div>");
				},
				type: "post",
				url: "getCloud.php",
				data: {
					prev: $('#prevText').text(),
					keyword: $('#inputBox').val(),
					limit: $('#limit').val()
				},
				success: function(msg){
					$('#cloudBox').html(msg);
				}
		});
	});
</script>