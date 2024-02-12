<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <title>Order</title>
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
  <div class="alert alert-success" id="alertSubmitOrder">
    <b>New Order</b>
  </div>

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
    <article>
      <div class="cont-In">
      <div class="cont-form">
        <div class="w-100 p-3">
          <form class="row g-3" action="{{ url('/order-add') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-md-6">
              <label class="form-label">SKU</label>
              <input type="text" class="form-control" id="ORSKU" name="ORSKU" oninput="getSuggestions()" value="">
              <div id="suggestion-list" class="list-group z-3 position-absolute">
              </div>
            </div>
            <div class="col-md-6">
              <label class="form-label">Product</label>
              <input type="text" class="form-control" id="ORProduct" name="ORProduct" value="">
            </div>
            <div class="col-md-6">
              <label class="form-label">Price</label>
              <input type="number" class="form-control" id="ORPrice" name="ORPrice" value="">
            </div>
            <div class="col-md-6">
              <label class="form-label">Quantity</label>
              <input type="number" class="form-control" id="ORQuantity" name="ORQuantity">
            </div>
            <div class="col-md-6">
              <label class="form-label">Discount</label>
              <input type="number" class="form-control" id="ORDiscount" name="ORDiscount" value="0">
            </div>
            <div class="col-md-6">
              <label class="form-label">sub total</label>
              <input type="text" class="form-control" id="ORSubtotal" name="ORSubtotal" value="">
            </div>

            <div class="col-md-6" style="display: none">
              <label class="form-label">id order</label>
              <input type="text" class="form-control" id="ORID" name="ORID" value="">
            </div>

            <div class="col-12 d-grid gap-2" >
              <button type="submit" class="btn btn-primary" id="btnAddOrder">Add</button>
              <button type="button" class="btn btn-danger" id="btnNewOrder">New Order</button>
            </div>  
          </form>   
   
        </div>
      </div>
        <div class="cont-table">
          <b>ID ORDER : </b>
          <small id="idOrder"> </small>
          <div class="w-100 p-3" id="content-table">
            <table class="table table-striped table-hover" id="table-display" width="100%">
              <thead>
                <tr>
                  <th width='30%'>Poduct</th>
                  <th width='10%'>Quantity</th>
                  <th>Price</th>
                  <th>discount</th>
                  <th>subtotal</th>
                  <th width='10%'>Actions</th>
              </tr>
                <tbody>
                  @forEach($getDataOrder as $data)
                  <tr>
                    <td>{{$data->product}}</td>
                    <td>{{$data->quantity}}</td>
                    <td>{{$data->price}}</td>
                    <td>{{$data->discount}}%</td>
                    <td>{{$data->subtotal}}</td>
                    <td>
                      <button class="btn btn-danger" onclick="deleteItem('{{$data->id}}','{{$data->SKU}}')">delete</button>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <form action="/order-submit/" method="POST" id="formTable">
                    @csrf
                    @method('PUT')
                    <tr>
                      <td>
                      total price : 
                      </td>
                      <td id="disCash" colspan="3">
                      </td>
                      <td colspan="2">
                        <input type="number" name="ORCash" id="ORCash" value="0" hidden>
                      </td>
                    </tr>
  
                  <tr>
                    <td>tax : </td>
                    <td>
                      <input type="number" class="form-control" id="ORTax" name="ORTax" value="0" >
                    </td>
                    
                    <td colspan="3"></td>
                  <td id="disTax" colspan="3">
                  </td>
                  </tr>
                  <tr>
                    <td>
                    total paid : 
                    </td>
                    <td colspan="2">
                    <input type="number" class="form-control" id="ORPaid" name="ORPaid" value="0" >
                    </td>
                    <td colspan="3">

                    </td>
                  </tr>

                  <tr >
                    <td colspan="8">
                      <div class="d-grid gap-2">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop" onclick="displayModal()">
                          Submit
                        </button>                        
                      </div>
                    </td>
                  </tr>
                </form>
                </tfoot>
              </thead>
            </table>
          </div>
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
        <table>
          <thead>
        <tr>
          <td><h5>Total Price</h5></td>
          <td><h5>:</h5></td>
          <td><h5 id="modalPrice"></h5></td>
        </tr>
        <tr>
          <td><h5>tax</h5></td>
          <td><h5>:</h5></td>
          <td><h5 id="modaltax"></h5></td>
        </tr>
        <tr>
          <td><h5>Paid </h5></td>
          <td><h5>:</h5></td>
          <td><h5 id="modalPaid"></h5></td>
        </tr>
        <tr>
          <td><h5>Change</h5></td>
          <td><h5>:</h5></td>
          <td><h5 id="modalChange"></h5></td>
        </tr>
      </thead>
        </table>
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
    let idOrder = localStorage.getItem('id_order')
    document.getElementById('idOrder').textContent = idOrder
    document.getElementById('ORID').value = idOrder

    let formTable = document.getElementById('formTable');
    let linkForm = formTable.getAttribute('action');
    linkForm = '/order-submit/'+ idOrder;
    formTable.setAttribute('action', linkForm);
  function deleteItem(IdItem, SKUItem){
    const confirmation = confirm('delete this item?')
  if(confirmation){
    window.location.href = `/order-deleteItem/${IdItem}-${SKUItem}`
  }

  }
  function submitOrder(){
    let form = document.getElementById('formTable');
    form.submit()
    newOrder()
  }
  function generateIdOrder(){
      var formattedTime = new Date().getTime();
      console.log(formattedTime)
      let ORID = `OR${formattedTime}`
      localStorage.setItem('id_order', ORID)
      window.location.href =`/order/${ORID}`
  }

function newOrder(){
  localStorage.clear()
    window.location.reload()
    generateIdOrder()
}
  document.getElementById('btnNewOrder').addEventListener('click', function(){
    const confirmation = confirm('Do you want to make a new Order?')
    if(confirmation){
      newOrder()
    }
  })

    function getSuggestions(){
      let inputSKU = document.getElementById('ORSKU').value
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
          document.getElementById('ORSKU').value = event.target.textContent;
          let product = event.target.textContent
          listSKU.innerHTML = ''
          fetch(`/order-getItem/${event.target.textContent}`)
          .then(response => response.json())
          .then(data =>{
            console.log(data.item)
              document.getElementById('ORProduct').value = data.item.name
              document.getElementById('ORPrice').value = data.item.price  
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
    let inputQuantity = document.getElementById('ORQuantity')
    let inputDiscount = document.getElementById('ORDiscount')
    let inputPrice = document.getElementById('ORPrice')
    let inputSubtotal = document.getElementById('ORSubtotal')
    inputQuantity.addEventListener('input', (e)=>{
      inputSubtotal.value = inputQuantity.value * inputPrice.value

    })
    inputDiscount.addEventListener('input', ()=>{
      inputSubtotal.value = (inputQuantity.value * inputPrice.value) - ((inputQuantity.value * inputPrice.value) * inputDiscount.value / 100)
    })
    //handle notif
    const notif = document.getElementById('notif')
      notif.style.display = 'block'
      const time = 1000
      setTimeout(() => {
      notif.style.display = 'none'
      }, time);

      //perhitungan pajak, cash dan kembalian
      let table = document.querySelector('#table-display')
      let tbody = table.querySelector('tbody')
      let rows = tbody.querySelectorAll('tr')
      let price = []
      let sumPrice = (a,b) => a+b
      rows.forEach(function(row) {
        let priceVal = +row.children[4].textContent;
        price.push(priceVal)
    });
    let totalPrice = price.reduce(sumPrice)
    let priceWithTax;
    let tax;
    let taxpersen;
    document.getElementById('disCash').textContent = totalPrice
    document.getElementById('ORCash').value = totalPrice
    //hitung pajak
    document.getElementById('ORTax').addEventListener('input',function(e){
      priceWithTax = totalPrice + (totalPrice * e.target.value / 100)
      document.getElementById('disCash').textContent = 'Rp. ' + priceWithTax +' (with tax)'
    document.getElementById('ORCash').value = priceWithTax
    tax = totalPrice * e.target.value / 100
    taxpersen = e.target.value
    })
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