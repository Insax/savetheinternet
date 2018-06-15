function makeTemplate(element){
    return '<div class="post-container" id="' + element.id + '">'+
           '<div class="post-left">'+
           '<img class="profile-pic" src="' + element.user.profile_image_url_https + '" />'+
           '</div>'+
           '<div class="post-right">'+
           '<div class="post-header">'+
           '<div class="profile-name">'+
           //'<span class="profile-displayname">' + element.user.name + '</span>'+
           '<span class="profile-username"><a href="https://twitter.com/' + element.user.screen_name + '">@' + element.user.screen_name + '</a></span>'+
           '<span class="post-time"> ' + moment(new Date(element.created_at)).fromNow() + '</span>'+
           '</div>'+
           '</div>'+
           '<div class="post-content">'+
           element.text
                  .replace(/(https?:\/\/[0-9a-zA-z\.-\/]+)/gi,'<span data-line="CENSORED" class="blacked-on-visible"><a href="$1">$1</a></span>')
                  .replace(/(lobbyist[a-zA-Z]+)/gi,'<span data-line="CENSORED" class="blacked-on-visible">$1</span>')
                  .replace(/#([a-zA-Z0-9]+)/gi,'<a href="https://twitter.com/hashtag/$1">#$1</a>')
                  .replace(/@([a-zA-Z0-9._]+)/gi,'<a href="https://twitter.com/$1">@$1</a>') +
           '</div>'+
           '</div>'+
           '</div>'

}

(function($) {

    /**
     * Copyright 2012, Digital Fusion
     * Licensed under the MIT license.
     * http://teamdf.com/jquery-plugins/license/
     *
     * @author Sam Sehnert
     * @desc A small plugin that checks whether elements are within
     *     the user visible viewport of a web browser.
     *     only accounts for vertical position, not horizontal.
     */

    $.fn.visible = function(partial) {

        var $t = $(this),
            $w = $(window),
            viewTop = $w.scrollTop(),
            viewBottom = viewTop + $w.height(),
            _top = $t.offset().top,
            _bottom = _top + $t.height(),
            compareTop = partial === true ? _bottom : _top,
            compareBottom = partial === true ? _top : _bottom;

        return ((compareBottom <= viewBottom) && (compareTop >= viewTop));

    };

})(jQuery);

function black(element, text) {
    var content = $(element).text();
    if (content.includes(text)) {
        $(element).empty();
        var before = content.substring(0, content.indexOf(text));
        var after = content.substring(content.indexOf(text) + text.length);
        $(element).append($('<span class="before">').text(before));
        $(element).append($('<span data-line="C E N S O R E D" class="blacked">').text(text));
        $(element).append($('<span class="after">').text(after));
    }
}

function checkBlacks() {
    $(".blacked-on-visible").each(function(i, elem) {
        var el = $(elem);
        if (el.visible(true)) {
            el.attr('class', "blacked");
        }
    });
}


function contains(id){
    return $("#" + id).length != 0;
}


function updateTweets() {
    $.get("/tweets", function(data) {
        data = data.sort(function(a,b){
            return a.id - b.id;
        });

        let inserted = 0;
		data = data.slice(0, 6);
        data.forEach(function(element) {
            if(!contains(element.id) && inserted < 1)
            {
                inserted ++;
                $('#tweets').prepend(makeTemplate(element));
            }
        });
		if($('#tweets').children().length > 6)
        	$('#tweets').children().last().remove();
        checkBlacks();
    });
}

$(window).scroll(function(event) {
    checkBlacks();
});

setInterval(function(){updateTweets();}, 2000);

$(document).ready(function() {
    checkBlacks();
});

updateTweets();
