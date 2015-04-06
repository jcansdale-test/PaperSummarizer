<head><head>
	<title>PaperFloat</title>
	<link rel="stylesheet" href="css/wordTable.css">
</head>
<body>
	<div id="header">"<?php echo  $_GET['word'] ?>"</div>
	<div id="table">
		<table id="wordTable">
			<tr>
				<th>Title</th>
				<th>Author</th>
				<th>Link</th>
				<th>Frequency</th>
				<th>Subset</th>
			</tr>
			<?php 
				for($i = 0; $i < 10; $i++){
					echo  "<tr><td></td><td></td><td></td><td></td><td></td></tr>";
				}
			?>
		</table>
	</div>
</body>
	

