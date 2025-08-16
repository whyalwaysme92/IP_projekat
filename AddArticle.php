<!DOCTYPE html> 
<html>
    <head>
        <title>Unesi vest - newS</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="css/style_AddArticle.css"> 
    </head>
    <body data-user-type="<?php echo (session_status() === PHP_SESSION_NONE) ? 3 : (isset($_SESSION['tip']) ? (int)$_SESSION['tip'] : 3);?>">
        <div class="PageContentDiv">
            <div class="PageContent">
                <!-- <div class="Header">
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
                </div> -->
        
                <?php 
                    include 'Navigation.php'; 
                ?>  

                <div class="AddArticleDiv">
                    <div class="HeadingDiv">
                        <h1>Unesi vest</h1>
                    </div>
                    <form action="InsertNews.php" method="POST" enctype="multipart/form-data">
                        <div class="LeftPartForm">
                            <div class="ArticleHeadingDiv">
                                <input type="text" name="Naslov" placeholder="Naslov vesti" required="required"/>
                            </div>
                            <div class="ArticleDateDiv">
                                <input type="date" name="Datum" placeholder="Datum vesti" required="required"/>
                            </div>
                            <div class="ArticleAbstractDiv">
                                <textarea name="Apstrakt" id="" placeholder="Apstrakt vesti"></textarea>
                            </div>
                        </div><div class="FirstArticleImage">
                            <input type="file" name="PrvaSlikaVesti"/>
                        </div>
                        <div class="ArticleMainText">
                            <textarea name="Tekst" id="" placeholder="Tekst vesti" required="required"></textarea>
                        </div>
                        <div class="SecondArticleImage">
                            <input type="file" name="DrugaSlikaVesti"/>
                        </div><button type="submit">Unesi vest</button>
                    </form>
                </div>
            </div>
        </div>
        <script src="js/scriptFile.js"></script>
    </body>
</html>