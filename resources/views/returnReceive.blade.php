<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <title>Current Stock</title>
    <style>
        .cont-table{
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            /* width: 100%;
            height: 100%; */
        }
        article.table-in{
        }
    </style>
</head>
<body>
    @include('_aside') 
    <main>
    @include('_header')
    
{{-- ! --}}
<div  id="container-notif">
  <div id="notif">
    {{-- menampilkan error dari session --}}
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

    <article class="table-in">
        <div class="cont-table">
            <div class="w-100 p-3">
                <b>Inbound ID : </b><small id="idReturn" ></small><br>
                <b>Shipping ID : </b><small>{{$IDSH}}</small><br>
                <b>Invoice : </b><small>{{$dataToReceive[0]->receipt}}</small><br>
                <b>Expedition: </b>{{$dataToReceive[0]->expedition}} <br>
                <b>Date Sent : </b>{{$dataToReceive[0]->created_at}}
                {{-- <b>View Purchase File :@if($POFile == null) no file @else</b> <small><a href="./data_file/{{$POFile[0]}}" target="_blank" rel="noopener noreferrer">view File</a> @endif</small> --}}
              <table class="table table-striped table-hover" id="table-display">
                <thead>
                  <tr>
                    <th>SKU</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Add notes</th>
                    <th width="20%">Add File</th>
                    <th>Placement</th>
                    <th>check</th>
                    
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($dataToReceive as $tempIn)
                    {{-- <tr @if($tempIn->submited == 'yes')  class="table-success" @endif> --}}
                      <form action="/return-add" method="post" enctype="multipart/form-data" id="formReturn">
                        @csrf
                      <td>
                        <input type="text" value="" class="addReturnId" name="addReturnId[]" hidden>
                        <input type="text" value="{{$IDSH}}" name="addReturnShippingId[]" hidden>
                        <input type="text" value="{{$tempIn->receipt}}" name="addReturnReceipt[]" hidden>
                        <input type="text" value="{{$tempIn->SKU}}" name="addReturnSKU[]" hidden>
                        <input type="text" value="{{$tempIn->expedition}}" name="addReturnExpedition[]" hidden>
                        <input type="text" value="{{$tempIn->created_at}}" name="addReturnDateSent[]" hidden>
                        {{$tempIn->SKU}}
                      </td>
                      <td>
                        {{$tempIn->product}}
                        <input type="text" value="{{$tempIn->product}}" name="addReturnProduct[]" hidden>
                      </td>
                      <td>
                        {{$tempIn->quantity}}
                        <input type="text" value="{{$tempIn->quantity}}" name="addReturnQuantity[]" hidden>
                      </td>
                      <td>
                          <div class="row g-3">
                              <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Add notes" name="addReturnNotes[]"  >
                            </div>
                        </td>
                        <td>
                            <div class="w-auto">
                                <input class="form-control" type="file" id="formFile" name="addReturnFile[]" >
                            </div>
                        </td>
                        <td>
                          <select class="form-select" aria-label="Default select example" name="addReturnPlacement[]" >
                            <option value="A">Warehouse A</option>
                            <option value="B">Warehouse B</option>
                            <option value="C">Warehouse C</option>
                            <option value="D">Warehouse D</option>
                            <option value="Broken">Broken</option>

                          </select>
                        </td>
                        <td>
                        <div>
                              <input type="checkbox" class="btn-check" id="btn-check-outlined{{$tempIn->id}}" value="checked" name="addReturnCheck[]">
                              <label class="btn btn-outline-warning" for="btn-check-outlined{{$tempIn->id}}" >Check</label>                
                          </div>
                          </td>
                    </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                  </form>

                    <tr >
                      <td colspan="11">
                        <div class="d-grid gap-2">
                          <button class="btn btn-warning" id="submitButton" >Submit</button>
                        </div>
                      </td>
                    </tr>
                  </tfoot>
              </table>
            </div>
          </div>
        </div> 
    </article>
    {{-- ! --}}
    @include('_footer')
</main>

 <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
       <script>
        const submit = document.getElementById('submitButton');
        submit.addEventListener('click', ()=>{

          const confirmation = confirm('Are you sure that all items were checked correctly?');
        const form = document.querySelector('#formReturn'); 
        if (confirmation) {
            form.submit();
            // console.log('ok')
        }

        })
      window.addEventListener("DOMContentLoaded", () =>{
      let idReturn = localStorage.getItem('id_return')
      document.getElementById('idReturn').textContent = idReturn;
      // document.getElementById('idInInput').value = idInbound;
      let valueIdReturn = document.getElementsByClassName('addReturnId')
      for(let x=0; x<valueIdReturn.length; x++){
        valueIdReturn[x].value = idReturn
      }

      const notif = document.getElementById('notif')
      notif.style.display = 'block'
      const time = 2000
      setTimeout(() => {
      notif.style.display = 'none'
      }, time);

    })



       </script>
</body>
</html>