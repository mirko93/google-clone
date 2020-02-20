<?php
include("config.php");
include("classes/SiteResultsProvider.php");

if (isset($_GET["term"])) {
    $term = $_GET["term"];
} else {
    exit("You must enter a search term");
}

if (isset($_GET["type"])) {
    $type = $_GET["type"];
} else {
    $type = "sites";
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Google</title>

    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <div class="wrapper">
        <div class="header">
            <div class="headerContent">

                <div class="logoContainer">
                    <a href="index.php">
                        <img src="assets/image/doodleLogo.png">
                    </a>
                </div>

                <div class="searchContainer">
                    <form action="search.php" method="GET">
                        <div class="searchBarContainer">
                            <input class="searchBox" type="text" name="term">
                            <button class="searchButton">
                                <img src="assets/image/icons/search.png">
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="tabsContainer">
                <ul class="tabList">

                    <li class="<?php echo $type == 'sites' ? 'active' : '' ?>">
                        <a href='<?php echo "search.php?term=$term&type=sites"; ?>'>
                            Sites
                        </a>
                    </li>

                    <li class="<?php echo $type == 'images' ? 'active' : '' ?>">
                        <a href='<?php echo "search.php?term=$term&type=images"; ?>'>
                            Images
                        </a>
                    </li>
                </ul>
            </div>
        </div>


<!--        search results-->
        <div class="mainResultsSection">
            <?php
            $resultsProvider = new SiteResultsProvider($con);

            $numResults = $resultsProvider->getNumResults($term);

            echo "<p class='resultsCount'>$numResults results found</p>";
            
            echo $resultsProvider->getResultsHtml(1, 20, $term);
            ?>
        </div>

    </div>

</body>
</html>