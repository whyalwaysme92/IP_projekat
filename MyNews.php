<!DOCTYPE html> 
<html>
    <head>
        <title>Moje vesti - newS</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="css/style_MyNews.css"> 
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
                            <li><a href="AuthorsMainPage.php">Naslovna</a></li>
                            <li>
                                <a href="">Vesti</a>
                                <ul>
                                    <li><a href="RecentNews.php">Najnovije</a></li>
                                    <li><a href="PopularNews.php">Najpopularnije</a></li>
                                    <li><a href="NewsFromLikedAuthors.php">Omiljeni&nbsp;autori</a></li>
                                    <li><a href="NewsSoulmates.php">Srodne&nbsp;duše</a></li>
                                </ul>
                            </li>
                            <li><a href="LikedAuthors.php">Omiljeni&nbsp;autori</a></li>
                            <li><a href="SoulmatesAuthors.php">Srodne&nbsp;duše</a></li>
                            <li><a href="AddArticle.php">Unesi&nbsp;vest</a></li>
                            <li><a href="MyNews.php">Moje&nbsp;vesti</a></li>
                            <li><a href="Logout.php">Izloguj&nbsp;se</a></li>
                        </ul>
                    </div>
                </div>
        
                <div class="MyNews">
                    <div class="HeadingDiv">
                        <h1>Moje vesti</h1>
                    </div>
                    <div class="AllMyArticles">
                        <div class="OneArticle">
                            <div class="ArticleImageDiv">
                                <img src="images/kurkumica.jpg" alt="">
                            </div><div class="ArticleInformations">
                                <div class="ArticleHeadingDiv">
                                    <a href="">Da li kurkuma i ljuta papričica doprinose našem zdravlju?</a>
                                </div>
                                <div class="ArticleDateDiv">
                                    <p>9-11-2024</p>
                                </div>
                                <div class="ArticleAbstractDiv">
                                    <p>Često se tvrdi da čili, kurkuma i drugi začini imaju zdravstvene prednosti
                                        ili čak sposobnost da „pojačaju naš imuni sistem“.
                                    </p>
                                </div>
                            </div><div class="ArticleButtons">
                                <button id="Update">Ažuriraj</button><button>Briši</button>
                            </div>
                        </div>
                        <div class="OneArticle">
                            <div class="ArticleImageDiv">
                                <img src="images/cvarci.jpg" alt="">
                            </div><div class="ArticleInformations">
                                <div class="ArticleHeadingDiv">
                                    <a href="">Punoletstvo Festivala čvaraka u Valjevu - za dobre čvarke potrebno strpljenje</a>
                                </div>
                                <div class="ArticleDateDiv">
                                    <p>8-11-2024</p>
                                </div>
                                <div class="ArticleAbstractDiv">
                                    <p>Vikend u Valjevu u znaku je čvaraka, čuvenog delikatesa od svinjskog mesa koji je postao nacionalni brend.
                                        I 18. Festival čvaraka privukao je desetine hiljada posetilaca.</p>
                                </div>
                            </div><div class="ArticleButtons">
                                <button id="Update">Ažuriraj</button><button>Briši</button>
                            </div>
                        </div>
                        <div class="OneArticle">
                            <div class="ArticleImageDiv">
                                <img src="images/zoo-vrt-(1).jpg" alt="">
                            </div><div class="ArticleInformations">
                                <div class="ArticleHeadingDiv">
                                    <a href="">Štrajk u beogradskom zoo vrtu</a>
                                </div>
                                <div class="ArticleDateDiv">
                                    <p>7-11-2024</p>
                                </div>
                                <div class="ArticleAbstractDiv">
                                    <p>Predsednik Nezavnisnog udruženja gorila Srbije (NUGS), Sale Manki, saopštio je danas da članovi njegovog udruženja
                                        započinju štrajk usled neispunjavanja uslova od strane... </p>
                                </div>
                            </div><div class="ArticleButtons">
                                <button id="Update">Ažuriraj</button><button>Briši</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>