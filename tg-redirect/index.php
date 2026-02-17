<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Переход в Telegram");
$APPLICATION->SetTitle("Переход в Telegram");
?>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="redirect-block">
                Подождите несколько секунд, перенаправляем в мессенджер
            </div>
        </div>
    </div>
</div>

    <script>
        $(document).ready(function() {

            const config = {
                cookieName: 'roistat_visit',
                baseRedirectUrl: 'https://t.me/KULTURAKOVROV_bot?start=roistat_',
                checkInterval: 2000,
                maxAttempts: 10,
            };

            function getCookie(name) {
                const value = `; ${document.cookie}`;
                const parts = value.split(`; ${name}=`);
                if (parts.length === 2) return parts.pop().split(';').shift();
            }

            function checkCookie() {
                config.currentAttempt++;

                const cookieValue = getCookie(config.cookieName);

                if (cookieValue) {

                    const redirectUrl = config.baseRedirectUrl + cookieValue;

                    window.location.href = redirectUrl;

                } else {

                    setTimeout(function() {
                        location.reload();
                    }, config.checkInterval);
                }
            }
            checkCookie();
        });

    </script>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>