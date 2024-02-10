<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <script type="text/javascript" src="sort-table.js"></script>

    <title>return</title>
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
  <h1 align="center">Return </h1>
  <hr>
</div>
<div class="w-100 p-3 navbar bg-body-tertiary">
  <div>
    <button class="btn btn-warning btn-lg" id="newReturn">New Return</button>
  </div>
</div>

      <article>
        <table class="table table-hover js-sort-table">
          <thead>
          <tr>
            <th>#</th>
            <th>Shipping ID</th>
            <th>Receipt Number</th>
            <th>Expedition</th>
            <th>date sent</th>
            <th>date receive</th>
            <th>Action</th>
          </tr>
          </thead>  
          <tbody  class="table-group-divider">
            @foreach($dataReturn as $index => $data)
            <tr>
              <td>{{$index + 1}}</td>
              <td>{{$data->return_id}}</td>
              <td>{{$data->receipt}}</td>
              <td>{{$data->expedition}}</td>
              <td>{{$data->date_sent}}</td>
              <td>{{$data->created_at}}</td>
                <td>
             <a class="btn btn-warning" href="/return-view/{{$data->return_id}}">View Detail</a>
                </td>
                {{-- <td id="submitedIn" hidden>{{$data->submited_in}}</td> --}}
            </tr>
            @endforeach
          </tbody>

          <tfoot>
            <tr>
              <td colspan="7">
                {{ $dataReturn->appends(request()->query())->links('pagination::bootstrap-5') }}

              </td>
            </tr>
          </tfoot>
        </table>

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

 document.getElementById('newReturn').addEventListener('click', ()=>{
  var formattedTime = new Date().getTime();
      console.log(formattedTime)
      let REID = `RE${formattedTime}`
      localStorage.setItem('id_return', REID)
      window.location.href =`/return-new`
 })
</script>
</body>
</html>