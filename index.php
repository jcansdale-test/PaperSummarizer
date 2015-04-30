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
		<button id="submitButton">Submit</button>
		<div id="buttons">
		<div id="articleLimit">
			<span>Article Limit:</span>
			<select id="limit">
				<?php
					for($i = 1; $i < 20; $i++) {
						echo "<option id=$i>$i</option>";
					}
				?>
			</select>
		</div>
		</div>
	</div>
</body>
</html>
<?php 
	error_reporting(E_ALL ^ E_NOTICE);
	if($_GET['word'] != null) {
		$toSearch = $_GET['word'];	
		echo "<script> 
		$(document).ready(function(){
			$.ajax({
				beforeSend: function() {
					$('#cloudBox').html(\"<img id='generating' src='http://sierrafire.cr.usgs.gov/images/loading.gif'>\");
				},
				type: 'post',
				url: 'getCloud.php',
				data: {
					prev: '',
					keyword: '$toSearch',
					limit: 5
				},
				success: function(msg){
					$('#cloudBox').html(msg);
				}
			});
		});
		</script>";
	}
	else if($_GET['papersID'] != null){
		$toSearch = $_GET['papersID'];
		$encodedSearch = json_encode($toSearch);
		
		echo "<script> 
		$(document).ready(function(){
			$.ajax({
				beforeSend: function() {
					$('#cloudBox').html(\"<img id='generating' src='http://sierrafire.cr.usgs.gov/images/loading.gif'>\");
				},
				type: 'POST',
				url: 'getCloud.php',
				data: {
					keyword: '',
					papersID: $encodedSearch,
					limit: 5
				},
				success: function(msg){
					$('#cloudBox').html(msg);
				}
			});
		});
		</script>";
	}
?>
<script>
	$("#submitButton").click(function(){
		$.ajax({
			beforeSend: function() {
				$('#cloudBox').html("<img id=\"generating\" src=\"http://sierrafire.cr.usgs.gov/images/loading.gif\">");
			},
			type: "post",
			url: "getCloud.php",
			data: {
				keyword: $('#inputBox').val(),
				papersID: '',
				limit: $('#limit').val()
			},
			success: function(msg){
				$('#cloudBox').html(msg);
			}
		});
	});
</script>