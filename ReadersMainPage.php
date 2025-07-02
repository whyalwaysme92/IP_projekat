<!DOCTYPE html> 
<html>
    <head>
        <title>Čitaoci - Početna - newS</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="css/style_MainPage.css"> 
    </head>
    <body>
        <div class="PageContentDiv">
            <div class="PageContent">
                <div class="Header">
                    <div class="HeaderLogoImage">
                        <p>new<span>S</span></p>
                    </div>
                    <div class="HeaderNavigation">
                        <ul>
                            <li><a href="ReadersMainPage.php">Naslovna</a></li>
                            <li>
                                <a href="">Vesti</a>
                                <ul>
                                    <li><a href="RecentNewsReaders.php">Najnovije</a></li>
                                    <li><a href="PopularNewsReaders.php">Najpopularnije</a></li>
                                    <li><a href="NewsFromLikedAuthorsReaders.php">Omiljeni&nbsp;autori</a></li>
                                    <li><a href="NewsSoulmatesReaders.php">Srodne&nbsp;duše</a></li>
                                </ul>
                            </li>
                            <li><a href="LikedAuthorsReaders.php">Omiljeni&nbsp;autori</a></li>
                            <li><a href="Soulmates.php">Srodne&nbsp;duše</a></li>
                            <li><a href="Logout.php">Izloguj&nbsp;se</a></li>
                        </ul>
                    </div>
                </div>
        
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
        
                    <!-- <div class="PopularNews">
                        <div class="OneArticle">
                            <div class="ArticleHeader">Vest 5</div>
                            <div class="ArticleDate"> 15-10-2024</div>
                            <div class="ArticleText"> Poslednja vest koja se pojavila na nasem sajtu.</div>
                        </div>
                        <div class="OneArticle">
                            <div class="ArticleHeader">Vest 4</div>
                            <div class="ArticleDate"> 14-10-2024</div>
                            <div class="ArticleText"> Cetvrta vest koja se pojavila na nasem sajtu.</div>
                        </div>
                        <div class="OneArticle">
                            <div class="ArticleHeader">Vest 3</div>
                            <div class="ArticleDate"> 13-10-2024</div>
                            <div class="ArticleText"> Treca vest koja se pojavila na nasem sajtu.</div>
                        </div>
                        <div class="OneArticle">
                            <div class="ArticleHeader">Vest 2</div>
                            <div class="ArticleDate"> 12-10-2024</div>
                            <div class="ArticleText"> Druga vest koja se pojavila na nasem sajtu.</div>
                        </div>
                        <div class="OneArticle">
                            <div class="ArticleHeader">Vest 1</div>
                            <div class="ArticleDate"> 11-10-2024</div>
                            <div class="ArticleText"> Prva vest koja se pojavila na nasem sajtu.</div>
                        </div>
                    </div>
                    <div class="NewestFromLikedAuthor">
                        <div class="OneArticle">
                            <div class="ArticleHeader">Vest 5</div>
                            <div class="ArticleDate"> 15-10-2024</div>
                            <div class="ArticleText"> Poslednja vest koja se pojavila na nasem sajtu.</div>
                        </div>
                        <div class="OneArticle">
                            <div class="ArticleHeader">Vest 4</div>
                            <div class="ArticleDate"> 14-10-2024</div>
                            <div class="ArticleText"> Cetvrta vest koja se pojavila na nasem sajtu.</div>
                        </div>
                        <div class="OneArticle">
                            <div class="ArticleHeader">Vest 3</div>
                            <div class="ArticleDate"> 13-10-2024</div>
                            <div class="ArticleText"> Treca vest koja se pojavila na nasem sajtu.</div>
                        </div>
                        <div class="OneArticle">
                            <div class="ArticleHeader">Vest 2</div>
                            <div class="ArticleDate"> 12-10-2024</div>
                            <div class="ArticleText"> Druga vest koja se pojavila na nasem sajtu.</div>
                        </div>
                        <div class="OneArticle">
                            <div class="ArticleHeader">Vest 1</div>
                            <div class="ArticleDate"> 11-10-2024</div>
                            <div class="ArticleText"> Prva vest koja se pojavila na nasem sajtu.</div>
                        </div>
                    </div>
                    <div class="BestRated">
                        <div class="OneArticle">
                            <div class="ArticleHeader">Vest 5</div>
                            <div class="ArticleDate"> 15-10-2024</div>
                            <div class="ArticleText"> Poslednja vest koja se pojavila na nasem sajtu.</div>
                        </div>
                        <div class="OneArticle">
                            <div class="ArticleHeader">Vest 4</div>
                            <div class="ArticleDate"> 14-10-2024</div>
                            <div class="ArticleText"> Cetvrta vest koja se pojavila na nasem sajtu.</div>
                        </div>
                        <div class="OneArticle">
                            <div class="ArticleHeader">Vest 3</div>
                            <div class="ArticleDate"> 13-10-2024</div>
                            <div class="ArticleText"> Treca vest koja se pojavila na nasem sajtu.</div>
                        </div>
                        <div class="OneArticle">
                            <div class="ArticleHeader">Vest 2</div>
                            <div class="ArticleDate"> 12-10-2024</div>
                            <div class="ArticleText"> Druga vest koja se pojavila na nasem sajtu.</div>
                        </div>
                        <div class="OneArticle">
                            <div class="ArticleHeader">Vest 1</div>
                            <div class="ArticleDate"> 11-10-2024</div>
                            <div class="ArticleText"> Prva vest koja se pojavila na nasem sajtu.</div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>

    </body>
</html>