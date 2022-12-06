(function ($, Drupal) {
    ("use strict");

    const scrollToTop = () => {
        window.scrollTo({top: 0, behavior: 'smooth'});
    };

    const initScrollToTopTrigger = () => {
        var trigger = injectFixedButton();
        attachScrollListener(trigger);
    };

    const injectFixedButton = () => {
        var container = document.createElement('div'); 
        container.classList.add('back-to-top');
        document.body.appendChild(container);

        var trigger = document.createElement('button');
        trigger.textContent = 'Back to top';
        trigger.classList.add('back-to-top__trigger', 'btn', 'btn-prefix-chevron-up');
        trigger.addEventListener('click', scrollToTop);
        container.appendChild(trigger);

        return trigger;
    };

    const attachScrollListener = (triggerElem) => {

        var onScrollBehavior = function() {
          var y = window.scrollY;
          if (y >= 150) {
            triggerElem.classList.add('active');
          } else {
            triggerElem.classList.remove('active');
          }
        };
        
        window.addEventListener("scroll", onScrollBehavior);
    };

    Drupal.behaviors.back_to_top = {
      attach: function (context, settings) {
        $(document, context).once('back_to_top').each(initScrollToTopTrigger);
      },
    };
  
  })(jQuery, Drupal);