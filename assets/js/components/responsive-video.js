import jQuery from 'jquery';
import Cookie from './Cookie';

class ResponsiveVideo {
    /**
     * Responsive Video with consent
     *
     * @param {string} selector jQuery Selector
     * @param {string} cacheName Name to save consent in localStorage/cookie
     */
    constructor(selector = '.responsive-video', cacheName = 'video-consent') {
        if (typeof selector !== 'string') {
            throw new Error('Please provide a valid selector');
        }

        this.selector = selector;
        this.cacheName = cacheName;
    }

    activate() {
        if (this.hasGivenConsent()) {
            this.switchToVideo();
        } else {
            this._setupConsent();
        }
    }

    _setupConsent() {
        jQuery.each(jQuery(this.selector).not('[data-responsive-video-activated]'), (index, element) => {
            element = jQuery(element);
            element.find('.consent').removeClass('hidden');
            element.find('.consent-btn').on('click', event => {
                event.preventDefault();
                event.stopImmediatePropagation();

                this.giveConsent();
            });
        });
    }

    hasGivenConsent() {
        let item = null;

        if (window.sessionStorage) {
            item = window.sessionStorage.getItem(this.cacheName);
        } else {
            item = new Cookie(this.cacheName).read();
        }

        return item === null ? false : item;
    }

    giveConsent() {
        if (window.sessionStorage) {
            window.sessionStorage.setItem(this.cacheName, true);
        } else {
            new Cookie(this.cacheName).write('true', false);
        }

        this.switchToVideo();
    }

    switchToVideo() {
        jQuery(this.selector).each((index, element) => {
            element = jQuery(element);
            element
                .find('iframe')
                .attr('src', element.data('video-src'))
                .removeClass('hidden');
            element.find('.consent').remove();
        });
    }
}

export default ResponsiveVideo;
