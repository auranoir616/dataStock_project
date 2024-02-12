<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <title>Return Detail</title>
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
@if(!$dataReturn[0])
<h1 align='center'>Data Kosong</h1>
@else

<div id="container-title">
  <h1 align='center'>Return Details</h1>
  <p align='center'><b >ID: {{$IDRE}}</b></p>
  <hr>
  </div>
 
      <article>
        <div id="container-content">
        <div class="w-100 p-3" id="content-table">
          
          <table>
            <thead>
            <tr>
              <td><b>Date Create</b></td>
              <td>:</td>
              <td>{{$dataReturn[0]->created_at}}</td>
            </tr>
            <tr>
              <td><b>Receipt Number</b></td>
              <td>:</td>
              <td>{{$dataReturn[0]->receipt}}</td>
            </tr>
            {{-- <tr>
              <td><b>Destination</b></td>
              <td>:</td>
              <td>{{$dataReturn[0]->destination}}</td>
            </tr> --}}
            <tr>
              <td><b>Shipping ID</b></td>
              <td>:</td>
              <td>{{$dataReturn[0]->shipping_id}}</td>
            </tr>
            <tr>
              <td><b>Expedition</b></td>
              <td>:</td>
              <td>{{$dataReturn[0]->expedition}}</td>
            </tr>
            <tr>
              <td><b>Shipping Status</b></td>
              <td>:</td>
              <td>{{$statusShipping->status}}</td>
            </tr>

          </thead>
          </table>
          <hr>
          <a href="#" class="btn btn-warning" id="buttonBack">back</a>
        </div>
        <div class="w-100 p-3" id="content-table">
          <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th width="10%">SKU</th>
                    <th width="20%">Product</th>
                    <th>Quantity</th>
                    <th>Notes</th>
                    <th>Placement</th>
                    <th>File</th>
                </tr>
                </thead>
                <tbody  class="table-group-divider">
                  @foreach($dataReturn  as $index => $data)
                    <tr>
                        <td>{{$index + 1}}</td>
                        <td>{{$data->SKU}}</td>
                        <td>{{$data->product}}</td>
                        <td>{{$data->quantity}}</td>
                        <td>{{$data->notes}}</td>
                        <td>{{$data->placement}}</td>
                        <td>@if($data->files == null) No File @else<a href="../data_file/{{$data->files}}" target="_blank">View File</a> @endif</td>
                    @endforeach
                </tbody>
                <tfoot>
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
document.getElementById('buttonBack').addEventListener('click', ()=>{
  window.history.back()
})
</script>

</html>