<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript" src="sort-table.js"></script>
    <title>Dashboard</title>
    <style>
      #contentDashboard{
        width: 100%;
        height: 100%;
        padding: 10px;
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: space-between;
      }
      #cont-chart{
        width: 30%;
        height: 50%;
        border: 2px solid black;
        border-radius: 5px
      }
      .cont-table{
        width: 100%;
        height: 100%;

      }
      @media(max-width:750px){
        #contentDashboard{
        display: flex;
        flex-direction: row;
      }
      #cont-chart{
        width: 100%;
        height: 350px;

      }
      }
    </style>
</head>
<body>
  @include('_aside') 

<main>
@include('_header')
<div  id="container-notif">
  <div id="notif">
    @if(session('success'))
    <div class="alert alert-success">
      <b> {{ session('success') }}</b>
    </div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger">
      <b > {{ session('error') }}</b>
    </div>
  @endif
  @if ($errors->any())
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
      <li><b>{{ $error }}</b></li>
      @endforeach
</ul>
  </div>
     @endif

</div>
</div>
<div id="container-title">
  <h1 align="center">Dashboard</h1> 
  <hr>
</div>

  
<article>
  <div id="contentDashboard">

    <div id="cont-chart">
      <h4 align="center">Top Selling Product</h4>
      <canvas id="myChart"></canvas>
    </div>

    <div id="cont-chart">
      <h4 align="center">Order Performance</h4>
      <canvas id="myChart2"></canvas>
    </div>

    <div id="cont-chart">
      <h4 align="center">Stock Categories</h4>
      <div class="cont-table">
        <table class="table table-hover js-sort-table  table-sm">
          <thead>
            <th>Category</th>
            <th>Stock</th>
          </thead>
          <tbody id="categoryStock">
          </tbody>
        </table>
      </div>
      </div>

      <div id="cont-chart">
        <h4 align="center">Low Stock</h4>
        <div class="cont-table">
          <table class="table table-hover js-sort-table  table-sm">
            <thead>
              <th>Product</th>
              <th>Stock</th>
            </thead>
            <tbody id="lowestStock">
            </tbody>
          </table>
        </div>
        </div>

        <div id="cont-chart">
          <h4 align="center">Recent Transactions</h4>
          <div class="card" style="width: 100%;">
            <ul class="list-group list-group-flush" id="listRecent">
            </ul>
          </div>
        </div>
  
  </div>
      </article>
    @include('_footer')
</main>
 <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
<script>
const notif = document.getElementById('notif')
 notif.style.display = 'block'
 const time = 2000
 setTimeout(() => {
   notif.style.display = 'none'
 }, time);

   fetch('/topsellingproduct')
 .then(res => res.json())
 .then(data =>{
  let label = []
   let dataset = [] 

   for(let x = 0; x < data.dataOrder.length; x++){
     label.push(data.dataOrder[x].SKU)
     dataset.push(data.dataOrder[x].qty)
    }
  const ctx = document.getElementById('myChart');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: label,
      datasets: [{
        label: 'Products',
        data: dataset,
        borderWidth: 1, 
        backgroundColor: ['red', 'blue', 'green', 'orange', 'purple']
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        },
      }
    }
  });

  })
  .catch(err =>{
    console.log(err)
  })
  
  fetch('/totalselling')
  .then( res => res.json())
  .then( data =>{
  const labels = [];
  let total = []
    data.forEach(data => {
  labels.push(data.date)
  total.push(data.total)
});
  
  const ctx2 = document.getElementById('myChart2');
  const dataline = {
    labels: labels,
    datasets: [{
      label: 'Date',
      data: total,
      fill: false,
      borderColor: 'rgb(75, 192, 192)',
      tension: 0.1
    }]
  };
  new Chart(ctx2, {
    type: 'line',
    data: dataline,
  });
  })
  .catch(err =>{
    console.log(err)
  })
  
  fetch('/stockcategory')
  .then( res => res.json())
  .then( data =>{
    let tbody = document.getElementById('categoryStock')
    data.forEach(function(data){
      let row = document.createElement('tr')
      let colCat = document.createElement('td')
      let colQty = document.createElement('td')
      colCat.textContent = data.categories
      colQty.textContent = data.qty
      row.appendChild(colCat)
      row.appendChild(colQty)
      tbody.appendChild(row)
    })
  })

  fetch('/lowstockalert')
  .then( res => res.json())
  .then( data =>{
    let tbody = document.getElementById('lowestStock')
    data.forEach(function(data){
      let row = document.createElement('tr')
      let colProd = document.createElement('td')
      let colQty = document.createElement('td')
      colProd.textContent = data.name
      colQty.textContent = data.quantity
      row.appendChild(colProd)
      row.appendChild(colQty)
      tbody.appendChild(row)
    })
  })
  fetch('/recenttransaction')
  .then( res => res.json())
  .then( data =>{
    console.log(data)
    let list = document.getElementById('listRecent')
      let broken_id = data.recentBR[0].broken_id
      let inbound_id = data.recentIN[0].id
      let order_id = data.recentOR[0].order_id
      let purchase_id = data.recentPO[0].purchase_id
      let return_id = data.recentRE[0].return_id
      let shipping_id = data.recentSH[0].shipping_id

      let link_purchase = document.createElement('a')
      link_purchase.href = `/dataPO-view/${purchase_id}`
      link_purchase.className = "list-group-item list-group-item-action list-group-item-primary "
      link_purchase.textContent = 'Recent Purchase Order'
      list.appendChild(link_purchase)

      let link_inbound = document.createElement('a')
      link_inbound.href = `/dataIn-view/${inbound_id}`
      link_inbound.className = "list-group-item list-group-item-action list-group-item-secondary"
      link_inbound.textContent = 'Recent Receive Goods'
      list.appendChild(link_inbound)

      let link_return = document.createElement('a')
      link_return.href = `/return-view/${return_id}`
      link_return.className = "list-group-item list-group-item-action list-group-item-warning"
      link_return.textContent = 'Recent Return'
      list.appendChild(link_return)

      let link_shipping = document.createElement('a')
      link_shipping.href = `/shipping-view/${shipping_id}`
      link_shipping.className = "list-group-item list-group-item-action list-group-item-success"
      link_shipping.textContent = 'Recent Shipping'
      list.appendChild(link_shipping)

      let link_order = document.createElement('a')
      link_order.href = `/order-view/${order_id}`
      link_order.className = "list-group-item list-group-item-action list-group-item-info"
      link_order.textContent = 'Recent Order'
      list.appendChild(link_order)

      let link_broken = document.createElement('a')
      link_broken.href = `/broken-view/${broken_id}`
      link_broken.className = "list-group-item list-group-item-action list-group-item-danger"
      link_broken.textContent = 'Recent Broken Stock'
      list.appendChild(link_broken)




  })

 </script>
</body>
</html>