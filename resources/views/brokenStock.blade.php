<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../../style.css">
    <title>Current Stock</title>
    <style>
      .cont-form{
        width: 50%;
        border: 2px solid grey;
        border-radius: 5px;
        background-color: rgb(255, 255, 255);
      }
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
        padding: 5px;
        background-color: gray;
      }
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
  <h1 align="center">Add Broken Stock</h1>
  <hr>
</div>
    <article>
      <div class="cont-form">
        <div class="w-100 p-3">
          <form class="row g-3" action="{{ url('/broken-new') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-md-6" style="display: none">
              <label class="form-label">Broken ID</label>
              <input type="text" class="form-control" id="brokenID" name="brokenID" value="">
              </div>
           
            <div class="col-md-6">
              <label class="form-label">SKU</label>
              <input type="text" class="form-control" id="brokenSKU" name="brokenSKU" oninput="getSuggestions()" value="@if(empty($dataFromReturn[0])) @else{{$dataFromReturn[0]->SKU}}@endif">
              <div id="suggestion-list" class="list-group z-3 position-absolute">
              </div>
            </div>
            <div class="col-md-6">
              <label class="form-label">Product</label>
              <input type="text" class="form-control" id="brokenProduct" name="brokenProduct" value="@if(empty($dataFromReturn[0])) @else{{$dataFromReturn[0]->product}}@endif">
            </div>
            <div class="col-md-6">
              <label class="form-label">Quantity</label>
              <input type="number" class="form-control" id="brokenQuantity" name="brokenQuantity" value="@if(empty($dataFromReturn[0])) @else{{$dataFromReturn[0]->quantity}}@endif">
            </div>
            <div class="col-md-6">
              <label for="formFile" class="form-label">File</label>
              <input class="form-control" type="file" id="brokenFile" name="brokenFile">
            </div>
            <div class="col-md-6">
              <label class="form-label">Reference</label>
              <input type="text" class="form-control" id="brokenReference" name="brokenReference" value="@if(empty($dataFromReturn[0])) @else{{$dataFromReturn[0]->return_id}}@endif">
            </div>
            <div class="col-12 ">
              <label for="exampleFormControlTextarea1" class="form-label">Notes</label>
              <textarea class="form-control" rows="2" id="brokenNotes" name="brokenNotes"></textarea>
            </div>
            <div class="col-12 d-grid gap-2" >
              <button type="submit" class="btn btn-primary" id="btnAddOrder">Add</button>
              <a href="/broken-history" class="btn btn-danger">Cancel</a>
            </div>  
          </form>   
        </div>
      </div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Submit Order?</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="submitOrder()">Submit</button>
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

    //! generate id order
    let idbroken = localStorage.getItem('id_broken')
    document.getElementById('brokenID').value = idbroken



  function submitOrder(){
    let form = document.getElementById('formTable');
    form.submit()
    // localStorage.clear()
  }
  function generateIdOrder(){
      var formattedTime = new Date().getTime();
      console.log(formattedTime)
      let ORID = `OR${formattedTime}`
      localStorage.setItem('id_order', ORID)
      window.location.href =`/order/${ORID}`
  }

    function getSuggestions(){
      let inputSKU = document.getElementById('brokenSKU').value
      const listSKU = document.getElementById('suggestion-list')
      //suggestion SKU
      fetch(`/order-suggestions?query=${inputSKU}`)
      .then(response => response.json())
      .then(data =>{
        listSKU.innerHTML = ''
        data.suggestions.forEach(suggestion => {
        const listItem = document.createElement('button');
        listItem.className = 'list-group-item list-group-item-action'
        listItem.type = 'button'
        listItem.textContent = suggestion;
        listSKU.appendChild(listItem);
        listItem.addEventListener('click', (event)=>{
          document.getElementById('brokenSKU').value = event.target.textContent;
          let product = event.target.textContent
          listSKU.innerHTML = ''
          fetch(`/order-getItem/${event.target.textContent}`)
          .then(response => response.json())
          .then(data =>{
            console.log(data.item)
              document.getElementById('brokenProduct').value = data.item.name
          })
          .catch(err=>{
              console.log('error', err)
          })

              })
              })
            })
      .catch(error => console.error('Error fetching suggestions:', error));
    }
    // metode diskon dan subtotal
    //handle notif
    const notif = document.getElementById('notif')
      notif.style.display = 'block'
      const time = 1000
      setTimeout(() => {
      notif.style.display = 'none'
      }, time);

      //perhitungan pajak, cash dan kembalian
    //uang kembalian
    function displayModal(){
    let paidMoney = document.getElementById('ORPaid').value
    let change = paidMoney - priceWithTax
    document.getElementById('modalPrice').textContent = 'Rp.'+totalPrice
    document.getElementById('modaltax').textContent = 'Rp.'+tax+' ('+taxpersen+'%)'
    document.getElementById('modalPaid').textContent = 'Rp.'+paidMoney
    document.getElementById('modalChange').textContent = 'Rp.'+change

  }
  </script>   
</body>
</html>