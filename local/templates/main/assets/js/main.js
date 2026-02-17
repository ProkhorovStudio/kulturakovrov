
$(document).on('click', '.video-section .play', function() {
    var url = $(this).attr('data');
    $('.video-section video').attr('src',url).attr('autoplay', '').attr('controls', '');
    $('.video-section').addClass('video');
})




$(document).on('click', '.dop-filter .smart-filter_title', function(e) {
    const $next = $(this).next('.bx_filter_block_expanded'); // Только следующий блок фильтра
    
    // Закрываем все открытые блоки, кроме текущего
    $('.dop-filter .bx_filter_block_expanded.open').not($next).removeClass('open');
    
    // Переключаем текущий блок (открыть/закрыть)
    $next.toggleClass('open');
});
$(document).on('click', '.smart-filter_title-razmer', function(e) {
   $(this).toggleClass('open');
});




/*Фиксация шапки*/

document.addEventListener('scroll', function () {

        if ($(window).scrollTop() > 120) {
            // если больше 1000 → добавляем класс
            $('body').addClass('fixed');
        } else {
            // если меньше 1000 → удаляем класс
            $('body').removeClass('fixed');
        }


})
/**/

$(document).on('click', '.wish-list', function(e) {
    e.preventDefault();
    var id = $(this).attr('data-id');

    $(this).toggleClass('active');
    // Отправляем AJAX-запрос
    $.ajax({
        url: '/local/ajax/wishlist.php', // Путь к обработчику
        type: 'GET',
        data: { id: id },
        success: function(response) {
            if(response == 0){
                $('.header-right__wish span').hide();
                $('.header-right__wish').removeClass('active');
            }
            else{
                if(!$('.header-right__wish').hasClass('active')){
                    $('.header-right__wish').addClass('active')
                }
                $('.header-right__wish').html('<span>'+response+'</span>');
            }


        },
        error: function(xhr, status, error) {
            console.error("Ошибка:", error);
            
        }
    });
})
$(document).on('click', '.getPriceModal', function(e) {
    var name = $(this).attr('title');
    var img = $(this).attr('img');
    var artikle = $(this).attr('artikle');
    $('.modal.getPrice,.wrp-modal').addClass('show');
    $('.modal.getPrice .product-block img').attr('src',img);
    $('.modal.getPrice .product-block .artikle > span').text(artikle);
    $('.modal.getPrice .product-block .name > span').text(name);
    $('.modal.getPrice .artKover').val(artikle);
    $('.modal.getPrice .titleKover').val(name);

})

$(document).on('click', '*[data-call]', function(e) {
    var title = $(this).attr('data-call');
    var yainfo = $(this).attr('data-counter');

    var name = $(this).attr('title');
    var img = $(this).attr('img');
    var artikle = $(this).attr('artikle');

    $('.modal.call .artKover').val(artikle);
    $('.modal.call .titleKover').val(name);



    if(yainfo){
        $('.modal input[name="data-counter"]').val(yainfo);
    }
    if(!title){
        title = 'Заказать звонок';
    }

    $('.modal.call .title-modal').text(title);

    $('.modal.call,.wrp-modal').addClass('show');
})
$(document).on('click', '.cookie-modal .close', function(e) {
   $('.cookie-modal').removeClass('show');
})

$(document).on('click', '.cookie-modal button', function(e) {
    /*Нужно куку записать*/
    $('.cookie-modal').removeClass('show');
    $.cookie('cookie-modal', true, {
        expires: 30,
        path: '/',
    });
})
document.addEventListener('click', function(e) {
    if (e.target.closest('.basket-btn-checkout')) {
        e.preventDefault();
        console.log('Клик на кнопке!', e.target);
    }
});

$(document).ready(function(){


    $('.button-more-desc').click(function(){
        $('html, body').animate({ scrollTop: $('.description-block').offset().top - 140 }, 'slow');
    })


    if (!$.cookie('cookie-modal')) {
        $('.cookie-modal').addClass('show');
    }

    $('form#call').submit(function(e){
        e.preventDefault();
        var dataForm = $(this).serialize();

        var yaCounter = $('input[name="data-counter"]',this).val();

        $.ajax({
            url: '/local/ajax/form.php', // Путь к обработчику
            type: 'GET',
            data: dataForm,
            success: function(response) {
                if(response == "200"){

                    if(yaCounter){
                        ym(100102212,'reachGoal', yaCounter)
                    }

                    $('.modal').removeClass('show');
                    $('.modal-success').addClass('show');
                    if(!$('.wrp-modal').hasClass('show')){
                        $('.wrp-modal').addClass('show');
                    }
                    setTimeout(function(){
                        location.reload();
                    }, 2000);
                }
                else{
                    alert("при отправке произошла ошибка, обратитесь к администратору сайта по телефону");
                }

            },
            error: function(xhr, status, error) {
                console.error("Ошибка:", error);

            }
        });

    })
})


$(document).on('click', '.dop-filter input', function() {

    // Получаем ID текущего чекбокса
    var checkboxId = $(this).attr('id');

    // Формируем ID соответствующего чекбокса в боковом фильтре
    var sideCheckboxId = checkboxId.replace('topFilter_', 'arrFilter_');

    // Находим соответствующий чекбокс в боковом фильтре
    var sideCheckbox = $('#' + sideCheckboxId);

    // Если чекбокс найден, синхронизируем состояние
    if (sideCheckbox.length) {
        // Устанавливаем такое же состояние checked
        var result = sideCheckbox.click();
    }

})

$(document).on('click', '.inCardNotPrice', function(e) {

    var yainfo = $(this).attr('data-counter');
    if(yainfo){
        $('.modal input[name="data-counter"]').val(yainfo);
    }

    var name = $(this).attr('title');
    var img = $(this).attr('img');
    var artikle = $(this).attr('artikle');
    $('.modal.getPrice,.wrp-modal').addClass('show');
    $('.modal.getPrice .product-block img').attr('src',img);
    $('.modal.getPrice .product-block .artikle > span').text(artikle);
    $('.modal.getPrice .product-block .name > span').text(name);
    $('.modal.getPrice .artKover').val(artikle);
    $('.modal.getPrice .titleKover').val(name);

})


$(document).on('click', '.view-button', function(e) {
    e.preventDefault();

    var productId = $(this).attr('data-id');

    // Отправляем AJAX-запрос
    $.ajax({
        url: '/local/ajax/view.php', // Путь к обработчику
        type: 'POST',
        data: { id: productId },
        dataType: 'html', // Ожидаем HTML-ответ (разметку карточки товара)
        beforeSend: function() {
            // Показываем лоадер (если нужно)
            $('.modal-view .content').html('<div class="loader">Загрузка...</div>');
        },
        success: function(response) {
            if (response) {
                // Вставляем HTML в модальное окно и открываем его
                $('.modal-view .content').html(response);
                $('.modal-view').fadeIn();

                $('.slider-view').slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    fade: true,
                    cssEase: 'linear',
                    draggable: false
                });

                $('.dots-other-images').slick({
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    asNavFor: '.slider-view',
                    draggable: false
                });
                $('.dots-other-images .slick-slide[data-slick-index = "0"]').addClass('point');

                $('.wrp-modal').addClass('show');

            }
        },
        error: function(xhr, status, error) {
            console.error("Ошибка:", error);
            $('.modal-view .content').html('<div class="error">Произошла ошибка при загрузке товара.</div>');
        }
    });
});
$(document).on('click', '.modal-view .close-modal', function(e) {
    $('.modal-view').fadeOut();
    $('.wrp-modal').removeClass('show');
    $('.modal-view .content').html('');
});

$(document).on('click', '.dots-other-images .slick-slide', function(e) {
    $sliderId = $(this).attr('data-slick-index');
    $('.dots-other-images .slick-slide').removeClass('point');
    $(this).addClass('point');
    $('.slider-view').slick('slickGoTo', $sliderId);
})


$(document).on('click', '.sort-line .this-sort', function() {
    $('.select-block').toggleClass('open');  
})



$(document).on('click', '.sort-line .select-block div', function(event) {
    event.preventDefault();
    var sortValue = $(this).attr('name');
    var sortType =  $(this).attr('type');

    $.ajax({
        url: '/local/ajax/sort.php',
        type: 'POST',
        data: {sortten: sortValue, type:sortType},
        dataType: 'json', // Ожидаем JSON-ответ
        success: function(response) {
            console.log('Server response:', response);
            if (response.status === 'success') {
                location.reload();
            }
        },
        error: function(xhr, status, error) {
            console.log("Error:", status, error);
            console.log("Response:", xhr.responseText);
        }
    });
});


$(document).on('click', '.modal-view .addCart', function(event) {
    event.preventDefault();
    var container = $(this);
    var id = $(this).attr('ids');
    $.ajax({
        url: '/local/ajax/cart.php',
        type: 'POST',
        data: {id: id},
        dataType: 'json', // Ожидаем JSON-ответ
        success: function(response) {
            container.next().show();
            container.remove();
            var count = response;

            ym(100102212,'reachGoal','webit_add_to_fitting');
            if(!$('.bx-basket-block').hasClass('active')){
                $('.bx-basket-block').addClass('active');
            }

            $('.bx-basket-block .count-cart').text(count);

        },
        error: function(xhr, status, error) {
            console.log("Error:", status, error);
            console.log("Response:", xhr.responseText);
        }
    });
})

$(document).on('click', '.detail-cart .addCart', function(event) {
    $(this).next().show();
    $(this).remove();
})



/*Скрытие/раскрытие значений параметров фильтра*/
$(document).on('click', '.smart-filter_checkbox .show-all', function(e) {
    e.preventDefault();
    const $container = $(this).closest('.smart-filter_checkbox');

    const $button = $(this);
    const isExpanded = $button.text().trim() === "Скрыть";

    if (!isExpanded) {
        // Показываем все скрытые элементы
        $container.find('input[type="checkbox"].hide, label.hide').removeClass('hide');
        $button.text('Скрыть');
    } else {
        // Скрываем все элементы, кроме первых 10 пар (чекбокс+лейбл)
        $container.find('input[type="checkbox"], label').each(function(index) {
            // Индексы начинаются с 0, скрываем все после 19 (10 пар = 20 элементов)
            if (index >= 20) {
                $(this).addClass('hide');
            }
        });
        $button.text('Раскрыть');
    }
});
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('title-search-input'); // ID инпута
    const searchContainer = searchInput.closest('#title-search-result'); // Контейнер поиска
    const searchResults = document.querySelector('.title-search-result'); // Блок результатов

    if (searchResults && searchContainer) {
        // Перемещаем результаты в контейнер поиска
        searchContainer.appendChild(searchResults);

        // Настраиваем стили (если нужно)
        searchResults.style.position = 'absolute';
        searchResults.style.top = '100%';
        searchResults.style.left = '0';
        searchResults.style.width = '100%';
        searchResults.style.zIndex = '1000';
    }
});
$(document).ready(function() {

    $('.cn_faq_list .cn_faq_el').each(function(){
        $(this).click(function(){
            $(this).toggleClass('show');
            if($(this).hasClass('show')){
                $('.cn_faq_el_info',this).slideDown();
            }
            else{
                $('.cn_faq_el_info',this).slideUp();
            }
        })
    })

    $('.mobile-sort').click(function(){
        $('.sort-line .select-block.mobile').toggleClass('open');
    })

    $('.top-mobile-filter__close').click(function(){
        $('.mobile_filter_panel.mobile').removeClass('open');
    })

    $('.mobile_filter_button').click(function(){
        $('.mobile_filter_panel.mobile').addClass('open');
    })

    $('.burger-menu').click(function (){
        $('.mobile-menu').addClass('open');
    })
    $('.mobile-menu .close').click(function (){
        $('.mobile-menu').removeClass('open');
    })

    $('.header-right__search-icon').click(function(){
        $('.header-right__search-form').addClass('show');
    })

    $('.header-right__search-form .close-search').click(function(){
        $('.header-right__search-form').removeClass('show');
    })

    $('.slider-logo').slick({
        dots:false,
        slidesToShow: 3,
        slidesToScroll: 1,
    })

    $('.slider-projects').slick({
        slidesToShow: 1, // 1 полный + 80% второго
        slidesToScroll: 1,
        infinite: true,
        arrows: true,
        dots: true,
    })

    if($('body').width() < 768){
        $('.slider-element-mobile').slick({
            slidesToShow: 6,
            arrows:false,
            swipe: false,
            allowTouchMove: false,

            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 1,
                        arrows:false,
                        swipe: false,
                        allowTouchMove: false,
                    }
                },
                {
                    breakpoint: 460,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 1,
                        arrows:false,
                        swipe: false,
                        allowTouchMove: false,
                    }
                }
            ]
        })

        $(document).on('click', '.slider-element-mobile .slick-slide', function(e) {
            $sliderId = $(this).attr('data-slick-index');
            $('.slider-element-mobile .slick-slide').removeClass('point');
            $(this).addClass('point');
            $('.first-element-slider').slick('slickGoTo', $sliderId);
        })

        $('.first-element-slider').slick({
            slidesToShow: 1,
            fade: true,
            cssEase: 'linear',
            draggable: false,
            arrows:false
        })

    }

    $('.slider-element-mobile .slick-slide[data-slick-index = "0"]').addClass('point');

});

$(document).on('click', '.product-item-container button.buybtn', function() {
    var $container = $(this).closest('.product-item-button-container');
    $(this).remove();
    $container.find('.inCart').addClass('show');
});

$(document).on('click', '.footer-view-map span', function() {
    $('.modal.map,.wrp-modal').addClass('show');

    var $content = $('.modal.map .content');

    // Очищаем и добавляем контейнер для карты
    $content.empty().html('<div id="map-container" style="width:100%;height:400px;"></div>');
    // Создаем и добавляем скрипт через append
    var script = document.createElement('script');
    script.type = 'text/javascript';
    script.charset = 'utf-8';
    script.src = 'https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A99766b88ffafb08c9611adccbf87247ec1cfe682f9199dab45ffd6569ddc89b5&amp;width=100%25&amp;height=400&amp;lang=ru_RU&amp;scroll=false';

    $('.modal.map .content #map-container')[0].appendChild(script);
});

$(document).on('click', '.modal .close', function() {
    $('.modal,.wrp-modal').removeClass('show');
    $('.modal form').trigger('reset');
    $('.modal input[name="data-counter"]').val('');
})





