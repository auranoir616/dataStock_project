<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <title>LOGIN</title>
    <style>
        body{
            background-image: url('bg_warehouse.jpg');
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center
        }
        .cont-login{
            color: white;
            height: 50%;
            width: 30%;
            border-radius: 10px;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .form-login{
            width: 400px;

        }
        .cont-form{
          width: 50%;
        }
        @media(max-width:750px){
          .cont-form{
          width: 100%;
        }
        .cont-login{
            height: 80%;
            width: 100%;
        }
        }
    </style>
</head>
<body>
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
            <div class="cont-login">
                <div class="row mb-3">
                    <h1 align="center"> Login</h1>
                </div>
                <div class="cont-form">
                  <form action="/loginUser" method="POST" enctype="multipart/form-data">
                    @csrf
                  <label for="inputusername" class="form-label">Username </label>
                  <input type="text" class="form-control" id="inputusername" name="loginUsername">
                  <label for="inputPassword" class="form-label">Password</label>
                    <input type="password" class="form-control" id="inputPassword" name="loginPassword" >
                <hr>
                <div class="row mb-3">
                    <button class="btn btn-primary" type="submit">Login</button>
                </div>
                </form>
              </div>
                <div class="row mb-3">
                      <p align="center"><b>username: admin<br>
                      password: admin</b></p>
                    </div>
                  </div>
                  
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