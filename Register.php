<!DOCTYPE html>
<html>
    <head>
        <title>Register - newS</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="css/style_Register.css"> 
    </head>
    <body>
        <div class="PageContentDiv">
            <div class="PageContent">
                <!-- <div class="Header">
                    <div class="HeaderLogoImage">
                        <p>new<span>S</span></p>
                    </div>
                    <div class="HeaderNavigation">
                        <ul>
                            <li><a href="MainPage.php">Naslovna</a></li>
                            <li><a href="LoginPage.php">Uloguj&nbsp;se</a></li>
                        </ul>
                    </div>
                </div> -->
        
                <?php 
                    include 'Navigation.php'; 
                ?>

                <div class="RegisterForm">
                    <form action="Registration.php" enctype="multipart/form-data" method="post">
                        <div class="FormHeading">
                            <h1>Registracija</h1>
                        </div>
                        <label for="UploadFile" class="CustomUploadFile">
                            <input id="UploadFile" type="file" required="required"/>
                            <div class="ImageContainer">
                                <img src="images/ProfileIcon.png" alt="">
                            </div>
                        </label>
                        <!-- <input type="file"/> -->
                        <div class="MailAndPass">
                            <input type="text" name="email" placeholder="Unesite email adresu" pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" required="required"/> 
                            <input type="password" name="password" placeholder="Unesite lozinku" required="required"/>
                        </div>
                        <input type="text" name="name" placeholder="Unesite ime" required="required"/> 
                        <input type="text" name="lastname" placeholder="Unesite prezime" required="required"/> 
                        <input type="text" name="phone" placeholder="Unesite telefon u formatu +38163123456" pattern="\+[0-9]{3}[0-9]{7,12}" required="required"/> 
                        <input type="text" name="address" placeholder="Unesite adresu" required="required"/> 
                        <ul>
                            <li><input type="radio" name="accountType" value="3" required="required"/><span>&nbsp;Čitalac</span></li>
                            <li><input type="radio" name="accountType" value="2" required="required"/><span>&nbsp;Autor</span></li>
                        </ul>
                        <button type="submit">Register</button>
                    </form>
                </div>            
            </div>
        </div>
        <script src="js/scriptFile.js"></script>
    </body>
</html>