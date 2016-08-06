// Global Variables
var $            = jQuery,
    pageTemplate = $('.main').attr('page-template');

// Global Functions
// Determine if item is visible on screen
$.fn.isOnScreen = function(){
    "use strict";

    if(pageTemplate != 'home-page' || !$('#skill .skill-chart .chart').length ){
        return;
    }
    var win = $(window);

    var viewport = {
        top : win.scrollTop(),
        left : win.scrollLeft()
    };
    viewport.right = viewport.left + win.width();
    viewport.bottom = viewport.top + win.height();

    var bounds = this.offset();
    bounds.right = bounds.left + this.outerWidth();
    bounds.bottom = bounds.top + this.outerHeight();
    return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));
};

function FillPieCharts(){
    "use strict";

    $('.chart-container').easyPieChart({
        easing: 'easeOutQuart',
        animate:{ duration: 2000, enabled: true },
        onStep: function(from, to, percent) {
            $(this.el).find('.percent').text(Math.round(percent));
        },
        barColor: function(percent) {
            var ctx = this.renderer.getCtx();
            var canvas = this.renderer.getCanvas();
            var gradient = ctx.createLinearGradient(0,60,60,0);
            gradient.addColorStop(0, "rgba("+hexToRgb(this.el.attributes['sColor'].value)+",0.3)");
            gradient.addColorStop(1, "rgba("+hexToRgb(this.el.attributes['eColor'].value)+",0.3)");
            return gradient;
        },
        lineWidth:11,
        lineCap:'butt',
        scaleLength:20,
        size:'141',
        scaleColor:false,
        trackColor:'rgba(255,255,255,0)'

    });


    $('.chart').easyPieChart({
        easing: 'easeInOutCirc',
        animate:{ duration: 3000, enabled: true },
        onStep: function(from, to, percent) {
            $(this.el).find('.percent').text(Math.round(percent));
        },
        barColor: function(percent) {
            var ctx = this.renderer.getCtx();
            var canvas = this.renderer.getCanvas();
            var gradient = ctx.createLinearGradient(0,60,60,0);
            gradient.addColorStop(0, "rgba("+hexToRgb(this.el.attributes['sColor'].value)+",0.9)");
            gradient.addColorStop(1, "rgba("+hexToRgb(this.el.attributes['eColor'].value)+",0.9)");
            return gradient;
        },
        lineWidth:11,
        lineCap:'butt',
        scaleLength:20,
        size:'119',
        scaleColor:false,
        trackColor:'rgba(255,255,255,0)'

    });

    function hexToRgb(hex) {

        var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
        return result ? parseInt(result[1], 16)+","+parseInt(result[2], 16)+","+parseInt(result[3], 16)
            : "0,0,0";
    }
}

function PieChartLoader() {
    "use strict";

    var VisibilityState = $('#skill .skill-chart .chart').isOnScreen();
    if(VisibilityState){
        FillPieCharts();
    }
}

// *** Top Menu *** //
function SF_Top_Menu(){
    "use strict";

    jQuery('ul.sf-menu').superfish({
        delay:       100,                            // one second delay on mouseout
        animation:   {opacity:'show',height:'show'},  // fade-in and slide-down animation
        speed:       'fast',                          // faster animation speed
        autoArrows:  false                            // disable generation of arrow mark-up
    });
}

// *** Portfolio Filter Selection Menu *** //
function SF_Portfolio_Filters(){
    "use strict";

    jQuery('ul.portfolio-filter').superfish({
        delay:       100,                            // one second delay on mouseout
        animation:   {height:'show'},  // fade-in and slide-down animation
        animationOut: {height:'hide'},
        speed:       'fast',                          // faster animation speed
        autoArrows:  false                            // disable generation of arrow mark-up
    });
}

// *** Smooth Scrolling *** //
function SmoothScroll() {
    "use strict";

    var $             = jQuery,
        $body         = $('body'),
        $navContainer = $('.navigation-mobile');

    $('a[href*=#]:not([href=#]):not(#one-page-nav a)').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
            if (target.length) {
                $('html,body').animate({
                        scrollTop: target.offset().top
                    }, 1000,'easeOutQuart',function(){
                        if($body.hasClass('pushed-left'))
                        {
                            $body.removeClass('pushed-left');
                            setTimeout(function(){
                                $navContainer.css({display:'none'});
                            }, 330);
                        }
                    }
                );
                return false;
            }
        }
    })
}

// *** Nav Smooth Scrolling *** //
function NavSmoothScroll() {
    "use strict";

    $("#one-page-nav a[href*=#]:not([href=#])").click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
            if (target.length) {
                $('html,body').animate({
                    scrollTop: target.offset().top
                }, 1000,'easeOutQuart');
                return false;
            }
        }
    });
    $('#fixed-nav').onePageNav();

}

// *** Nav Tooltip *** //
function NavTooltip() {
    "use strict";

    if(pageTemplate != 'home-page' || !$('.NavTooltip').length){
        return;
    }
    $('.NavTooltip').tooltipster({
        delay:10,
        position:'left',
        theme:'tooltipster-default'
    });
}

function PortfolioFilter(){
    "use strict";

    if(!$('#portfolio').length){
        return;
    }
    var $container = $('.portfolio-container');
    $container.isotope({
        itemSelector: '.portfolio-item',
        layoutMode : 'fitRows'
    });

    $('.portfolio-filter-items a').click(function(){
        var selector = $(this).attr('data-filter');
        $container.isotope({ filter: selector});
        // Change Title text
        $('.portfolio-filter span.text').html($(this).html());
        return false;
    });
}

function SetPortfolioItemsHeight(){
    "use strict";

    var windowWidth = $(window).width(),
        col= 0;

    if( windowWidth > 1200 )
    {
        col=5;
    }
    else if(windowWidth <= 1200 && windowWidth > 768 )
    {
        col=3;
    }
    else if(windowWidth <= 768 && windowWidth > 480 )
    {
        col=2;
    }else
    {
        col=1;
    }
    var itemWidth = Math.floor( windowWidth/col);
    var itemHeight = Math.floor(itemWidth*0.595);

    $('#portfolio article.portfolio-item .portfolio-image-link .photo img').css('height','100%');
    $('#portfolio article.portfolio-item').css('width',itemWidth);
    $('#portfolio article.portfolio-item .portfolio-image-link .photo').css('height',itemHeight);
}

function ResetPortfolioItemsHeight(){
    "use strict";

    var itemHeight = Math.floor(Math.floor($(window).width())/5*0.595);
    $('#portfolio article.portfolio-item .portfolio-image-link .photo').css('height','inherit');
}


//Map Init
function LoadContactMap(){
    "use strict";

    var $gmapContainers = $('#contact-map');

    if(!$gmapContainers.length) return;

    var   lng  = parseFloat(contactParam.contactMediaMap.longitude);
    $gmapContainers.each(function(){

        var $map = $(this),
            $markers = $map.find('.gmap-marker'),
            zoom =  parseInt(contactParam.contactMediaMap.zoom),
            addr = contactParam.contactMediaMap.address,
            ctrl = false,
            lat  = contactParam.contactMediaMap.latitude,
            lng  = contactParam.contactMediaMap.longitude,
            markers = [],
            mapType = (contactParam.contactMediaMap.style == 'dark')?"Gray":google.maps.MapTypeId.ROADMAP;


        //Get marker data
        $markers.each(function(){
            var $marker = $(this),
                mlat    = contactParam.contactMediaMap.latitude,
                mlng    = contactParam.contactMediaMap.longitude,
                maddr   = contactParam.contactMediaMap.address,
                icon    = '"'+contactParam.contactMediaMap.marker+'"',
                marker  = {};



            if(mlat.length && mlng.length)
            {
                mlat = parseFloat(mlat);
                mlng = parseFloat(mlng);
                marker['latLng'] = [mlat, mlng];
            }
            else if(addr.length)
            {
                marker['address'] = maddr;
            }
            else
                return;

            //Set icon
            if(icon.length)
                marker['options'] = {icon: icon};
            else
                marker['options'] = {icon: contactParam.path.img + '/gmap-marker.png'};


            markers.push(marker);
        });



        var settings = {
            map:{
                options:{
                    zoom:zoom,
                    disableDefaultUI: !ctrl,
                    scrollwheel: false,
                    draggable: false,
                    mapTypeId:mapType,
                    mapTypeControlOptions: {
                        mapTypeIds: [google.maps.MapTypeId.ROADMAP, "Gray"]
                    }
                }
            },
            styledmaptype:{
                id: "Gray",
                options:{
                    name: "Gray"
                },
                styles:[
                    {
                        featureType: "water",
                        elementType: "geometry",
                        stylers: [
                            { color : "#1d1d1d" },
                            { visibility: "simplified" }
                        ]
                    },{
                        featureType: "landscape",
                        stylers: [
                            {color: "#3e3e3e" },
                            {lightness: 7 }
                        ]
                    },{
                        featureType: "administrative.country",
                        elementType: "geometry.stroke",
                        stylers: [
                            { color: "#5f5f5f" },
                            { weight : 1 }
                        ]
                    },{
                        featureType: "landscape.natural.terrain",
                        stylers: [
                            { color : "#4f4f4f" }
                        ]
                    },{
                        featureType: "road",
                        stylers: [
                            { color: "#393939" }
                        ]
                    },{
                        featureType: "administrative.country",
                        elementType: "labels",
                        stylers: [
                            { visibility: "on" },
                            { weight: 0.4 },
                            { color: "#686868" }
                        ]
                    },{
                        eatureType: "administrative.locality",
                        elementType: "labels.text.fill",
                        stylers: [
                            { weigh: 2.4 },
                            { color: "#9b9b9b" }
                        ]
                    },{
                        featureType: "administrative.locality",
                        elementType: "labels.text",
                        stylers: [
                            { visibility: "simplified" },
                            { lightness: -80 }
                        ]
                    },{
                        featureType: "poi",
                        stylers: [
                            { visibility: "off" },
                            { color: "#d78080" }
                        ]
                    },{
                        featureType: "administrative.province",
                        elementType: "geometry",
                        stylers: [
                            { visibility: "simplified" },
                            { lightness: -80 }
                        ]
                    },{
                        featureType: "water",
                        elementType: "labels",
                        stylers: [
                            { color: "#adadad" },
                            { weight: 0.1 }
                        ]
                    },{
                        featureType: "administrative.province",
                        elementType: "labels.text.fill",
                        stylers: [
                            { color: "#3a3a3a" },
                            { weight: 4.8 },
                            { lightness: -69 }
                        ]
                    }

                ]
            },
            marker:{
                values:[
                    {'latLng': [lat,lng]}
                ],
                options:{
                    'icon':new google.maps.MarkerImage(String(contactParam.contactMediaMap.marker))
                }
            }
        };

        //Prefer lat/lng over address
        if(lat.length && lng.length)
        {
            lat = parseFloat(lat);
            lng = parseFloat(lng);
            settings.map.options['center'] = [lat, lng];
        }
        else if(addr.length)
        {
            settings.map['address'] = addr;
        }
        else
        {
            //Default location
            settings.map.options['center'] = [29.697421,52.470375];
        }

        //Add markers
        if(markers.length)
        {
            settings['marker'] = {values: markers};
        }
        $map.gmap3(settings);
    });
}
//end Map init

function ContactTopBar(){
    "use strict";
    var $contactBtn = $('#page-top-menu nav.top-menu li.contactitem a, #page-top-menu div.mobile-menu-bottons a.navigation-button span.contact, nav.navigation-mobile ul.menu li.contactitem a');
    
    

    if (! $contactBtn.length ) return;

    if(contactParam.contactMedia == 'image'){
        $('#contact-map').css({'background-image':'url('+contactParam.contactMediaImage+')','background-size':'cover','background-position':'center'});
    }else if(contactParam.contactMedia == 'map'){
        LoadContactMap ();
    }


    $contactBtn.click(function(e){
        e.preventDefault();
        $('#contact-topbar').animate({top: '0px',opacity:1}, 1000, 'easeInOutQuart',function(){
            var $             = jQuery,
                $body         = $('body'),
                $navContainer = $('.navigation-mobile');
            if($body.hasClass('pushed-left'))
            {
                $body.removeClass('pushed-left');
                setTimeout(function(){
                    $navContainer.css({display:'none'});
                }, 330);
            }
        });
        return false;
    });
    $('#contact-topbar .control-bar a.close-btn').click(function(){
        var WinHeight = $(window).height();
        $('#contact-topbar').animate({top: WinHeight*(-1),'opacity':0}, 1000, 'easeInOutQuart');
        return false;
    });
}

function ResetItemsSize(){
    "use strict";

    if($('#contact-topbar').css('top')!='0px'){
        //Reset Contact-TopBar Top Position
        var WinHeight = $(window).height();
        $('#contact-topbar').css({'top':WinHeight*(-1),'opacity':0});
    }
}

function MagnificPopUp(){
    "use strict";
    if(!$('.portfolio-image-link').length){
        return;
    }
    $('.portfolio-image-link').magnificPopup({
        type: 'ajax',
        mainClass: 'my-mfp-zoom-in',
        removalDelay: 0,
        preloader: true,
        fixedContentPos: true,
        fixedBgPos: true,
        callbacks: {
            parseAjax: function(mfpResponse) {
                mfpResponse.data = $(mfpResponse.data).find('.portfolio-container');
            },
            ajaxContentAdded: function() {
                PortfolioFlexSlider();
            },
            afterClose: function() {

            }

        }
    });
}

function PortfolioFlexSlider(){
    "use strict";

    $('body.home .flexslider').flexslider({
        controlNav: false,
        //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
        directionNav: true,
        //Boolean: Create navigation for previous/next navigation? (true/false)
        prevText: "",
        //String: Set the text for the "previous" directionNav item
        nextText: "",
        //String: Set the text for the "next" directionNav item
        slideshow: false,
        //Boolean: Animate slider automatically
        animation: "fade",
        //String: Select your animation type, "fade" or "slide"
        controlsContainer: ".slider-nav-controls-container",
        animationSpeed:700,

        start: function(slider){
            var navControlsContainer = $(this.controlsContainer);
            navControlsContainer.append('<div class="slider-status"><span class="current-slide-number"></span>/<span class="total-slides-count"></span></div>');

            $(this.controlsContainer + ' .current-slide-number').html(slider.currentSlide+1);
            $(this.controlsContainer + ' .total-slides-count').html(slider.count);
        },

        before: function(slider){
            var MySlideNumber;
            if(slider.direction=="next"){
                MySlideNumber = slider.currentSlide+2;
            }
            else{
                MySlideNumber = slider.currentSlide;
                if(MySlideNumber==0){
                    MySlideNumber = slider.count;
                }
            }
            if(MySlideNumber > slider.count){
                MySlideNumber=1;
            }
            $(this.controlsContainer + ' .current-slide-number').html(MySlideNumber);
        }
    });
}

// Post Gallery handler
function postGallery (){
    "use strict";
   
    
    var $ = jQuery;

    var x=$('body.blog,body.single-post,body.archive');

    if(!$('body.blog,body.single-format-gallery,body.archive,body.home .blog-part').length) return;

    var $flexSlider = $('.flexslider');
    
    
    //Don't load flex slider for less than two slides
    if(!($flexSlider.find('.slides > li').length < 2))
    {
        $flexSlider.flexslider({"slideshow":true,"slideshowSpeed": 3000, });
    }
};

function MobileMenu() {
    "use strict";

    var $             = jQuery,
        $body         = $('body'),
        $doc          = $(document),
        $layout       = $('body > .main'),
        $navContainer = $('.navigation-mobile'),
        $closeBtn     = $navContainer.find('.navigation-close'),
        $navBtn       = $('.navigation-button:first-child'),
        dontResize    = false,
        isTouchDevice = 'ontouchstart' in window || 'onmsgesturechange' in window;// second test works on ie10 (surface)

    //Set overflow-y on mobile devices
    if(isTouchDevice)
        $navContainer.css({overflowY: 'scroll'});

    $navBtn.click(function(e){
        e.preventDefault();
        e.stopPropagation();

        if(!$body.hasClass('pushed-left'))
        {
            $navContainer.css({display:'block', height: $layout.outerHeight()});
            $body.toggleClass('pushed-left');
        }
        else
            CloseMenu();
    });

    function CloseMenu()
    {
        if($body.hasClass('pushed-left'))
        {
            $body.removeClass('pushed-left');
            setTimeout(function(){
                $navContainer.css({display:'none'});
            }, 330);
        }
    }

    //Prevent resize event on IOS webkit browsers
    $doc.on('touchstart', function(e){
        var touch = e.originalEvent.touches[0] || e.originalEvent.changedTouches[0],
            $target = $(touch.target);

        if($target.is($navContainer) || $target.parents('.navigation-mobile').length)
            dontResize = true;

    }).on('touchend', function(){
        setTimeout(function(){dontResize = false;}, 1000);
    });


    $closeBtn.click(CloseMenu);

    $navContainer.click(function(e){
        e.stopPropagation();
    });

    $doc.click(function(e){
        CloseMenu();
    });


}

// Home Video Background
function videoBackground(){
    "use strict";

    if ((typeof param == 'undefined')|| ($('.video-background').length) || param.type != 'video' )
        return;
    if ( ( $(window).width() < 1025)){
        if (param.altImg!=""){
            $('#intro').css({'background-image':'url('+param.altImg+')','background-size':'cover'});
        }else{
            $('#intro').css({'background-color':'#252525'});
        }
    }else{
        $('#intro').prepend('<div class="video-background visible-desktop hidden-tablet hidden-phone" style="height:'+$("#intro").height()+'px";></div>');
        $('.video-background').videoBG({
            mp4:param.videoFile.mp4,
            ogv:param.videoFile.ogg,
            webm:param.videoFile.webm,
            poster:param.altImg,
            scale:true,
            loop:true,
            zIndex:-1,
            sclae:false
        });

    }
    $('.video-background > video').bind('playing',function(){
        $(this).attr("poster","");

    });
}

function resetIntroVideoBGWidthOnPageResize(){
    "use strict";
    if(! $('#intro').lenghth ) return;

    var containerWidth = $('#intro').width();
    var containerHeight = $('#intro').height();
    $('#intro .videoBG_wrapper').height(containerHeight);
    $('#intro .videoBG_wrapper').width(containerWidth);
    $('#intro .videoBG').height(containerHeight);
    $('#intro .videoBG').width(containerWidth);
}

// Home Image Background
function imageBackground(){
    "use strict";
    if (! $('#intro .flexslider').length ) return;

    $('.slides li div').css({'width':$(window).width()});

    $('#intro .flexslider').flexslider({
        animation: "fade",
        controlNav:false,
        directionNav:false,
        after:function(){
            if (parseInt(state.detector) === 1)
                BackgroundCheck.refresh();
        }
    });

    $(window).resize(function(){
        $('.slides li div').css({'width':$(window).width()});
    });
}

function headerColor(){
    "use strict";
    if (parseInt(state.detector) === 0 || !$('#intro').length )
        return;

    BackgroundCheck.init({
        targets: '.top-menu',
        images: '.slides li div'
    });

}

function biographySection(){
    "use strict";
    if (! $('#intro').length) return;

    var $introHeight = $("#intro").height(),
        $containerHeight = $("#intro .container").height(),
        $marginTop,
        $headerHeight = $("header").height();
    if($('body div.main section')[0].id != 'intro'){
        $("#intro").css("margin-top",82);
        $marginTop = ($introHeight - $containerHeight) / 2;
    }else if($(window).width() <= 480){
        $marginTop = ($introHeight - $containerHeight) / 2;
    }else{
        $marginTop = (($introHeight + $headerHeight) - $containerHeight) / 2;
    }
    $("#intro .container").css("margin-top",$marginTop);

}

// Content Animation
function contentAnimation(){
    "use strict";

    var $ = jQuery;
    if($(window).width() <= 480){
        return
    }
    var $Exp             = $('.experience-parts .experience-part'),
        $education       = $('.education-parts .education-part'),
        $intro           = $('#intro > .container'),
        $portfolio       = $(".portfolio-container"),
        $expAnimation    = $('#experience').hasClass('animation'),
        $eduAnimation    = $('#education').hasClass('animation'),
        $introAnimation  = $('#intro').hasClass('animation'),
        $portAnimation   = $('#portfolio').hasClass('animation');


    $('#intro.animation').not('.animation-done').addClass('animation-waiting');
    $('#experience.animation').not('.animation-done').addClass('animation-waiting');
    $('#education.animation').not('.animation-done').addClass('animation-waiting');
    $('#portfolio.animation').not('.animation-done').addClass('animation-waiting');


    var eduFlag   = $('#education.animation').hasClass('animation-waiting'),
        expFlag   = $('#experience.animation').hasClass('animation-waiting'),
        introFlag = $('#intro.animation').hasClass('animation-waiting'),
        portfolioFlag = $('#portfolio.animation').hasClass('animation-waiting'),
        eduTop,expTop,introTop,portfolioTop,i;


    function setFirstTimeProperties(){
        if(introFlag){
            if($('#intro div.face-photo').length > 0){
                TweenMax.set('#intro .face-photo-container', {alpha:"0", rotationX:36, rotationY:-90, rotationZ:-18, scaleX:"1.1", scaleY:"1.1"}); // Biography avatar animation
            }

            if($('#intro .about .about-name').length > 0){
                TweenMax.set('#intro .about .about-name', {autoAlpha:"0", paddingTop:"30px"}); // Biography content animation
            }

            if($('#intro .about .description').length > 0){
                TweenMax.set($('#intro .about .description'), {autoAlpha:"0", marginLeft:"-30px", paddingRight:"30px"}); // Biography content animation
            }

            if($('#intro .about .signature').length > 0){
                TweenMax.set($('#intro .about .signature'), {autoAlpha:"0", marginLeft:"-30px"}); // Biography content animation
            }

        }

        if(expFlag && ($Exp.length > 0)){
            TweenMax.set($('.experience-parts .experience-part'), {autoAlpha:"0", marginLeft:"-30px"}); // experience avatar animation
        }

        if(eduFlag && ($education.length > 0)){
            TweenMax.set($('.education-parts .education-part'), {autoAlpha:"0", marginLeft:"-30px"}); // experience avatar animation
        }

        if (portfolioFlag && ($portfolio.length > 0)){
            //tweenMax.set($('#portfolio article.portfolio-item .portfolio-image-link img'), {autoAlpha:"0"});
        }
    }

//    setFirstTimeProperties();

    function doAnimation(){
        var sHeight   = $(document).scrollTop()+$(window).height();

        eduTop   = ($education.length > 0) ? $education.position().top : 5000;
        expTop   = ($Exp.length > 0) ? $Exp.position().top : 5000;
        introTop = ($intro.length > 0) ? $intro.position().top : 5000;
        portfolioTop = ($portfolio.length > 0) ? $portfolio.position().top : 5000;

        //Intro Animation
        if( sHeight > introTop && introFlag  && $introAnimation){
            showIntro();
        }//Education Animation
        if( sHeight > eduTop && eduFlag  && $eduAnimation){
            showEdu();

        }//Experience Animation
        if( sHeight > expTop && expFlag && $expAnimation){
            showExp();
        }//Portfolio animation
        if( sHeight > portfolioTop && portfolioFlag && $portAnimation){
            if ($(window).width() <= 480 )
                return;
            showPortfolio();
        }
    }
    doAnimation();

    function showIntro(){

        $('#intro.animation').removeClass('animation-waiting').addClass('animation-done');

        if($('#intro div.face-photo').length > 0){
            TweenMax.fromTo('#intro .face-photo-container', 1, {alpha:"0", rotationX:36, rotationY:-90, rotationZ:-18, scaleX:"1.1", scaleY:"1.1"},{alpha:"1", rotationX:0, rotationY:0, rotationZ:0, scaleX:"1", scaleY:"1", delay:"1", ease:Power4.easeOut }); // Biography avatar animation
        }

        if($('#intro .about .about-name').length > 0){
            TweenMax.fromTo('#intro .about .about-name', 1, {autoAlpha:"0", paddingTop:"30px"},{autoAlpha:"1", paddingTop:"0px", delay:"1", ease:Power4.easeOut }); // Biography content animation
        }

        TweenMax.fromTo($('#intro .about .separator'), 1, {autoAlpha:"0", paddingTop:"30px"},{autoAlpha:"1", paddingTop:"0", delay:"1.3", ease:Power4.easeOut }); // Biography content animation

        TweenMax.fromTo($('#intro .about .description'), 1, {autoAlpha:"0", paddingTop:"30px"},{autoAlpha:"1", paddingTop:"0px", delay:"1.6", ease:Power4.easeOut }); // Biography content animation
        if($('#intro .about .signature').length > 0){
            TweenMax.fromTo('#intro .about .signature', 1.5, {autoAlpha:"0", scale:"1.3"},{autoAlpha:"1", scale:"1", delay:"1.9", ease:Power4.easeOut }); // Biography content animation
        }
    }

    function showEdu() {

        $('#education.animation').removeClass('animation-waiting').addClass('animation-done');

        var exdelay = 0;
        eduFlag = false;

        for(i=0; i < $education.length;i++){
            exdelay = exdelay + 0.3;
            TweenMax.fromTo($('.education-parts .education-part')[i], 2,{autoAlpha:"0", marginTop:"50px"}, {autoAlpha:"1", marginTop:"0px", delay:exdelay, ease:Power4.easeOut }); // experience avatar animation
        }
    }

    function showExp() {
        $('#experience.animation').removeClass('animation-waiting').addClass('animation-done');

        var exdelay = 0;
        expFlag = false;

        for(i=0; i < $Exp.length;i++){
            exdelay = exdelay + 0.3;
            TweenMax.fromTo($('.experience-parts .experience-part')[i], 2, {autoAlpha:"0", marginTop:"50px"}, {autoAlpha:"1", marginTop:"0px", delay:exdelay, ease:Power4.easeOut}); // experience avatar animation
        }
    }

    function showPortfolio(){

        var $lists = $('.portfolio-container'),
        $items = $lists.find('.portfolio-item'),
        $images   = $lists.find('img');

        //Fade-in portfolio images
        $items.each(function(i){
            var $item = $(this);
            setTimeout(function(){$item.addClass('start-animation');}, i*200);
        });
    }
}


function portfolioLoadMore() {

    "use strict";
    var $ppageNav = $('.portfolio-pagination'),
        $pblog    = $('#portfolio_loop'),
        $portfolio_gallery = $('#portfolio');

    if (typeof portfolio_data == 'undefined' || $ppageNav.length < 1)
        return;

    var startPage = parseInt(portfolio_data.startPage),
        nextPage  = startPage + 1,
        max       = parseInt(portfolio_data.maxPages),
        isLoading = false;

    if (max < 2) {
        if(startPage > 1){
            $('.loadmore-btn').hide();
            $('.loadmore').css('width','125');
            $('.loadmore-text').css('display','block');
            $ppageNav.html('<div class="loadmore">' + portfolio_data.noMorePostsText + '</div>');
        }
        return
    };

    //Replace links with load more button

    $ppageNav.html('<div class="loadmore"><span class="loadmore-btn"></span><span class="loadmore-text">' + portfolio_data.loadMoreText + '</span></div>');
    var $btn = $('.loadmore'),
        $btnText = $('.loadmore-text');
    if (nextPage > max)
        $btnText.text(portfolio_data.noMorePostsText);
    var resTimer = 0;
    $(window).resize(function () {
        clearTimeout(resTimer);
        resTimer = setTimeout(function () {
            if ($(window).width() < 768) {
                $ppageNav.insertAfter($portfolio_gallery);
            }
            else {
                //$ppageNav.insertAfter($portfolio_gallery);
            }
        }, 100);
    }).resize();
    $btn.click(function () {
        if (nextPage > max || isLoading)
            return;
        isLoading = true;
        //Set loading text
        $btnText.text(portfolio_data.loadingText);
        var $pageContainer = $('<div class="posts-page-'+nextPage+'"></div>');
        var $pagedNum = 'paged';
        portfolio_data.nextLink = portfolio_data.nextLink.replace(/\/page\/[0-9]+/, '/?'+$pagedNum+'=' + parseInt(nextPage));
        portfolio_data.nextLink = portfolio_data.nextLink.replace(/paged=[0-9]+/, $pagedNum+'=' + parseInt(nextPage));
        portfolio_data.nextLink = portfolio_data.nextLink.replace(/paged_[0-9]+=[0-9]+/, $pagedNum+'=' + parseInt(nextPage));
        $pageContainer.load(portfolio_data.nextLink + ' .portfolio-item', function () {
            //Insert the posts container before the load more button
            $pageContainer.appendTo('.portfolio-container');
            // Update page number and nextLink.
            nextPage++;
            if (/\/page\/[0-9]+/.test(portfolio_data.nextLink)){
                portfolio_data.nextLink = portfolio_data.nextLink.replace(/\/page\/[0-9]+/, '/page/' + nextPage);
            } else{
                portfolio_data.nextLink = portfolio_data.nextLink.replace(/paged1=[0-9]+/, 'paged=' + nextPage);
            }

            if (nextPage <= max){
                $btnText.text(portfolio_data.loadMoreText);
            } else if (nextPage > max){
                $('.loadmore-btn').hide();
                $('.loadmore').css('width','125');
                $('.loadmore-text').css('display','block');
                $btnText.text(portfolio_data.noMorePostsText);
                $('.portfolio-loadmore').fadeOut(3000);
            }

            isLoading = false;
            var num = nextPage;
            num--;

            var $items = $('.portfolio-item');
            var $container = $('.portfolio-container');
            $container.isotope( 'appended', $items, function() {
                $container.isotope('reLayout');
            });
            SetPortfolioItemsHeight();
            SF_Portfolio_Filters();
            PortfolioFilter();
            MagnificPopUp();
            PortfolioFlexSlider();
        });
    });
}

// Testimonial widget handler
function testimonialWidget (){
    "use strict";
    var $ = jQuery,
        $testimonials = $('.widget_px_testimonials');

    if(!$testimonials.length) return;

    //Init lists
    $testimonials.each(function(){
        var $testimonial = $(this),
            $list  = $testimonial.find('ul'),
            $items = $list.find('> li'),
            $li0   = $items.eq(0),
            $ctrls = $testimonial.find('.testimonials-controls'),
            $next  = $ctrls.find('.next'),
            $prev  = $ctrls.find('.previous');

        if($items.length < 2){
            $ctrls.hide();
            return;
        }

        //Init items
        $items.each(function(i){
            var $item   = $(this),
                w       = $list.width();

            $item.css({ position: 'absolute', width: w, top: 0, left: i * w, display:'block' });
        });

        $li0.addClass('current');
        $list.css({height: $li0.height()});


        $next.click(function(e){
            e.preventDefault();

            var curIndx = $items.filter('.current').index(),
                nextIndx = curIndx + 1;

            if (nextIndx >= $items.length)
                nextIndx = 0;

            GoTo(nextIndx, $list, $items);
        });

        $prev.click(function(e){
            e.preventDefault();

            var curIndx = $items.filter('.current').index(),
                nextIndx = curIndx - 1;

            if (nextIndx < 0)
                nextIndx = $items.length - 1;

            GoTo(nextIndx, $list, $items);
        });

        HandleResize($list, $items);
    });//$lists.each


    function GoTo(i, $list, $items) {
        var width     = $list.width(),
            $nextItem = $items.eq(i),
            $nextItemName = $nextItem.find('.name');

        $items.removeClass('current');
        $nextItem.addClass('current');

        //Animate list height
        $list.stop().animate({ height: $nextItem.height() }, { speed: 300 });

        $nextItemName.css({visibility:'hidden', opacity:0});

        $items.each(function (j) {
            var $item = $(this);

            $item.stop().animate({ left: (j - i) * width }, { speed: 300, complete: function(){ $nextItemName.css({visibility:'visible', opacity:1}); } });
        });
    }

    function HandleResize($list, $items)
    {
        smartResize(function(){
            var $curItem = $items.filter('.current'),
                curIndx  = $curItem.index();

            $items.each(function (i) {
                var $item = $(this),
                    w     = $list.width();

                $item.css({ width: w, left: (i - curIndx) * w });
            });

            //Change parent height
            $list.stop().animate({ height: $curItem.height() }, { speed: 300 });

        }, 100);

    }

};

// Smart window resize handler
function smartResize(handler, delay){
    "use strict";
    var resizeTimer = 0;
    return jQuery(window).resize(function(){
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(handler, delay);
    });
    return smartResize;
};

/* Testimonials Rotators */
function testimonials() {
    "use strict";



    if($(window).width()>768){
        $(".descriptions ").flexslider({
            animation: "slide",
            direction:"vertical",
            slideshow: true,
            slideshowSpeed: 6000,
            animationSpeed: 600,
            controlsContainer: $(".tab-selectors"),
            easing: "swing",
            pauseOnHover: true,
            touch: true,
        });
    }
    else
    {
        $(".descriptions ").flexslider({
            animation: "fade",
            direction:"vertical",
            slideshow: true,
            slideshowSpeed: 6000,
            animationSpeed: 600,
            controlsContainer: $(".tab-selectors"),
            pauseOnHover: true,
            touch: true,
        });
    }



}

function printBtn(){
    "use strict";
    var $ = jQuery,
        $printBtn = $('a.print-box[href=#]') ;

    if (!$printBtn.length)
        return;

    $printBtn.click(function(e){
        e.preventDefault();
        window.print();

    });
}

// Timeline blog Animation
function blogAnimation(){
    "use strict";
    var $      = jQuery,
        smallElements = $('.posts');

    if (! smallElements.length) return;

    $(window).scroll(function(){

        $('article.post').each(function(){
            var $this    = $(this),
                sHeight  = $(window).scrollTop()+ $(window).height(),
                position = $this.position(),
                elemTop  = position.top + $(this).outerHeight()-250,
                $circle  = $this.find('.circle'),
                $line    = $this.find('.line'),
                $line1   = $this.find('.hr-line'),
                $year    = $this.find('.year'),
                $md      = $this.find('.day-month');

            if(! $this.hasClass('small')) return;

            if( ( sHeight > elemTop  )&&($(window).width()>480)){
                TweenMax.to($circle,.5,{scale:(1),opacity:0.7});
                TweenMax.to($line,.5,{css:{height:"100%",opacity:0.7},delay:.4});
            }else if($(window).width()<=480){
                TweenMax.to($circle,.5,{scale:(1),opacity:1});
                vCenter($line1);
            }


        });

    });

}

function pageHeight(){
    "use strict";

    var $page = $('.blog, .page, .search,.single,.error404 , .archive'),
        $main = $('.main') ,
        $mainPart = $('.main > div , .main > section'),
        windowH = $(window).height(),
        footerHeight = $('footer').height();


    if(! $page.length) return;

    if( $main.height()< windowH ){
        $mainPart.css({'height':windowH-footerHeight});
    }
}


function instagramWidget(){
    'use strict';

    $('.widget-instagram').each(function(){
        var $this = $(this),
            firstItem = $this.find('.item:first').clone();
        $this.find('.featured-item').css({'height':($this.find('.featured-item').width())});
        $this.find('.featured-item').append(firstItem).fadeIn('slow');

        $this.find('.item').click(function(){
            $this.find('.featured-item .item').fadeOut().remove();
            $this.find('.featured-item').append($(this).clone());
            $this.find('.featured-item .item').hide().fadeIn(800);
        });
    });
}

function menuchange(){

    console.log(appdata)
   $(".menu-item-type-custom").each(function(){

       href=$(this).find("a").attr("href");
       mystring=href.split("#");
       newhref=appdata.siteaddress +"/#"+mystring[1];
       $(this).find("a").attr("href",newhref);
   })


}

// Load Functions
$(document).ready(function(e) {
    "use strict";
    imageBackground();
    videoBackground();
    biographySection();
    blogAnimation();
    pageHeight();
    SetPortfolioItemsHeight();
    ContactTopBar();
    ResetItemsSize();
    PieChartLoader();
    SF_Top_Menu();
    SF_Portfolio_Filters();
    NavSmoothScroll();
    SmoothScroll();
    NavTooltip();
    PortfolioFilter();
    PortfolioFlexSlider();
    portfolioLoadMore();
    testimonialWidget();
    MagnificPopUp();
    MobileMenu();
    contentAnimation();
    headerColor();
    testimonials();
    printBtn();
    postGallery();
    menuchange();
});

$(document).scroll(function(e) {
    "use strict";

    PieChartLoader();
    contentAnimation();
});

$(window).resize(function(e) {
    "use strict";

    resetIntroVideoBGWidthOnPageResize();
    SetPortfolioItemsHeight();
    PieChartLoader();
    ResetItemsSize();
    testimonials();
});