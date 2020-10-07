document.addEventListener("DOMContentLoaded", function() {

  const body = document.querySelector('body');
  const albumNavCurtain = document.querySelector('.js-album-nav-curtain');
  const albumNavToggle = document.querySelector('.js-album-nav-toggle');

  albumNavToggle.addEventListener('click', (e) => {
    body.classList.toggle('js-album-nav-shown');
  });

  albumNavCurtain.addEventListener('click', (e) => {
    body.classList.remove('js-album-nav-shown');
  });


  document.onkeydown = function(evt) {
    evt = evt || window.event;
    var isEscape = false;
    if ("key" in evt) {
        isEscape = (evt.key === "Escape" || evt.key === "Esc");
    } else {
        isEscape = (evt.keyCode === 27);
    }
    if (isEscape) {
      body.classList.remove('js-album-nav-shown');
    }
};

});
