<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <title>dashboard</title>
    <style>
      #img-icon{
        width: 50px;
        height: 50px;
        border-radius: 50%
      }
      article.list-user{
        display: flex;
        flex-direction: row;
        align-items: flex-start;
        justify-content: space-around;
        width: 100%;
        padding: 10px;
      }
      .cont-table-list-user{
        width: 75%
      }
    </style>
</head>
<body>
  @include('_aside') 

<main>
@include('_header')
    <article class="list-user">
        {{-- <div  id="container-notif">
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
          </div> --}}
          <div class="cont-table-list-user">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>photo</th>
                  <th>name</th>
                  <th>Username</th>
                  <th>Role</th>
                  <th>action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($dataUsers as $user)
                <tr>
                  <td><img src="../data_file/{{$user->image}}" alt="" id="img-icon"></td>
                  <td>{{$user->name}}</td>
                  <td>{{$user->username}}</td>
                  <td>{{$user->access}}</td>
                  <td>
                    <div class="btn-group">
                      <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        action
                      </button>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="/editUser-form/{{$user->id}}">Edit</a></li>
                          <li><a class="dropdown-item" href="/deleteUser/{{$user->id}}">Delete</a></li>
                        </ul>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
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