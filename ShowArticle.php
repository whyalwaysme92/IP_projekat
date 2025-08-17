<?php
session_start();

$connection = new mysqli("localhost", "root", "", "bazag01");

$currentUserId = $_SESSION['IDkorisnika'] ?? null;
$currentUserType = $_SESSION['tip'] ?? null;

$articleId = $_GET['id'] ?? 0;

$sqlOne = $connection->prepare("SELECT * FROM vesti WHERE IDvesti = ?");
$sqlOne->bind_param("i", $articleId);
$sqlOne->execute();
$result = $sqlOne->get_result()->fetch_assoc();

$sqlTwo = $connection->prepare("SELECT * FROM korisnici WHERE IDkorisnika = ?");
$sqlTwo->bind_param("i", $result['IDkorisnika']);
$sqlTwo->execute();
$resultTwo = $sqlTwo->get_result()->fetch_assoc();

$currentRating = 0;
if ($currentUserId) {
    $sqlThree = $connection->prepare("SELECT Ocena FROM ocene WHERE IDkorisnika = ? AND IDvesti = ?");
    $sqlThree->bind_param("ii", $currentUserId, $articleId);
    $sqlThree->execute();
    $resRating = $sqlThree->get_result()->fetch_assoc();
    if ($resRating) {
        $currentRating = (int)$resRating['Ocena'];
    }
    $sqlThree->close();
}

$connection->close();

?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($result['Naslov']); ?> - newS</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/style_ShowArticle.css">
    <style>
        .star-rating {
            font-size: 2em;
            direction: ltr;
            unicode-bidi: bidi-override;
            font-family: 'nunitoBold', sans-serif;
            display: inline-block;
            line-height: 1;
        }

        .star-rating .star {
            color: #cccccc;
            cursor: pointer;
            transition: color 0.2s ease;
            display: inline-block;
            padding: 0 3px;
            font-size: 1.2em;
        }

        .star-rating .star.hovered {
            color: #ffcc00 !important;
            transform: scale(1.1);
        }

        .star-rating .star.selected {
            color: #ff9900 !important;
        }

        /* Ensure no other styles are overriding these */
        .star-rating .star.hovered,
        .star-rating .star.selected {
            text-shadow: 0 0 5px rgba(255, 204, 0, 0.5);
        }
    </style>
</head>
<body data-user-type="<?php echo $currentUserType ?? ''; ?>">
    <div class="PageContentDiv">
        <div class="PageContent">
            <?php include 'Navigation.php'; ?>
            <div class="ArticleDiv">
                <div class="HeadingDiv">
                    <h1><?php echo($result['Naslov']); ?></h1>
                </div>
            </div>

            <div class="ArticleDetailsAndImages"> 
                <div class="AuthorDetailsDiv">
                    <p>Autor: <?php echo($resultTwo['Ime'] . " " . $resultTwo['Prezime']); ?></p>
                    <p>&nbsp;|&nbsp;</p>
                    <p>Datum: <?php echo (new DateTime($result['Datum']))->format('d-m-y'); ?></p>
                    <p>&nbsp;|&nbsp;</p>
                    <p>Ocena: <?php echo($result['Ocena']); ?></p>
                </div>

                <img src="<?php echo($result['PrvaSlikaVesti']); ?>" alt="<?php echo($result['Naslov']); ?>">
                
                <div class="ArticleTextDiv">
                    <p><?php echo($result['Tekst']); ?></p>
                </div>

                <div class="SecondImageDiv">
                    <img src="<?php echo($result['DrugaSlikaVesti']); ?>" alt="<?php echo($result['Apstrakt']); ?>">
                </div>
            </div>

            <?php if ($currentUserId && in_array($currentUserType, [1, 2])): ?>
                <div class="RatingDiv">
                    <h3>Ocenite vest:</h3>
                    <div class="star-rating" data-current-rating="<?php echo $currentRating; ?>" data-article-id="<?php echo $articleId; ?>">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <span class="star<?php echo $i <= $currentRating ? ' selected' : ''; ?>" data-value="<?php echo $i; ?>">★</span>
                        <?php endfor; ?>
                    </div>
                    <div class="RatingMessage" style="color: green; margin-top: 10px;"></div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>

        const userType = parseInt(document.body.dataset.userType, 10);

        if (userType == 1) {
            let logoutTimer;
            const logoutAfter = 60 * 1000;

            function resetTimer() {
                clearTimeout(logoutTimer);
                logoutTimer = setTimeout(() => {
                    alert("Niste aktivni 1 minut. Bićete izlogovani.");
                    window.location.href = "Logout.php";
                }, logoutAfter);
            }

            document.addEventListener("mousemove", resetTimer);
            document.addEventListener("keydown", resetTimer);
            document.addEventListener("click", resetTimer);
            document.addEventListener("scroll", resetTimer);

            resetTimer();
        }

        function showTime() {
            const now = new Date();
            let hours = now.getHours().toString().padStart(2, '0');
            let minutes = now.getMinutes().toString().padStart(2, '0');
            let seconds = now.getSeconds().toString().padStart(2, '0');

            document.getElementById('TimeDiv').textContent = `${hours}:${minutes}:${seconds}`;
        }

        showTime();

        setInterval(showTime, 1000);
        
        document.addEventListener("DOMContentLoaded", function() {
    const ratingContainer = document.querySelector(".star-rating");
    if (!ratingContainer) return;

    const stars = ratingContainer.querySelectorAll(".star");
    const articleId = ratingContainer.dataset.articleId;
    let selected = parseInt(ratingContainer.dataset.currentRating) || 0;
    let hovered = 0;

    // Initialize stars with current rating
    updateStars();

    stars.forEach(star => {
        star.addEventListener("mouseover", function() {
            hovered = parseInt(this.dataset.value);
            updateStars();
        });

        star.addEventListener("mouseout", function() {
            hovered = 0;
            updateStars();
        });

        star.addEventListener("click", function() {
            selected = parseInt(this.dataset.value);
            updateStars();
            
            fetch("SubmitRating.php", {
                method: "POST",
                headers: { 
                    "Content-Type": "application/x-www-form-urlencoded",
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: `rating=${selected}&article_id=${articleId}`
            })
            .then(response => {
                if (!response.ok) throw new Error("Network response was not ok");
                return response.text();
            })
            .then(data => {
                const messageDiv = document.querySelector(".RatingMessage");
                if (messageDiv) {
                    messageDiv.textContent = "Uspešno ste ocenili vest!";
                    setTimeout(() => messageDiv.textContent = "", 3000);
                }
            })
            .catch(error => {
                console.error("Error:", error);
                const messageDiv = document.querySelector(".RatingMessage");
                if (messageDiv) {
                    messageDiv.textContent = "Došlo je do greške prilikom ocenjivanja.";
                    messageDiv.style.color = "red";
                }
            });
        });
    });

    function updateStars() {
        stars.forEach(star => {
            const value = parseInt(star.dataset.value);
            star.classList.toggle("selected", value <= selected);
            star.classList.toggle("hovered", hovered > 0 && value <= hovered);
        });
    }
});
        
		
    </script>
</body>
</html>
