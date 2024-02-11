<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <link rel="icon" type="image/x-icon" href="icon_warehouse.jpg">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript" src="sort-table.js"></script>



    <title>dashboard</title>
    <style>
      #contentDashboard{
        width: 100%;
        height: 100%;
        padding: 10px;
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: flex-start;
      }
      #cont-chart{
        width: 35%;
        height: 50%;
      }
      #cont-table{
        width: 25%;
        padding: 10px;

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
  <h1 align="center">dashboard</h1> 
  <hr>
</div>

  
<article>
  <div id="contentDashboard">
    <div id="cont-chart">
      <h4 align="center">Top Selling Product</h4>

      <canvas id="myChart"></canvas>
      <hr>
      <h4 align="center">Order Performance</h4>

      <canvas id="myChart2"></canvas>
    </div>

    <div id="cont-table">
      <h4 align="center">Stock Categories</h4>
        <table class="table table-hover js-sort-table">
        <thead>
          <th width="50%">Category</th>
          <th>Stock</th>
        </thead>
        <tbody id="categoryStock">

        </tbody>
        </table>
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
     label.push(data.dataOrder[x].product)
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
 </script>
</body>
</html>