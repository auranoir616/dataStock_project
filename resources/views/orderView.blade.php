<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <title>Order Detail</title>
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
  <h1 align=center>Order details</h1>
  </div>
      <article>
        <div id="content-table">
        <div class="w-100 p-3">
          {{-- @if($dataPOView[0]->submited == 'yes' )<h5 style="color: red">SUBMITED</h5> @endif   --}}

          <a href="/order-history" class="btn btn-info">< back to Order History</a>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Product(SKU)</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Starting Price</th>
                    <th>Discount</th>
                    <th>Price After Discount</th>
                </tr>
                </thead>
                <tbody>
                  @forEach($DataOrderDetail as $order)
                    <tr>
                      <td>{{$order->SKU}}</td>
                      <td>{{$order->product}}</td>
                      <td>{{$order->quantity}}</td>
                      <td>Rp.{{$order->price}}</td>
                      <td>{{$order->discount}}%</td>
                      <td>Rp.{{$order->price - ($order->price*$order->discount/100)}}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                  <tr >
                      <td>
                        <b>total : </b>Rp.{{$DataOrderDetail[0]->subtotal}} 
                          {{-- {{ $dataPO->appends(request()->query())->links('pagination::bootstrap-4') }} --}}
                      </td>
                   </tr>
                   <tr>
                    <td>
                      <b>tax : </b>@if(!$DataOrderDetail[0]->tax) 0% @endif
                    </td>
                   </tr>
                   <tr>
                    <td>
                      <b>total cost(with tax) : </b>@if(!$DataOrderDetail[0]->cash) Rp.{{$DataOrderDetail[0]->subtotal}} @endif

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
  function generateIdPO(){
       var formattedTime = new Date().getTime();
        let IDPO = `PO${formattedTime}`
   console.log(formattedTime)
   localStorage.setItem('id_PO', IDPO)
   window.location.href = `/dataPO-new/${IDPO}`
}

const notif = document.getElementById('notif')
notif.style.display = 'block'
const time = 1000
setTimeout(() => {
 notif.style.display = 'none'
}, time);

function deleteItemPO(IDPO){
  const confirmation = confirm('are you sure?')
  if(confirmation){
    window.location.href = `/dataPOView-delete/${IDPO}`
  }
}
</script>

</html>