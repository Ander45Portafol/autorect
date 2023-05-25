//Paths to the API
const PRODUCT_API = 'bussines/public/products.php';
const MEMBERSHIP_API = 'bussines/public/memberships.php';

//HTML elements
const CAROUSEL = document.getElementById('product-carousel');
const MEMBERSHIP_ROW = document.getElementById('memberships-row');

//Fill sections when the DOM is loaded
document.addEventListener('DOMContentLoaded', async () => {
    fillCarousel();
    fillMemberships();
})

//Function to keep the carousel responsive when resizing
window.addEventListener("resize", function () {
    updateCarousel();
});

/*Function to fill the memberships*/ 
async function fillMemberships(){
    const JSON = await dataFetch(MEMBERSHIP_API, 'readImgs');
    if (JSON.status) {
        JSON.dataset.forEach(row => {
            MEMBERSHIP_ROW.innerHTML += `    
            <img src="../../api/images/memberships/${row.imagen_membresia}" alt="${row.tipo_membresia}">
            `;
        })
    }
}

/*Function to fill the carousel*/ 
async function fillCarousel(){
    var count = 0;
    const JSON = await dataFetch(PRODUCT_API, 'readTop10');
    if (JSON.status) {
        JSON.dataset.forEach(row => {
            const carouselClass = count === 0 ? 'carousel-item active' : 'carousel-item';
            var url = `product_details.html?id=${row.id_producto}&categoria=${row.id_categoria}`;
            CAROUSEL.innerHTML += `    
            <div class="${carouselClass}">
                        <div class="card">
                            <div class="img-wrapper">
                                <img src="../../api/images/products/${row.imagen_principal}" alt="Slide">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">${row.nombre_producto} - $${row.precio_producto}</h5>
                                <p class="card-text">${row.descripcion_producto}</p>
                                <a href="${url}" class="btn btn-primary">More details</a>
                            </div>
                        </div>
                    </div>               
            `;

            var cards = document.querySelectorAll('#carouselExampleControls .card');
            var maxHeight = 0;

            cards.forEach(function(card) {
                var cardHeight = card.offsetHeight;
                if (cardHeight > maxHeight) {
                maxHeight = cardHeight;
                }
            });

            // Establece la altura máxima en todas las tarjetas
            cards.forEach(function(card) {
                card.style.height = maxHeight + 'px';
            });
            count++;
        });
        updateCarousel();
    }
}

/*Function to make the carousel responsive*/
function updateCarousel() {
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
        nextButton.addEventListener("click", function () {
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
        prevButton.addEventListener("click", function () {
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
