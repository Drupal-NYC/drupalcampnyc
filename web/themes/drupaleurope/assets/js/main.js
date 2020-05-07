'use strict';
// images are loaded here, so they get preprocessed by webpack.
const images = [
    require('../images/plussign.svg')
];

(function($) {
    Drupal.behaviors.onLoad = {
        onLoad: function (context, settings) {
            // on scroll fade small logo in menu
            if ($('body').hasClass('path-frontpage')) {
                $(document).scroll(function() {
                    let pageHeader = $(".page--header");
                    const offsetTop = $('.js-content--header').offset().top;
                    const pageHeaderFadedIn = pageHeader.hasClass("fade-in");
                    if (offsetTop <= $(document).scrollTop()
                        && !pageHeaderFadedIn) {
                      pageHeader.addClass('fade-in');
                    }
                    else if (offsetTop > $(document).scrollTop()
                        && pageHeaderFadedIn) {
                      pageHeader.removeClass('fade-in');
                    }
                });
            }

            $('.superhero--view-mode-volunteer-profile', context)
                .find('.field--name-field-u-volunteer-about')
                .before("<div class='expand'><span>" + Drupal.t('Read more') + "</span></div>");
            $('.expand').click(el => {
                let $parent = $($(el.target).parents('.superhero--prosa'));

                $parent.addClass('show-more');
                $(el.target).remove();
            });

            // add wrapper on users data
            $('.people .field--name-field-u-first-name').parent().addClass('main-data-wrapper');

            let users = $('.superhero');

            users.each(function(index, item) {
                if($(item).find('img').length === 0) {
                    $(item).find('.superhero--profile').prepend('<img src="/themes/drupaleurope/user-placeholder.png"/>');
                }
            });

        }(),
        clickEvents: function() {
            let mainMenu = $('.menu--main');
            $(".hamburger").click(function() {
                if(mainMenu.hasClass('open')) {
                    mainMenu.removeClass('open');
                    $('main').removeClass('mobile-menu-opened');
                }
                else {
                    mainMenu.addClass('open');
                    $('main').addClass('mobile-menu-opened');
                }
            });
        }()
    };

    Drupal.behaviors.ticketing = {
      attach: function(context, settings) {
        // Set donation to checked once value is changed for donation amount.
        $('input[name="price_2"]').change(function() {
          $('input[name="item_2"]').prop('checked', true);
        });
      }
  };
})(jQuery);
