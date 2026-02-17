<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Контакты салона ковров «KULTURAKOVROV» — свяжитесь с нами для консультации, заказа или подбора идеального ковра для вашего интерьера. Адрес, телефон и e-mail доступны для удобной связи с нашими специалистами. Мы рады помочь вам выбрать качественный ковер ручной работы.");
$APPLICATION->SetPageProperty("title", "Контакты - салон ковров «KULTURAKOVROV»");
$APPLICATION->SetTitle("Контакты");
?><div class="container contact-page">
	<div class="row one-block">
		<div class="col-lg-12">
			<p>
				kulturakovrov на связи
			</p>
			<div class="title-line">
				<h1 class="title-catalog">контактная информация</h1>
 <a href="/o-kompanii/">о компании</a>
			</div>
		</div>
	</div>
	<div class="row two-block">
		<div class="col-lg-3 col-md-6">
			<div class="contact-block">
				<div class="contact-block__soc">
 <a target="_blank" href="https://t.me/KULTURAKOVROV_bot" class="contact-block__soc-tg">Телеграм</a> <a target="_blank" href="https://api.whatsapp.com/send/?phone=79167195666" class="contact-block__soc-wh">WhatsApp</a>
				</div>
				<div class="contact-block__line">
					<p>
						Телефон
					</p>
 <a href="tel:+74953203241">+7 (495) 320-32-41</a>
				</div>
				<div class="contact-block__line">
					<p>
						Электронная почта
					</p>
 <a target="_blank" href="mailTo:info@kulturakovrov.ru" class="footer-mail">info@kulturakovrov.ru</a>
				</div>
				<div class="contact-block__line">
					<p>
						Телеграм
					</p>
 <a target="_blank" href="https://t.me/KulturaKovrov" class="footer-mail">KulturaKovrov</a>
				</div>
				<div class="contact-block__line">
					<p>
						Адрес
					</p>
					<p>
						Москва, Кутузовский пр-т, 22
					</p>
					<div class="footer-view-map">
						Показать на карте
					</div>
				</div>
				<div class="contact-block__line">
					<p>
						Время работы
					</p>
					<p>
						10:00 - 20:00 (ежедневно)
					</p>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-md-6">
			<div class="button-parkovka" data-call="Запрос парковки" data-counter="form_parking">
				<div class="button-parkovka__img">
				</div>
				<div class="button-parkovka__right">
					<p>
						посетите шоурум
					</p>
					<p>
						запрос парковки
					</p>
				</div>
			</div>
			<div class="contacts-form">
				<div class="contacts-form__title">
					Бесплатная консультация
				</div>
				<div class="contacts-form__desc">
					Ответим на ваши вопросы и подберем лучшее решение для вас
				</div>
				<form id="call" action="#" method="POST">
 <input type="text" name="NAME" placeholder="Ваше имя"> <input type="text" name="PHONE" placeholder="Номер телефона" required=""> <input type="checkbox" id="politika-contacts" required=""> <label for="politika-contacts"> <span>Нажимая на кнопку "Перезвоните мне", я даю <a href="/soglasie-na-obrabotku-pd/" target="_blank">согласие на обработку моих персональных данных</a>, в соответствии с <a href="#" target="_blank">политикой</a></span> </label> <input type="hidden" name="data-counter" value="form_free"> <button type="submit">Перезвоните мне</button>
				</form>
			</div>
			<div class="d-md-none adress-info">
				<p>
					Юридический адрес: 121151, Город Москва, вн.тер.г. муниципальный округ Дорогомилово, пр-кт Кутузовский, д. 24, помещ. 1А/1А, ИНН: 9704075993, ОГРН: 1217700312488
				</p>
			</div>
		</div>
		<div class="col-lg-6 col-md-12">
			<div class="map-block">
				 <script data-skip-moving="true" type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A99766b88ffafb08c9611adccbf87247ec1cfe682f9199dab45ffd6569ddc89b5&amp;width=100%25&amp;height=553&amp;lang=ru_RU&amp;scroll=false"></script>
			</div>
		</div>
	</div>
	<div class="row adress-info d-none d-md-block">
		<div class="col-lg-7">
			<p>
				Юридический адрес: 121151, Город Москва, вн.тер.г. муниципальный округ Дорогомилово, пр-кт Кутузовский, д. 24, помещ. 1А/1А, ИНН: 9704075993, ОГРН: 1217700312488
			</p>
		</div>
	</div>
</div><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>