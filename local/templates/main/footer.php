<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>


<?

$notView = ['/','/partneram/','/o-kompanii/pressa-o-nas/','/o-kompanii/faq/','/o-kompanii/privilegii/','/kontakty/'];

$thisLink = $APPLICATION->GetCurPage(false);

if (!in_array($thisLink, $notView)): ?>
<section id="preimushestva">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <p class="before-title">Индивидуальный подход</p>
                <h2>Преимущества,<br>
                    созданные для вас</h2>
            </div>
        </div>
        <?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"preimushestva", 
	array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "N",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "11",
		"IBLOCK_TYPE" => "main",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "N",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "20",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(
			0 => "ATT_LINK",
			1 => "",
		),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N",
		"COMPONENT_TEMPLATE" => "preimushestva"
	),
	false
);?>

    </div>
</section>
<? endif; ?>

<?if($thisLink == '/kontakty/'):?>
<footer id="kontakty">
    <div class="container">
        <div class="row footer-bottom">
            <div class="col-lg-3">
                ООО "Культура ковров", все права защищены.
            </div>
            <div class="col-lg-6">
                <a href="/politika-pd/" target="_blank" class="footer-politica">Политика в отношении персональных данных</a>
                <a href="/СОУТ_сводная_ведомость_и_план_мероприятий.pdf" target="_blank" class="footer-sout">СОУТ</a>
            </div>
            <div class="col-lg-3">
                <a class="footer-developer" target="_blank" href="https://prokhorov.studio/">Разработка и продвижение: prokhorov.studio</a>
            </div>
        </div>
    </div>
</footer>
<?else:?>
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-2 d-none d-lg-block">
                    <a class="footer-logo" href="/"></a>
                    <p class="footer-logo__title">
                        Культура<br/>
                        Вдохновляет
                    </p>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="footer-value">
                        <div class="line-footer">
                            <p>Телефон</p>
                            <a href="tel:+74953203241" class="footer-phone">+7 (495) 320-32-41</a>
                        </div>

                        <div class="line-footer">
                            <p>Электронная почта</p>
                            <a href="mailTo:info3@kulturakovrov.ru" class="footer-mail">info@kulturakovrov.ru</a>
                        </div>

                        <div class="line-footer">
                            <p>Телеграм</p>
                            <a target="_blank" href="https://t.me/KulturaKovrov" class="footer-tlg">KulturaKovrov</a>
                        </div>

                        <div class="line-footer">
                            <p>Адрес</p>
                            <p class="footer-address">Москва, Кутузовский пр-т, 22</p>
                        </div>
                        <div class="footer-view-map"><span>Показать на карте</span></div>

                        <div class="line-footer">
                            <p>Время работы</p>
                            <p class="footer-address">10:00 - 20:00 (ежедневно)</p>
                        </div>

                        <div class="line-footer-soc">
                            <a onclick="ym(100102212,'reachGoal','inst-foot');return true;" target="_blank" href="https://www.instagram.com/kulturakovrov/" class="inst-footer"></a>
                            <a onclick="ym(100102212,'reachGoal','tg-foot');return true;" target="_blank" href="https://t.me/KulturaKovrov?start=roistat_760818" class="tg-footer"></a>
                            <a onclick="ym(100102212,'reachGoal','dzen-foot');return true;" target="_blank" href="https://dzen.ru/kulturakovrov" class="dzen-footer"></a>
                            <a onclick="ym(100102212,'reachGoal','vk-foot');return true;"  target="_blank" href="https://vk.com/kulturakovrov" class="vk-footer"></a>
                        </div>

                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <p class="footer-ur-address d-md-none">Юридический адрес: 121151, Город Москва, вн.тер.г. муниципальный округ Дорогомилово, пр-кт Кутузовский, д. 24, помещ. 1А/1А<br>
                        ИНН: 9704075993<br> ОГРН: 1217700312488</p>
                    <div class="footer-form">
                        <div class="footer-form__title">Бесплатная консультация</div>
                        <div class="footer-form__title-after">Ответим на ваши вопросы и подберем лучшее решение для вас</div>
                        <form id="call" class="footer-form__form">
                            <input type="text" name="NAME" placeholder="Ваше имя" required>
                            <input type="text" name="PHONE" placeholder="Номер телефона" required>
                            <input type="checkbox" id="politika" required>

                            <label for="politika">
                                <i></i>
                                <span>Нажимая на кнопку "Перезвоните мне", я даю <a href="/soglasie-na-obrabotku-pd/" target="_blank">согласие на обработку моих
                                    персональных данных</a>, в соответствии с <a href="/politika-pd/" target="_blank">политикой</a></span>

                            </label>
                            <input type="hidden" name="data-counter" value="form_free">
                            <button type="submit">перезвоните мне</button>
                        </form>
                    </div>
                    <p class="footer-ur-address d-none d-md-block">Юридический адрес: 121151, Город Москва, вн.тер.г. муниципальный округ Дорогомилово, пр-кт Кутузовский, д. 24, помещ. 1А/1А<br>
                        ИНН: 9704075993<br> ОГРН: 1217700312488</p>
                </div>

                <div class="col-xl-4 col-lg-4">
                    <div id="footer-map" class="footer-map">
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            setTimeout(function() {
                                var mapContainer = document.getElementById('footer-map');
                                var script = document.createElement('script');
                                script.type = 'text/javascript';
                                script.charset = 'utf-8';
                                script.async = true;
                                script.setAttribute('data-skip-moving', 'true');
                                script.src = 'https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A99766b88ffafb08c9611adccbf87247ec1cfe682f9199dab45ffd6569ddc89b5&amp;width=100%25&amp;height=553&amp;lang=ru_RU&amp;scroll=false';

                                mapContainer.appendChild(script);
                            }, 3000); // 3 секунды
                        });
                    </script>
                    <div class="col-md-12 d-lg-none">
                        <div class="logo-footer-mob">
                            <a class="footer-logo" href="/"></a>
                            <p class="footer-logo__title">
                                Культура<br/>
                                Вдохновляет
                            </p>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row footer-bottom">
                <div class="col-lg-3">
                    ООО "Культура ковров", все права защищены.
                </div>
                <div class="col-lg-6">
                    <a href="/politika-pd/" target="_blank" class="footer-politica">Политика в отношении персональных данных</a>
                    <a class="site-map" href="/karta-sayta/" target="_blank">Карта сайта</a>
                    <a href="/СОУТ_сводная_ведомость_и_план_мероприятий.pdf" target="_blank" class="footer-sout">СОУТ</a>
                </div>
                <div class="col-lg-3">
                    <a class="footer-developer" target="_blank" href="https://prokhorov.studio/">Разработка и продвижение: prokhorov.studio</a>
                </div>
            </div>
        </div>
    </footer>
<?endif;?>




<div class="modal-view">
    <div class="close-modal"></div>
    <div class="content"></div>
</div>
<div class="wrp-modal"></div>
    <div class="modal map">
        <div class="top-modal">
            <div class="title-modal">Мы на карте</div>
            <span class="close"></span>
        </div>

        <div class="content">
        </div>
    </div>
<div class="modal getPrice">
    <div class="top-modal">
        <div class="title-modal">Узнать цену</div>
        <span class="close"></span>
    </div>
    <div class="content">
        <div class="product-block">
            <div class="image"><img src="" alt=""></div>
            <div class="right-block-tovar">
                <p class="artikle">Артикул: <span></span></p>
                <p class="name">КОВЕР <span></span></p>
            </div>
        </div>
        <div class="form-block">
            <form id="call" action="#" method="post">
                <div class="input-line">
                    <input type="text" name="NAME" placeholder="Ваше имя" required>
                    <span class="required">*</span>
                </div>
                <div class="input-line">
                    <input type="text" name="PHONE" placeholder="Номер телефона" required>
                    <span class="required">*</span>
                </div>
                <input type="hidden" name="artKover" class="artKover">
                <input type="hidden" name="titleKover" class="titleKover">
                <div class="politika-line">
                    <input type="checkbox" id="politika" required>
                    <label for="politika">
                        Нажимая на кнопку "Запросить цену", я даю <a href="/soglasie-na-obrabotku-pd/" target="_blank">согласие на обработку моих
                            персональных данных</a>, в соответствии с <a href="/politika-pd/" target="_blank">политикой</a>
                    </label>

                </div>
                <input type="hidden" name="data-counter" value="form_free">
                <button type="submit" class="button-form">Запросить цену</button>

            </form>
        </div>
    </div>
</div>
<div class="modal call">
    <div class="top-modal">
        <div class="title-modal">Заказ звонка</div>
        <span class="close"></span>
    </div>
    <div class="content">

        <div class="form-block">
            <form id="call" action="#" method="post">
                <div class="input-line">
                    <input type="text" name="NAME" placeholder="Ваше имя" required>
                    <span class="required">*</span>
                </div>
                <div class="input-line">
                    <input type="text" name="PHONE" placeholder="Номер телефона" required>
                    <span class="required">*</span>
                </div>
                <input type="hidden" name="artKover" class="artKover">
                <input type="hidden" name="titleKover" class="titleKover">
                <div class="politika-line">
                    <input type="checkbox" id="politika" required>
                    <label for="politika">
                        Нажимая на кнопку "Отправить", я даю <a href="/soglasie-na-obrabotku-pd/" target="_blank">согласие на обработку моих
                            персональных данных</a>, в соответствии с <a href="/politika-pd/" target="_blank">политикой</a>
                    </label>

                </div>
                <input type="hidden" name="data-counter" value="form_free">
                <button type="submit" class="button-form">Отправить</button>

            </form>
        </div>
    </div>
</div>
<div class="modal-success">
    <div class="top-modal">
        <div class="title-modal">Спасибо что выбрали нас</div>
    </div>
    <div class="content">

        <div class="form-block">
            <p>Мы уже получили вашу заявку и скоро перезвоним</p>
        </div>
    </div>
</div>


<?php

$template = 'menu-mobile-new';

?>


<?$APPLICATION->IncludeComponent(
	"bitrix:menu",
    $template,
	[
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "left",
		"DELAY" => "N",
		"MAX_LEVEL" => "2",
		"MENU_CACHE_GET_VARS" => [
		],
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"ROOT_MENU_TYPE" => "mob",
		"USE_EXT" => "Y",
		"COMPONENT_TEMPLATE" => "menu-mobile"
	],
	false
);?>

<div class="cookie-modal">
    <span class="close"></span>
    <div>
        <p>Сайт использует файлы cookie и Яндекс. Метрика с целью аналитики и повышения удобства пользования сайтом. Продолжая использовать сайт, Вы даете ООО «КУЛЬТУРА КОВРОВ» согласие на  <a href="/politika-cookie/" target="_blank">обработку файлов cookies и пользовательских данных</a>. Если Вы не хотите, чтобы Ваши данные обрабатывались, просим отключить обработку файлов cookies и сбор пользовательских данных в настройках Вашего браузера или покинуть сайт.</p>
        <button>Согласен</button>
    </div>
</div>

<!-- Roistat Counter Start -->
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function(m,e,t,r,i,k,a){
        m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();
        for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
        k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)
    })(window, document,'script','https://mc.yandex.ru/metrika/tag.js', 'ym');

    ym(100102212, 'init', {webvisor:true, clickmap:true, ecommerce:"dataLayer", referrer: document.referrer, url: location.href, accurateTrackBounce:true, trackLinks:true});
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/100102212" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<script>
   (function(w, d, s, h, id) {
        w.roistatProjectId = id; w.roistatHost = h;
        var p = d.location.protocol == "https:" ? "https://" : "http://";
        var u = /^.*roistat_visit=[^;]+(.*)?$/.test(d.cookie) ? "/dist/module.js" : "/api/site/1.0/"+id+"/init?referrer="+encodeURIComponent(d.location.href);
        var js = d.createElement(s); js.charset="UTF-8"; js.async = 1; js.src = p+h+u; var js2 = d.getElementsByTagName(s)[0]; js2.parentNode.insertBefore(js, js2);
    })(window, document, 'script', 'cloud.roistat.com', '77c1bfbe9a917815edf0a2f59fe7a3b7');
</script>
<script>
    window.roistatVisitCallback = function (visitId) {

        window.addEventListener('b24:form:init', (event) => {
            let form = event.detail.object;
            form.setProperty("roistatID", visitId);
        });


        (function(w,d,u){
            var s=d.createElement('script');s.async=true;s.src=u+'?'+(Date.now()/60000|0);
            var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);
        })(window,document,'https://bitrix.kulturakovrov.ru/upload/crm/site_button/loader_2_8lrb3s.js');


        // 28.03.24 clickon custom repair popup , and cut in chunk "b24Custom" - start
        (function(w,d,u){
            var s=d.createElement('script');s.async=true;s.src=u+'?'+(Date.now()/180000|0);
            var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);
        })(window,document,'https://bitrix.kulturakovrov.ru/upload/crm/form/loader_9_tiuwmq.js');

        (function(w,d,u){
            var s=d.createElement('script');s.async=true;s.src=u+'?'+(Date.now()/180000|0);
            var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);
        })(window,document,'https://bitrix.kulturakovrov.ru/upload/crm/form/loader_10_ep7k8j.js');
        // end

        // 28.03.24 clickon custom repair popup , and cut in chunk "b24_custom_page_partner" - start
        (function (w, d, u) {
            var s = d.createElement('script');s.async = true;s.src = u + '?' + (Date.now() / 180000 | 0);
            var h = d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s, h);
        })(window, document, 'https://bitrix.kulturakovrov.ru/upload/crm/form/loader_11_q2jgzw.js');
        // end
        // 21.11.2024 clickon custom repair popup , and cut in chunk "b24_anons" - start
        (function(w,d,u){
            var s=d.createElement('script');s.async=true;s.src=u+'?'+(Date.now()/180000|0);
            var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);
        })(window,document,'https://bitrix.kulturakovrov.ru/upload/crm/form/loader_13_95hkmw.js');
        // end




        window.Bitrix24WidgetObject = window.Bitrix24WidgetObject || {};
        window.Bitrix24WidgetObject.handlers = {
            'form-init': function (form) {
                form.presets = {
                    'roistatID': visitId
                };
            }
        };
    }
</script>

<script>
    (function() {
        if (window.roistat !== undefined) {
            handler();
        } else {
            var pastCallback = typeof window.onRoistatAllModulesLoaded === "function" ? window.onRoistatAllModulesLoaded : null;
            window.onRoistatAllModulesLoaded = function () {
                if (pastCallback !== null) {
                    pastCallback();
                }
                handler();
            };
        }

        function handler() {
            function init() {
                appendMessageToLinks();

                var delays = [1000, 5000, 15000];
                setTimeout(function func(i) {
                    if (i === undefined) {
                        i = 0;
                    }
                    appendMessageToLinks();
                    i++;
                    if (typeof delays[i] !== 'undefined') {
                        setTimeout(func, delays[i], i);
                    }
                }, delays[0]);
            }

            function replaceQueryParam(url, param, value) {
                var explodedUrl = url.split('?');
                var baseUrl = explodedUrl[0] || '';
                var query = '?' + (explodedUrl[1] || '');
                var regex = new RegExp("([?;&])" + param + "[^&;]*[;&]?");
                var queryWithoutParameter = query.replace(regex, "$1").replace(/&$/, '');
                return baseUrl + (queryWithoutParameter.length > 2 ? queryWithoutParameter  + '&' : '?') + (value ? param + "=" + value : '');
            }

            function appendMessageToLinks() {
                var message = 'roistat_roistat_visit';
                var text    = message.replace(/roistat_visit/g, window.roistatGetCookie('roistat_visit'));
                text = encodeURI(text);
                var linkElements = document.querySelectorAll('[href*="//t.me"]');
                for (var elementKey in linkElements) {
                    if (linkElements.hasOwnProperty(elementKey)) {
                        var element = linkElements[elementKey];
                        element.href = replaceQueryParam(element.href, 'start', text);
                    }
                }
            }
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', init);
            } else {
                init();
            }
        };
    })();
</script>




<!-- BEGIN BITRIX24 WIDGET INTEGRATION WITH ROISTAT-->
<!-- BEGIN WHATSAPP INTEGRATION WITH ROISTAT -->


<script>
    (function() {

        if (window.roistat !== undefined) {
            handler();

        } else {
            var pastCallback = typeof window.onRoistatAllModulesLoaded === "function" ? window.onRoistatAllModulesLoaded : null;
            window.onRoistatAllModulesLoaded = function () {
                if (pastCallback !== null) {
                    pastCallback();
                }
                handler();


            };

        }


        function handler() {
            function init() {
                appendMessageToLinks();

                var delays = [1000, 5000, 15000];
                setTimeout(function func(i) {
                    if (i === undefined) {
                        i = 0;
                    }
                    appendMessageToLinks();
                    i++;
                    if (typeof delays[i] !== 'undefined') {
                        setTimeout(func, delays[i], i);
                    }
                }, delays[0]);
            }

            function replaceQueryParam(url, param, value) {
                var explodedUrl = url.split('?');
                var baseUrl = explodedUrl[0] || '';
                var query = '?' + (explodedUrl[1] || '');
                var regex = new RegExp("([?;&])" + param + "[^&;]*[;&]?");
                var queryWithoutParameter = query.replace(regex, "$1").replace(/&$/, '');
                return baseUrl + (queryWithoutParameter.length > 2 ? queryWithoutParameter  + '&' : '?') + (value ? param + "=" + value : '');
            }

            function appendMessageToLinks() {
                var text = 'Здравствуйте! Номер моего обращения: ' + window.roistatGetCookie('roistat_visit') + '\r\n'+ '(Убедительно просим Вас не стирать номер Вашего обращения. Это существенно упрощает обработку входящих сообщений.)';
                text = encodeURI(text);
                var linkElements = document.querySelectorAll('[href*="//wa.me"], [href*="//api.whatsapp.com/send"], [href*="//web.whatsapp.com/send"], [href^="whatsapp://send"],[href*="wa.clck.bar"]');
                for (var elementKey in linkElements) {
                    if (linkElements.hasOwnProperty(elementKey)) {
                        var element = linkElements[elementKey];
                        element.href = replaceQueryParam(element.href, 'text', text);
                    }
                }
            }
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', init);
            } else {
                init();
            }
        };
    })();
</script>
<!-- END WHATSAPP INTEGRATION WITH ROISTAT -->
<script>
    (function(w, d, s, h) {
        w.roistatLanguage = '';
        var p = d.location.protocol == "https:" ? "https://" : "http://";
        var u = "/static/marketplace/Bitrix24Widget/script.js";
        var js = d.createElement(s); js.async = 1; js.src = p+h+u; var js2 = d.getElementsByTagName(s)[0]; js2.parentNode.insertBefore(js, js2);
    })(window, document, 'script', 'cloud.roistat.com');
</script>
<!-- END BITRIX24 WIDGET INTEGRATION WITH ROISTAT -->
<!-- Roistat Counter End -->








<!-- UNTARGET.AI code -->
<!--<script>
    (function(s,o){s[o]=s[o]||function(){(s[o].d=s[o].d||[]).push(arguments);}})(window,"UntargetJS");
    UntargetJS('ts', 1*new Date());
    UntargetJS('id', '9c429');
</script>
<script async src="https://cdn.untarget.ai/untarget.min.o.js">
</script>-->
<!-- UNTARGET.AI code -->
</body>
</html>