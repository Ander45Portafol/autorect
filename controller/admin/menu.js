const ASIDE=document.querySelector('aside') 

ASIDE.innerHTML=`      <ul class="nav flex-column">
<div class="topnav">
  <div class="image">
    <img src="../../resources/images/LogoLogin.png" alt="" />
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
  <button type="button" class="btn" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Dashboard"><a class="nav-link" id="dashboard" href="admin.html"><i class="bx bxs-grid-alt"></i></a></button>
    
  </li>
  <li class="nav-item">
  <button type="button" class="btn" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Users"><a class="nav-link" href="user.html" id="user"><i class="bx bxs-user-circle"></i></a></button>
    
  </li>
  <li class="nav-item">
  <button type="button" class="btn" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Employees"><a class="nav-link" href="employee.html" id="employee"><i class="bx bxs-group"></i></a></button>
    
  </li>
  <li class="nav-item">
  <button type="button" class="btn" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Clients"><a class="nav-link" href="clients.html" id="client"><i class="bx bxs-user-pin"></i></a></button>

  </li>
  <li class="nav-item">
  <button type="button" class="btn" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Products"><a class="nav-link" href="products.html" id="product"><i class="bx bxs-cart-alt"></i></a></button>
    
  </li>
  <li class="nav-item">
    <button type="button" class="btn" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Order Details"><a class="nav-link" href="orderdetails.html" id="order_details"><i class="bx bx-spreadsheet"></i></a></button>

  </li>
  <li class="nav-item">
  <button type="button" class="btn" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Orders"><a class="nav-link" href="models.html" id="Orders"><i class="bx bxs-box"></i></a></button>

  </li>
  <li class="nav-item">
  <button type="button" class="btn" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Categories"><a class="nav-link" href="categories.html" id="Categories"><i class="bx bxs-category-alt"></i></a></button>

  </li>
  <li class="nav-item">
  <button type="button" class="btn" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Brands"><a class="nav-link" href="brands.html" id="Brands"><i class="bx bxs-car"></i></a></button>
  </li>
  <li class="nav-item">
    <button type="button" class="btn" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Models"><a class="nav-link" href="models.html" id="models"><i class="bx bxs-car-garage"></i></a></button>
  </li>
</div>
<div class="bottomnav">
    <li class="nav-item">
    <button type="button" class="btn" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Log-Out"><a class="btn" href="index.html" id="logout"><i class="bx bxs-log-out"></i></a></button>
        
      </li>
</div>
</ul>`
