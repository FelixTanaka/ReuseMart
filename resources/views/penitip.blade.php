<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    @foreach($penitips as $penitip)
        <p>{{ penitip->nama_penitip }}</p>
    @endforeach    
</body>
</html>