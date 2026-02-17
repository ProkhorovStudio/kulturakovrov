<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');
CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Страница не найдена");
$APPLICATION->AddChainItem("Ошибка 404", "/404.php");
$APPLICATION->SetTitle("404 Not Found");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
?>

    <script>
        $(document).ready(function(){
            setTimeout(function(){
                ym(100102212,'reachGoal','webit_404_error');
                return true;
            },2500)

       })
    </script>

    <div class="container page404">
        <style>.right_block.wide_, .right_block.wide_N{float:none !important;width:100% !important;}</style>
        <div class="row">
            <div class="col-lg-12">
                <p class="first">страница не найдена</p>
                <div class="bg-404">
                    <span>404</span>
                </div>
                <p class="bottom-text">Эта страница пока не соткана</p>
                <div class="button-404">
                    <a href="/" class="home-btn">На главную</a>
                    <a href="/catalog/" class="catalog-btn">В каталог</a>
                </div>
            </div>

        </div>
    </div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>