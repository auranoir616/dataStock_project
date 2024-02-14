<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <script type="text/javascript" src="sort-table.js"></script>

    <title>Shipping</title>
    <style>
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
  <h1 align="center">Shipping</h1>
  <hr>
</div>
<div class="w-100 p-3 navbar bg-body-tertiary">
  <div>
    <button class="btn btn-success btn-lg" id="buttonShipping" onclick="generateShippingId()">New Shipping</button>
  </div>

</div>

      <article>
        <div id="content-table">

        <table class="table table-hover js-sort-table">
          <thead>
        <tr>
          <th>#</th>
          <th>Shipping ID</th>
          <th>Receipt Number</th>
          <th>Destination</th>
          <th>Name</th>
          <th>Expedisi</th>
          <th width="10%">Status</th>
          <th>Action</th>
        </tr>
        </thead>  
        <tbody  class="table-group-divider">
          @foreach($shipping as $index => $data)
          <tr>
            <td>{{$index + 1}}</td>
            <td>{{$data->shipping_id}}</td>
            <td>{{$data->receipt}}</td>
            <td>{{$data->destination}}</td>
            <td>{{$data->name}}</td>
            <td>{{$data->expedition}}</td>
            <td>
              <div class="col-md-6 form_status">
                <form action="/shipping-editStatus/{{$data->shipping_id}}" method="POST">
                  @csrf
                  @method('PUT')
              <select class="form-select" aria-label="Default select example " name="SHStatus" id="SHStatus" IDSH="{{$data->shipping_id}}" submited='{{$data->submited_in}}'>
                <option @if($data->status == 'On Delivery') selected @endif value="On Delivery">On Delivery</option>
                <option @if($data->status == 'Delivered') selected @endif value="Delivered">Delivered</option>
                <option @if($data->status == 'Pending') selected @endif value="Pending">Pending</option>
                <option @if($data->status == 'Cancel') selected @endif value="Cancel">Cancel</option>
                <option @if($data->status == 'Returned') selected @endif value="Returned">Returned</option>
              </select>
            </form>
              </div>
            </td>
              <td>
                  <a class="btn btn-success" href="/shipping-view/{{$data->shipping_id}}">View Detail</a>
              </td>
          </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <td colspan="8">
              {{ $shipping->appends(request()->query())->links('pagination::bootstrap-5') }}

            </td>
          </tr>

        </tfoot>
        </table>
        </div>
        </article>

    @include('_footer')
</main>
 <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
<script>

function generateShippingId(){
  var formattedTime = new Date().getTime();
  let IDShipping = `SH${formattedTime}`
  console.log(formattedTime)
  localStorage.setItem('id_shipping', IDShipping)
  window.location.href = `/shipping-new/${IDShipping}`
  }

const notif = document.getElementById('notif')
 notif.style.display = 'block'
 const time = 2000
 setTimeout(() => {
   notif.style.display = 'none'
 }, time);

 let SHStatusEdit = document.querySelectorAll('#SHStatus')
SHStatusEdit.forEach(function(statusEdit){
  let row = statusEdit.closest('td')
  let statusValue = statusEdit.value
  let submited = statusEdit.getAttribute('submited')
  if(statusValue === 'Cancel'){
    row.className = 'table-danger'
  }
  if(statusValue === 'Returned'){
    row.className = 'table-success'
  }  
  if(statusValue === 'Pending'){
    row.className = 'table-warning'
  }  
  if(statusValue === 'Delivered'){
    row.className = 'table-primary'
  }if(submited === 'yes'){
    statusEdit.disabled = true

  }

  statusEdit.addEventListener('change', (e)=>{
      const confirmation = confirm('Save change?')
        if(confirmation){
          const form = statusEdit.closest('form');
            form.submit();
        }else{
          window.location.reload()
        }
  })
})

</script>
</body>
</html>