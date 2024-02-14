<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>New Receive Goods</title>
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
</div>
</div>
<div id="container-title">
  <h1 align='center'>Receive Goods</h1>
  <hr>
  </div>
  <article >
    
      <div id="content-table">
        <div class="w-100 p-3">
          <b>Inbound ID : </b><small id="idInbound" ></small><br>
          <b>Purchase ID : </b><small>{{$IDPO}}</small><br>
          <b>Invoice : </b><small>{{$dataItemsPO[0]->invoice}}</small><br>
          <b>View Purchase File :@if($POFile == null) no file @else</b> <small><a href="./data_file/{{$POFile[0]}}" target="_blank" rel="noopener noreferrer">view File</a> @endif</small>
        </div>
    
              <table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th>SKU</th>
                    <th>Product</th>
                    <th>categories</th>
                    <th>price/item</th>
                    <th>Qty</th>
                    <th>unit</th>
                    <th>Add notes</th>
                    <th width="20%">Add File</th>
                    <th>Placement</th>
                    <th>check</th>
                    
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($dataItemsPO as $tempIn)
                    <tr @if($tempIn->submited == 'yes')  class="table-success" @endif>
                      <form action="/dataIn-add" method="post" enctype="multipart/form-data" id="formReceiveGoods">
                        @csrf
                      <td>
                        <input type="text" value="" class="addInIdInbound" name="addInIdInbound[]" hidden  @if($tempIn->submited == 'yes') disabled @endif>
                        <input type="text" value="{{$IDPO}}" name="addInIdPO[]" hidden @if($tempIn->submited == 'yes') disabled @endif>
                        <input type="text" value="{{$tempIn->invoice}}" name="addInInvoice[]" hidden @if($tempIn->submited == 'yes') disabled @endif>
                        <input type="text" value="{{$tempIn->SKU}}" name="addInSKU[]" hidden @if($tempIn->submited == 'yes') disabled @endif>
                        <input type="text" value="{{$tempIn->id}}" name="addInIdItemPO[]" hidden @if($tempIn->submited == 'yes') disabled @endif>
                        {{$tempIn->SKU}}
                      </td>
                      <td>
                        {{$tempIn->name}}
                        <input type="text" value="{{$tempIn->name}}" name="addInName[]" hidden @if($tempIn->submited == 'yes') disabled @endif>
                      </td>
                      <td>
                        {{$tempIn->categories}}
                        <input type="text" value="{{$tempIn->categories}}" name="addInCategories[]" hidden @if($tempIn->submited == 'yes') disabled @endif>
                      </td>
                      <td>
                        {{$tempIn->price}}
                        <input type="text" value="{{$tempIn->price}}" name="addInPrice[]" hidden @if($tempIn->submited == 'yes') disabled @endif>
                      </td>
                      <td>
                        {{$tempIn->quantity}}
                        <input type="text" value="{{$tempIn->quantity}}" name="addInQuantity[]" hidden @if($tempIn->submited == 'yes') disabled @endif>
                      </td>
                      <td>
                        {{$tempIn->unit}}
                        <input type="text" value="{{$tempIn->unit}}" name="addInUnit[]"" hidden @if($tempIn->submited == 'yes') disabled @endif>
                      </td>
                      <td>
                          <div class="row g-3">
                              <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Add notes" name="addInNotes[]"  @if($tempIn->submited == 'yes') disabled @endif>
                            </div>
                        </td>
                        <td>
                            <div class="w-auto">
                                <input class="form-control" type="file" id="formFile" name="addInFile[]"  @if($tempIn->submited == 'yes') disabled @endif>
                            </div>
                        </td>
                        <td>
                          <select class="form-select" aria-label="Default select example" name="addInPlacement[]" @if($tempIn->submited == 'yes') disabled @endif>
                            <option value="A">Warehouse A</option>
                            <option value="B">Warehouse B</option>
                            <option value="C">Warehouse C</option>
                            <option value="D">Warehouse D</option>
                            <option value="Pending">Pending</option>

                          </select>
                        </td>
                        <td>
                        <div>
                              <input type="checkbox" class="btn-check" id="btn-check-outlined{{$tempIn->id}}" value="checked" name="addInCheck[]" @if($tempIn->submited == 'yes') disabled @endif>
                              <label class="btn btn-outline-success" for="btn-check-outlined{{$tempIn->id}}" >Check</label>                
                          </div>
                          </td>
                    </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                  </form>

                    <tr >
                      <td colspan="10">
                        <div class="d-grid gap-2">
                          <button class="btn btn-primary" id="submitButton" >add</button>
                        </div>
                      </td>
                    </tr>
                  </tfoot>
              </table>
            </div>
    </article>
    {{-- ! --}}
    @include('_footer')
  </main>
  
</body>
 <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
       <script>
        const submit = document.getElementById('submitButton');
        submit.addEventListener('click', ()=>{
          const confirmation = confirm('Are you sure that all items were checked correctly?');
        const form = document.querySelector('#formReceiveGoods'); 
        if (confirmation) {
            form.submit();
            // console.log('ok')
        }

        })
      window.addEventListener("DOMContentLoaded", () =>{
      let idInbound = localStorage.getItem('id_inbound')
      document.getElementById('idInbound').textContent = idInbound;
      // document.getElementById('idInInput').value = idInbound;
      let valueIdInbound = document.getElementsByClassName('addInIdInbound')
      for(let x=0; x<valueIdInbound.length; x++){
        valueIdInbound[x].value = idInbound
      }

      const notif = document.getElementById('notif')
      notif.style.display = 'block'
      const time = 2000
      setTimeout(() => {
      notif.style.display = 'none'
      }, time);

    })
       </script>
</html>