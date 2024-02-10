<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <title>data items</title>
</head>
<body>
    <table class="table">
        <thead>
          <tr>
            <th scope="col">SKU</th>
            <th scope="col">name</th>
            <th scope="col">categories</th>
            <th scope="col">unit</th>
            <th scope="col">price</th>
            <th scope="col">quantity</th>
            <th scope="col">notes</th>
            <th scope="col">date_in</th>
            <th scope="col">exp_date</th>
          </tr>
        </thead>
        <tbody>
     
            @foreach($data as $data)
            <tr>
            <td>{{$data->SKU}}</td>
            <td>{{$data->name}}</td>
            <td>{{$data->categories}}</td>
            <td>{{$data->unit}}</td>
            <td>{{$data->price}}</td>
            <td>{{$data->quantity}}</td>
            <td>{{$data->notes}}</td>
            <td>{{$data->date_in}}</td>
            <td>{{$data->exp_date}}</td>
        </tr>
            @endforeach
    
        </tbody>
      </table>
      
</body>
</html>