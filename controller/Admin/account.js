const ASIDE = document.querySelector(`aside`);

  ASIDE.innerHTML = `<div class="navbar">
    <nav>
      <div class="topnav">
        <div class="img">
          <img src="../../resources/imagenes/LogoLogin.png" alt="" />
        </div>
        <div class="btn">
          <button onclick=""><i class="bx bx-chevron-right"></i></button>
        </div>
        <div class="btnback">
          <button onclick=""><i class="bx bx-chevron-left"></i></button>
        </div>
      </div>
      <div class="sidebar">
        <div class="middlenav">
          <a href="admin.html" id="dashboard"><i class="bx bxs-grid-alt"></i></a>
          <a href="user.html" id="user"><i class="bx bxs-user-circle" data-feather="dashboard"></i></a>
          <a href="employee.html" id="employee"><i class="bx bxs-group"></i></a>
          <a href="clients.html" id="client"><i class="bx bxs-user-pin"></i></a>
          <a href="products.html" id="product"><i class="bx bxs-cart-alt"></i></a>
          <a href="orderdetails.html" id="order_details"><i class="bx bx-spreadsheet"></i></a>
          <a href="orders.html" id="orders"><i class="bx bxs-box"></i></a>
          <a href="categories.html" id="categories"><i class="bx bxs-category-alt"></i></a>
          <a href="brands.html" id="brands"><i class="bx bxs-car"></i></a>
          <a href="models.html" id="models"><i class="bx bxs-car-garage"></i></a>
        </div>
        <div class="logout">
          <a href="index.html" class="logout"> <i class="bx bxs-log-out"></i></a>
        </div>
      </div>
    </nav>
  </div>`;