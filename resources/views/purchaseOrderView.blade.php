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
@if(!$dataPOView[0])
<h1 align='center'>Data Kosong</h1>
@else

<div id="container-title">
  <h1 align='center'>Purchase Order details</h1>
  <hr>
  </div>
 
      <article>
        <div id="container-content">
        <div class="w-100 p-3" >
          <p>
            <b>Purchase Order ID :</b> {{$IDPO}} <br>
          <b>Date Create :</b>{{$dataPOView[0]->create_date}}
          </p> 
          <a href="/purchaseOrder" class="btn btn-info" >< back to Purchase Order</a>
        </div>
        <div id="content-table">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th width="10%">Invoice</th>
                    <th width="10%">Supplier</th>
                    <th width="10%">SKU</th>
                    <th width="20%">Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>File</th>
                    <th>Notes</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($dataPOView as $data)
                    <tr>
                        <td>{{$data->invoice}}</td>
                        <td>{{$data->supplier}}</td>
                        <td>{{$data->SKU}}</td>
                        <td>{{$data->name}}</td>
                        <td>{{$data->quantity}}</td>
                        <td>{{$data->price}}</td>
                        <td>@if($data->file == null) No File @else<a href="../data_file/{{$data->file}}" target="_blank"> View File</a> @endif</td>
                        <td>{{$data->notes}}</td>
                        <td>
                          <div class="dropdown-center">
                            @if($data->submited == 'yes' )<h3 style="color: red">SUBMITED</h3>@else 

                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" @if($data->submited == 'yes') disabled  @endif>
                             Actions
                            </button>
                            <ul class="dropdown-menu">
                              <li><a class="dropdown-item" href="/dataPOView-editForm/{{$data->id}}" >Edit</a></li>
                              <li><a class="dropdown-item" href="#" onclick="deleteItemPO('{{$data->id}}')">Delete</a></li>
                              
                            </ul>
                            @endif
                          </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="2">
                      <b>Tax : </b>{{$dataPOView[0]->tax}}% <br>
                      <b>Discount : </b>{{$dataPOView[0]->discount}}% <br>
                     <b>Total Price : </b>Rp. {{$dataPOView[0]->total_cost}}
                    </td>
                  </tr>
                  <tr >
                      <td colspan="9">
                          {{ $dataPOView->appends(request()->query())->links('pagination::bootstrap-4') }}
                      </td>
                   </tr>
              </tfoot>
        </table>
        </div>
      </div>

    </article>

    @include('_footer')
    @endif
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