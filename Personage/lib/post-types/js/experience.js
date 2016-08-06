(function ($) {

    //Handles icon selector
	function expIconSelect() {
        
		var $iconInput = $('input[name=exp-item-icon]');
        if($iconInput.attr('value') != ''){
            $('.px-icon[data-name=' + $iconInput.attr('value') + ']').addClass('selected');
        }
		$(document).on('click', '.px-icon', function () {
			$iconInput.attr('value',$(this).attr('data-name'));
			$('.px-icon').removeClass('selected');
			$(this).addClass('selected');
		});
    }

    $(document).ready(function () {
        expIconSelect();
    });

})(jQuery);