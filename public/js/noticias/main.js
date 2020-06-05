$(function(){
    
    colorize();

    $infinite = $("#infinite");
    
    $infinite.infiniteScroll({
        path: '/noticias/scroll/{{#}}',
        checkLastPage:'.end',
        append: 'section'
    });

    $infinite.on('append.infiniteScroll', function(){
        colorize();
    });
    
    $('a[href="'+window.location.href+'"]').click(e => e.preventDefault())

    $('[data-dir]').click(function(e){
        e.preventDefault()
        location.href = $(this).data('dir');
    });
});

function colorize(){
    /*$('[data-hex-bg]').each(function(c, e){
        $(e).css({'border-left':'2px solid #'+$(this).data('hex-bg')});
    })*/

    $('[data-hex-cl]').each(function(c, e){
        $(e).css({'color':'#'+$(this).data('hex-cl')});
    })
}