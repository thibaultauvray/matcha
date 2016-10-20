/**
 * Created by tauvray on 10/20/16.
 */

    $(document).ready(function(){
        console.log('ok');
        $('.navbar-header').on('click', function()
        {
            console.log($('.navbar-content').css('display'));
            if($('.navbar-content').css('display') == 'none')
                $('.navbar-content').show(1000);
            else
                $('.navbar-content').hide(1000);
        });
    })
