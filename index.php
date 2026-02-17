<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
$APPLICATION->SetPageProperty("keywords", "KULTURAKOVROV, салон, магазин, интернет, ковер, купить, заказать, изготовить, ручная, работа, натуральный, материал, выбор, москва, примерка, бесплатно, премиум класс, уникальные, модели, возврат, гарантия.");
$APPLICATION->SetPageProperty("description", "Магазин - салон премиум класса KULTURAKOVROV предлагает широкий выбор натуральных ковров ручной работы в Москве. У нас вы можете купить как готовый ковер, так и заказать изготовление ковра по индивидуальному эскизу. Бесплатные примерки, более 15 тыс. уникальных моделей, 100% гарантия возврата средств.");
$APPLICATION->SetPageProperty("title", "Салон ковров ручной работы KULTURAKOVROV в Москве");
$APPLICATION->SetTitle("Главная");?><script>
        /*Второй слайдер на главной*/

        if($('body').width() > 768){
        document.addEventListener('DOMContentLoaded', function() {
            var $slider_two = $('.slider-float').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
                dots: false,
                speed: 200,
                fade: true,
                cssEase: 'linear',
                infinite: false,
                draggable: false
            });

            var duration = 4000;

            var slideCount = $slider_two.find('.slick-slide:not(.slick-cloned)').length;
            var currentSlide = 0;
            var windowHeight = $(window).height();
            var sliderHeight = windowHeight * slideCount;

            const sectionController = new ScrollMagic.Controller();
            const section = document.querySelector('section.sthree');

            // 1. Фиксация секции (как было)
            new ScrollMagic.Scene({
                triggerElement: 'section.sthree',
                triggerHook: 0,
                duration: duration
            })
                .setPin('section.sthree')
                .addTo(sectionController);

            // 2. Анимация картинок (исправленная версия)
            new ScrollMagic.Scene({
                triggerElement: 'section.sthree',
                triggerHook: 0,
                duration: duration,
                offset: 1
            })
                .on('progress', function(e) {
                    var slideProgress = e.progress * slideCount;
                    var newSlide = Math.min(slideCount - 1, Math.floor(slideProgress));
                    var progressInSlide = slideProgress - newSlide;

                    // Переключение слайда (как было)
                    if (newSlide !== currentSlide) {
                        currentSlide = newSlide;
                        $slider_two.slick('slickGoTo', currentSlide);
                    }

                    // Находим элементы В АКТИВНОМ СЛАЙДЕ (ключевое изменение!)
                    const activeSlide = $slider_two.find('.slick-slide.slick-active').get(0);
                    const images = {
                        one: activeSlide.querySelector('.image-one'),
                        two: activeSlide.querySelector('.image-two'),
                        three: activeSlide.querySelector('.image-three')
                    };

                    // Анимация для ЛЮБОГО слайда (работает во всех)
                    if (images.one && images.two && images.three) {
                        gsap.to(images.one, { x: progressInSlide * 200, ease: 'power1.out' });
                        gsap.to(images.two, { x: progressInSlide * 280, ease: 'power1.out' });
                        gsap.to(images.three, { x: progressInSlide * 320, ease: 'power1.out' });
                    }
                })
                .addTo(sectionController);



        });
        }
        else{
            $(document).ready(function(){
                $('.slider-float').slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                    dots: false,
                    speed: 300,
                    infinite: true

                });
                $('.slider-block-mobile').slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                    dots: false,
                    speed: 100,
                    fade: true,
                    cssEase: 'linear',
                    infinite: false,
                    infinite: false,
                    draggable: false
                });
                $('.slider-dots-two div').click(function(){
                    $('.slider-dots-two div').removeClass('active');
                    $(this).addClass('active');
                    var sliderNumber = $(this).attr('data-id');
                    $('.slider-block-mobile').slick('slickGoTo', sliderNumber);
                })
            })
        }
    </script> <section id="slider-home">
<?/*$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"slider-home", 
	[
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"COMPONENT_TEMPLATE" => "slider-home",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => [
			0 => "",
			1 => "",
		],
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "6",
		"IBLOCK_TYPE" => "main",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "5",
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
		"PROPERTY_CODE" => [
			0 => "ATT_LINK",
			1 => "",
		],
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
		"STRICT_SECTION_CHECK" => "N"
	],
	false
);*/?>



    <?$APPLICATION->IncludeComponent(
        "bitrix:news.list",
        "slider-home-new",
        [
            "ACTIVE_DATE_FORMAT" => "d.m.Y",
            "ADD_SECTIONS_CHAIN" => "N",
            "AJAX_MODE" => "N",
            "AJAX_OPTION_ADDITIONAL" => "",
            "AJAX_OPTION_HISTORY" => "N",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "Y",
            "CACHE_FILTER" => "N",
            "CACHE_GROUPS" => "Y",
            "CACHE_TIME" => "36000000",
            "CACHE_TYPE" => "A",
            "CHECK_DATES" => "Y",
            "COMPONENT_TEMPLATE" => "slider-home",
            "DETAIL_URL" => "",
            "DISPLAY_BOTTOM_PAGER" => "Y",
            "DISPLAY_DATE" => "Y",
            "DISPLAY_NAME" => "Y",
            "DISPLAY_PICTURE" => "Y",
            "DISPLAY_PREVIEW_TEXT" => "Y",
            "DISPLAY_TOP_PAGER" => "N",
            "FIELD_CODE" => [
                0 => "",
                1 => "",
            ],
            "FILTER_NAME" => "",
            "HIDE_LINK_WHEN_NO_DETAIL" => "N",
            "IBLOCK_ID" => "6",
            "IBLOCK_TYPE" => "main",
            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
            "INCLUDE_SUBSECTIONS" => "Y",
            "MESSAGE_404" => "",
            "NEWS_COUNT" => "5",
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
            "PROPERTY_CODE" => [
                0 => "ATT_LINK",
                1 => "",
            ],
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
            "STRICT_SECTION_CHECK" => "N"
        ],
        false
    );?>



</section>
    <!--<section id="one">
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<p class="before-title">
				 <?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"AREA_FILE_SHOW" => "file",
		"AREA_FILE_SUFFIX" => "inc",
		"EDIT_TEMPLATE" => "",
		"PATH" => "/include/index/one/before-title.php"
	)
);?>
			</p>
			<h2><?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"AREA_FILE_SHOW" => "file",
		"AREA_FILE_SUFFIX" => "inc",
		"EDIT_TEMPLATE" => "",
		"PATH" => "/include/index/one/title.php"
	)
);?></h2>
		</div>
	</div>
	<div class="row">
		<div class="offset-xl-6 offset-lg-4 col-xl-3 col-lg-4">
			<p class="one-description">
				 <?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"AREA_FILE_SHOW" => "file",
		"AREA_FILE_SUFFIX" => "inc",
		"EDIT_TEMPLATE" => "",
		"PATH" => "/include/index/one/desc-one.php"
	)
);?>
			</p>
		</div>
		<div class="col-xl-3 col-lg-4">
			<p class="one-description">
				 <?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"AREA_FILE_SHOW" => "file",
		"AREA_FILE_SUFFIX" => "inc",
		"EDIT_TEMPLATE" => "",
		"PATH" => "/include/index/one/desc-two.php"
	)
);?>
			</p>
		</div>
	</div>
</div>
 </section> -->
<?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"type-float", 
	[
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"COMPONENT_TEMPLATE" => "type-float",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => [
			0 => "",
			1 => "ATT_IMAGE_1",
			2 => "ATT_IMAGE_2",
			3 => "ATT_IMAGE_3",
			4 => "",
		],
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "12",
		"IBLOCK_TYPE" => "main",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "10",
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
		"PROPERTY_CODE" => [
			0 => "ATT_LINK",
			1 => "",
		],
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
		"STRICT_SECTION_CHECK" => "N"
	],
	false
);?>

    <?$APPLICATION->IncludeComponent(
        "bitrix:news.list",
        "dinamic-slider-new",
        [
            "ACTIVE_DATE_FORMAT" => "d.m.Y",
            "ADD_SECTIONS_CHAIN" => "N",
            "AJAX_MODE" => "N",
            "AJAX_OPTION_ADDITIONAL" => "",
            "AJAX_OPTION_HISTORY" => "N",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "Y",
            "CACHE_FILTER" => "N",
            "CACHE_GROUPS" => "Y",
            "CACHE_TIME" => "36000000",
            "CACHE_TYPE" => "A",
            "CHECK_DATES" => "Y",
            "COMPONENT_TEMPLATE" => "dinamic-slider",
            "DETAIL_URL" => "",
            "DISPLAY_BOTTOM_PAGER" => "Y",
            "DISPLAY_DATE" => "Y",
            "DISPLAY_NAME" => "Y",
            "DISPLAY_PICTURE" => "Y",
            "DISPLAY_PREVIEW_TEXT" => "Y",
            "DISPLAY_TOP_PAGER" => "N",
            "FIELD_CODE" => [
                0 => "",
                1 => "",
            ],
            "FILTER_NAME" => "",
            "HIDE_LINK_WHEN_NO_DETAIL" => "N",
            "IBLOCK_ID" => "7",
            "IBLOCK_TYPE" => "main",
            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
            "INCLUDE_SUBSECTIONS" => "Y",
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
            "PROPERTY_CODE" => [
                0 => "ATT_TITLE",
                1 => "ATT_LINK",
                2 => "",
            ],
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
            "STRICT_SECTION_CHECK" => "N"
        ],
        false
    );?>

    <section id="five">
<div class="container">
	<div class="row">
		<div class="col-lg-6">
			<p class="before-title">
				 От замеров до постпродажной поддержки
			</p>
			<h2>Лучший сервис для вас —<br class="d-none d-md-block">
			 забота на всех этапах</h2>
		</div>
		<div class="col-lg-6">
			<p class="desc-block-title">
				 Берем на себя все заботы: точно замерим пространство, привезем ковры для примерки,&nbsp;доставим в любую точку мира и останемся на связи даже после покупки. Ваш комфорт — наша главная задача.
			</p>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6">
			<div class="bg-block">
				<div class="bg-block__title">
					 Бесплатная консультация эксперта
				</div>
				<div class="bg-block__desc">
					 Наши эксперты помогут подобрать тот самый ковер, который подчеркнет индивидуальность Вашего интерьера и станет его лаконичным дополнением.
				</div>
				<div class="bg-block__btn" data-call="Получить консультацию">
					 получить консультацию
				</div>
			</div>
		</div>
		<div class="col-lg-3">
			<div class="desc-block">
				<p>
					 Выезд на замеры
				</p>
				<p>
					 Специалист приедет к вам, чтобы всё точно измерить и подобрать идеальное решение.
				</p></div>
				<div class="desc-block">
					<p>
						 Бесплатная примерка
					</p>
					<p>
						 Примерка в день обращения. Привезем большой выбор ковров, и вы сможете выбрать идеальный вариант.
					</p>
				</div>
				<div class="desc-block">
					<p>
						 Доставка по России
					</p>
					<p>
						 Осуществляем доставку в любой регион России. А также по всему миру.
					</p>
				</div>
				<div class="desc-block">
					<p>
						 Сервис после покупки
					</p>
					<p>
						 Все ковры имеют гарантию, а при необходимости вы можете воспользоваться услугами чистки, реставрации и хранением ковров.
					</p>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="bg-block-two">
				</div>
			</div>
		</div>
	</div>
</div>
</section>

<section id="project">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <p class="before-title">
                    Воплощенные идеи говорят сами за себя
                </p>
                <h2>
                    реализованные<br>
                    проекты
                </h2>
            </div>
            <div class="col-lg-6">
                <div class="right-title">Наши коллекции, от классики до современности, позволяют найти идеальный ковер для любого интерьера, а высококачественные натуральные материалы гарантируют долговечность и элегантность.</div>
            </div>
        </div>
        <?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"project-list-index", 
	[
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "N",
		"DISPLAY_NAME" => "N",
		"DISPLAY_PICTURE" => "N",
		"DISPLAY_PREVIEW_TEXT" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => [
			0 => "",
			1 => "",
		],
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "16",
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
		"PROPERTY_CODE" => [
			0 => "",
			1 => "",
		],
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
		"STRICT_SECTION_CHECK" => "N"
	],
	false
);?>
        <div class="row">
            <div class="col-lg-12">
                <div class="project-slider">
                    <div class="project-slider__item"></div>
                </div>
            </div>
        </div>
    </div>
</section>

    <section id="six">
<div class="container">
	<div class="row">
		<div class="col-lg-6 ">
			<h2>Почему нам доверяют<br class="d-none d-md-block">
			 с 2009 года</h2>
		</div>
		<div class="col-lg-6">
			<p class="desc-block-title">
				 Искусство в каждом шаге - не просто фраза, это философия, отражающая уникальность и красоту каждого изделия. Мы обеспечиваем индивидуальный подход и уникальные условия для каждого клиента.
			</p>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-3 col-6">
			<div class="desc-item one">
				<div class="image">
				</div>
                <p>
                    Более 15 тысяч<br class="d-none d-md-block">
                    уникальных изделий
                </p>

			</div>
		</div>
        <div class="col-lg-3 col-6">
            <div class="desc-item four">
                <div class="image">
                </div>
                <p>
                    Более 2000 реализованных <br class="d-none d-md-block">
                    проектов
                </p>
            </div>
        </div>

		<div class="col-lg-3 col-6">
			<div class="desc-item three">
				<div class="image">
				</div>
				<p>
					 Примерка<br class="d-none d-md-block">
					 с премиум-сервисом
				</p>
			</div>
		</div>
        <div class="col-lg-3 col-6">
            <div class="desc-item two">
                <div class="image">
                </div>
                <p>
                    Доставка<br class="d-none d-md-block">
                    точно в срок
                </p>
            </div>
        </div>
	</div>
</div>
 </section> <br><?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');
?>