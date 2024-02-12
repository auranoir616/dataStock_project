<header> 
  <style>
    nav{
      padding-right: 25px
    }
  </style>
  <nav class="navbar bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
        <img src="icon_warehouse.jpg" alt="Logo" width="40" height="40" class="d-inline-block align-text-top">
        Warehouse Management System
      </a>
      <div class="btn-group dropstart">
        <form class="d-flex" role="search" action="/searchproduct" method="GET">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" id="search" name="query">
          <button class="btn btn-outline-success" type="button" onclick="searchbtn()">Search</button>
          </form>
            </div>

      </div>
      
  </nav>
</header>
<script>
    function searchbtn() {
    let inputSearch = document.getElementById('search').value;
    window.location.href = `/searchproduct?query=${inputSearch}`;
}
</script>