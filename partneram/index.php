<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Партнерская программа");

$APPLICATION->SetTitle("Партнерская программа");
?>


    <div class="container partner-page">
	<div class="row one-block">
		<div class="col-lg-12">
			<p>
				 Приглашаем вас к сотрудничеству
			</p>
			<div class="title-line">
				<h1 class="title-catalog">Партнерская программа KulturaKovrov</h1>
 <a href="/o-kompanii/uslugi/">услуги компании</a>
			</div>
			<div class="after-title-block">
				 Приглашаем к сотрудничеству архитекторов, комплектаторов, декораторов, интерьерных и текстильных дизайнеров.
			</div>
		</div>
	</div>
	<div class="row two-block">
		<div class="col-lg-4">

			<div class="desc-block">
				 Мы предлагаем партнерам специальные условия для удобной демонстрации наших изделий у Ваших клиентов, а также все необходимые для этого презентационные материалы и доступ к самой актуальной версии каталога с фотографиями в высоком качестве.
			</div>
			<div class="snoska-block">
				 Мы предлагаем индивидуальные условия для каждого партнера
			</div>
			<div id="load_predlogenie" onclick="triggerDownload('/exclusive-offer-KULTURAKOVROV.pdf');roistat.event.send('load_predlogenie');ym(100102212,'reachGoal','presentation');" class="presentation-download">
				 Скачать презентацию
			</div>
		</div>
		<div class="col-lg-8">
			<div class="two-block__bg">
 <img alt="Мы предлагаем индивидуальные условия для каждого партнера" src="/local/templates/main/assets/images/partners-bg.jpg">
			</div>
			<div class="after-bg">
				 Мы верим, что партнерство — это взаимовыгодное<br>
				 соглашение, и мы готовы рекомендовать и презентовать<br>
				 нашим клиентам и дизайнерам Ваши услуги или салон,<br>
				 а также разместить у себя Ваши рекламные материалы.
			</div>
		</div>
	</div>
	<div class="row three-block">
		<div class="col-lg-12">
			<div class="title-top">
				<h2>Преимущества<br>
				 партнерства с нами</h2>
 <div class="more-catalog" data-call="Получить каталог" data-counter="form_ business">Получить каталог</div>
			</div>
		</div>
	</div>
	<div class="row three-block__items">
		<div class="col-lg-3 col-md-6 col-sm-6">
			<div class="three-block__items-item one">
 <img alt="Широкий ассортимент" src="/local/templates/main/assets/images/pr1.jpg">
				<div class="three-block__items-title">
					 Широкий ассортимент
				</div>
				<div class="three-block__items-desc">
					 Некоторые модели мы предлагаем эксклюзивно, что позволяет нам предоставлять каталог ковров, включающий актуальные новинки и трендовые изделия.
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-md-6 col-sm-6">
			<div class="three-block__items-item two">
 <img alt="С заботой о Вас" src="/local/templates/main/assets/images/pr2.jpg">
				<div class="three-block__items-title">
					 С заботой о Вас
				</div>
				<div class="three-block__items-desc">
					 Мы предлагаем нашим партнерам эксклюзивный сервис подборки и примерки ковра в интерьере. Чтобы Вы могли подобрать идеальный ковер для Вашего проекта как и когда Вам удобно.
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-md-6 col-sm-6">
			<div class="three-block__items-item three">
 <img alt="Рекламные материалы" src="/local/templates/main/assets/images/pr3.jpg">
				<div class="three-block__items-title">
					 Рекламные материалы
				</div>
				<div class="three-block__items-desc">
					 Вы можете разместить ваши рекламные материалы у нас в салоне, чтобы клиенты могли узнать о Вас.
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-md-6 col-sm-6">
			<div class="three-block__items-item four">
 <img alt="Постпродажное обслуживание" src="/local/templates/main/assets/images/pr4.jpg">
				<div class="three-block__items-title">
					 Постпродажное<br>
					 обслуживание
				</div>
				<div class="three-block__items-desc">
					 На все наши ковры распространяется гарантия, а также, при необходимости, ваши клиенты могут воспользоваться услугами чистки и реставрации.
				</div>
			</div>
		</div>
	</div>
</div>
    <script>
        function triggerDownload(fileName) {
            var element = document.createElement('a');
            element.setAttribute('href', fileName);
            element.setAttribute('download', fileName);
            element.style.display = 'none';
            document.body.appendChild(element);
            // Происходит клик, словно совершил его сам программирующий ниндзя
            element.click();
            document.body.removeChild(element);
        }
    </script><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>