var nav = document.querySelector('nav');

window.addEventListener('scroll', function () {
  if (window.pageYOffset > 200) {
    nav.classList.add('navbar2');
  } else {
    nav.classList.remove('navbar2');
  }
});