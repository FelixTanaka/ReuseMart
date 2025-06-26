<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard Customer Service</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans flex h-screen">

    <!-- Sidebar -->
    <aside class="bg-white w-64 border-r border-gray-200 flex flex-col">
        <div class="h-16 flex items-center justify-center border-b border-gray-200 font-bold text-xl">
            LOGO
        </div>
        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="{{ route('pegawai.dashboard') }}"
            class="block px-4 py-2 rounded hover:bg-blue-100 text-blue-600 font-semibold">
                Daftar Transaksi Penitipan
            </a>

            <a href="{{ route('pegawai.dashboard', ['halaman' => 'daftar-penitip']) }}"
            class="block px-4 py-2 rounded hover:bg-gray-100">
                Daftar Penitip
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-auto">

        <!-- Navbar -->
        <header class="bg-white shadow h-16 flex items-center px-6 justify-between border-b border-gray-200">
            <div class="text-lg font-semibold text-gray-700">Dashboard Customer Service</div>
            <div>
                <button class="text-gray-600 hover:text-gray-900">Logout</button>
            </div>
        </header>

        <!-- Page content -->
        <main class="p-6 flex-1 overflow-y-auto">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Nama Barang</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Nama Penitip</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Tanggal Penitipan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Bonus</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach ($transaksis as $index => $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $item->barang->nama_barang ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $item->barang->penitip->nama_penitip ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $item->barang->tanggal_penitipan }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $item->barang->status_penitipan ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-semibold">
                                    Rp{{ number_format($item->bonus, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <button class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-3 py-1 rounded">Kirim Notifikasi</button>

                                    <form action="{{ route('transaksiPenitipan.selesai', $item->id_transaksi_penitipan) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white text-sm px-3 py-1 rounded">
                                            Selesaikan
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>
    </div>

</body>
</html>
