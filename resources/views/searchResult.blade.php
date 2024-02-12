<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <title>Search</title>
    <style>
      .container-result{
        width: 100%;
        height: 500px;
        overflow: auto;
      }
      .results{
        width: 100%;
        height: 100%;
        padding: 10px;
        border-radius: 5px

      }
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
  <h1 align="center">Search Results</h1>
  <hr>
</div>
    <article>
      <div class="results">
      <div class="container-result">
        @if(!empty($dataPO[0])) <h4 align="center">from data Purchase Order</h4> @else @endif
        <div class="list-group">
          @forEach($dataPO as $data)
          <a href="/dataPO-view/{{$data->purchase_id}}" class="list-group-item list-group-item-action" aria-current="true">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">{{$data->product_name}}</h5>
              <small>{{$data->updated_at}}</small>
            </div>
            <p class="mb-1">Click to see the detail</p>
            <small>And some small print.</small>
          </a>
          @endforeach      
        </div>
          
      @if(!empty($dataShipping[0])) <h4 align="center">from data Shipping</h4> @else @endif
      <div class="list-group">
        @forEach($dataShipping as $data)
        <a href="/shipping-view/{{$data->shipping_id}}" class="list-group-item list-group-item-action">
          <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1">{{$data->product}}</h5>
            <small class="text-body-secondary">{{$data->updated_at}}</small>
          </div>
          <p class="mb-1">Click to see the detail</p>
          <small class="text-body-secondary">ID : {{$data->shipping_id}}</small>
        </a>       
         @endforeach      
      </div>

      @if(!empty($dataOrder[0]))  <h4 align="center">from data Order</h4>@else   @endif
      <div class="list-group">
        @forEach($dataOrder as $data)
        <a href="/order-view/{{$data->order_id}}" class="list-group-item list-group-item-action">
          <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1">{{$data->product}}</h5>
            <small class="text-body-secondary">{{$data->updated_at}}</small>
          </div>
          <p class="mb-1">Click to see the detail</p>
          <small class="text-body-secondary">ID : {{$data->order_id}}</small>
        </a>       
        @endforeach      
      </div>

      @if(!empty($dataIn[0])) <h4 align="center">from data In</h4> @else @endif
      <div class="list-group">
        @forEach($dataIn as $data)
        <a href="/dataIn-view/{{$data->id}}" class="list-group-item list-group-item-action">
          <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1">{{$data->product_name}}</h5>
            <small class="text-body-secondary">{{$data->updated_at}}</small>
          </div>
          <p class="mb-1">Click to see the detail</p>
          <small class="text-body-secondary">ID : {{$data->Id_Inbound}}</small>
        </a>       
        @endforeach      
      </div>

      @if(!empty($dataReturn[0])) <h4 align="center">from data Return</h4> @else @endif
      <div class="list-group">
        @forEach($dataReturn as $data)
        <a href="/return-view/{{$data->return_id}}" class="list-group-item list-group-item-action">
          <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1">{{$data->product}}</h5>
            <small class="text-body-secondary">{{$data->updated_at}}</small>
          </div>
          <p class="mb-1">Click to see the detail</p>
          <small class="text-body-secondary">ID : {{$data->return_id}}</small>
        </a>       
         @endforeach      
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
</script>
</body>
</html>