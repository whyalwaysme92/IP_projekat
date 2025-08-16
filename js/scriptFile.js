		const userType = parseInt(document.body.dataset.userType, 10);

		if (userType == 0) {
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