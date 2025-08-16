<!DOCTYPE html> 
<html>
    <head>
        <title>Naslovna - newS</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="css/style_MainPage.css"> 
    </head>
    <body>
        <div class="PageContentDiv">
            <div class="PageContent">
            <?php 
                include 'Navigation.php'; 
            ?>
                <div class="MainPartOfPage">
                    <div class="NewsChronologically">
                        <h1>Poslednje vesti</h1>
                        <div class="Articles">
                            <?php
                            $sort = 'date';
                            include 'FetchNews.php'; 
                            ?>
                        </div>
                    </div>
        
                    <div class="PopularNews">
                        <h1>Najpopularnije</h1>
                        <div class="Articles">
                        <?php
                            $sort = 'popularity';
                            include 'FetchNews.php'; 
                            ?>
                        </div>
                    </div>
        
                    <div class="NewestFromLikedAuthor">
                        <h1>Najnovije od omiljenog autora</h1>
                        <div class="Articles">
                        <?php
                            $sort = 'favorite';
                            include 'FetchNews.php'; 
                            ?>
                        </div>
                    </div>
                            
                    <div class="BestRated">
                        <h1>Najbolje ocenjeno</h1>
                        <div class="Articles">
                        <?php
                            $sort = 'best';
                            include 'FetchNews.php'; 
                            ?>
                        </div>
                    </div>
            </div>
                </div>
            </div>
        </div>
        <script src="js/scriptFile.js"></script>
    </body>
</html>



