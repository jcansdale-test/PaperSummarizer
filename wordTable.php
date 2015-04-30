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
                <th>Conference</th>
			</tr>
			<?php
                include "WordCloud.php";
                global $authorName;
                global $publisherName;
                global $thePaperID;
                $papersID = $_GET['papersID'];
                global $frequency;
                $word = $_GET['word'];
                $provider = new WordCloud;
                $articlesWithWord = $provider->getArticlesByWord($word, $papersID, $authorName, $publisherName, $thePaperID, $frequency, "http://ieeexplore.ieee.org/gateway/ipsSearch.jsp?an=");
				for($i = 0; $i < count($articlesWithWord); $i++){
                    $url = "http://ieeexplore.ieee.org/xpl/articleDetails.jsp?tp=&arnumber=". $thePaperID[$i];
					$explodedNames = explode(",", $authorName[$i]);
					$formattedAuthorName = $explodedNames[0]; 
					echo  "<tr><td><a href = 'http://smanoj.student.uscitp.com/PaperSummarizer/'> $articlesWithWord[$i] </a></td><td><a href='index.php?word=$formattedAuthorName'>$authorName[$i]</a></td><td><a href=$url>Link To Article</a></td><td>&nbsp$frequency[$i]</td><td>
                        <input type='checkbox' name='Yes' value='True'> Add to Subset
                        </td><td>$publisherName[$i]</td></tr>";
				}
			?>
		</table>
	</div>
</body>
	

