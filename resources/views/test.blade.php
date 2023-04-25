<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>hello</h1>
    @foreach($category as $item)
    @foreach($item->categorydetails as $xx)
    @foreach($xx->images as $yy)
    <h1>{{$yy->colors->name}}</h1>
    @endforeach
    @endforeach
    @endforeach
    
</body>
</html>