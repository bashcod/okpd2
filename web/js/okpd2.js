console.log('asset start');

$(document).ready(function(){
    window.init = function() {
        $('.js__get_sub_tree.not_active').click(function(){getSubTree(this);});
        $('.js__get_sub_tree.active').click(function(){removeSubTree(this);});
        $('.js__info').click(function(){getInfo(this);});
    }

    
    window.getSubTree = function(t){
        $('.to-highlight').css('background', '');
        if(!$(t).hasClass('active')){
            console.log('get sub tree start');
            $.get( '/okpd2/get-subtree', { path: $(t).attr('data-path'), level: $(t).attr('data-level') } )
            .done(function( data ) {
                $(t).removeClass('not_active').addClass('active');
                $(t).parent().siblings('.subtree').html(data);
                
                init();
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                alert('Произошла ошибка выполнения запроса: ' + errorThrown);
            });
            console.log('get sub tree end');
        }
    }
    
    window.removeSubTree = function(t) {
        $('.to-highlight').css('background', '');
        if(!$(t).hasClass('not_active')){
            console.log('remove sub tree start');
    
            $(t).removeClass('active').addClass('not_active');
            $(t).parent().siblings('.subtree').html('');
            
            console.log('remove sub tree end');
        }
    }
    
    window.getInfo = function(t){
        console.log('get info start');
        $.get( '/okpd2/get-info', { idx: $(t).attr('data-idx')} )
        .done(function( data ) {
            $('#okpd2txt').html(data);
            $("#okpd2modal").modal('show');
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            alert('Произошла ошибка выполнения запроса: ' + errorThrown);
        });
        console.log('get info start');
    }

    window.expandTree = function(t) {
        console.log('selected start');

        $('[data-level="1"]').each(function(){window.removeSubTree(this);});
        $('.to-highlight').css('background', '');
        console.log($(t));
        $.get( '/okpd2/get-tree-to-element', { idx: $(t).val()} )
        .done(function( data ) {
            console.log(data);
            data.forEach(function(item, key, array){
                console.log([item, key]);
                var timerId;
                if(array.length > (key + 1)) {
                    console.log($('[data-path="'+ item +'"]'));
                    timerId = setInterval(function() {
                        $elem = $('[data-path="'+ item +'"]');
                        if($elem.length > 0) {
                            window.getSubTree($elem);
                            clearInterval(timerId);
                        }
                    }, 100);
                } else if(array.length == (key + 1)){
                    console.log('last element');
                    console.log($('[data-path="'+ item +'"]'));
                    timerId = setInterval(function() {
                        $elem = $('[data-path="'+ item +'"]');
                        if($elem.length > 0) {
                            console.log($elem.parent());
                            $elem.parent().parent().css('background-color', '#FFFF00');
                            clearInterval(timerId);
                            $([document.documentElement, document.body]).animate({
                                scrollTop: $elem.offset().top - ($(window).height()/2) + ($elem.height()/2)
                            }, 1000);
                        }
                    }, 100);
                }
            });
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            alert('Произошла ошибка выполнения запроса: ' + errorThrown);
        });
        console.log('selected end');
    }

    window.init();
});

console.log('asset end');