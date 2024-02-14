<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <title>Purchase order</title>
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
          <form class="row g-3" action="{{ url('/dataPO-add') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-12" style="display: none">
              <label class="form-label">ID PO</label>
              <input type="text" class="form-control" id="idpoinput" value=""  name="POId">
            </div>

            <div class="col-md-6">
              <label class="form-label">Create Date</label>
              <input type="date" class="form-control" id="POCreateDate" name="POCreateDate">
              </select>            
            </div>
            <div class="col-md-6">
              <label class="form-label">invoice</label>
              <input type="text" class="form-control" id="POinvoice" name="POInvoice">
            </div>
            <div class="col-md-6">
              <label for="inputState" class="form-label">Suppliers</label>
              <select class="form-select" id="POSupplier" name="POSupplier">
                <option selected> </option>
                @foreach ($dataSuppliers as $supplier)
                <option>{{$supplier}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">SKU</label>
              <input class="form-control" aria-label="Default select example" id="POSKU"  name="POSKU" oninput="getSuggestions()" autocomplete="off">
              <div id="suggestion-list" class="list-group z-3 position-absolute" >
              </div>

            </div>
            <div class="col-md-6">
              <label class="form-label">Price</label>
              <input type="number" class="form-control" id="POPrice" name="POPrice">
            </div>
            <div class="col-md-6">
              <label class="form-label">Quantity</label>
              <input type="number" class="form-control" id="POQuantity" name="POQuantity">
            </div>
            <div class="col-md-6">
              <label for="formFile" class="form-label">File</label>
              <input class="form-control" type="file" id="POFile" name="POFile">
            </div>
            <div class="col-12 ">
              <label for="exampleFormControlTextarea1" class="form-label">Notes</label>
              <textarea class="form-control" rows="2" id="PONotes" name="PONotes"></textarea>
            </div>
            <div class="col-12 d-grid gap-2">
              <button type="submit" class="btn btn-primary" id="btnAdd">Add</button>
              <button type="button" class="btn btn-danger" id="btnDeleteData" onclick="deleteData()">delete previous data</button>
              
            </div>
          </form>        
        </div>
      </div>
        <div class="cont-table">
          <b>id PO : </b>
          <small id="idPO"> </small>
          <div class="w-100 p-3" id="content-table">
            <table class="table table-striped table-hover" id="table-display" width="100%">
              <thead>
                <tr>
                  <th  width="15%">Create Date</th>
                  <th  width="10%">Invoice</th>
                  <th>Supplier</th>
                  <th>Product(SKU)</th>
                  <th>Quantity</th>
                  <th>Price</th>
                  <th>Notes</th>
                  <th width="15%">Actions</th>
              </tr>

                <tbody>
                  @foreach($tempTablePO as $tempPo)
                  <tr>
                    <td>{{ \Carbon\Carbon::parse($tempPo->create_date)->format('j M Y') }}</td>
                    <td>{{$tempPo->invoice}}</td>
                    <td>{{$tempPo->supplier}}</td>
                    <td>{{$tempPo->SKU}}</td>
                    <td>{{$tempPo->quantity}}</td>
                    <td class="cellprice">{{$tempPo->price}}</td>
                    <td>{{$tempPo->notes}}</td>
                    <td><a class="btn btn-danger" href="#" onclick="deleteItemPO('{{$tempPo->id}}')">Delete</a></td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot style="display:none">
                  <form action="" method="POST" id="formPrice">
                    @csrf
                    @method('PUT')
                  <tr>
                    <td>discount : </td>
                    <td>
                      <input type="number" class="form-control" id="discount" name="PODiscount" value="0">
                    </td>
                    <td colspan="3"> </td>
                    <td id="disDiscount" colspan="3">
                    </td>
                  </tr>
                  <tr>
                    <td>tax : </td>
                    <td>
                      <input type="number" class="form-control" id="tax" name="POTax" value="0" disabled>
                      <input type="number" name="POTotalCost" id="POTotalCost" value="0" hidden>

                    </td>
                    
                    <td colspan="3"></td>
                  <td id="disTax" colspan="3">

                  </td>
                  </tr>
                  <tr>
                    <td>
                    total price :
                    </td>
                    <td colspan="4"> </td>
                    <td id="totalPrice" colspan="3">
                    </td>
                  </tr>
                  <tr >
                    <td colspan="8">
                      <div class="d-grid gap-2">
                        <button class="btn btn-primary" disabled id="btnSubmit">submit</button>
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
    </article>

    @include('_footer')

</main>
 <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
  <script>
    function getSuggestions(){
      let inputSKU = document.getElementById('POSKU').value
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
          document.getElementById('POSKU').value = event.target.textContent;
          let product = event.target.textContent
          listSKU.innerHTML = ''
          })
              })
          })
      .catch(error => console.error('Error fetching suggestions:', error));
    }

    window.addEventListener("DOMContentLoaded", () =>{
      let idPO = localStorage.getItem('id_PO')
      document.getElementById('idPO').textContent = idPO;
      document.getElementById('idpoinput').value = idPO;
      console.log(idPO)

      let addButon = document.getElementById('btnAdd')
      addButon.addEventListener('click', function(){
      let inputDate = document.getElementById('POCreateDate').value 
      let inputInvoice = document.getElementById('POinvoice').value 
      let inputSupplier = document.getElementById('POSupplier').value 
      // let inputPayment = document.getElementById('POPayment').value 
        localStorage.setItem('valDate', inputDate)
        localStorage.setItem('valInvoice', inputInvoice)
        localStorage.setItem('valSupplier', inputSupplier)
        // localStorage.setItem('valPayment', inputPayment)
      })
      let valDate = document.getElementById('POCreateDate')
      valDate.value  = localStorage.getItem('valDate')
      let valInvoice = document.getElementById('POinvoice')
      valInvoice.value = localStorage.getItem('valInvoice')
      let valSupplier = document.getElementById('POSupplier') 
      valSupplier.value = localStorage.getItem('valSupplier')
      // let valPayment = document.getElementById('POPayment')
      // valPayment.value  = localStorage.getItem('valPayment')

      let formPrice = document.getElementById('formPrice');
      let linkForm = formPrice.getAttribute('action');
      linkForm = '/dataPO-addPrice/'+ idPO;
      formPrice.setAttribute('action', linkForm);

      const notif = document.getElementById('notif')
      notif.style.display = 'block'
      const time = 1000
      setTimeout(() => {
      notif.style.display = 'none'
      }, time);
   
    })
    // delete data form sebelumnya
      function deleteData(){
        // Menghapus item satu per satu
        localStorage.removeItem('valDate');
        localStorage.removeItem('valInvoice');
        localStorage.removeItem('valSupplier');
        window.location.reload()
      }
      //metode untuk submit data
      document.getElementById('btnSubmit').addEventListener('click', (e)=>{
        const confirmation = confirm('apakah anda sudah yakin?')
        const form = e.target.closest('form')
      if(confirmation){
        form.submit()
        localStorage.clear();
        

      }
      window.location.href = '/purchaseOrder'

    })
//metode delete data dalam tabel
      function deleteItemPO(IdItem){
  const confirmation = confirm('are you sure?')
  if(confirmation){
    window.location.href = `/dataPO-TableDelete/${IdItem}`
  }
}
 let tabelDisplay = document.getElementById('table-display')
 let tbody = tabelDisplay.querySelector('tbody')
 let tfoot = tabelDisplay.querySelector('tfoot')
 let jumlahTR = tbody.childElementCount;
 if(jumlahTR > 0){
  tfoot.style.display = ''
 }
//metode discount, tax & price
let prices = document.querySelectorAll('.cellprice');
let tax = document.getElementById('tax');
let discount = document.getElementById('discount');

let totalPrice = document.getElementById('totalPrice');
let distax = document.getElementById('disTax');
let disdiscount = document.getElementById('disDiscount');
let cost = document.getElementById('POTotalCost')

let arrayPrice = [];
const sumArray = (a, b) => a + b;
prices.forEach(price => {
  arrayPrice.push(+price.textContent);
});

let priceVal = arrayPrice.length ? arrayPrice.reduce(sumArray) : 0 // Total harga
let currentPrice;
let dicountPrice; 
discount.addEventListener('input', (e) => {
  tax.disabled = false
  let valDiscount = e.target.value;
  let discountCal = priceVal - (priceVal * valDiscount / 100);
  disdiscount.textContent = Math.round(priceVal - discountCal); // Menampilkan jumlah diskon saja
  dicountPrice = discountCal
  currentPrice = dicountPrice
  totalPrice.textContent = currentPrice
  cost.value =  Math.round(currentPrice)
});
tax.addEventListener('input', (e) => {
  let valTax = e.target.value;
  let taxCal =  dicountPrice + (dicountPrice * valTax / 100);
  distax.textContent = Math.round(taxCal - dicountPrice); // Menampilkan jumlah pajak saja
  currentPrice = taxCal
  totalPrice.textContent = currentPrice
  cost.value = Math.round(currentPrice)
});

discount.addEventListener('input', ()=>{
  document.getElementById('btnSubmit').disabled = false
})
  </script>   
</body>
</html>