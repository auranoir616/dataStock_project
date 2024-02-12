<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="sort-table.js"></script>
    <title>Current Stock</title>
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
  <h1 align="center">Current Stock</h1>
  <hr>
</div>


    <article>
            <div class="w-100 p-3" id="content-table">
              <table class="table table-hover js-sort-table">
                <thead>
                      <tr>
                        <th scope="col"  width="15%">SKU</th>
                        <th scope="col"  width="25%">name</th>
                        {{-- <th scope="col"  width="5%">categories</th> --}}
                        {{-- <th scope="col"  width="5%">unit</th> --}}
                        <th scope="col"  width="5%">price</th>
                        <th scope="col"  width="10%">quantity</th>
                        <th scope="col"  width="5%">Broken</th>
                        <th scope="col"  width="7%">Last In</th>
                        <th scope="col"  width="7%">Last Sold</th>
                        <th scope="col"  width="7%">Last Shipped</th>
                        <th scope="col"  width="7%">Last Return</th>

                      </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        @foreach($dataItems as $item)
                        <tr>
                        <td>{{$item->SKU}}</td>
                        <td>{{$item->name}}</td>
                        {{-- <td>{{$item->categories}}</td> --}}
                        {{-- <td>{{$item->unit}}</td> --}}
                        <td>Rp.{{$item->price}}</td>
                        <td>{{$item->quantity}}</td>
                        <td>

                          @foreach($dataBroken as $dataBrokenItem)
                          @if($dataBrokenItem->SKU == $item->SKU)
                              {{$dataBrokenItem->qty}}
                          @endif
                      @endforeach
                      </td>
                        <td>
                          @foreach($dataIn as $dataInItem)
                          @if($dataInItem->SKU == $item->SKU)
                          {{ \Carbon\Carbon::parse($dataInItem->last_in)->format('d M Y')}}

                          @endif
                      @endforeach

                        </td>
                        
                      <td>
                          @foreach($dataOrder as $dataOrderItem)
                              @if($dataOrderItem->SKU == $item->SKU)
                                  {{\Carbon\Carbon::parse($dataOrderItem->last_Out)->format('d M Y')}}
                              @endif
                          @endforeach
                      </td>
                      <td>
                        @foreach($dataShipping as $dataShippingItem)
                            @if($dataShippingItem->SKU == $item->SKU)
                            {{\Carbon\Carbon::parse($dataShippingItem->last_Out)->format('d M Y')}}
                            @endif
                        @endforeach
                    </td>
                    <td>
                      @foreach($dataReturn as $dataReturnItem)
                          @if($dataReturnItem->SKU == $item->SKU)
                          {{\Carbon\Carbon::parse($dataReturnItem->last_Out)->format('d M Y')}}
                          @endif
                      @endforeach
                  </td>
                  </tr>
              @endforeach                   
             </tbody>
                    <tfoot>
                        <tr >
                            <td colspan="9">
                                {{ $dataItems->appends(request()->query())->links('pagination::bootstrap-5') }}
    
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