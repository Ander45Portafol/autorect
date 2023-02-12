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
          <a href="admin.html"><i class="bx bxs-grid-alt"></i></a>
          <a href="user.html"><i class="bx bxs-user-circle"></i></a>
          <a href="empleado.html"><i class="bx bxs-group"></i></a>
          <a href=""><i class="bx bxs-user-pin"></i></a>
          <a href=""><i class="bx bxs-cart-alt"></i></a>
          <a href=""><i class="bx bx-spreadsheet"></i></a>
          <a href=""><i class="bx bxs-box"></i></a>
          <a href=""><i class="bx bxs-category-alt"></i></a>
          <a href=""><i class="bx bxs-car"></i></a>
          <a href=""><i class="bx bxs-car-garage"></i></a>
        </div>
        <div class="logout">
          <a href="" class="logout"> <i class="bx bxs-log-out"></i></a>
        </div>
      </div>
    </nav>
  </div>`;

const pru=()=>{
  prompt("Hola")
}