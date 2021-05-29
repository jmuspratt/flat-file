document.addEventListener("DOMContentLoaded", function() {

  const body = document.querySelector('body');
  const albumNavCurtain = document.querySelector('.js-album-nav-curtain');
  const albumNavToggle = document.querySelector('.js-album-nav-toggle');
  const albumNavClose = document.querySelector('.js-album-nav-close');


  // Clicking btn toggles album nav
  albumNavToggle.addEventListener('click', (e) => {
    body.classList.toggle('js-album-nav-shown');
  });

  // Clicking background "curtain" closes album nav
  albumNavCurtain.addEventListener('click', (e) => {
    body.classList.remove('js-album-nav-shown');
  });

  albumNavClose.addEventListener('click', (e) => {
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
      closeLightBox();
    }
  };

  // Click an image/video to expand
  const lightboxTriggers = document.querySelectorAll('.js-lightbox-trigger');
  const lightboxContent  = document.querySelector('.lightbox__content');
  const lightboxClosers  = document.querySelectorAll('.js-lightbox-close');


  function closeLightBox() {
    body.classList.remove('js-lightbox-shown');
    lightboxContent.innerHTML = '';
  }

  // Clicking a closer closes lightbox
  lightboxClosers.forEach(closer=>{
    closer.addEventListener('click', (e) => {
      closeLightBox();
    });
  });


  lightboxTriggers.forEach(item=>{

    console.log('adding', item);

    item.addEventListener('click', (e) => {
      body.classList.add('js-lightbox-shown');

      e.preventDefault();
      const target = e.target;

      if (target.tagName == 'IMG') {
        const duplicateImg = target.cloneNode(true);
        lightboxContent.appendChild(duplicateImg);
      }

      if (target.tagName == 'VIDEO') {

        const source = target.querySelector('source').getAttribute('src');

        const markup = `
        <video controls autoplay>
          <source src="${source}" />
        </video>
        `;

        lightboxContent.innerHTML = markup;
      }

    });
  });

});
