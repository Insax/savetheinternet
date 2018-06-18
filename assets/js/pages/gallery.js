import Masonry from 'masonry-layout';

function debounce(func, wait, immediate) {
    let timeout;
    return function () {
        let context = this,
            args    = arguments;
        let later = function () {
            timeout = null;
            if(!immediate) {
                func.apply(context, args);
            }
        };
        let callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if(callNow) {
            func.apply(context, args);
        }
    };
};

jQuery(document)
    .ready(function () {
        if($('.gallery-grid').length < 1) {
            return;
        }

        const gallery = new Masonry('.gallery-grid', {
            itemSelector: '.gallery',
            columnWidth:  '.grid-sizer',
            percentPosition: true,
            gutter:       25,
        });

        const refreshLayout = debounce(function () {
            gallery.layout();
        }, 100);

        jQuery(".gallery-grid img")
            .one("load", refreshLayout)
            .each(function (index, element) {
                if(element.complete) {
                    jQuery(element)
                        .trigger('load');
                }
            });
    });
