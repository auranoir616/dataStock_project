<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <title>Edit USER</title>
    <style>
        .bg-user{
            height: 100%;
            width: 100%;
            background-image: url('../bg_warehouse.jpg');
            background-size: contain;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            background-color: rgb(236, 236, 7)
        }
        .cont-form-user{
            height: 60%;
            width: 50%;
            border-radius: 10px;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 20px
        }
        .form-new-user{
            /* display: flex; */
            /* flex-wrap: wrap; */
        }
    </style>
</head>
<body>
  @include('_aside') 
<main>
@include('_header')
    <article>
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
          
        <div class="bg-user">
            <div class="cont-form-user">
                <div class="row mb-3">

                    <h2 align="center">Edit User</h2>
                </div>
            <form action="/editUser/{{$dataUser->id}}" method="POST" class="form-new-user" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                  <label for="inputname" class="col-sm-2 col-form-label">name</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputname" name="editName" value=''>
                </div>
                </div>
                <div class="row mb-3">
                    <label for="inputusername" class="col-sm-2 col-form-label">username</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputusername" name="editUsername" value=''>
                    </div>
                  </div>
                  
                <div class="row mb-3">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" id="inputPassword" name="editPassword" value=''>
                  </div>
                </div>
                <div class="row mb-3">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Access Type</label>
                    <div class="col-sm-10">
                    <select class="form-select" aria-label="Default select example" name="editAccess" value={{$dataUser->access}}>
                    <option @if($dataUser->access == 'Admin') selected @endif value="Admin">Admin</option>
                    <option @if($dataUser->access == 'Staff') selected @endif value="Staff">Staff</option>
                  </select>                  
                      </div>
                </div>
                <div class="row mb-3">
                    <label for="formFile" class="col-sm-2 col-form-label">User's Photo</label>
                    <div class="col-sm-10">
                    <input class="form-control" type="file" id="formFile" name="editPhoto" value=''>
                    </div>
                  </div>
                <hr>
                <div class="d-grid gap-2 col-6 mx-auto">
                    <button class="btn btn-primary" type="submit">edit</button>
                  </div>
                     </form>
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
</script>
</body>
</html>