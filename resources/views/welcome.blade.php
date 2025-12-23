<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <title>Latvenergo Veikals</title>
    <script src="{{ asset('js/tailwind.js') }}"></script>
</head>
<body class="bg-gray-100 p-10">
    <div class="max-w-5xl mx-auto bg-white p-8 rounded-lg shadow-md">
        
        <div class="mb-10 p-6 bg-gray-50 rounded-lg border">
            <h2 class="text-xl font-bold mb-4">Pievienot jaunu produktu</h2>
            <form action="/products" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @csrf
                <input type="text" name="name" placeholder="Nosaukums" class="p-2 border rounded" required>
                <input type="text" name="description" placeholder="Mazs apraksts" class="p-2 border rounded" required>
                <input type="number" step="0.01" name="price" placeholder="Cena" class="p-2 border rounded" required>
                <input type="number" name="quantity" placeholder="Daudzums" class="p-2 border rounded" required>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 md:col-span-2 transition">
                    Saglabāt produktu noliktavā
                </button>
            </form>
        </div>

        <h1 class="text-2xl font-bold mb-6 text-gray-800">Produktu saraksts</h1>

        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b bg-gray-50">
                    <th class="py-2 px-4">Nosaukums</th>
                    <th class="py-2 px-4">Apraksts</th>
                    <th class="py-2 px-4">Cena</th>
                    <th class="py-2 px-4">Noliktavā</th>
                    <th class="py-2 px-4 text-center">Darbība</th>
                </tr>
            </thead>
            <tbody id="product-table">
                @foreach($products as $product)
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-4 px-4 font-bold">{{ $product->name }}</td>
                    <td class="py-4 px-4 text-gray-600 text-sm">{{ $product->description }}</td>
                    <td class="py-4 px-4">{{ $product->price }} €</td>
                    <td class="py-4 px-4" id="stock-{{ $product->id }}">{{ $product->quantity }}</td>
                    <td class="py-4 px-4 text-center">
                        @if($product->quantity > 0)
                            <button onclick="addToCart({{ $product->id }}, '{{ $product->name }}')" class="bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700 transition">
                                Pievienot grozam vienu
                            </button>
                        @else
                            <span class="text-red-500 font-bold italic">Nav pieejams</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div id="cart-container" class="mt-10 p-6 bg-blue-50 rounded-lg border-2 border-blue-200 hidden">
            <h2 class="text-xl font-bold mb-4 text-blue-800 border-b border-blue-200 pb-2">Tavs Iepirkumu Grozs</h2>
            <ul id="cart-list" class="mb-6 space-y-2 list-disc pl-5"></ul>
            <div class="flex justify-between items-center">
                <button onclick="clearCart()" class="text-red-600 hover:underline">Iztīrīt grozu</button>
                <button onclick="submitOrder()" class="bg-orange-600 text-white px-8 py-3 rounded-xl font-bold shadow-lg hover:bg-orange-700 transition">
                    Noformēt pasūtījumu
                </button>
            </div>
        </div>
    </div>

    <script>
        let cart = [];

        function addToCart(id, name) {
            const stockElement = document.getElementById(`stock-${id}`);
            const stock = parseInt(stockElement.innerText);
            
            const inCart = cart.filter(item => item.id === id).length;

            if (inCart >= stock) {
                alert("Nevar pievienot vairāk, nekā ir noliktavā!");
                return;
            }

            cart.push({ id: id, qty: 1 });
            
            document.getElementById('cart-container').classList.remove('hidden');
            
            const list = document.getElementById('cart-list');
            const li = document.createElement('li');
            li.className = "text-gray-700 font-medium";
            li.innerText = `${name} (1 gab.)`;
            list.appendChild(li);
        }

        function clearCart() {
            cart = [];
            document.getElementById('cart-list').innerHTML = '';
            document.getElementById('cart-container').classList.add('hidden');
        }

        function submitOrder() {
            if (cart.length === 0) return;

            fetch('/order', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                },
                body: JSON.stringify({ items: cart })
            })
            .then(async res => {
                const data = await res.json();
                if (res.ok) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert("KĻŪDA: " + (data.error || "Neizdevās apstrādāt pasūtījumu"));
                }
            })
            .catch(err => alert("Sistēmas kļūda!"));
        }
    </script>
</body>
</html>