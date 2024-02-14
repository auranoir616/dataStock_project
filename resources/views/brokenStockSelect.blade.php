<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <title>List Broken Stock</title>
    <style>
        .cont-form{
          /* border: 2px solid black; */
          border-radius: 10px;
          background-color: rgb(230, 230, 230)
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
      <div class="cont-form">
        <div class="w-100 p-3">
          <form class="row g-3" action="#" method="GET" id="AddFromReturn">
            @csrf
            <div class="col-12">
            </select>                  
            </div>
            <div class="col-12">
              <label class="form-label">Purchase ID </label>
              <select class="form-select" aria-label="Default select example" name="selectID" value='' id="selectID">
                  @foreach($dataBrokenReturn as $broken)
                  <option value="{{$broken->SKU}},{{$broken->return_id}}">
                   {{$broken->SKU}}  <small>{{$broken->return_id}}</small> {{$broken->id}}
                  </option> 
                  @endforeach
            </select>                  
            </div>
            <div class="col-12">
            </div>
            <div class="col-12 d-grid gap-2">
              <p>Purchase ID will display purchase orders with <b>Delivered, and Partial Received</b> status</p>
            </div>
          </form>    
          <button type="button" class="btn btn-primary" id="btnBrokenAdd" >Add</button>
        </div>
      </div>
    </article>

    @include('_footer')

</main>
 <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
  <script>

    document.getElementById('btnBrokenAdd').addEventListener('click', function(){
      let selectedOption = document.getElementById('selectID').selectedOptions[0];
    if (selectedOption) {
        let values = selectedOption.value.split(',');
        let returnSKU = values[0];
        let returnID = values[1];
        window.location.href = `/broken-add/${returnID}/${returnSKU}`
          }})
        

const notif = document.getElementById('notif')
notif.style.display = 'block'
const time = 2000
setTimeout(() => {
 notif.style.display = 'none'
}, time);

  </script>   
</body>
</html>