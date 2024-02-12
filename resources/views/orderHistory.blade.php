<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script type="text/javascript" src="sort-table.js"></script>
    <link rel="stylesheet" href="../style.css">
    <title>Order History</title>
    <style>
    </style>
</head>
<body>
  @include('_aside') 
<main>
@include('_header')
<div id="container-notif">
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
  <h1 align="center">Order History</h1>
  <hr>
</div>
<div class="w-100 p-3 navbar bg-body-tertiary">
  <div>
    <a href="#" class="btn btn-info btn-lg" onclick="generateIdOrder()">New Order</a>
  </div>
</div>

      <article>
        <div id="content-table">

        <table class="table table-hover js-sort-table">
          <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Create Date</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach($dataOrder as $data)
                    <tr>
                      {{-- @php
                       $countID = $data->purchase_id->count('');
                       $countSubmited = $data->submited->where('1')->count();   
                      @endphp --}}
                        <td>{{$data->order_id}}</td>
                        <td>{{$data->updated_at}}</td>
                        <td>Rp.{{$data->subtotal}}</td>
                        <td>
                          <a href="/order-view/{{$data->order_id}}" class="btn btn-info">View Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                  <tr >
                      <td colspan="4">
                        {{ $dataOrder->appends(request()->query())->links('pagination::bootstrap-5') }}
                      </td>
                   </tr>
              </tfoot>
        </table>
        </div>
    </article>

    @include('_footer')
</main>
</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
<script>

function generateIdOrder(){
      var formattedTime = new Date().getTime();
      console.log(formattedTime)
      let ORID = `OR${formattedTime}`
      localStorage.setItem('id_order', ORID)
      window.location.href =`/order/${ORID}`
  }

</script>
</html>