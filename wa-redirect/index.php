<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Переход в WhatsApp");
?>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="redirect-block">
                    Подождите несколько секунд, перенаправляем в мессенджер.
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Конфигурация
            const config = {
                cookieName: 'roistat_visit',
                baseRedirectUrl: 'https://wa.me/79167195666',
                checkInterval: 2000, // Проверять каждые 2 секунды
                maxAttempts: 10, // Максимум 10 попыток (1 минута)
            };

            function getCookie(name) {
                const value = `; ${document.cookie}`;
                const parts = value.split(`; ${name}=`);
                if (parts.length === 2) return parts.pop().split(';').shift();
            }

            // Функция проверки и редиректа
            function checkCookie() {
                config.currentAttempt++;

                const cookieValue = getCookie(config.cookieName);

                if (cookieValue) {
                    const messageText = "Здравствуйте! Номер моего обращения: " + cookieValue + "%0D%0A(Убедительно просим Вас не стирать номер Вашего обращения. Это существенно упрощает обработку входящих сообщений.)";
                    const redirectUrl = config.baseRedirectUrl + "?text=" + messageText;
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