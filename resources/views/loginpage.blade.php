<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <title>LOGIN</title>
    <style>
        .bg-user{
            height: 100%;
            width: 100%;
            background-image: url('bg_warehouse.jpg');
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center
        }
        .cont-form-user{
            /* height: 60%;
            width: 50%; */
            border-radius: 10px;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 20px;
        }
        .form-login{
            width: 400px;

        }
        article.loginpage{
            width: 100%
        }
    </style>
</head>
<body>
<main>
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
    <article class="loginpage">          
        <div class="bg-user">
            
            <div class="cont-form-user">
                <div class="row mb-3">
                    <h2 align="center"> Login</h2>
                </div>
            <form action="/loginUser" method="POST" class="form-login" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                      <label for="inputusername" class="col-sm-2 col-form-label">Username </label>
                      <input type="text" class="form-control" id="inputusername" name="loginUsername">
                  </div>
                <div class="row mb-3">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                    <input type="password" class="form-control" id="inputPassword" name="loginPassword">
                </div>
                <hr>
                <div class="d-grid gap-2 col-6 mx-auto">
                    <button class="btn btn-primary" type="submit">Login</button>
                  </div>
                     </form>
            </div>
        </div>    
    </article>

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