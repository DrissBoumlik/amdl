jQuery(function ($) {


    var wrapper_width, items, item_width, item_all_width;
    function readParams(wrapper, item) {
        wrapper_width = $(wrapper)[0].getBoundingClientRect().width; //$('.calendar_items').outerWidth();
        items = $(item);
        item_width = $(item)[0].getBoundingClientRect().width; //items.outerWidth();
        item_all_width = item_width * items.length;

        displayed_items = parseInt((item_all_width > wrapper_width) ?
            (wrapper_width / item_width) : items.length);
        hidden_items = items.length - displayed_items;
    }

    function translateX(next_index, step) {
        items.each(function (i) {
            $(items.eq(i)).css('transform', 'translateX(' + (next_index * item_width * step) + 'px)');
        })
    }

    $('.timeline-indicators').delegate('div', 'click', function () {
        current = $('.timeline-indicators .active').attr('data-slide');
        next = $(this).attr('data-slide');
        // console.log(next);
        console.log(next);
        move = current != next;

        if (move) {
            // $($('.agenda-article')[next]).removeClass('fadeOut hidden').addClass('faceIn')
            //     .siblings('.agenda-article').addClass('fadeOut hidden').removeClass('faceIn')
            $(this).addClass('active').siblings().removeClass('active');

            $($('.agenda-article')[next]).removeClass('fadeOut hidden').addClass('fadeIn')
                .siblings('.agenda-article').addClass('fadeOut hidden').removeClass('fadeIn')
        }
    });


    $('.updates-indicators').delegate('li', 'click', function () {
        current = $('.updates-indicators li.active').attr('data-slide');
        next = $(this).attr('data-slide');

        // console.log("current : " + current);
        // console.log("To : " + next);

        next = next * -1;
        move = current != next;
        // console.log(move);

        if (move) {
            readParams($('#latest-articles'), $('.article'));
            $(this).addClass('active').siblings().removeClass('active')
            translateX(next, displayed_items);
        }

    })
    
    if($('.slider-item-wrapper').length){
            setTimeout(function () {
            wrapper_width = $('.slider-item-wrapper').css('width').replace('px', '')
            body_width = $('body')[0].getBoundingClientRect().width
            right = (body_width - wrapper_width) / 2;
            $('.n2-ss-control-bullet.n2-ss-control-bullet-horizontal').css('right', right + 'px');
            $('.n2-ss-control-bullet.n2-ss-control-bullet-horizontal').css('transform', 'translateX(-50%)');
        }, 500);
    }
});