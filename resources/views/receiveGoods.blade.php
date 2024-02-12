<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="sort-table.js"></script>
    <title>Receive Goods</title>
    <style>
    </style>
</head>
<body>
    @include('_aside') 
    <main>
    @include('_header')
    
{{-- ! --}}
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
    <h1 align="center">Receive Goods</h1>
    <hr>
  </div>
  
    <article>
      
      <div class="w-100 p-3 navbar bg-body-tertiary">
        <button class="btn btn-secondary btn-lg" type="button" aria-expanded="false" onclick="generateInId()">
          New In
        </button>
      </div>
      <div id="content-table">
            <table class="table table-hover js-sort-table">
                <thead>
                    {{-- <th>ID Inbound</th> --}}
                    {{-- <th>Purchase ID</th> --}}
                    {{-- <th>SKU</th> --}}
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Unit</th>
                    <th>Categories</th>
                    <th>Selling Price</th>
                    <th>Notes</th>
                    <th>Checked</th>
                    <th>Action</th>
                    <th>Warehouse</th>
                </thead>
                <tbody class="table-group-divider">
                    @foreach($dataIn as $data)
                    <tr>
                        {{-- <td>{{$data->Id_Inbound}}</td> --}}
                        {{-- <td>{{$data->purchase_Id}}</td> --}}
                        {{-- <td>{{$data->invoice}}</td> --}}
                        {{-- <td>{{$data->SKU}}</td> --}}
                        <td>{{$data->product_name}}</td>
                        <td>{{$data->quantity}}</td>
                        <td>{{$data->unit}}</td>
                        <td>{{$data->categories}}</td>
                        <td>{{$data->price}}</td>
                        <td>{{$data->notes}}</td>
                        <td>@if($data->checked == 1 ) yes @else no @endif</td>
                        <td>                          
                          <a class="btn btn-secondary" href="/dataIn-view/{{$data->id}}">View Detail</a>
                        </td>
                        <td>{{$data->placement}}</td>

                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="11">
                            {{ $dataIn->appends(request()->query())->links('pagination::bootstrap-5') }}

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
       <script>
        function generateInId(){
            var formattedTime = new Date().getTime();
            let IDinbound = `IN${formattedTime}`
            console.log(formattedTime)
            localStorage.setItem('id_inbound', IDinbound)
            window.location.href = `/dataIn-new/`
        }
        function deleteItem(IdItem, SKUItem){
          const confirmation = confirm('are you sure? deleting will change the current stock data')
          if(confirmation){
            console.log(IdItem, SKUItem)
            window.location.href = `/dataIn-delete/${IdItem}-${SKUItem}`
          }
        }
        const notif = document.getElementById('notif')
        notif.style.display = 'block'
        const time = 1000
        setTimeout(() => {
        notif.style.display = 'none'
        }, time);

  function search(){
    
  }

       </script>
</body>
</html>