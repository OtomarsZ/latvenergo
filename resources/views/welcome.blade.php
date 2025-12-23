<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <title>Latvenergo Veikals</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md">
        
        <div class="mb-10 p-6 bg-gray-50 rounded-lg border">
            <h2 class="text-xl font-bold mb-4">Pievienot jaunu produktu</h2>
            <form action="/products" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                @csrf
                <input type="text" name="name" placeholder="Nosaukums" class="p-2 border rounded" required>
                <input type="number" step="0.01" name="price" placeholder="Cena" class="p-2 border rounded" required>
                <input type="number" name="quantity" placeholder="Skaits" class="p-2 border rounded" required>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Pievienot
                </button>
            </form>
        </div>

        <h1 class="text-2xl font-bold mb-6">Pieejamie produkti</h1>
        
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b">
                    <th class="py-2">Nosaukums</th>
                    <th class="py-2">Cena</th>
                    <th class="py-2">Noliktavā</th>
                    <th class="py-2">Darbība</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr class="border-b">
                    <td class="py-4">{{ $product->name }}</td>
                    <td class="py-4">{{ $product->price }} €</td>
                    <td class="py-4">{{ $product->quantity }}</td>
                    <td class="py-4">
                        <button onclick="pirkt({{ $product->id }})" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Pirkt 1 gab.
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        function pirkt(id) {
            fetch('/order', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `product_id=${id}&quantity=1`
            })
            .then(res => res.json())
            .then(data => {
                if(data.message) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.error);
                }
            });
        }
    </script>
</body>
</html>