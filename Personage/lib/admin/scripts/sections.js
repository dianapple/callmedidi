function AddBtn(){
    var $ = jQuery,
        itemCount = $('#post-type-archive-checklist li label:not(#post-type-archive-checklist li label[style*="display: none"])').length,
        controlsBtn = $('#post-type-archives .accordion-section-content .inside .button-controls');
    if(itemCount <= 0){
        controlsBtn.hide();
    }else{
        controlsBtn.show();
    }
}

function removeItem(){
	var $        = jQuery,
		index,
		sections = [
            "intro",
			"skill",
			"experience",
			"education",
			"portfolio",
			"testimonial",
            "contact"
					];
	$('.menu-item-skill .menu-item-settings .menu-item-actions .item-delete, .menu-item-testimonial .menu-item-settings .menu-item-actions .item-delete, .menu-item-education .menu-item-settings .menu-item-actions .item-delete, .menu-item-experience .menu-item-settings .menu-item-actions .item-delete, .menu-item-portfolio .menu-item-settings .menu-item-actions .item-delete, .menu-item-intro .menu-item-settings .menu-item-actions .item-delete, .menu-item-contact .menu-item-settings .menu-item-actions .item-delete').click(function(event) {
		var section = $(this).parent().parent().parent().attr('class');
		for (index = 0; index < sections.length; ++index) {
			if(section.indexOf(sections[index]) > -1){
				$('#post-type-archive-checklist').append('<li><label><input type="checkbox" value ="'+sections[index]+'" /> '+sections[index]+' </label></li>');
			}
		}
        AddBtn();
	})
}

jQuery(document).ready(function($) {
    $("#screen-options-wrap input:checkbox#post-type-archives-hide").prop("checked", true);
    $('#post-type-archives').css("display", "list-item");

    $("#screen-options-wrap input:checkbox#add-custom-part-hide").prop("checked", true);
    $('#add-custom-part').css("display", "list-item");
    removeItem();
    AddBtn();
    $('#submit-post-type-archives').click(function(event) {
        event.preventDefault();
 
        /* Get checked boxes */
        var postTypes = [];
        $('#post-type-archive-checklist li :checked').each(function() {
            postTypes.push($(this).val());
        });
 
        /* Send checked post types with our action, and nonce */
        $.post( ajaxurl, {
                action: "my-add-post-type-archive-links",
                posttypearchive_nonce: MyPostTypeArchiveLinks.nonce,
                post_types: postTypes
            },
 
            /* AJAX returns html to add to the menu */
            function( response ) {
                $('#menu-to-edit').append(response);
				$('#post-type-archive-checklist li :checked').each(function() {
					$(this).parent().remove();
				});
				removeItem();
                AddBtn();
            }
        );
    })
});