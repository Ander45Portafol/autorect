/*Function to add the footer*/
const footer = document.querySelector('footer')

footer.innerHTML = ` 
<!-- Modal for support -->
<div class="modal fade" id="ModalSupport" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel"> Support - Q&A </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="modal-top-bold"> 1- Where can you locate us? </p>
                Autorect has different branches throughout El Salvador, to learn about them you can visit our
                contact us page.
                <p class="modal-bold"> 2- How long does it take for us to deliver an order? </p>
                Normally the product is delivered the same day, but it depends on the size of the product.
                <p class="modal-bold"> 3- What brands do you work with? </p>
                Autorect works with a wide variety of brands, to know all you can visit our home page.
            </div>
        </div>
    </div>
</div>

<!-- Modal for Terms & Conditions -->
<div class="modal fade" id="ModalTerms" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel"> Terms & Conditions </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="modal-top-bold"> TERMS AND CONDITIONS </p>
                <p> Our store focuses on providing our customers with the best quality in terms of spare parts,
                    however there are certain regulations that help us carry out certain actions or situations
                    that may arise throughout the process of purchasing or delivering the products.</p>
                <p>The regulations encompass all those involved when buying through our platform, from customers
                    and users to sales advisors and external distributors.</p>
                <p>In order to make these processes and regulations known, we define a series of rules or
                    conditions to use our platform and make your necessary purchases safely and effectively.</p>
                <p class="modal-bold">· To our clients:</p>
                <p>a. We ask all our clients to ensure that before making their purchases through our platform,
                    they provide all the necessary data for stable and accessible communication between
                    themselves and the associated distributors.</p>
                <p>b. We ask our customers to be punctual and be present or leave someone in charge with their
                    confirmation data when receiving their products to avoid confusion and to verify the state
                    in which the purchase has been delivered.</p>
                <p>c. All our products have an extended warranty for a period of three business days for the
                    change of part.</p>
                <p>d. In order to make the exchange of the part effective, the client must present photographs
                    of the moment in which he receives his product, and the issued invoice.</p>
                <p>e. Having defined the previous clause, we intend to make it clear that Autorect does NOT
                    accept returns if customers do not meet the requested requirements.</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal for How to buy-->
<div class="modal fade" id="ModalBuy" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel"> How to buy? </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="modal-top-bold"> How to buy? </p>
                <p> To buy products in Autorect, you just have to search for the product you want to buy in our
                    store and add it to your cart. Finally, you place your order and wait for the arrival of
                    your product. </p>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap container -->
<div class="container">
    <!-- Footer -->
    <div class="row">
        <!-- Social media links -->
        <div class="social-footer col-lg-3 col-sm-6">
            <a href="https://www.facebook.com/">
                <img src="../../resources/images/public/facebook_logo.svg" alt="facebook"> @Autorect_SV
            </a>
            <a href="https://twitter.com/">
                <img src="../../resources/images/public/twitter_logo.svg" alt="twitter"> @Autorect_SV
            </a>
            <a href="https://www.instagram.com/">
                <img src="../../resources/images/public/instagram_logo.svg" alt="instagram"> @Autorect_SV
            </a>
        </div>
        <!-- Logo Autorect -->
        <div class="logo-footer col-lg-6 col-sm-6">
            <img src="../../resources/images/logos/logo_svg.svg" alt="logo_footer">
        </div>
        <!-- Information links -->
        <div class="information-footer col-lg-3 col-sm-12">
            <a data-bs-toggle="modal" data-bs-target="#ModalTerms">
                Terms & Conditions
            </a>
            <a data-bs-toggle="modal" data-bs-target="#ModalSupport">
                Support
            </a>
            <a data-bs-toggle="modal" data-bs-target="#ModalBuy">
                How to buy
            </a>
        </div>
    </div>
</div>`