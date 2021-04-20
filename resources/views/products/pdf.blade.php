<!DOCTYPE html>
<html>

<head>
    <title>List Categories</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
</head>

<body>
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 9pt;
        }

    </style>
    <center>
        <h4>List Of Product</h4>
    </center>

    <table class='table table-bordered'>
        <thead>
            <tr>
                <th>No</th>
                <th>Product Code</th>
                <th>Nama</th>
                <th>Categories</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            @php $i=1 @endphp
            @foreach ($products as $product)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $product->product_code }}</td>
                    <td>{{ $product->name }}</td>
                    <td> <?php $elements = []; ?>
                        @foreach ($product->category as $cat)
                            <?php $elements[] = $cat->name; ?>
                        @endforeach
                        <?php echo implode(', ', $elements); ?>
                    </td>
                    <td>{{ $product->stok->jumlah_barang }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
