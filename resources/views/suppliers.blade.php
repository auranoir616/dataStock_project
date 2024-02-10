<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="sort-table.js"></script>

    <style>
      #container-form-supplier{
        background-color: rgb(247, 247, 247);
        border-radius: 10px
      }
    </style>
    <title>Suppliers</title>
</head>
<body>
  
  @include('_aside') 
<main>
@include('_header')

{{-- ! --}}
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
  <h1 align="center">Suppliers </h1>
  <hr>
</div>


    <article>
      <div class="w-50 p-3" id="container-form-supplier">
        <form action="/suppliers-add" method="POST">
          @csrf
          <div class="row mb-3">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
              <input type="texc" class="form-control" id="supName"  name="supName">
            </div>
          </div>
          <div class="row mb-3">
            <label for="inputPassword3" class="col-sm-2 col-form-label">Address</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="supAddress" name="supAddress">
            </div>
          </div>
          <div class="row mb-3">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Phone</label>
            <div class="col-sm-10">
              <input type="number" class="form-control" id="supPhone" name="supPhone">
            </div>
          </div>
  
          <div class="row mb-3">
            <label for="inputPassword3" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
              <input type="email" class="form-control" id="supEmail" name="supEmail">
            </div>
          </div>
          <div class="d-grid gap-2 col-6 mx-auto">
           <button type="submit" class="btn btn-primary">Submit</button>

          </div>
        </form>
              
          </div>
        
        </form>
      </div>
      <div class="w-100 p-3">
        <table class="table table-hover js-sort-table">
          <thead>
            <th>Name</th>
            <th>Address</th>
            <th>Phone</th>
            <th>Email</th>
          </thead>
          <tbody class="table-group-divider">
            @foreach($suppliers as $sup)
            <tr>
              <td>{{$sup->supplier_name}}</td>
              <td>{{$sup->supplier_address}} </td>
              <td>{{$sup->supplier_phone}}</td>
              <td>{{$sup->supplier_email}}</td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <td colspan="4">
                {{ $suppliers->appends(request()->query())->links('pagination::bootstrap-5') }}

              </td>
            </tr>
          </tfoot>
        </table>
  
      </div>

    </article>

    {{-- ! --}}
    @include('_footer')
</main>



 <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
       
</body>
</html>