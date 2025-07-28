<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>ExSMuV - Grid</title>
  <link rel="stylesheet" href="css/basic.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/snippetbase.css">
  <style>
    .media-title {
      font-size: 0.85rem;
      text-align: center;
      margin-top: 5px;
    }
    .media-block {
      margin-bottom: 20px;
    }
    .media-img, .media-video {
      width: 100%;
      height: auto;
      border-radius: 10px;
    }
    .video-thumbnail {
      position: relative;
    }
    .video-thumbnail::after {
      content: "▶";
      font-size: 2rem;
      color: white;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      pointer-events: none;
      text-shadow: 0 0 8px black;
    }
    .section-heading {
      font-weight: 600;
      margin-bottom: 1rem;
      text-align: center;
    }
    .reference-links a {
      margin-right: 15px;
    }
    .grid-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
      gap: 20px;
      padding: 20px;
      max-width: 1200px;
      margin: 0 auto;
    }
    @media (max-width: 768px) {
      .media-img, .media-video {
        max-height: 120px;
      }
      .media-title {
        font-size: 0.75rem;
      }
    }
  </style>
</head>
<body>
  <div style="padding: 20px; text-align: center;">
    <div style="background: white;border-radius: 50px;overflow: hidden;box-shadow: 0 4px 12px rgba(0,0,0,0.05);" align="left">
      <img src="images/ExSMuV.png" height="30" width="100">
      <input type="text" id="search-input" placeholder="Search here" style="border: 1;padding: 10px 20px;font-size: 16px;outline: none;width: 50%;" value="<?php if(isset($_GET["query"])){echo $_GET["query"];}else{echo "";}?>">
      <button id="search-button" style="background: #131c29;color: white;padding: 10px 20px;border: none;cursor: pointer;"><span>🔍</span></button>
    <select name="workspace" id="workspace" style="
  padding: 8px 14px;
  font-size: 16px;
  font-family: 'Segoe UI', sans-serif;
  background-color: #f8f9fa;
  border: 1px solid #ccc;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
  color: #333;
  cursor: pointer;
  transition: all 0.2s ease-in-out;
">
	<option value="Grid" selected="selected">Grid</option>
	<option value="Canvas">Canvas</option>
	</select>
	</div>
  </div>

<!-- Result grid -->
<div id="nodes-container" style="display: grid;grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));"></div>

<div class="split right">
  <div class="centered"></div>
</div>

<script src="js/grid.js"></script>
<script>
function loadMoreDetails(title) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'caller/cccallme.php?title=' + encodeURIComponent(title), true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            document.querySelector('.split.right .centered').innerHTML = xhr.responseText;
        } else {
            console.error('Failed to load details');
        }
    };
    xhr.onerror = function () {
        console.error('An error occurred during the request');
    };
    xhr.send();
}
</script>
<script>
document.getElementById("workspace").addEventListener("change", function() {
    const value = this.value;

    // Define redirection URLs for each option
    const routes = {
        "Grid": "index.php",
        "Canvas": "index2.php"
    };

    // Redirect to the corresponding page
    if (routes[value]) {
        window.location.href = routes[value];
    }
});
</script>
</body>
</html>
