$(document).ready(function($){
    if( $('.c-pricing-modal').length > 0 ) {
        //set some form parameters
        var hiddenForm = document.getElementById('hidden-form');
        var device = checkWindowWidth(),
            tableFinalWidth = ( device == 'mobile') ? $(window).width()*0.9 : 210,
            tableFinalHeight = ( device == 'mobile' ) ? 93 : 500;
        var formMaxWidth = 900,
            formMaxHeight = 650,
            animating =  false;

        //set animation duration/delay
        var	animationDuration = 800,
            delay = 200,
            backAnimationDuration = animationDuration - delay;

        //store DOM elements
        var formPopup = $('.c-pricing-container'),
            coverLayer = $('.c-pricing-modal-overlay');

        //select a plan and open the signup form
        formPopup.on('click', 'button', function(event){
            var planID = $(this).attr('data-plan-id');
            var change = $(this).attr('data-change');

            var tokenInput = document.createElement('input');
            tokenInput.setAttribute('type', 'hidden');
            tokenInput.setAttribute('name', 'planID');
            tokenInput.setAttribute('value', planID);
            hiddenForm.appendChild(tokenInput);

            event.preventDefault();
            triggerAnimation( $(this).parents('.c-pricing__footer').parent('.c-pricing'), coverLayer, true, change);
        });

        function removePlanID() {
            $(hiddenForm).find('[name="planID"]').remove();
        }

        $(document).keyup(function(event){
            if( event.which=='27' ) {
                triggerAnimation( formPopup.find('.selected-table'), coverLayer, false);
                removePlanID();
            }
        });
        coverLayer.on('click', function(event){
            event.preventDefault();
            triggerAnimation( formPopup.find('.selected-table'), coverLayer, false);
            removePlanID();
        });

        //on resize - update form position/size
        $(window).on('resize', function(){
            requestAnimationFrame(updateForm);
        });
    }

    function setAction(change) {
        let action;
        if (change) {
            action = hiddenForm.querySelector('[name="change"]').value;
        } else {
            action = hiddenForm.querySelector('[name="subscribe"]').value;
        }
        hiddenForm.setAttribute('action', action);
    }

    function triggerAnimation(table, layer, bool, change) {
        if( !animating ) {
            layer.toggleClass('is-visible', bool);
            setAction(change);
            animateForm(table, bool);
            table.toggleClass('selected-table', bool);
        }
    }

    function animateForm(table, animationType) {
        animating = true;

        var tableWidth = table.outerWidth(),
            tableHeight = table.outerHeight(),
            tableTop = table.offset().top - $(window).scrollTop(),
            tableLeft = table.offset().left,
            form = $('.c-pricing-modal'),
            formPlan = form.find('.c-pricing-modal__copy'),
            formFinalWidth = formWidth(),
            formFinalHeight = formHeight(),
            formTopValue = formTop(formFinalHeight),
            formLeftValue = formLeft(formFinalWidth),
            formTranslateY = tableTop - formTopValue,
            formTranslateX = tableLeft - formLeftValue,
            windowWidth = $(window).width(),
            windowHeight = $(window).height();

        if( animationType ) {//open the form
            //set the proper content for the .cd-plan-info inside the form
            formPlan.html(table.html());

            //animate plan info inside the form - set initial width and hight - then animate them to their final values
            formPlan.velocity(
                {
                    'width': tableWidth+'px',
                    'height': tableHeight+'px',
                }, 50);

            form.find('.c-pricing-modal__content').velocity(
                {
                    'opacity': 1
                }, 50);

            form.find('.c-pricing-modal__content').velocity(
                {
                    'paddingLeft': tableWidth+'px'
                }, 50);

            //animate popout form - set initial width, hight and position - then animate them to their final values
            form.velocity(
                {
                    'width': tableWidth+'px',
                    'height': tableHeight+'px',
                    'top': formTopValue,
                    'left': formLeftValue,
                    'translateX': formTranslateX+'px',
                    'translateY': formTranslateY+'px',
                    'opacity': 1,
                }, 50, function(){
                    table.addClass('empty-box');

                    form.velocity(
                        {
                            'width': formFinalWidth+'px',
                            'height': formFinalHeight+'px',
                            'translateX': 0,
                            'translateY': 0,
                        }, animationDuration, [ 220, 20 ], function(){
                            animating = false;
                            setTimeout(function(){
                                form.children('.c-pricing-modal__form').addClass('is-scrollable');
                            }, 300);
                        }).addClass('is-visible');

                });
        } else {//close the form
            form.children('.c-pricing-modal__form').removeClass('is-scrollable');

            form.find('.c-pricing-modal__content').velocity(
                {
                    'opacity': 0
                }, 100);

            //animate plan info inside the form to its final dimension
            formPlan.velocity(
                {
                    'width': tableWidth+'px',
                }, {
                    duration: backAnimationDuration,
                    easing: 'easeOutCubic',
                    delay: delay
                });

            //animate form to its final dimention/position
            form.velocity(
                {
                    'width': tableWidth+'px',
                    'height': tableHeight+'px',
                    'translateX': formTranslateX+'px',
                    'translateY': formTranslateY+'px',
                }, {
                    duration: backAnimationDuration,
                    easing: 'easeOutCubic',
                    delay: delay,
                    complete: function(){
                        table.removeClass('empty-box');
                        form.velocity({
                            'translateX': 0,
                            'translateY': 0,
                            'opacity' : 0,
                        }, 0).find('.c-pricing-modal__form').scrollTop(0);
                        animating = false;
                    }
                }).removeClass('is-visible');

            //target browsers not supporting transitions
            if($('.no-csstransitions').length > 0 ) table.removeClass('empty-box');
        }
    }

    function checkWindowWidth() {
        var mq = window.getComputedStyle(document.querySelector('.c-pricing-modal'), '::before').getPropertyValue('content').replace(/"/g, '').replace(/'/g, '');
        return mq;
    }

    function updateForm() {
        var device = checkWindowWidth(),
            form = $('.c-pricing-modal');
        tableFinalWidth = ( device == 'mobile') ? $(window).width()*0.9 : 210;
        tableFinalHeight = ( device == 'mobile' ) ? 93 : 500;

        if(form.hasClass('is-visible')) {
            var formFinalWidth = formWidth(),
                formFinalHeight = formHeight(),
                formTopValue = formTop(formFinalHeight),
                formLeftValue = formLeft(formFinalWidth);

            form.velocity(
                {
                    'width': formFinalWidth,
                    'height': formFinalHeight,
                    'top': formTopValue,
                    'left': formLeftValue,
                }, 0).find('.c-pricing-modal__copy').velocity(
                {
                    'width': tableFinalWidth+'px',
                    'height': tableFinalHeight+'px',
                }, 0);
        }
    }

    //evaluate form dimention/position
    function formWidth() {
        return ( formMaxWidth <= $(window).width()*0.9) ? formMaxWidth : $(window).width()*0.9;
    }
    function formHeight() {
        return ( formMaxHeight <= $(window).height()*0.9) ? formMaxHeight : $(window).height()*0.9;
    }
    function formTop(formHeight) {
        return ($(window).height() - formHeight)/2;
    }
    function formLeft(formWidth) {
        return ($(window).width() - formWidth)/2;
    }

});
