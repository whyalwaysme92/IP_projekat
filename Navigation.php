<?php

    session_start();

    $defaultNavigation = <<<EOD
    '<div class="Header">
        <div class="HeaderLogoImage">
            <p>new<span>S</span></p>
        </div>
        <div class="HeaderNavigation">
            <ul>
                <li><a href="MainPage.php">Naslovna</a></li>
                <li><a href="LoginPage.php">Uloguj&nbsp;se</a></li>
            </ul>
        </div>
    </div>'
    EOD;

    $navigationForAdmin = <<<EOD
    '<div class="Header">
        <div class="HeaderLogoImage">
            <p>new<span>S</span></p>
        </div>
        <div class="HeaderNavigation">
            <ul>
                <li><a href="Admins.php">Naslovna</a></li>
                <li><a href="RecentNewsAdmins.php">Najnovije&nbsp;vesti</a></li>
                <li><a href="Authors.php">Autori</a></li>
                <li><a href="Readers.php">Čitaoci</a></li>
                <li><a href="Logout.php">Izloguj&nbsp;se</a></li>
            </ul>
        </div>
    </div>'
    EOD;

    $navigationForAuthors = <<<EOD
    '<div class="Header">
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
    </div>'
    EOD;

    $navigationForReaders = <<<EOD
    '<div class="Header">
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
    </div>'
    EOD;
    if(isset($_SESSION['tip'])){
        switch ($_SESSION['tip']) {
            case 1:
                echo($navigationForAdmin);
                break;
            
            case 2:
                echo($navigationForAuthors);
                break;
            
            case 3:
                echo($navigationForReaders);
                break;
        }
    }else{
        echo($defaultNavigation);
        session_destroy();
    }

?>