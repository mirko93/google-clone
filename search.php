<?php
include("config.php");
include("classes/SiteResultsProvider.php");
include("classes/ImageResultsProvider.php");

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

if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    <link rel="stylesheet" href="assets/css/style.css">

    <script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous">
    </script>
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
                            <input type="hidden" name="type" value="<?php echo $type ?>">
                            <input class="searchBox" type="text" name="term" value="<?php echo $term ?>">
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
            if ($type == "sites") {
                $resultsProvider = new SiteResultsProvider($con);
                $pageSize = 20;
            } else {
                $resultsProvider = new ImageResultsProvider($con);
                $pageSize = 30;
            }

            $numResults = $resultsProvider->getNumResults($term);

            echo "<p class='resultsCount'>$numResults results found</p>";
            
            echo $resultsProvider->getResultsHtml($page, $pageSize, $term);
            ?>
        </div>

        <div class="paginationContainer">
            <div class="pageButtons">
                <div class="pageNumberContainer">
                    <img src="assets/image/pageStart.png" alt="">
                </div>

                <?php
                $pagesToShow = 10;
                $numPages = ceil($numResults / $pageSize);
                $pagesLeft = min($pagesToShow, $numPages);

                $currentPage = $page - floor($pagesToShow / 2);

                if ($currentPage < 1) {
                    $currentPage = 1;
                }

                if ($currentPage + $pagesLeft > $numPages + 1) {
                    $currentPage = $numPages + 1 - $pagesLeft;
                }

                while ($pagesLeft != 0 && $currentPage <= $numPages) {

                    if ($currentPage == $page) {
                        echo "<div class='pageNumberContainer'>
                                <img src='assets/image/pageSelected.png' alt=''>
                                <span class='pageNumber'>$currentPage</span>
                              </div>";
                    } else {
                        echo "<div class='pageNumberContainer'>
                                <a href='search.php?term=$term&type=$type&page=$currentPage'>
                                    <img src='assets/image/page.png' alt=''>
                                    <span class='pageNumber'>$currentPage</span>
                                </a>        
                              </div>";
                    }

                    $currentPage++;
                    $pagesLeft--;
                }
                ?>

                <div class="pageNumberContainer">
                    <img src="assets/image/pageEnd.png" alt="">
                </div>
            </div>
        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
    <script src="assets/js/script.js"></script>

</body>
</html>