<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Guestbook</title>
        <link rel="stylesheet" href="/css/styles.css">
    </head>

<body>
    <div class="container">
            <div class="form-container">

            <h1>Leave a message</h1>
        
            <?php if (isset($_GET['success'])): ?>
                <div class="success-message">Message was successfully sent!</div>
            <?php endif; ?>

            <form action="submit.php" method="POST" class="guestbook-form">
                <div class="form-group">
                    <label for="username">User Name:</label>
                    <input type="text" id="username" name="username" required pattern="[a-zA-Z0-9]+">
                </div>
                
                <div class="form-group">
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="homepage">Homepage (URL):</label>
                    <input type="url" id="homepage" name="homepage">
                </div>
                
                <div class="form-group">
                    <div class="captcha-container">
                        <img src="captcha.php" alt="CAPTCHA" id="captcha-image">
                        <button type="button" onclick="refreshCaptcha()">Refresh</button>
                    </div>
                    <input type="text" id="captcha" name="captcha" required>
                </div>
                
                <div class="form-group">
                    <label for="text">Message:</label>
                    <textarea id="text" name="text" rows="5" required></textarea>
                </div>
                
                <button type="submit" class="submit-btn">Send</button>
            </form>
        </div>

        <div class="messages-container">
            <h2>Latest messages</h2>
            <?php include 'display_messages.php'; ?>
        </div>
    </div>

    <script>
        function refreshCaptcha() {
            const captchaImage = document.getElementById('captcha-image');
            captchaImage.src = 'captcha.php?' + new Date().getTime();
        }
    </script>
</body>

</html>