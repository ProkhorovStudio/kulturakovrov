var slideshowDuration = 4000;
var slideshow=$('.main-content .slideshow');

function slideshowSwitch(slideshow, index, auto) {
    if (slideshow.data('wait')) return;

    var slides = slideshow.find('.slide');
    var pages = slideshow.find('.pagination');
    var activeSlide = slides.filter('.is-active');
    var activeSlideImage = activeSlide.find('.image-container');
    var newSlide = slides.eq(index);
    var newSlideImage = newSlide.find('.image-container');
    var newSlideContent = newSlide.find('.slide-content');
    var newSlideElements = newSlide.find('.caption > *');

    if (newSlide.is(activeSlide)) return;

    newSlide.addClass('is-new');
    var timeout = slideshow.data('timeout');
    clearTimeout(timeout);
    slideshow.data('wait', true);
    var transition = slideshow.attr('data-transition');

    if (transition == 'fade') {
        // ... (ваш код для fade-анимации) ...
    } else {
        newSlide.css({
            display: 'block',
            width: 0,
            left: 0,
            right: 'auto',
            zIndex: 2
        });

        newSlideImage.css({
            width: slideshow.width(),
            left: -slideshow.width() / 8,
            right: 'auto'
        });

        newSlideContent.css({
            width: slideshow.width(),
            left: 'auto',
            right: 0
        });

        activeSlideImage.css({
            left: 0,
            right: 'auto'
        });

        TweenMax.to(activeSlideImage, 1, {
            left: -slideshow.width() / 4,
            ease: Power3.easeInOut
        });

        TweenMax.to(newSlide, 1, {
            width: slideshow.width(),
            ease: Power3.easeInOut
        });

        TweenMax.to(newSlideImage, 1, {
            left: 0,
            ease: Power3.easeInOut
        });

        if (newSlideElements.length) {
            TweenMax.staggerFromTo(newSlideElements, 0.8,
                { alpha: 0, y: 60 },
                { alpha: 1, y: 0, ease: Power3.easeOut, force3D: true, delay: 0.6 },
                0.1,
                onAnimationComplete
            );
        } else {
            onAnimationComplete();
        }
    }

    function onAnimationComplete() {
        newSlide.addClass('is-active').removeClass('is-new')
            .removeAttr('style');

        activeSlide.removeClass('is-active')
            .removeAttr('style');

        newSlideImage.removeAttr('style');
        activeSlideImage.removeAttr('style');
        newSlideContent.removeAttr('style');

        slideshow.find('.pagination').trigger('check');
        slideshow.data('wait', false);

        if (auto) {
            slideshow.data('timeout', setTimeout(function() {
                slideshowNext(slideshow, false, true);
            }, slideshowDuration));
        }
    }
}

function slideshowNext(slideshow, previous, auto) {
    if (slideshow.data('wait')) return;

    var slides = slideshow.find('.slide');
    var activeSlide = slides.filter('.is-active');
    var newSlide = previous ?
        activeSlide.prev('.slide').length ? activeSlide.prev('.slide') : slides.last() :
        activeSlide.next('.slide').length ? activeSlide.next('.slide') : slides.first();

    slideshowSwitch(slideshow, newSlide.index(), auto);
}

function homeSlideshowParallax(){
    var scrollTop=$(window).scrollTop();
    if(scrollTop>windowHeight) return;
    var inner=slideshow.find('.slideshow-inner');
    var newHeight=windowHeight-(scrollTop/2);
    var newTop=scrollTop*0.8;

    inner.css({
        transform:'translateY('+newTop+'px)',height:newHeight
    });
}

$(document).ready(function() {
    $('.slide').addClass('is-loaded');

    function updateArrows() {
        $('.slideshow').each(function() {
            const $slideshow = $(this);
            const $arrowNext = $slideshow.find('.arrow.next');
            const currentIndex = $slideshow.find('.slide.is-active').index();
        });
    }

    updateArrows();

    $('.slideshow').on('click', '.arrow', function() {
        const $arrow = $(this);
        slideshowNext($arrow.closest('.slideshow'), $arrow.hasClass('prev'));
    });

    $('.slideshow .pagination .item').on('click', function() {
        const $slideshow = $(this).closest('.slideshow');
        slideshowSwitch($slideshow, $(this).index());
    });

    $('.slideshow .pagination').on('check', function() {
        const $slideshow = $(this).closest('.slideshow');
        const index = $slideshow.find('.slide.is-active').index();
        $(this).find('.item').removeClass('is-active').eq(index).addClass('is-active');
        updateArrows();
    });

    const originalSlideshowSwitch = slideshowSwitch;
    slideshowSwitch = function(slideshow, index, auto) {
        originalSlideshowSwitch.call(this, slideshow, index, auto);
        setTimeout(updateArrows, 50);
    };

    const timeout = setTimeout(function() {
        slideshowNext($('.slideshow').first(), false, true);
    }, slideshowDuration);
    $('.slideshow').first().data('timeout', timeout);
});

if($('.main-content .slideshow').length > 1) {
    $(window).on('scroll',homeSlideshowParallax);
}