/*===================================================================================================
* TimeLine - HomePage (Section - Agenda & Event) behavion according to the page language
* ==================================================================================================*/
var valid  = $('#timeline-carousel').length > 0 && $('.calendar_items').length > 0 && $('.calendar_item').length > 0;
if(valid){
    var wrapper_width,items,item_width,item_all_width;
    var hidden_items,displayed_items;
    var current_index, rest_left;
    var to_left, to_right;
    var lang_arabic;

    readParams();
    init();
    
    /*======SWIP TIMELINE - MOBILE=======*/
    
    
    $( "#timeline-carousel" ).on( "swipeleft", function ( event ){
        $('#carousel-indicators .right').first().trigger('click');
    } );

    $( "#timeline-carousel" ).on( "swiperight", function ( event ){
        $('#carousel-indicators .left').first().trigger('click');
    } );
    
    /*======SWIP TIMELINE - MOBILE FIN =======*/
    
    /*====== Carousel controlled by keyboard =======*/
    $(document).keydown(function(e) {
        if (e.keyCode === 37) {
            // Previous
            jQuery('#carousel-indicators .left').first().trigger('click');
            return false;
        }
        if (e.keyCode === 39) {
            // Next
            jQuery('#carousel-indicators .right').first().trigger('click');
            return false;
        }
    });
    /*====== Carousel controlled by keyboard FIN =======*/
    

    $('#carousel-indicators .left').on('click', function(){
        readParams();
        if(to_left) {
            lang_arabic ? current_index++ : current_index--;
            _translate('left');
            to_right = true;
            if((lang_arabic && ((current_index + 1) * displayed_items) >= items.length) || (current_index <= 0)){
                to_left = false;
            }
        }
    })
    $('#carousel-indicators .right').on('click', function(){
        readParams();
        if(to_right) {
            lang_arabic ? current_index-- : current_index++;
            _translate('right');
            to_left = true;
            if((lang_arabic && current_index <= 0) || ((current_index + 1) * displayed_items >= items.length)){
                to_right = false;
            }
        }
    })

    function _translate(direction = 'left'){
        var slide = current_index * displayed_items * item_width;
        rest_left = (hidden_items < (current_index * displayed_items)) ? 0 : hidden_items - (current_index * displayed_items);
        rest_right = hidden_items - rest_left;
        if((current_index + 1) * displayed_items > items.length || !to_left) slide = rest_right * item_width;
        if(!lang_arabic) slide *= -1;

        items.each(function (i) {
            $(items.eq(i)).css('transform', 'translateX(' + slide + 'px)');
        })
    }

    function init(){
        lang_arabic = $('html[lang*=ar]').length > 0 ? true : false;
        current_index = 0;
        rest_left = hidden_items;
        rest_right = 0;

        to_left = lang_arabic ? ((hidden_items == 0) ? false : true) : false;
        to_right = lang_arabic ? false : ((hidden_items == 0) ? false : true);
    }

    function readParams() {
        wrapper_width = $('.calendar_items')[0].getBoundingClientRect().width; //$('.calendar_items').outerWidth();
        items = $('.calendar_item');
        item_width = $('.calendar_item')[0].getBoundingClientRect().width; //items.outerWidth();
        item_all_width = item_width * items.length;

        displayed_items = parseInt(( item_all_width > wrapper_width) ?
        (wrapper_width / item_width) : items.length);
        hidden_items = items.length - displayed_items;
    }
}