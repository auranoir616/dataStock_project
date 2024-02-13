<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <title>Document</title>
</head>
<body>
    <label for="exampleDataList" class="form-label">Datalist example</label>
    <input class="form-control" list="datalistOptions" id="exampleDataList" placeholder="Type to search..." oninput="getSuggestions()">
    <datalist id="datalistOptions">
    </datalist>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
<script>
        function getSuggestions(){
      let inputSKU = document.getElementById('exampleDataList').value
      const listSKU = document.getElementById('datalistOptions')
      //suggestion SKU
      fetch(`/order-suggestions?query=${inputSKU}`)
      .then(response => response.json())
      .then(data =>{
        listSKU.innerHTML = ''
        data.suggestions.forEach(suggestion => {
        const listItem = document.createElement('option');
        listItem.value = suggestion;
        listSKU.appendChild(listItem);
        console.log(data)
    })
          })
      .catch(error => console.error('Error fetching suggestions:', error));
    }
</script>   
</body>
</html>