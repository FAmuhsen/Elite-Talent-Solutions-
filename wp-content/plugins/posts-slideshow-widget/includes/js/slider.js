/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


(function($) {
    $(document).ready(function() {
        $('[class^=psw-slider-wrapper-]').each(function() {
            var options = $(this).next(".psw-slider-opts");
            $(this).bxSlider({
                'controls': options.data("controls"),
                'auto': options.data("auto")
            });
        });
    });

})(jQuery);