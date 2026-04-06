<!DOCTYPE html>
<html lang="en">
<head>
    @vite('resources/css/app.css')
    <title>Input Orderan Baru</title>
</head>
<body class="bg-slate-50 p-6">
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-2xl shadow-sm">
        <h2 class="text-2xl font-bold text-slate-800 mb-6">Input Orderan Barang</h2>
        
        <form action="{{ route('order.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-8 p-4 bg-blue-50 rounded-xl border-2 border-dashed border-blue-200 text-center">
                <label class="block text-blue-700 font-semibold mb-2">Upload Bukti Pembayaran (JPG/PNG)</label>
                <input type="file" name="bukti_pembayaran" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700" required>
            </div>

            <table class="w-full mb-4" id="itemTable">
                <thead>
                    <tr class="text-left text-slate-600 border-b">
                        <th class="pb-2">Nama Barang</th>
                        <th class="pb-2">Qty</th>
                        <th class="pb-2">Harga Satuan</th>
                        <th class="pb-2">Aksi</th>
                    </tr>
                </thead>
                <tbody id="itemBody">
                    <tr class="item-row">
                        <td class="py-3"><input type="text" name="nama_item[]" class="w-full border-slate-200 rounded-lg" required></td>
                        <td class="py-3"><input type="number" name="qty[]" class="w-20 border-slate-200 rounded-lg" required></td>
                        <td class="py-3"><input type="number" name="harga[]" class="w-full border-slate-200 rounded-lg" required></td>
                        <td class="py-3 text-center"><button type="button" class="text-red-500 font-bold" onclick="removeRow(this)">X</button></td>
                    </tr>
                </tbody>
            </table>

            <button type="button" onclick="addRow()" class="mb-6 text-blue-600 font-semibold">+ Tambah Barang Lain</button>

            <div class="flex justify-end gap-4">
                <a href="/sales/dashboard" class="px-6 py-2 bg-slate-200 rounded-xl">Batal</a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-xl font-bold">Simpan Orderan</button>
            </div>
        </form>
    </div>

    <script>
        function addRow() {
            let body = document.getElementById('itemBody');
            let newRow = body.firstElementChild.cloneNode(true);
            newRow.querySelectorAll('input').forEach(input => input.value = '');
            body.appendChild(newRow);
        }
        function removeRow(btn) {
            let rows = document.querySelectorAll('.item-row');
            if(rows.length > 1) btn.closest('tr').remove();
        }
    </script>
</body>
</html>