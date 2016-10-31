/**
 * Created by tauvray on 10/20/16.
 */

    $(document).ready(function(){
        $('.navbar-header').on('click', function()
        {
            if($('.navbar-content').css('display') == 'none')
                $('.navbar-content').show(1000);
            else
                $('.navbar-content').hide(1000);
        });
    })
