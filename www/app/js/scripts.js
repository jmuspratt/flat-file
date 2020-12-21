document.addEventListener("DOMContentLoaded", function() {

  const body = document.querySelector('body');
  const albumNavCurtain = document.querySelector('.js-album-nav-curtain');
  const albumNavToggle = document.querySelector('.js-album-nav-toggle');
  const lightboxTriggers = document.querySelectorAll('.js-lightbox-trigger');

  // Clicking btn toggles album nav
  albumNavToggle.addEventListener('click', (e) => {
    body.classList.toggle('js-album-nav-shown');
  });

  // Clicking background "curtain" closes album nav
  albumNavCurtain.addEventListener('click', (e) => {
    body.classList.remove('js-album-nav-shown');
  });

  // Pressing escape key closes album nav
  document.onkeydown = function(evt) {
    evt = evt || window.event;
    let isEscape = false;
    if ('key' in evt) {
      isEscape = (evt.key === "Escape" || evt.key === "Esc");
    } else {
      isEscape = (evt.keyCode === 27);
    }
    if (isEscape) {
      body.classList.remove('js-album-nav-shown');
    }
  };

  // Click an image/video to expand
  lightboxTriggers.forEach(item=>{
    item.addEventListener('click', (e) => {
      e.preventDefault();
      const target = e.target;
      console.log(target.tagName);

      if (target.tagName == 'IMG') {
      }

      if (target.tagName == 'VIDEO') {
        const source = target.querySelector('source').getAttribute('src');

        const markup = `
        <video controls autoplay>
          <source src="${source}" />
        </video>
        `;
        console.log(markup);
      }

    });
  });

});
