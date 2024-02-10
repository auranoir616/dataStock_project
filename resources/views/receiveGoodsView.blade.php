<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <title>Purchase order</title>
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
  <h1 align=center>Receive Item details</h1>
  </div>
      <article>
        <div id="container-content">
        <div class="w-100 p-3">
            <p>
              <b>Inbound ID :</b> {{$dataItem[0]->Id_Inbound}}<br>
          <b>Purchase ID : </b>{{$dataItem[0]->purchase_Id}} <br>
          <b>Status :</b> @if($statusPending == 1 && $dataItem[0]->placement == 'Pending') <h2>Pending</h2> @else <h2>Submited</h2> @endif
        </p> 
          {{-- @if($dataPOView[0]->submited == 'yes' )<h5 style="color: red">SUBMITED</h5> @endif   --}}
          <a href="/receiveGoods" class="btn btn-info">< back to Receive Goods</a>
        </div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Date In</th>
                    {{-- <th>ID Inbound</th> --}}
                    <th>Invoice</th>
                    <th>Product(SKU)</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Selling Price</th>
                    <th>File</th>
                    <th>Notes</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$dataItem[0]->created_at}}</td>
                        {{-- <td>{{$data->Id_Inbound}}</td> --}}
                        <td>{{$dataItem[0]->invoice}}</td>
                        <td>{{$dataItem[0]->SKU}}</td>
                        <td>{{$dataItem[0]->product_name}}</td>
                        <td>{{$dataItem[0]->quantity}}</td>
                        <td>{{$dataItem[0]->price}}</td>
                        <td>@if($dataItem[0]->file == null) No File @else<a href="../data_file/{{$dataItem[0]->file}}" target="_blank"> View File</a> @endif</td>
                        <td>{{$dataItem[0]->notes}}</td>
                    </tr>
                </tbody>
                <tfoot>
                  <tr >
                      <td colspan="8">
                          {{-- {{ $dataPO->appends(request()->query())->links('pagination::bootstrap-4') }} --}}
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