<head><head>
	<title>PaperFloat</title>
	<link rel="stylesheet" href="css/wordTable.css">
	<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="http://code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
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
					$explodedArticleTitle = explode(" ", $articlesWithWord[$i]);
					$uglyClickableHTMLStringTitle = "";
					foreach($explodedArticleTitle as $word) {
						$uglyClickableHTMLStringTitle .= "<a href='index.php?word=$word'>$word </a>";
					}
					echo  "<tr><td>$uglyClickableHTMLStringTitle</td><td><a href='index.php?word=$formattedAuthorName'>$authorName[$i]</a></td><td><a href=$url>Link To Article</a></td><td>&nbsp$frequency[$i]</td><td>
                        <input type='checkbox' name=\"subsetList\" value=$thePaperID[$i]> Add to Subset</input>
                        </td><td>$publisherName[$i]</td></tr>";
				}
			?>
		</table>
	</div>
	<input type="submit" id="subsetSubmit">
</body>
<script>
$('#subsetSubmit').click(function(){
            var checkValues = $('input[name=subsetList]:checked').map(function()
            {
                return $(this).val();
            }).get();
/*
            $.ajax({
                url: 'index.php',
                type: 'get',
                data: { ids: checkValues },
                success:function(data){

                }
            });
			*/
			
			var url = "?word=&";
			for(i = 0; i < checkValues.length; i++) {
				url += "papersID[]=" + checkValues[i] + "&";
			}
			
			window.location = "index.php" + url;
        
    });
</script>
	

