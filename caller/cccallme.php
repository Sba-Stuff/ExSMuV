<div class="container py-4">
<?php
include('debugging.php');
include_once('../verticalsfetcher.php');

if (isset($_GET['title'])) {
    $title = urldecode($_GET['title']);
    $title = str_replace('+', ' ', $title);
    $title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
    $encodedQuery = $title;
    $searchResults = BingWebResults($encodedQuery, 5, false);
    $images = BingImageResults($title);
    $videos = scrapeBingVideoResults($title);
    // Heading and summary
    echo '<h2 class="text-center mb-3">'.htmlspecialchars($searchResults[0]['title']).'</h2>';
    echo '<p class="text-center mb-4">'.htmlspecialchars($searchResults[0]['description']).'</p>';

    // Begin fixed-columns layout
    echo '<div class="fixed-columns">';

    // === IMAGES COLUMN ===
    echo '<div>';
    echo '<h5 class="section-heading">Images</h5>';
    for ($i = 0; $i < 5; $i++) {
        echo '<div class="media-block">';
        echo "<img src='".htmlspecialchars($images[$i]['thumb_url'])."' class='media-img' alt='".htmlspecialchars($images[$i]['title'])."'>";
        echo '<div class="media-title"><a href="'. htmlspecialchars($images[$i]['page_url']) .'">'.htmlspecialchars($images[$i]['title']).'</a></div>';
        echo '</div>';
    }
    echo '</div>'; // close image column

    // === VIDEOS COLUMN ===
    echo '<div>';
    echo '<h5 class="section-heading">Videos</h5>';
    for ($i = 0; $i < 5; $i++) {
        echo '<div class="media-block">';
        echo '<div class="video-thumbnail">';
        echo "<a href='".htmlspecialchars($videos[$i]['video_url'])."' target='_blank'>";
        echo "<img src='".htmlspecialchars($videos[$i]['thumb_url'])."' class='media-video' alt='".htmlspecialchars($videos[$i]['title'])."'>";
        echo '</a>';
        echo '</div>';
        echo '<div class="media-title"><a href="'. htmlspecialchars($videos[$i]['video_url']) .'">'.htmlspecialchars($videos[$i]['title']).'</a></div>';
        echo '</div>';
    }
    echo '</div>'; // close video column

    echo '</div>'; // close fixed-columns

    // === REFERENCES SECTION ===
    echo '<div class="mt-5 reference-links text-center">';
    echo '<h5>References</h5>';
    for ($i = 0; $i < 3; $i++) {
        $ref = $searchResults[$i];
        echo "[".$i+1 . "] "." <a href='".htmlspecialchars($ref['link'])."' class='text-decoration-none' target='_blank'>".htmlspecialchars($ref['title'])."</a> <br>";
    }
    echo '</div>';
} else {
    echo "<p>Invalid request: title parameter missing.</p>";
}
?>
</div>
