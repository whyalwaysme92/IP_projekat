<?php

    $htmlStranica =<<<'EOD'
    '<!DOCTYPE html>
<html>
    <head>
        <title>Login - newS</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="css/style_Login.css"> 
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
                            <li><a href="MainPage.php">Naslovna</a></li>
                            <li><a href="LoginPage.php">Uloguj&nbsp;se</a></li>
                        </ul>
                    </div>
                </div>
        
                <div class="LoginForm">
                    <form action="LoginCheck.php" method="post">
                        <div class="FormHeading">
                            <h1>Ulogujte se</h1>
                        </div>
                        <input type="text" name="email" placeholder="Unesite email" pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$"/>
                        <input type="password" name="pass" placeholder="Unesite lozinku"/>
                        <p>Ukoliko nemate nalog na našem sajtu:&nbsp;</p> <a href="Register.php">Registrujte se</a>
                        <button type="submit">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>'
EOD;





    echo($htmlStranica);

?>

