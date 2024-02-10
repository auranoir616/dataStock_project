<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
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
    <article>
      <div class="cont-In">
      <div class="cont-form">
        <div class="w-100 p-3">
          <form class="row g-3" action="{{ url('/shipping-add') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <h3>Expedition</h3>
            <div class="row g-3">
            <div class="col-md-6" style="display: none">
                <label class="form-label">Shipping ID</label>
                <input type="text" class="form-control" id="SHShipping_id" name="SHShipping_id" value="">
              </div>
              <div class="col-sm-4">
                <label class="form-label">Receipt Number</label>
                <input type="text" class="form-control" id="SHReceipt" name="SHReceipt" value="">
              </div>
              <div class="col-sm">
                <label class="form-label">Destination</label>
                <input class="form-control" type="text" id="SHDestination" name="SHDestination"> 
              </div>
              <div class="col-sm">
                <label class="form-label">Recepient Name</label>
                <input type="text" class="form-control" id="SHName" name="SHName" value="">
              </div>
            </div>
            <div class="row g-3">
              <div class="col-sm-4">
                <label class="form-label">Expedition</label>
                <select class="form-select" aria-label="Default select example"  id="SHExpedition" name="SHExpedition">
{{-- dari array --}}
                  </select>              
            </div>
              <div class="col-sm">
                <label class="form-label">Shipping Cost</label>
                <input type="number" class="form-control" id="SHShippingCost" name="SHShippingCost" value="">
              </div>
              <div class="col-sm">
                  <label for="formFile" class="form-label">File</label>
                  <input class="form-control" type="file" id="SHFile" name="SHFile">
                </div>
            </div>
              <div class="col-12">
                <label for="exampleFormControlTextarea1" class="form-label">Address</label>
                <textarea class="form-control" rows="2" id="SHNotes" name="SHNotes"></textarea>
              </div>
              <hr>
              <h3>Product</h3>

            <div class="col-md-6">
              <label class="form-label">SKU</label>
              <input type="text" class="form-control" id="SHSKU" name="SHSKU" oninput="getSuggestions()" value="">
              <div id="suggestion-list" class="list-group z-3 position-absolute">
              </div>
            </div>
            <div class="col-md-6">
              <label class="form-label">Product</label>
              <input type="text" class="form-control" id="SHProduct" name="SHProduct" value="" readonly>
            </div>
            <div class="row g-3">

            <div class="col-sm-4">
              <label class="form-label">Price</label>
              <input type="number" class="form-control" id="SHPrice" name="SHPrice" value="" readonly>
            </div>
            <div class="col-sm">
              <label class="form-label">Quantity</label>
              <input type="number" class="form-control" id="SHQuantity" name="SHQuantity">
            </div>
            <div class="col-sm">
              <label class="form-label">Discount</label>
              <input type="number" class="form-control" id="SHDiscount" name="SHDiscount" value="0">
            </div>
            <div class="col-sm">
              <label class="form-label">sub total</label>
              <input type="text" class="form-control" id="SHSubtotal" name="SHSubtotal" value="" readonly>
            </div>
        </div>
       
  
            <div class="col-12 d-grid gap-2" >
              <button type="submit" class="btn btn-primary" id="btnAddShipping">Add</button>
              <button type="button" class="btn btn-danger" id="btnNewShipping">Delete Previous data</button>
            </div>  
          </form>   
   
        </div>
      </div>
        <div class="cont-table">
          <b>ID Shipping : </b>
          <small id="idOrder"> </small><br>
          <b>Receipt Number : </b>@if(isset($dataShipping[0])) {{$dataShipping[0]->receipt}} @else @endif<br>
          <b>Destination : </b>@if(isset($dataShipping[0])) {{$dataShipping[0]->destination}} @else @endif<br>
          <b>Receipt name : </b>@if(isset($dataShipping[0])) {{$dataShipping[0]->name}} @else  @endif<br>
          <b>Expedition : </b>@if(isset($dataShipping[0])) {{$dataShipping[0]->expedition}} @else  @endif
          
          <div class="w-100 p-3">
            <table class="table table-striped table-hover" id="table-display" width="100%">
              <thead>
                <tr>
                  <th width='30%'>Poduct</th>
                  <th width='10%'>Quantity</th>
                  <th>Price</th>
                  <th>discount</th>
                  <th width='10%'>Actions</th>
              </tr>
                <tbody  class="table-group-divider">
                  @forEach($dataShipping as $data)
                  <tr>
                    <td>{{$data->product}}</td>
                    <td>{{$data->quantity}}</td>
                    <td>{{ $data->price - ($data->price * $data->discount / 100) }}</td>
                    <td>{{$data->discount}}%</td>
                    {{-- <td>{{$data->subtotal}}</td> --}}
                    <td>
                      <button class="btn btn-danger" onclick="deleteItem('{{$data->id}}','{{$data->SKU}}')">delete</button>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <form action="/shipping-submit/" method="POST" id="formTable">
                    @csrf
                    @method('PUT')  
                  <tr>
                    <td>Tax : </td>
                    <td>
                      <input type="number" class="form-control" id="SHTax" name="SHTax" value="0" >
                    </td>
                    
                    <td colspan="3"></td>
                  <td id="disTax" colspan="3">
                  </td>
                  </tr>
                  <tr>
                    <td>
                    Total Cost : 
                    </td>
                    <td colspan="2">
                      <input type="number" class="form-control" name="SHTotal_cost" id="SHTotal_cost" value="" readonly>
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
          <td><h5>Price</h5></td>
          <td><h5>:</h5></td>
          <td><h5 id="modalPrice"></h5></td>
        </tr>
        <tr>
          <td><h5>tax</h5></td>
          <td><h5>:</h5></td>
          <td><h5 id="modaltax"></h5></td>
        </tr>
        <tr>
          <td><h5>Shipping</h5></td>
          <td><h5>:</h5></td>
          <td><h5 id="modalShippingCost"></h5></td>
        </tr>
        <tr>
          <td><h5>Total Cost</h5></td>
          <td><h5>:</h5></td>
          <td><h5 id="modalCost"></h5></td>
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
    let idShipping = localStorage.getItem('id_shipping')
    document.getElementById('idOrder').textContent = idShipping
    document.getElementById('SHShipping_id').value = idShipping

    let formTable = document.getElementById('formTable');
    let linkForm = formTable.getAttribute('action');
    linkForm = '/shipping-submit/'+ idShipping;
    formTable.setAttribute('action', linkForm);

  function deleteItem(IdItem, SKUItem){
    const confirmation = confirm('delete this item?')
  if(confirmation){
    window.location.href = `/shipping-delete/${IdItem}-${SKUItem}`
  }

  }
  function submitOrder(){
    let form = document.getElementById('formTable');
    form.submit()
    // localStorage.clear()
  }
  function generateIdShipping(){
      var formattedTime = new Date().getTime();
      console.log(formattedTime)
      let ORID = `OR${formattedTime}`
      localStorage.setItem('id_order', ORID)
      window.location.href =`/order/${ORID}`
  }

const inputIds = ['SHReceipt', 'SHDestination', 'SHName', 'SHExpedition', 'SHNotes', 'SHShippingCost'];
const outputIds = ['receiptVal', 'destinationVal', 'nameVal', 'expeditionVal', 'notesVal', 'shippingCostVal'];

document.getElementById('btnAddShipping').addEventListener('click', function () {
    inputIds.forEach((inputId, index) => {
        const inputValue = document.getElementById(inputId).value;
        localStorage.setItem(outputIds[index], inputValue);
    });
});

const setValuesFromLocalStorage = () => {
    inputIds.forEach((inputId, index) => {
        const setInput = document.getElementById(inputId);
        setInput.value = localStorage.getItem(outputIds[index]);
    });
};
document.getElementById('btnNewShipping').addEventListener('click', function () {
  outputIds.forEach((outputId)=>{
    localStorage.removeItem(outputId)

})
window.location.reload()
})

// Set initial values
setValuesFromLocalStorage();

  // document.getElementById('btnNewOrder').addEventListener('click', function(){
  //   const confirmation = confirm('Do you want to make a new Order?')
  //   if(confirmation){
  //   localStorage.clear()
  //   window.location.reload()
  //   generateIdShipping()
  //   }
  // })

    function getSuggestions(){
      let inputSKU = document.getElementById('SHSKU').value
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
          document.getElementById('SHSKU').value = event.target.textContent;
          let product = event.target.textContent
          listSKU.innerHTML = ''
          fetch(`/order-getItem/${event.target.textContent}`)
          .then(response => response.json())
          .then(data =>{
            console.log(data.item)
              document.getElementById('SHProduct').value = data.item.name
              document.getElementById('SHPrice').value = data.item.price  
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
    let inputQuantity = document.getElementById('SHQuantity')
    let inputDiscount = document.getElementById('SHDiscount')
    let inputPrice = document.getElementById('SHPrice')
    let inputSubtotal = document.getElementById('SHSubtotal')
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
        let priceVal = +row.children[2].textContent;
        price.push(priceVal)
    });      
    let totalPrice = price.length ? price.reduce(sumPrice) : 0
    let priceWithTax;
    let tax;
    let taxpersen;
    let totalCost;
    let shippingCost = +document.getElementById('SHShippingCost').value

    document.getElementById('SHTotal_cost').value = totalPrice
    //hitung pajak
    document.getElementById('SHTax').addEventListener('input',function(e){
      priceWithTax = totalPrice + (totalPrice * e.target.value / 100)
      // document.getElementById('disTotal_Cost').textContent = 'Rp. ' + priceWithTax +' (with tax)'
    totalCost = priceWithTax + shippingCost
    document.getElementById('SHTotal_cost').value = totalCost
    tax = totalPrice * e.target.value / 100
    taxpersen = e.target.value
    })
    //uang
    function displayModal(){
    document.getElementById('modalPrice').textContent = 'Rp.'+ totalPrice
    document.getElementById('modaltax').textContent = 'Rp.'+tax+' ('+taxpersen+'%)'
    document.getElementById('modalShippingCost').textContent = 'Rp.'+ shippingCost
    document.getElementById('modalCost').textContent = 'Rp.'+ totalCost
  }
  let expedisi = [
    'JNE',
    'Tiki',
    'Pos',
    'Wahana',
    'J&T',
    'Sicepat',
    'RPX',
    'Lion Parcel',
    'Ninja Xpress',
    'AnterAja',
    'SiCepat Ekspres',
    'Lazada Express',
    'Alfamart',
    'Alfamidi',
    'Jembatan Merah',
    'Pahala Kencana',
    'Jasa Raharja',
    'First Logistics',
    'Jaya Express',
];
expedisi.forEach(function(exp){
  let select = document.getElementById('SHExpedition')
  let option = document.createElement('option')
  option.value = exp
  option.textContent = exp
  select.appendChild(option)
})

  </script>   
</body>
</html>