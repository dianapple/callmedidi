(function ($) {

    //Handles icon selector
	function educationIconSelect() {
        
		var $iconInput = $('input[name=education-item-icon]');
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
        educationIconSelect();
    });

})(jQuery);