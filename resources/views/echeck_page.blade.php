<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Echeck Payment</title>
</head>
<body>
    <div class="container">
        <form action="{{ route('post_echeck') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <input type="text" class="mb-3" name="account_number" placeholder="Account Number">
                </div>
                <div class="col-md-12">
                    <input type="text" class="mb-3" name="routing_number" placeholder="Routing Number">
                </div>
                <div class="col-md-12">
                    <button type="submit"> Submit </button>
                </div>
            </div>
        </form>
    </div>

</body>
</html>
