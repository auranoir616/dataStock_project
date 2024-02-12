<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <title>Purchase Order Edit</title>
    <style>
      /* .cont-form{
        width: 50%;
        border: 2px solid grey;
        border-radius: 5px;
        background-color: rgb(255, 255, 255);
      } */
      .cont-table{
        width: 50%;
        border: 2px solid grey;
        border-radius: 5px;
        background-color: rgb(255, 255, 255);

      }
      .cont-In{
        height: 100%;
        width: 100%;
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        padding: 5px;
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
    <article>
      <div class="cont-In">
      <div class="cont-form">
        <div class="w-100 p-3">
          <h4>Edit Item In : {{$dataPOEdit[0]->purchase_id}}</h4>


          <form class="row g-3" action="/dataPOView-editSave/{{$dataPOEdit[0]->id}}" method="POST"  enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-md-6">
              <label class="form-label">ID Item</label>
              <input type="text" class="form-control" id="IdItem" value="{{$dataPOEdit[0]->id}}"  name="IdItem" disabled>
            </div>

            <div class="col-md-6">
              <label class="form-label">Create Date</label>
              <input type="date" class="form-control" id="POCreateDateEdit" name="POCreateDateEdit" value="{{$dataPOEdit[0]->create_date}}">
              </select>            
            </div>
            <div class="col-md-6">
              <label class="form-label">invoice</label>
              <input type="text" class="form-control" id="POinvoiceEdit" name="POInvoiceEdit" value="{{$dataPOEdit[0]->invoice}}">
            </div>
            <div class="col-md-6">
              <label for="inputState" class="form-label">Suppliers</label>
              <select class="form-select" id="POSupplierEdit" name="POSupplierEdit">
                @foreach ($dataSuppliers as $supplier)
                <option @if($dataPOEdit[0]->supplier == $supplier) selected @endif value="{{$supplier}}">{{$supplier}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">SKU</label>
              <select class="form-select" aria-label="Default select example" id="POSKUEdit"  name="POSKUEdit">
                @foreach ($dataSKU as $SKU)
                <option @if($dataPOEdit[0]->SKU == $SKU) selected @endif value="{{$SKU}}">{{$SKU}}</option>
                @endforeach
              </select>            
            </div>
            <div class="col-md-6">
              <label class="form-label">Quantity</label>
              <input type="number" class="form-control" id="POQuantityEdit" name="POQuantityEdit" value="{{$dataPOEdit[0]->quantity}}">
            </div>
            <div class="col-md-6">
              <label for="POFileEdit" class="form-label" id="POFileEdit">File</label>
              <input class="form-control" type="file" id="POFileEdit" name="POFileEdit">
            </div>
            <div class="col-md-6">
              <label for="PONotesEdit" class="form-label" id="PONotesEdit">Notes</label>
              <textarea class="form-control" rows="2" id="PONotesEdit" name="PONotesEdit" value="{{$dataPOEdit[0]->notes}}">{{$dataPOEdit[0]->notes}}</textarea>
            </div>
            <div class="col-12">
            </div>
            <div class="col-12 d-grid gap-2">
              <button type="submit" class="btn btn-primary" id="btnAdd">Save Change</button>
              <a href="/dataPO-view/{{$dataPOEdit[0]->purchase_id}}" class="btn btn-danger">Back</a>
            </div>
          </form>        
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

function cancelEdit(){
  window.history.back()
}
</script>
</body>
</html>