<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script type="text/javascript" src="sort-table.js"></script>
    <link rel="stylesheet" href="../style.css">
    <title>Purchase order</title>
    <style>
    </style>
</head>
<body>
  @include('_aside') 
<main>
@include('_header')
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
  <h1 align="center">Purchase Order</h1>
  <hr>
</div>
<div class="w-100 p-3 navbar bg-body-tertiary">
  <div>
    <a href="#" class="btn btn-primary btn-lg" onclick="generateIdPO()">New Purchase Order</a>
  </div>
</div>

      <article>
        <table class="table table-hover js-sort-table">
          <thead>
                <tr>
                    <th>PO Number</th>
                    <th>Create Date</th>
                    <th>Invoice</th>
                    <th width="10%">PO Status</th>
                    <th>Notes</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach($dataPO as $data)
                    <tr>
                      {{-- @php
                       $countID = $data->purchase_id->count('');
                       $countSubmited = $data->submited->where('1')->count();   
                      @endphp --}}
                        <td>{{$data->purchase_id}}</td>
                        <td>{{$data->create_date}}</td>
                        <td>{{$data->invoice}}</td>
                        <td>
                          <div class="col-md-6 form_status">
                            <form action="/dataPO-editStatus/{{$data->purchase_id}}" method="POST">
                              @csrf
                              @method('PUT')
                          <select class="form-select " aria-label="Default select example " name="POStatus" id="POStatus" IDPO="{{$data->purchase_id}}">
                            <option @if($data->PO_status == 'On Process') selected @endif value="On Process">On Process</option>
                            <option @if($data->PO_status == 'Delivered') selected @endif value="Delivered">Delivered</option>
                            <option @if($data->PO_status == 'Received') selected @endif value="Received">Received</option>
                            <option @if($data->PO_status == 'Partial Received') selected @endif value="Partial Received">Partial Received</option>
                            <option @if($data->PO_status == 'Completed') selected @endif value="Completed">Completed</option>
                            <option @if($data->PO_status == 'Cancel') selected @endif value="Cancel">Cancel</option>
                          </select>
                        </form>
                          </div>
                            </td>
                        <td>{{$data->notes}}</td>
                        <td>
                          <div class="dropdown-center">
                            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                             Actions
                            </button>
                            <ul class="dropdown-menu">
                              <li><a class="dropdown-item" href="/dataPO-view/{{$data->purchase_id}}">View Detail</a></li>
                              <li><a @if($data->submited == 'yes') class="dropdown-item disabled" @else class="dropdown-item " @endif href="" onclick="deletePO('{{$data->purchase_id}}')">Delete</a></li>
                            </ul>
                          </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                  <tr >
                      <td colspan="9">
                        {{ $dataPO->appends(request()->query())->links('pagination::bootstrap-5') }}
                      </td>
                   </tr>
              </tfoot>
        </table>
    </article>

    @include('_footer')
</main>
</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
<script>
  function generateIdPO(){
    var formattedTime = new Date().getTime();
    let IDPO = `PO${formattedTime}`
   localStorage.setItem('id_PO', IDPO)
   window.location.href = `/dataPO-new/${IDPO}`
}

const notif = document.getElementById('notif')
notif.style.display = 'block'
const time = 1000
setTimeout(() => {
 notif.style.display = 'none'
}, time);

let POStatusEdit = document.querySelectorAll('#POStatus')
POStatusEdit.forEach(function(statusEdit){
  let row = statusEdit.closest('td')
  let statusValue = statusEdit.value
  if(statusValue === 'Cancel'){
    row.className = 'table-danger'
     }
  if(statusValue === 'Received'){
    row.className = 'table-success'
    statusEdit.disabled = true
  }  
  if(statusValue === 'Partial Received'){
    row.className = 'table-warning'
  }  
  if(statusValue === 'Delivered'){
    row.className = 'table-info'
  }  


  statusEdit.addEventListener('change', (e)=>{
      const confirmation = confirm('Save change?')
        if(confirmation){
          const form = statusEdit.closest('form');
            form.submit();
        }else{
          window.location.reload()
        }
  })
})

function deletePO(IDPO){
  const confirmation = confirm('delete this data?')
  if(confirmation){
    window.location.href = `/dataPO-delete/${IDPO}`
  }
}

</script>
</html>