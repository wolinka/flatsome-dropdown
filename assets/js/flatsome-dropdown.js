/**
 * Flatsome Dropdown Plugin JS
 */
(function($) {
    'use strict';

    $(document).ready(function() {
        
        var $submenus = $('.flatsome-classic-submenu');

        // Overflow Screen Edge Detection (Left/Right bounds)
        function checkMenuBounds() {
            $submenus.each(function() {
                var $menu = $(this);
                // Only act on deep menus (level 2+) and when they are visible-ish or when hovered
                // Actually it's better to check on hover so it gets calculated right
            });
        }

        $('.has-classic-dropdown').on('mouseenter', function() {
            var $menu = $(this).children('.sub-menu');
            if ($menu.length === 0) return;

            // Check if this menu goes off-screen to the right
            var menuObj = $menu[0].getBoundingClientRect();
            var windowWidth = $(window).width();

            // If it exceeds the right viewport bounds
            if (menuObj.right > windowWidth) {
                // If it's a first level dropdown, we might want to shift it right instead of left
                var isFirstLevel = $(this).parent().hasClass('header-nav') || $(this).closest('ul').hasClass('nav');
                
                if (!isFirstLevel) {
                    // Deep level: open to the left
                    $menu.addClass('flow-left');
                } else {
                    // First level: usually just align right
                    $menu.css({ 'left': 'auto', 'right': '0' });
                }
            }
        }).on('mouseleave', function() {
            var $menu = $(this).children('.sub-menu');
            // We can optionally reset classes on mouseleave if needed
            // $menu.removeClass('flow-left').css({ 'left': '', 'right': '' });
        });

        // Touch Device Support (Double Tap to Go)
        // First tap opens submenu, second tap navigates to link.
        var isTouch = 'ontouchstart' in window || navigator.maxTouchPoints > 0;
        
        if (isTouch) {
            $('.has-classic-dropdown > a').on('click', function(e) {
                var $parent = $(this).parent();

                // If it's not opened yet
                if (!$parent.hasClass('touch-opened')) {
                    e.preventDefault(); // suppress navigation
                    
                    // Close other neighbors
                    $parent.siblings('.touch-opened').removeClass('touch-opened')
                           .find('.touch-opened').removeClass('touch-opened');

                    // Mark as opened
                    $parent.addClass('touch-opened');
                } else {
                    // It's already opened, allow navigation
                }
            });

            // Close all if touched outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.has-classic-dropdown').length) {
                    $('.touch-opened').removeClass('touch-opened');
                }
            });
        }

    });

})(jQuery);
