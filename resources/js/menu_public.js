/*Function to add the navbar*/
const header = document.querySelector('header')

header.innerHTML = `
<nav class="navbar fixed-top navbar-expand-lg navbar2">
<div class="container">
    <a class="navbar-brand" href="#">
        <img class="logo-navbar" src="../../resources/images/logo_svg.svg">
    </a>
    <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse"
        data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a type="button" href="cart.html" class="btn-cart order-lg-2">
        <img src="../../resources/images/cart.svg" alt="cart">
    </a>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto order-lg-1">
            <li class="nav-item">
                <a class="link-home nav-link text-white" href="index.html">Home</a>
            </li>
            <li class="nav-item">
                <a class="link-products nav-link text-white" href="products.html">Products</a>
            </li>
            <li class="nav-item">
                <a class="link-about nav-link text-white" href="about_us.html">Abouts Us</a>
            </li>
            <li class="nav-item">
                <a class="link-contact nav-link text-white" href="contact_us.html">Contact Us</a>
            </li>
        </ul>
        <a type="button" class="btn-login btn btn-light btn-xs order-lg-3" href="login_public.html">
            LOGIN <img class="img-btn-login" src="../../resources/images/login_icono.svg" alt="loginimg">
        </a>
    </div>
</div>
</nav>`