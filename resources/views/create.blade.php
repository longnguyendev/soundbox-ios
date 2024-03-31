<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    <title>Admin</title>
</head>

<body>
    <div class="container mt-5">
        <form action="/api/songs" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class="mb-3">
                <label for="photo" class="form-label">File</label>
                <input type="file" class="form-control" id="photo" name="file">
            </div>
            <div class="mb-3">
                <label for="photo" class="form-label">Thumbnail</label>
                <input type="file" class="form-control" id="photo" name="thumbnail">
            </div>
            <h3>singers</h3>
            @foreach ($singers as $singer)
            <label class="mx-2">{{$singer->name}}<input class="mx-1" type="radio" name="singer_id" value="{{$singer->id}}"></label>
            @endforeach
            <br />
            <button class="btn btn-primary mt-3" type="submit">Thêm</button>
        </form>
    </div>

</body>

</html>