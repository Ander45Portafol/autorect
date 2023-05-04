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
function updateCarousel(){
  var multipleCardCarousel = document.querySelector(
    "#carouselExampleControls"
  );
  if (window.matchMedia("(min-width: 768px)").matches) {
    multipleCardCarousel.classList.remove("slide");
    var carouselInner = document.querySelector(".carousel-inner");
    var carouselWidth = carouselInner.scrollWidth;

    var carouselItems = document.querySelectorAll(".carousel-item");
    var cardWidth = carouselItems[0].offsetWidth;
    var scrollPosition = 0;

    var nextButton = document.querySelector("#carouselExampleControls .carousel-control-next");
    nextButton.addEventListener("click", function() {
      if (scrollPosition < carouselWidth - cardWidth * 4) {
        scrollPosition += cardWidth;
        var carouselInner = document.querySelector("#carouselExampleControls .carousel-inner");
        carouselInner.scrollTo({
          left: scrollPosition,
          behavior: "smooth"
        });
      }
    });

    var prevButton = document.querySelector("#carouselExampleControls .carousel-control-prev");
    prevButton.addEventListener("click", function() {
    if (scrollPosition > 0) {
      scrollPosition -= cardWidth;
      var carouselInner = document.querySelector("#carouselExampleControls .carousel-inner");
      carouselInner.scrollTo({
        left: scrollPosition,
        behavior: "smooth"
      });
    }
    });
  } else {
    multipleCardCarousel.classList.add("slide");
  }
}

updateCarousel();

window.addEventListener("resize", function() {
  updateCarousel();
});