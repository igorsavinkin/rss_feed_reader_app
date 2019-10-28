<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>RSS feed</title>
</head>
<body><?php session_start(); 
if (isset($_SESSION['user'])){
	echo '<p style="text-align: right; color: green;">Logged in user:<br />'.$_SESSION['user']['email'] .'<br />';
	echo '<a href="logout.php">Log out</a></p>';
} else {
	header("Location: login.php"); /* Redirect browser */
	exit();
}
echo '<h2 style="text-align:center;display: block;">RSS feed</h2>';
$xml = simplexml_load_file('https://www.theregister.co.uk/software/headlines.atom');
$stop_words=['the','be','to','of','and','a','in','that','have','I','it','for','not','on','with','he','as','you','do','at','this','but','his','by','from','they','we','say','her','she','or','an','will','my','one','all','would','there','their','what','so','up','out','if','about','who','get','which','go','me'];


$words_by_counts = array('10X'=>0);
foreach ($xml->entry as $entry) { 
    $item = $entry->summary ; 
	$item = strip_tags($item);  
    $item = preg_replace("#[[:punct:]]#", "", $item); // strip punctuation
	$item = str_replace( ['…', '–'], ' ',  $item); 
    $item_words = preg_split('/\s+/', $item); // split into words replacing spaces
	
    foreach ($item_words as $word) { 
	    if ($word && !(in_array($word, $stop_words))) { 
			if (in_array( $word, array_keys($words_by_counts))){ 
				$words_by_counts[$word]++;
			} else {
				$words_by_counts[$word] = 1;
			}
	    }
	}		
}
// Output top 10 words of the feed
arsort($words_by_counts); // descending array sorting by values
echo '<div ><h3>Top 10 words of the feed:</h3><table border=1> <tr><th>Word</th><th>&nbsp;Count&nbsp;</th></tr><tbody>';
foreach (array_slice( $words_by_counts, 0, 10) as $word => $count){
	echo '<tr><td>', $word, '</td><td> ', $count, '</td></tr>'; 
}
echo '</tbody></table></div>';

// Output the feed itself
echo '<hr><ol>';
foreach ($xml->entry as $entry) { 
  echo "<li><a target='_blank' href=", $entry->link->attributes()['href'] , ">",  substr($entry->updated, 0 ,10) , '</a> by ', $entry->author->name , $entry->summary ,"</li>";
} 
?>
</ol></body>