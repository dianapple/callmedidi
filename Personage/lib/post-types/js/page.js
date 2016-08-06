(function ($) {

    function PageTemplateSections()
    {
        var $templates  = $('select#page_template'),
            $metaBox    = $('.px-main'),
            $sidebarSec = $metaBox.find('.section-sidebar'),
            $homepageSec = $('#home_meta_box'),
			$contactpageSec = $('#contact_meta_box'),
			$resumepageSec = $('#resume_meta_box'),
			$editor = $('#postdivrich'),			
            $portfolioSwitch = $('select[name=portfolio-switch]'),
			$experienceSec = $('#experience_meta_box');;


        function changeHandler()
        {
            var selected = $templates.find(':selected').val();

            if('home-page.php' == selected)
            {
                $homepageSec.slideDown('fast');
                $editor.slideUp('fast');
				$sidebarSec.slideUp('fast');
				$contactpageSec.slideUp('fast');
				$resumepageSec.slideUp('fast');
				$experienceSec.slideUp('fast');

            }
            else if('portfolio.php' == selected)
            {
                $editor.slideUp('fast');
				$sidebarSec.slideUp('fast');
                $homepageSec.slideUp('fast');
				$contactpageSec.slideUp('fast');
				$resumepageSec.slideUp('fast');
				$experienceSec.slideUp('fast');
            }
			else if('full-width.php' == selected)
            {
                $editor.slideDown('fast');
				$sidebarSec.slideUp('fast');
                $homepageSec.slideUp('fast');
				$contactpageSec.slideUp('fast');
				$resumepageSec.slideUp('fast');
				$experienceSec.slideUp('fast');
            }
			else if('contact-page.php' == selected)
            {
				$contactpageSec.slideDown('fast');
                $sidebarSec.slideUp('fast');
                $homepageSec.slideUp('fast');
				$resumepageSec.slideUp('fast');
				$editor.slideUp('fast');
				$experienceSec.slideUp('fast');
            }
			else if('resume-page.php' == selected)
            {
				$resumepageSec.slideDown('fast');
                $sidebarSec.slideUp('fast');
                $homepageSec.slideUp('fast');
				$contactpageSec.slideUp('fast');
				$editor.slideUp('fast');
				$experienceSec.slideDown('fast');
            }
            else
            {
				$editor.slideDown('fast');
				$contactpageSec.slideUp('fast');
                $homepageSec.slideUp('fast');
				$resumepageSec.slideUp('fast');
                $sidebarSec.slideDown('fast');
				$experienceSec.slideUp('fast');
            }

        }

        function changeHomeOption ()
        {
            if($portfolioSwitch.val() == "1")
            {
                $sidebarSec.slideUp('fast');
            }
            else{
                $sidebarSec.slideDown('fast');
            }


        }
        changeHandler();
        $templates.change(changeHandler);
        $portfolioSwitch.change(changeHomeOption);

    }
	
	function ImageFields()
    {
        var $imageSec    = $('.section-background'),
            $fields      = $imageSec.find('.background-image'),
            $dupBtn      = $('<a class="duplicate-button" href="#">Add Image</a>'),
            $remBtn      = $('<a class="remove-button" href="#">Remove</a>');

        //Click handler for remove button
        $remBtn.click(function(e){
            e.preventDefault();

            var $this = $(this);

            $this.parent().remove();

            $fields = $imageSec.find('.background-image');

            if($fields.length < 2)
            //Remove the button
                $fields.find('.remove-button').remove();
        });


        //Add remove button if there is more than one image field
        if($fields.length > 1)
            $fields.append($remBtn.clone(true));

        //Add duplicate button after last upload field
        $fields.filter(':last').after($dupBtn);

        $dupBtn.click(function(e){
            e.preventDefault();

            //Don't try to reuse $fields var above ;)
            $fields        = $imageSec.find('.background-image');
            var $lastField = $fields.filter(':last'),
                $clone     = $lastField.clone(true);

            //Clear the value (if any)
            $clone.find('input[type="text"]').val('');

            $lastField.after($clone);

            //Refresh
            $fields        = $imageSec.find('.background-image');
            //Add 'remove' button to all fields
            //Rest of 'remove' buttons will get cloned
            if($fields.length == 2)
                $fields.append($remBtn.clone(true));
        });
    }
	
    function resumeHandler(){
		
		var $resumeExpSection = $('#field-resume-exp-section'),
			$resumeExpSectionOpen = $('#field-resume-exp-section-open'),
			$resumeSkillSection = $('#field-resume-skills-section'),
			$resumeSkillSectionOpen = $('#field-resume-skills-section-open'),
			$resumeEduSection = $('#field-resume-education-section'),
			$resumeEduSectionOpen = $('#field-resume-education-section-open'),
			$resumeTestSection = $('#field-resume-testimonial-section'),
			$resumeTestSectionOpen = $('#field-resume-testimonial-section-open'),
			$experienceSec = $('#experience_meta_box');
			
        //Click handler for active/deactive experiace section setting
		if($resumeExpSection.attr("checked")){
			$resumeExpSectionOpen.attr('disabled',false);
			$experienceSec.slideDown('fast');
		}else{
			$resumeExpSectionOpen.attr('disabled',true);
			$experienceSec.slideUp('fast');
		}
		$resumeExpSection.change(function(){
			if($resumeExpSection.attr("checked")){
				$resumeExpSectionOpen.attr('disabled',false);
				$experienceSec.slideDown('fast');
			}else{
				$resumeExpSectionOpen.attr('disabled',true);
				$experienceSec.slideUp('fast');
			}
		});
		
		//Click handler for active/deactive skills section setting
		if($resumeSkillSection.attr("checked")){
			$resumeSkillSectionOpen.attr('disabled',false);
		}else{
			$resumeSkillSectionOpen.attr('disabled',true);
		}
		$resumeSkillSection.change(function(){
			if($resumeSkillSection.attr("checked")){
				$resumeSkillSectionOpen.attr('disabled',false);
			}else{
				$resumeSkillSectionOpen.attr('disabled',true);
			}
		});
		
		//Click handler for active/deactive education section setting
		if($resumeEduSection.attr("checked")){
			$resumeEduSectionOpen.attr('disabled',false);
		}else{
			$resumeEduSectionOpen.attr('disabled',true);
		}
		$resumeEduSection.change(function(){
			if($resumeEduSection.attr("checked")){
				$resumeEduSectionOpen.attr('disabled',false);
			}else{
				$resumeEduSectionOpen.attr('disabled',true);
			}
		});
		
		//Click handler for active/deactive Testimonial section setting
		if($resumeTestSection.attr("checked")){
			$resumeTestSectionOpen.attr('disabled',false);
		}else{
			$resumeTestSectionOpen.attr('disabled',true);
		}
		$resumeTestSection.change(function(){
			if($resumeTestSection.attr("checked")){
				$resumeTestSectionOpen.attr('disabled',false);
			}else{
				$resumeTestSectionOpen.attr('disabled',true);
			}
		});
	}
	$(document).ready(function () {
		PageTemplateSections();
		ImageFields();
		resumeHandler();

    });

})(jQuery);