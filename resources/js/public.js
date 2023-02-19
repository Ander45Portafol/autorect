/*Function to remove the transparency of the navbar*/ 
var nav = document.querySelector('nav');

window.addEventListener('scroll', function () {
  if(this.window.innerWidth < 1280){
    nav.classList.add('navbar2');
  }else{
    if (window.pageYOffset > 200) {
      nav.classList.add('navbar2');
    } else {
      nav.classList.remove('navbar2');
    }
  }
});


/*Function to make the carousel responsive*/
var multipleCardCarousel = document.querySelector(
  "#carouselExampleControls"
);
if (window.matchMedia("(min-width: 768px)").matches) {
  $(multipleCardCarousel).removeClass("slide");
  var carousel = new bootstrap.Carousel(multipleCardCarousel, {
    interval: false,
  });
  var carouselWidth = $(".carousel-inner")[0].scrollWidth;
  var cardWidth = $(".carousel-item").width();
  var scrollPosition = 0;
  $("#carouselExampleControls .carousel-control-next").on("click", function () {
    if (scrollPosition < carouselWidth - cardWidth * 4) {
      scrollPosition += cardWidth;
      $("#carouselExampleControls .carousel-inner").animate(
        { scrollLeft: scrollPosition },
        600
      );
    }
  });
  $("#carouselExampleControls .carousel-control-prev").on("click", function () {
    if (scrollPosition > 0) {
      scrollPosition -= cardWidth;
      $("#carouselExampleControls .carousel-inner").animate(
        { scrollLeft: scrollPosition },
        600
      );
    }
  });
} else {
  $(multipleCardCarousel).addClass("slide");
}