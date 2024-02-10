<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <script type="text/javascript" src="sort-table.js"></script>

    <title>OUT</title>
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
  <h1 align="center">Product List</h1>
  <hr>
</div>

      <article>
        <div>
          <form class="row row-cols-lg-auto g-3 align-items-center" method="POST" action="/productlist-add">
            @csrf
            <div class="col-12">
              <div class="input-group">
                <div class="input-group-text">SKU</div>
                <input type="text" class="form-control" id="addSKU" name="addSKU">
              </div>
            </div>
            <div class="col-12">
              <div class="input-group">
                <div class="input-group-text">Product</div>
                <input type="text" class="form-control" id="addProduct" name="addProduct">
              </div>
            </div>
            <div class="col-12">
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                Add
              </button>
              </div>
          </form>
          <hr>
        </div>
        
        <div  class="w-100 p-3">
          <table class="table table-hover js-sort-table">
            <thead>
          <th>#</th>
          <th>SKU</th>
          <th>Product</th>
        </thead>
        <tbody class="table-group-divider">
          @foreach($listSKU as $key=>$SKU)
            <tr>
              <td>{{$SKU->id-1}}</td>
            <td>{{$SKU->SKU}}</td>
            <td>{{$SKU->product}}</td>
          </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <td colspan="3">
              {{ $listSKU->appends(request()->query())->links('pagination::bootstrap-5') }}

            </td>
          </tr>
        </tfoot>
          </table>
        </div>
<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>
          save Change? make sure the data was correct.
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">no, close</button>
        <button type="button" class="btn btn-primary" id="submitButton">yes, Submit</button>
      </div>
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

 document.getElementById('submitButton').addEventListener('click', function(){
  let form = document.querySelector('form')
      form.submit()
})
</script>
</body>
</html>