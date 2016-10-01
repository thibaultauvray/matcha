$(document).ready(function()
{
    $("#croi").change(function(){
        $("#tri").trigger("change");
    });
    $("#tri").change(function()
    {
        function sort_age(a, b){
            if($("#croi").val() == "croi")
            {
                return ($(b).data('age')) < ($(a).data('age')) ? 1 : -1;
            }
            else
            {
                return ($(b).data('age')) > ($(a).data('age')) ? 1 : -1;
            }
        }
        function sort_local(a, b){
            if($("#croi").val() == "croi")
            {
                return ($(b).data('localisation')) < ($(a).data('localisation')) ? 1 : -1;
            }
            else
            {
                return ($(b).data('localisation')) > ($(a).data('localisation')) ? 1 : -1;
            }
        }
        function sort_pop(a, b){
            if($("#croi").val() == "croi")
            {
                return ($(b).data('popularity')) < ($(a).data('popularity')) ? 1 : -1;
            }
            else
            {
                return ($(b).data('popularity')) > ($(a).data('popularity')) ? 1 : -1;
            }
        }

        function sort_tags(a, b){
            if($("#croi").val() == "croi")
            {
                return ($(b).data('tags')) < ($(a).data('tags')) ? 1 : -1;
            }
            else
            {
                return ($(b).data('tags')) > ($(a).data('tags')) ? 1 : -1;
            }
        }
        function sort_def(a, b)
        {
            if ($("#croi").val() == "croi")
            {
                return ($(b).data('index')) < ($(a).data('index')) ? 1 : -1;
            }
            else
            {
                return ($(b).data('index')) > ($(a).data('index')) ? 1 : -1;
            }
        }

        if($(this).val() == "age")
            $(".listusers .encart-users").sort(sort_age).appendTo('.listusers');
        else if ($(this).val() == "localisation")
            $(".listusers .encart-users").sort(sort_local).appendTo('.listusers');
        else if ($(this).val() == "popularite")
            $(".listusers .encart-users").sort(sort_pop).appendTo('.listusers')
        else if ($(this).val() == "tags")
            $(".listusers .encart-users").sort(sort_tags).appendTo('.listusers');
        else if ($(this).val() == "default")
            $(".listusers .encart-users").sort(sort_def).appendTo('.listusers');

    });

    function isInteret(interet, interetUser)
    {
        bool = true;
        if(typeof image_array !== 'undefined' && image_array.length > 0)
        {
        $.each(interetUser, function(index, value)
        {
            if($.inArray(value.trim(), interet) !== -1)
            {
                if(bool != false)
                    bool = true;
            }
            else
            {
                bool = false
            }
        });
        }
        return bool;
    }

    $(".filter").on('input', function()
    {
        age1 = $("#amount").val().split('-')[0].trim();
        age2 = $("#amount").val().split('-')[1].trim();
        loca = $("#filterLoca").val().toLowerCase();
        pop1 = $("#popularity").val().split('-')[0].trim();
        pop2 = $("#popularity").val().split('-')[1].trim();
        interetUser = $('#filterTags').val().split(',');
        $(".listusers .encart-users").each(function(){
            interet = $(this).data("tag-list").split(',');
            city = $(this).data('city').toLowerCase();
            if(($(this).data("age") < age1 || $(this).data("age") > age2) || (city.indexOf(loca) == -1) || isInteret(interet, interetUser) == false || ($(this).data("popularity") < pop1 || $(this).data("popularity") > pop2))
            {
                $(this).hide('1000');
            }
            else
            {
                $(this).show('1000');
            }
        });
    })

    $( "#age-range" ).slider({
        range: true,
        min: 14,
        max: 99,
        values: [ 14, 99 ],
        slide: function( event, ui ){
            $( "#amount" ).val( ui.values[ 0 ] + " - " + ui.values[ 1 ] );
        },
        change: function(event, ui){
            $(".filter").trigger("input");
        }
    });
    $( "#pop-range" ).slider({
        range: true,
        min: 0,
        max: 1000,
        values: [ 0, 1000 ],
        slide: function( event, ui ){
            $( "#popularity" ).val( ui.values[ 0 ] + " - " + ui.values[ 1 ] );
        },
        change: function(event, ui){
            $(".filter").trigger("input");
        }
    });
    $( "#popularity" ).val($( "#pop-range" ).slider( "values", 0 ) +
        " - " + $( "#pop-range" ).slider( "values", 1 ) );
    $( "#amount" ).val($( "#age-range" ).slider( "values", 0 ) +
        " - " + $( "#age-range" ).slider( "values", 1 ) );
});