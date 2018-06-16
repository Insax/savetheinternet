import jQuery from 'jquery';
import Masonry from 'masonry-layout';

jQuery(document).ready(function() {
    const gallery = new Masonry('.gallery-grid', {
        itemSelector: '.gallery',
        columnWidth:  250,
        gutter: 25
    });
});
