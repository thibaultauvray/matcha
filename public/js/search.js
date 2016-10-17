
$(document).ready(function ()
{







    $("#croi").change(function ()
    {
        $("#tri").trigger("change");
    });
    $("#tri").change(function ()
    {
        function sort_age(a, b)
        {
            if ($("#croi").val() == "croi")
            {
                return ($(b).data('age')) < ($(a).data('age')) ? 1 : -1;
            }
            else
            {
                return ($(b).data('age')) > ($(a).data('age')) ? 1 : -1;
            }
        }

        function sort_local(a, b)
        {
            if ($("#croi").val() == "croi")
            {
                return ($(b).data('localisation')) < ($(a).data('localisation')) ? 1 : -1;
            }
            else
            {
                return ($(b).data('localisation')) > ($(a).data('localisation')) ? 1 : -1;
            }
        }

        function sort_pop(a, b)
        {
            if ($("#croi").val() == "croi")
            {
                return ($(b).data('popularity')) < ($(a).data('popularity')) ? 1 : -1;
            }
            else
            {
                return ($(b).data('popularity')) > ($(a).data('popularity')) ? 1 : -1;
            }
        }

        function sort_tags(a, b)
        {
            if ($("#croi").val() == "croi")
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

        if ($(this).val() == "age")
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
        if (typeof image_array !== 'undefined' && image_array.length > 0)
        {
            $.each(interetUser, function (index, value)
            {
                if ($.inArray(value.trim(), interet) !== -1)
                {
                    if (bool != false)
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

    $("input[type=checkbox]").on('change', function ()
    {
        $(this).trigger('input');
    });

    $(".filter").on('input', function ()
    {
        genderM = $("#m").prop('checked');
        genderF = $("#f").prop('checked');
        homo = $("#homo").prop('checked');
        hete = $("#hetero").prop('checked');
        bi = $("#bi").prop('checked');

        age1 = $("#age-range .ui-slider-handle:eq(0)").attr('data-label-value').trim();
        age2 = $("#age-range .ui-slider-handle:eq(1)").attr('data-label-value').trim();

        loca = $("#filterLoca").val().toLowerCase();
        pop1 = $("#pop-range .ui-slider-handle:eq(0)").attr('data-label-value').trim()
        pop2 = $("#pop-range .ui-slider-handle:eq(1)").attr('data-label-value').trim()
        interetUser = $('#filterTags').val().split(',');
        $(".listusers .encart-users").each(function ()
        {
            interet = $(this).data("tag-list").split(',');
            city = $(this).data('city').toLowerCase();
            console.log(loca + " C ; " + city + " R " + city.indexOf(loca));
            if (($(this).data("age") < age1 || $(this).data("age") > age2) || (city.indexOf(loca) == -1) || isInteret(interet, interetUser) == false || ($(this).data("popularity") < pop1 || $(this).data("popularity") > pop2) || ($(this).data('sex') == "f" && genderF == false)
                || ($(this).data('sex') == "m" && genderM == false) || ($(this).data('orien') == "homosexuel" && homo == false) || ($(this).data('orien') == "bisexuel" && bi == false) || ($(this).data('orien') == "hetero" && hete == false))
            {
                $(this).hide('1000');
            }
            else
            {
                console.log("caca");
                $(this).show('1000');
            }
        });
    });

    function hasClass(element, cls) {
        return (' ' + element.className + ' ').indexOf(' ' + cls + ' ') > -1;
    }

    $("#age-range").slider({

        range: true,
        min: 18,
        max: 99,
        values: [18, 99],
        slide: function (event, ui)
        {
            if (hasClass(ui.handle, 'first'))
                ui.handle.setAttribute('data-label-value', ui.values[0]);
            else
                ui.handle.setAttribute('data-label-value', ui.values[1]);
        },
        change: function (event, ui)
        {
            $(".filter").trigger("input");
        }
    });

    $('#age-range .ui-slider-handle:eq(0)').addClass('first');
    $('#age-range .ui-slider-handle:eq(0)').attr('data-label-value', 18);
    $('#age-range .ui-slider-handle:eq(1)').addClass('last');
    $('#age-range .ui-slider-handle:eq(1)').attr('data-label-value', 99);


    $("#pop-range").slider({
        range: true,
        min: 0,
        max: 1000,
        values: [0, 1000],
        slide: function (event, ui)
        {
            if (hasClass(ui.handle, 'first'))
                ui.handle.setAttribute('data-label-value', ui.values[0]);
            else
                ui.handle.setAttribute('data-label-value', ui.values[1]);
        },
        change: function (event, ui)
        {
            $(".filter").trigger("input");
        }
    });

    $('#pop-range .ui-slider-handle:eq(0)').addClass('first');
    $('#pop-range .ui-slider-handle:eq(0)').attr('data-label-value', 0);
    $('#pop-range .ui-slider-handle:eq(1)').addClass('last');
    $('#pop-range .ui-slider-handle:eq(1)').attr('data-label-value', 1000);
});