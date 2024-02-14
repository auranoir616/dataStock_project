<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script type="text/javascript" src="sort-table.js"></script>
    <link rel="stylesheet" href="../style.css">
    <title>Broken Stock</title>
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
  <h1 align="center">Broken Stock</h1>
  <hr>
</div>
<div class="w-100 p-3 navbar bg-body-tertiary">
  <div class="dropdown">
    <button class="dropdown-toggle btn btn-danger btn-lg" type="button" data-bs-toggle="dropdown" aria-expanded="false">
      Add New Broken Stock  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
       {{$dataBrokenReturnCount}}
        <span class="visually-hidden">unread messages</span>
      </span>
    </button>
    <ul class="dropdown-menu">
      <li> <a href="#" class="dropdown-item" onclick="generateIdBroken()">New Broken Stock</a></li>
      <li><a class="dropdown-item" href="/broken-Select" onclick="generateIdBroken()">Submit From Return</a></li>
    </ul>
  </div>
</div>

      <article>
        <div id="content-table">

        <table class="table table-hover js-sort-table">
          <thead>
                <tr>
                    <th>Broken ID</th>
                    <th>Poduct</th>
                    <th>Quantity</th>
                    <th><A></A>ction</th>
                </tr>
                </thead>
                <tbody class="table-group-divider">
                  <tr>

                    @forEach($dataBroken as $data)
                    <td>{{$data->broken_id}}</td>
                    <td>{{$data->product}}</td>
                    <td>{{$data->quantity}}</td>
                    <td>
                      <a href="/broken-view/{{$data->broken_id}}" class="btn btn-light">View Detail</a>
                    </td>
                  </tr>
                   @endforeach
                </tbody>
                <tfoot>
                  <tr >
                      <td colspan="4">
                        {{ $dataBroken->appends(request()->query())->links('pagination::bootstrap-5') }}
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

function generateIdBroken(){
      var formattedTime = new Date().getTime();
      console.log(formattedTime)
      let IDBR = `BR${formattedTime}`
      localStorage.setItem('id_broken', IDBR)
      window.location.href =`/broken-form/${IDBR}`
  }
  const notif = document.getElementById('notif')
notif.style.display = 'block'
const time = 1000
setTimeout(() => {
 notif.style.display = 'none'
}, time);

</script>
</html>