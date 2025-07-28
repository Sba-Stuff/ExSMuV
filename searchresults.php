<?php
include('debugging.php');
function generateTitleFromParagraph($paragraph) {
    // List of common stop words to be removed
    $stopWords = array('the', 'and', 'a', 'an', 'in', 'on', 'of', 'to', 'for', 'with', 'at', 'by', 'is', 'are', 'as', 'it', 'that', 'this', 'we', 'you', 'they', 'i', 'he', 'she', 'me', 'him', 'her', 'us', 'them');
    
    // Convert paragraph to lowercase and remove punctuation
    $paragraph = strtolower(preg_replace('/[^a-z0-9\s]/i', '', $paragraph));
    
    // Tokenize the paragraph into words
    $words = explode(' ', $paragraph);
    
    // Count the frequency of each word
    $wordCounts = array_count_values($words);
    
    // Remove stop words
    foreach ($stopWords as $stopWord) {
        unset($wordCounts[$stopWord]);
    }
    
    // Sort the words by frequency in descending order
    arsort($wordCounts);
    
    // Take the first few high-scoring words and combine them to form the title
    $titleWords = array_slice(array_keys($wordCounts), 0, 5); // Change 5 to the desired number of words in the title
    
    // Capitalize the first letter of each word and join them to form the title
    $title = ucwords(implode(' ', $titleWords));
    
    return $title;
}

function FetchTopics($query)
{
$encodedQuery = $query;
include_once("verticalsfetcher.php");
include_once("subtopicminer.php");
$relatedSearch = BingRelatedSearches($encodedQuery,false);
$relatedTopics = array_column($relatedSearch, 'text');
$suggestions = getBingSuggestions($encodedQuery, false);
$searchResults = BingWebResults($encodedQuery, 10, false);
$onlytitles = array_column($searchResults, 'title');
$onlydescriptions = array_column($searchResults, 'description');
$subtopicsRaw = extractSubtopics($query, $onlytitles, $onlydescriptions);
$subtopics = array_column($subtopicsRaw, 'subtopic');
$allTopics = array_merge($relatedTopics, $suggestions, $subtopics);
$uniqueTopics = array_values(array_unique($allTopics));
$rankedTopics = rankTitlesByCosineSimilarity($query, $uniqueTopics);
//$rankedTopics = rankTitlesByCosineSimilarity($query, $rankedTopics);
$searchResults = $rankedTopics;
//print_r($searchResults);
//exit();
$x="";
//for ($i = 0; $i < 1; $i++) {
for ($i = 0; $i < count($searchResults); $i++) {
    $result = $searchResults[$i]['title'];
    if (empty($result)) {
        continue; // Skip this result if any field is empty
    }
	//exit();
	set_time_limit(5000);
	ini_set('display_errors', 0);
	$web = BingWebResults($result, 1, false);
	/**/
	/* empty($web[0]['title']) && empty($web[0]['description']) && empty($web[0]['link'])*/
	
	if (empty($web[0]['title']) && empty($web[0]['description']) && empty($web[0]['link'])) {
      continue; // Skip this result if any field is empty
    }
	/**/
	$videos = scrapeBingVideoResults($result);
	$images = BingImageResults($result);
	$x=$x."<div class='snippet'>";
	$x=$x."<div class='thumbnail-container'>";
	$x=$x."<div style='display: flex; flex-wrap: wrap; gap: 5px; width: 100%;overflow: auto; border: 1px solid #ddd; border-radius: 8px; padding: 5px;'>";
	$x=$x."<img src=\"".htmlspecialchars($images[0]['thumb_url'])."\" alt=\"".htmlspecialchars($images[0]['title'])."\" style=\"height: 40px; width: 40px; object-fit: cover; border-radius: 5px;\">";
	$x=$x."<img src=\"".htmlspecialchars($images[1]['thumb_url'])."\" alt=\"".htmlspecialchars($images[0]['title'])."\" style=\"height: 40px; width: 40px; object-fit: cover; border-radius: 5px;\">";
	$x=$x."<img src=\"".htmlspecialchars($images[2]['thumb_url'])."\" alt=\"".htmlspecialchars($images[0]['title'])."\" style=\"height: 40px; width: 40px; object-fit: cover; border-radius: 5px;\">";
	$x=$x."<img src=\"".htmlspecialchars($images[3]['thumb_url'])."\" alt=\"".htmlspecialchars($images[0]['title'])."\" style=\"height: 40px; width: 40px; object-fit: cover; border-radius: 5px;\">";
	$x=$x."<img src=\"".htmlspecialchars($images[4]['thumb_url'])."\" alt=\"".htmlspecialchars($images[0]['title'])."\" style=\"height: 40px; width: 40px; object-fit: cover; border-radius: 5px;\">";
	$x=$x."<img src=\"".htmlspecialchars($images[5]['thumb_url'])."\" alt=\"".htmlspecialchars($images[0]['title'])."\" style=\"height: 40px; width: 40px; object-fit: cover; border-radius: 5px;\">";
	$x=$x."</div>";
	$x=$x."<video poster='".$videos[0]['thumb_url']."' controls>";
	$x=$x."Your browser does not support the video tag.";
	$x=$x."</video>";
	$x=$x."<video poster='".$videos[1]['thumb_url']."' controls>";
	$x=$x."Your browser does not support the video tag.";
	$x=$x."</video>";
	$x=$x."</div>";
	$x=$x."<div class='contenter'>";
	$x=$x."<h3>".$result."</h3>";
	$x=$x."<p>".$web[0]['description']."</p>";
	$x .= "<button onclick=\"loadMoreDetails('" . $query." ".$result . "')\" style='margin-top: 10px; padding: 10px 20px; background-color: #007BFF; color: white; border: none; border-radius: 5px; cursor: pointer;'>More Details</button>";
	$x=$x."</div>";
	$x=$x."</div>";
}
echo $x;	
}

function Summarize($query)
{
$encodedQuery = $query;//urlencode($query);
include_once("verticalsfetcher.php");
$searchResults = BingWebResults($encodedQuery, 10, false);
//$onlytitles = array_column($searchResults, 'title');
//$onlydescriptions = array_column($searchResults, 'description');
//include_once("subtopicminer.php");
//print_r(extractSubtopics($query, $onlytitles, $onlydescriptions));
//exit();
$x="";
for ($i = 0; $i < count($searchResults); $i++) {
    $result = $searchResults[$i];
    if (empty($result['title']) && empty($result['description']) && empty($result['link'])) {
        continue; // Skip this result if any field is empty
    }
	set_time_limit(500);
	ini_set('display_errors', 0);
	$videos = scrapeBingVideoResults(generateTitleFromParagraph($result['title']));
	$images = BingImageResults(generateTitleFromParagraph($result['title']));
	$x=$x."<div class='snippet'>";
	$x=$x."<div class='thumbnail-container'>";
	$x=$x."<div style='display: flex; flex-wrap: wrap; gap: 5px; width: 100%;overflow: auto; border: 1px solid #ddd; border-radius: 8px; padding: 5px;'>";
	$x=$x."<img src=\"".htmlspecialchars($images[0]['thumb_url'])."\" alt=\"".htmlspecialchars($images[0]['title'])."\" style=\"height: 40px; width: 40px; object-fit: cover; border-radius: 5px;\">";
	$x=$x."<img src=\"".htmlspecialchars($images[1]['thumb_url'])."\" alt=\"".htmlspecialchars($images[0]['title'])."\" style=\"height: 40px; width: 40px; object-fit: cover; border-radius: 5px;\">";
	$x=$x."<img src=\"".htmlspecialchars($images[2]['thumb_url'])."\" alt=\"".htmlspecialchars($images[0]['title'])."\" style=\"height: 40px; width: 40px; object-fit: cover; border-radius: 5px;\">";
	$x=$x."<img src=\"".htmlspecialchars($images[3]['thumb_url'])."\" alt=\"".htmlspecialchars($images[0]['title'])."\" style=\"height: 40px; width: 40px; object-fit: cover; border-radius: 5px;\">";
	$x=$x."<img src=\"".htmlspecialchars($images[4]['thumb_url'])."\" alt=\"".htmlspecialchars($images[0]['title'])."\" style=\"height: 40px; width: 40px; object-fit: cover; border-radius: 5px;\">";
	$x=$x."<img src=\"".htmlspecialchars($images[5]['thumb_url'])."\" alt=\"".htmlspecialchars($images[0]['title'])."\" style=\"height: 40px; width: 40px; object-fit: cover; border-radius: 5px;\">";
	$x=$x."</div>";
	$x=$x."<video poster='".$videos[0]['thumb_url']."' controls>";
	$x=$x."Your browser does not support the video tag.";
	$x=$x."</video>";
	$x=$x."<video poster='".$videos[1]['thumb_url']."' controls>";
	$x=$x."Your browser does not support the video tag.";
	$x=$x."</video>";
	$x=$x."</div>";
	$x=$x."<div class='contenter'>";
	$x=$x."<h3>".generateTitleFromParagraph($result['title'])."</h3>";
	$x=$x."<p>".$result['description']."</p>";
	$x .= "<button onclick=\"loadMoreDetails('" . $query ." ". $result['title'] . "')\" style='margin-top: 10px; padding: 10px 20px; background-color: #007BFF; color: white; border: none; border-radius: 5px; cursor: pointer;'>More Details</button>";
	$x=$x."</div>";
	$x=$x."</div>";
}
echo $x;	
}
?>
<?php
if(isset($_GET["query"]))
{
echo Summarize(htmlspecialchars($_GET["query"]));
echo FetchTopics(htmlspecialchars($_GET["query"]));
}
?>
<script src="js/resultsnippet.js"></script>