"use strict";
// images are loaded here, so they get preprocessed by webpack.
// however, commented out because it throws an error:
// Module not found: Error: request argument is not a string
// const images = [require("../images/plussign.svg")];

(function ($, Drupal) {
  Drupal.behaviors.onLoad = {
    attach: function (context, settings) {
      // on scroll fade small logo in menu
      if ($("body").hasClass("path-frontpage")) {
        $(document).scroll(function () {
          let pageHeader = $(".page--header");
          const offsetTop = $(".js-content--header").offset().top;
          const pageHeaderFadedIn = pageHeader.hasClass("fade-in");
          if (offsetTop <= $(document).scrollTop() && !pageHeaderFadedIn) {
            pageHeader.addClass("fade-in");
          } else if (offsetTop > $(document).scrollTop() && pageHeaderFadedIn) {
            pageHeader.removeClass("fade-in");
          }
        });
      }

      $(".superhero--view-mode-volunteer-profile", context)
        .find(".field--name-field-u-volunteer-about")
        .before(
          "<div class='expand'><span>" + Drupal.t("Read more") + "</span></div>"
        );
      $(".expand").click((el) => {
        let $parent = $($(el.target).parents(".superhero--prosa"));

        $parent.addClass("show-more");
        $(el.target).remove();
      });

      // add wrapper on users data
      $(".people .field--name-field-u-first-name")
        .parent()
        .addClass("main-data-wrapper");

      let users = $(".superhero");

      users.each(function (index, item) {
        if ($(item).find("img").length === 0) {
          $(item)
            .find(".superhero--profile")
            .prepend('<img src="/themes/drupalnyc/user-placeholder.png"/>');
        }
      });
    }
  };

  Drupal.behaviors.clickEvents = {
    attach: function (context, settings) {
      let mainMenu = $(".menu--main");
      $(".hamburger").click(function () {
        if (mainMenu.hasClass("open")) {
          mainMenu.removeClass("open");
          $("main").removeClass("mobile-menu-opened");
        } else {
          mainMenu.addClass("open");
          $("main").addClass("mobile-menu-opened");
        }
      });
    }
  }

  Drupal.behaviors.ticketing = {
    attach: function (context, settings) {
      // Set donation to checked once value is changed for donation amount.
      $('input[name="price_2"]').change(function () {
        $('input[name="item_2"]').prop("checked", true);
      });
    },
  };
  function myFunction(x) {
    if (x.matches) {
      // If media query matches

      $(".page--header")
        .addClass("mobile--page--header")
        .removeClass("page--header");
    } else {
      $(".mobile--page--header")
        .addClass("page--header")
        .removeClass("mobile--page--header");
    }
  }

  let x = window.matchMedia("(max-width: 1023px)");
  myFunction(x); // Call listener function at run time
  x.addListener(myFunction); // Attach listener function on state changes
})(jQuery, Drupal);
