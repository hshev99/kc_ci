
var maodian1 = function (hd, bd, speed) {
    $(function () {
        $(hd).on('click', function () {
            var o = $(this).index();
            var s_top = $(bd).eq(o).offset().top - (o * 50) - 55 - 30;
            $('html,body').animate({ scrollTop: s_top }, speed);
            //alert($(bd).eq(o).offset().top + '-' + $(this).offset().top);
        });

        var Sp = 0, Bdp = 0, io = 0;
        $(window).scroll(function () {
            io = 0;
            Sp = $(window).scrollTop();
            $(bd).each(function (i) {
                Bdp = $(this).offset().top;
                $(this).attr('_top', Bdp);
            });

            $(hd).each(function (i) {
                var ot1 = $(this).offset().top,
                    ot2 = $(bd).eq(i).offset().top,
                    oth = $(bd).eq(i).height() + ot2;
                $(this).attr('_top', ot1);

                if (ot1 >= ot2 && ot1 <= oth) {
                    $(hd).removeClass('on').eq(i).addClass('on');
                }
            });

            //无需修改
            if (Sp > 265) {
                $('.data').addClass('fixed');
            } else { $('.data').removeClass('fixed'); }

            if (Sp > 144) {
                $('#fixed_nav').addClass('fixed');
            } else { $('#fixed_nav').removeClass('fixed'); }

        });
    });
}