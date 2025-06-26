<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard Customer Service</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body x-data="penitipForm()" class="bg-gray-100 font-sans flex h-screen">

    <!-- Sidebar -->
    <aside class="bg-white w-64 border-r border-gray-200 flex flex-col">
        <div class="h-16 flex items-center justify-center border-b border-gray-200 font-bold text-xl">
            LOGO
        </div>
        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="{{ route('pegawai.dashboard') }}" class="block px-4 py-2 rounded hover:bg-blue-100 text-blue-600 font-semibold">
                Daftar Transaksi Penitipan
            </a>
            <a href="{{ route('pegawai.dashboard', ['halaman' => 'daftar-penitip']) }}" class="block px-4 py-2 rounded hover:bg-gray-100">
                Daftar Penitip
            </a>
        </nav>
    </aside>

    <!-- Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white shadow h-16 flex items-center px-6 justify-between border-b border-gray-200">
            <div class="text-lg font-semibold text-gray-700">Dashboard Penitip</div>
            <div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-gray-600 hover:text-gray-900">Logout</button>
                </form>
            </div>
        </header>

        <!-- Main Content -->
        <main class="p-6 overflow-auto">
            <h1 class="text-2xl font-bold mb-4">Daftar Penitip</h1>
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-2">
                <button @click="openTambah()" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700 transition">
                    + Tambah Penitip
                </button>
                <input type="text" id="searchInput" placeholder="Cari penitip..." class="px-4 py-2 border rounded w-full md:w-1/3" />
            </div>

            <!-- Modal -->
            <div x-show="openForm" class="fixed inset-0 z-50 flex items-start justify-center pt-20 bg-black bg-opacity-50">
                <div @click.outside="openForm = false" class="bg-white w-full max-w-2xl mx-4 p-6 rounded shadow-lg relative h-[90vh] md:max-h-[80vh] overflow-y-auto">
                    <button @click="openForm = false" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800">✕</button>
                    <h2 class="text-xl font-bold mb-4" x-text="editMode ? 'Edit Penitip' : 'Tambah Penitip'"></h2>

                    <!-- Tambah -->
                    <form x-show="!editMode" action="{{ route('penitip.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-1 font-medium">Nama</label>
                                <input type="text" name="nama_penitip" x-model="formData.nama_penitip" class="w-full border rounded px-3 py-2" required />
                            </div>
                            <div>
                                <label class="block mb-1 font-medium">Email</label>
                                <input type="email" name="email_penitip" x-model="formData.email_penitip" class="w-full border rounded px-3 py-2" required />
                            </div>
                            <div>
                                <label class="block mb-1 font-medium">No Telepon</label>
                                <input type="text" name="no_telp_penitip" x-model="formData.no_telp_penitip" class="w-full border rounded px-3 py-2" required />
                            </div>
                            <div>
                                <label class="block mb-1 font-medium">NIK</label>
                                <input type="text" name="nik_penitip" x-model="formData.nik_penitip" class="w-full border rounded px-3 py-2" required />
                            </div>
                            <div>
                                <label class="block mb-1 font-medium">Poin</label>
                                <input type="number" name="poin_penitip" x-model="formData.poin_penitip" class="w-full border rounded px-3 py-2" required />
                            </div>
                            <div>
                                <label class="block mb-1 font-medium">Saldo</label>
                                <input type="number" name="saldo_penitip" x-model="formData.saldo_penitip" class="w-full border rounded px-3 py-2" required />
                            </div>
                            <div>
                                <label class="block mb-1 font-medium">Badge</label>
                                <input type="text" name="badge_penitip" x-model="formData.badge_penitip" class="w-full border rounded px-3 py-2" required />
                            </div>
                            <div>
                                <label class="block mb-1 font-medium">Rating</label>
                                <input type="number" name="rating_penitip" x-model="formData.rating_penitip" class="w-full border rounded px-3 py-2" required />
                            </div>
                            <div>
                                <label class="block mb-1 font-medium">Total Barang Terjual</label>
                                <input type="number" name="total_barang_terjual" x-model="formData.total_barang_terjual" class="w-full border rounded px-3 py-2" required />
                            </div>
                            <div>
                                <label class="block mb-1 font-medium">Password</label>
                                <input type="password" name="password_penitip" class="w-full border rounded px-3 py-2" required />
                            </div>
                            <div>
                                <label class="block mb-1 font-medium">Foto</label>
                                <input type="file" name="gambar_penitip" class="w-full border rounded px-3 py-2" />
                            </div>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">Simpan</button>
                        </div>
                    </form>

                    <!-- Edit -->
                    <form x-show="editMode" :action="'/penitip/' + formData.id_penitip" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" value="PUT" />
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-1 font-medium">Nama</label>
                                <input type="text" name="nama_penitip" x-model="formData.nama_penitip" class="w-full border rounded px-3 py-2" required />
                            </div>
                            <div>
                                <label class="block mb-1 font-medium">Email</label>
                                <input type="email" name="email_penitip" x-model="formData.email_penitip" class="w-full border rounded px-3 py-2" required />
                            </div>
                            <div>
                                <label class="block mb-1 font-medium">No Telepon</label>
                                <input type="text" name="no_telp_penitip" x-model="formData.no_telp_penitip" class="w-full border rounded px-3 py-2" required />
                            </div>
                            <div>
                                <label class="block mb-1 font-medium">NIK</label>
                                <input type="text" name="nik_penitip" x-model="formData.nik_penitip" class="w-full border rounded px-3 py-2" required />
                            </div>
                            <div>
                                <label class="block mb-1 font-medium">Poin</label>
                                <input type="number" name="poin_penitip" x-model="formData.poin_penitip" class="w-full border rounded px-3 py-2" required />
                            </div>
                            <div>
                                <label class="block mb-1 font-medium">Saldo</label>
                                <input type="number" name="saldo_penitip" x-model="formData.saldo_penitip" class="w-full border rounded px-3 py-2" required />
                            </div>
                            <div>
                                <label class="block mb-1 font-medium">Badge</label>
                                <input type="text" name="badge_penitip" x-model="formData.badge_penitip" class="w-full border rounded px-3 py-2" required />
                            </div>
                            <div>
                                <label class="block mb-1 font-medium">Rating</label>
                                <input type="number" name="rating_penitip" x-model="formData.rating_penitip" class="w-full border rounded px-3 py-2" required />
                            </div>
                            <div>
                                <label class="block mb-1 font-medium">Total Barang Terjual</label>
                                <input type="number" name="total_barang_terjual" x-model="formData.total_barang_terjual" class="w-full border rounded px-3 py-2" required />
                            </div>
                            <div>
                                <label class="block mb-1 font-medium">Foto (opsional)</label>
                                <input type="file" name="gambar_penitip" class="w-full border rounded px-3 py-2" />
                            </div>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">Update</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white shadow-md rounded-lg text-sm">
                    <thead class="bg-blue-100 text-gray-700">
                        <tr>
                            <th class="p-3 text-left">Nama</th>
                            <th class="p-3 text-left">Foto</th>
                            <th class="p-3 text-left">Email</th>
                            <th class="p-3 text-left">No Telp</th>
                            <th class="p-3 text-left">NIK</th>
                            <th class="p-3 text-left">Poin</th>
                            <th class="p-3 text-left">Saldo</th>
                            <th class="p-3 text-left">Badge</th>
                            <th class="p-3 text-left">Rating</th>
                            <th class="p-3 text-left">Barang Terjual</th>
                            <th class="p-3 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penitip as $item)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3">{{ $item->nama_penitip }}</td>
                            <td class="p-3">
                                @if($item->gambar_penitip)
                                <a href="{{ asset($item->gambar_penitip) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Foto</a>
                                @else
                                <span class="text-gray-400 italic">-</span>
                                @endif
                            </td>
                            <td class="p-3">{{ $item->email_penitip }}</td>
                            <td class="p-3">{{ $item->no_telp_penitip }}</td>
                            <td class="p-3">{{ $item->nik_penitip }}</td>
                            <td class="p-3">{{ $item->poin_penitip }}</td>
                            <td class="p-3">Rp{{ number_format($item->saldo_penitip) }}</td>
                            <td class="p-3">{{ $item->badge_penitip }}</td>
                            <td class="p-3">{{ $item->rating_penitip }}</td>
                            <td class="p-3">{{ $item->total_barang_terjual }}</td>
                            <td class="p-3 space-x-2">
                                <button @click='openEdit(@json($item))' class="text-blue-600 hover:underline">Edit</button>
                                <form action="{{ route('penitip.destroy', $item->id_penitip) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Yakin ingin menghapus?')" class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script>
        function penitipForm() {
            return {
                openForm: false,
                editMode: false,
                formData: {
                    nama_penitip: '',
                    email_penitip: '',
                    no_telp_penitip: '',
                    nik_penitip: '',
                    poin_penitip: 0,
                    saldo_penitip: 0,
                    badge_penitip: '',
                    rating_penitip: 0,
                    total_barang_terjual: 0
                },
                openTambah() {
                    this.editMode = false;
                    this.openForm = true;
                    this.formData = {
                        nama_penitip: '',
                        email_penitip: '',
                        no_telp_penitip: '',
                        nik_penitip: '',
                        poin_penitip: 0,
                        saldo_penitip: 0,
                        badge_penitip: '',
                        rating_penitip: 0,
                        total_barang_terjual: 0
                    };
                },
                openEdit(item) {
                    this.editMode = true;
                    this.openForm = true;
                    this.formData = { ...item };
                }
            }
        }

        document.getElementById('searchInput').addEventListener('keyup', function () {
            let keyword = this.value.toLowerCase();
            let rows = document.querySelectorAll('table tbody tr');
            rows.forEach(function (row) {
                let text = row.innerText.toLowerCase();
                row.style.display = text.includes(keyword) ? '' : 'none';
            });
        });
    </script>
</body>
</html>
