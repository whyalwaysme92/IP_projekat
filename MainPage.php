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
                            <div class="OneArticle">
                                <div class="ArticleHeader"> <a href="">Da li kurkuma i ljuta papričica doprinose našem zdravlju?</a></div>
                                <div class="ArticleDate"> <p>9-11-2024</p> <p> | </p></div>
                                <div class="ArticleAuthor"> <p>Mona Liza</p></div>
                                <div class="ArticleGrade"> <p>4.8</p></div>
                                <div class="ArticleText"> <p>Često se tvrdi da čili, kurkuma i drugi začini imaju zdravstvene prednosti
                                    ili čak sposobnost da „pojačaju naš imuni sistem“.</p></div>
                            </div>
                            <div class="OneArticle">
                            <div class="ArticleHeader"> <a href="">Punoletstvo Festivala čvaraka u Valjevu - za dobre čvarke potrebno strpljenje</a></div>
                            <div class="ArticleDate"> <p>8-11-2024</p> <p> | </p></div>
                            <div class="ArticleAuthor"> <p>Mona Liza</p></div>
                            <div class="ArticleGrade"> <p>4.7</p></div>
                            <div class="ArticleText"> <p>Vikend u Valjevu u znaku je čvaraka, čuvenog delikatesa od svinjskog mesa koji je postao nacionalni brend.
                                     I 18. Festival čvaraka privukao je desetine hiljada posetilaca.</p></div>
                            </div>
                            <div class="OneArticle">
                                <div class="ArticleHeader"> <a href="">Štrajk u beogradskom zoo vrtu</a></div>
                                <div class="ArticleDate"> <p>7-11-2024</p> <p> | </p></div>
                                <div class="ArticleAuthor"> <p>Mona Liza</p></div>
                                <div class="ArticleGrade"> <p>4.8</p></div>
                                <div class="ArticleText"> <p>Predsednik Nezavnisnog udruženja gorila Srbije (NUGS), Sale Manki, saopštio je danas da članovi njegovog udruženja
                                    započinju štrajk usled neispunjavanja uslova od strane beogradskog zoo vrta. </p></div>
                            </div>
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

    </body>
</html>



