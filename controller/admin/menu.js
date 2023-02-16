const ASIDE=document.querySelector('aside')

ASIDE.innerHTML=`      <ul class="nav flex-column">
<div class="topnav">
  <div class="image">
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
  <li class="nav-item">
    <a class="nav-link" id="dashboard" href="#"><i class="bx bxs-grid-alt"></i></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#" id="user"><i class="bx bxs-user-circle" data-feather="dashboard"></i></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#" id="employee"><i class="bx bxs-group"></i></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#" id="client"><i class="bx bxs-user-pin"></i></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#" id="product"><i class="bx bxs-cart-alt"></i></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#" id="order_details"><i class="bx bx-spreadsheet"></i></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#" id="orders"><i class="bx bxs-box"></i></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#" id="categories"><i class="bx bxs-category-alt"></i></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#" id="brands"><i class="bx bxs-car"></i></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#" id="models"><i class="bx bxs-car-garage"></i></a>
  </li>
</div>
<div class="bottomnav">
    <li class="nav-item">
        <a class="nav-link" href="#" id="logout"><i class="bx bxs-log-out"></i></a>
      </li>
</div>
</ul>`