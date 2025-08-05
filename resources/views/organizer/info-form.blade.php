<x-app-layout>
    <div class="max-w-xl mx-auto py-10">
        <h2 class="text-2xl font-bold mb-6">Informasi Rekening untuk Pencairan Dana</h2>

        <div id="form-alert" class="hidden mb-4 p-4 rounded"></div>

        <form id="organizer-info-form">
            @csrf

            {{-- Dropdown Bank --}}
            <div class="mb-4">
                <label for="bank_code" class="block font-semibold mb-1">Pilih Bank</label>
                <select name="bank_code" id="bank_code"
                    class="w-full border border-gray-300 rounded px-3 py-2" required>
                    <option value="">-- Pilih Bank --</option>
                    {{-- Diisi via JavaScript --}}
                </select>
            </div>

            {{-- Nomor Rekening --}}
            <div class="mb-4">
                <label for="bank_account_number" class="block font-semibold mb-1">Nomor Rekening</label>
                <input type="text" name="bank_account_number" id="bank_account_number"
                    class="w-full border border-gray-300 rounded px-3 py-2"
                    placeholder="1234567890" required>
            </div>

            {{-- Nama Pemilik Rekening --}}
            <div class="mb-4">
                <label for="bank_account_name" class="block font-semibold mb-1">Nama Pemilik Rekening</label>
                <input type="text" name="bank_account_name" id="bank_account_name"
                    class="w-full border border-gray-300 rounded px-3 py-2"
                    placeholder="Sesuai buku tabungan" required>
            </div>

            <button type="submit"
                class="bg-indigo-600 text-white font-semibold px-6 py-2 rounded hover:bg-indigo-700">
                Simpan Informasi
            </button>
        </form>
    </div>

    <script>
        const alertBox = document.getElementById('form-alert');
        const bankSelect = document.getElementById('bank_code');

        // 🔄 Ambil daftar bank saat halaman dimuat
        document.addEventListener('DOMContentLoaded', async () => {
            try {
                const res = await fetch(`{{ route('organizer.info.banks') }}`);
                // const banks = await res.json();

                const banks = [{
                        code: 'BCA',
                        name: 'Bank Central Asia'
                    },
                    {
                        code: 'BNI',
                        name: 'Bank Negara Indonesia'
                    },
                    {
                        code: 'BRI',
                        name: 'Bank Rakyat Indonesia'
                    },
                ];

                banks.forEach(bank => {
                    const option = document.createElement('option');
                    option.value = bank.code;
                    option.textContent = `${bank.name} (${bank.code})`;
                    bankSelect.appendChild(option);
                });
            } catch (err) {
                console.error('Gagal memuat bank:', err);
            }
        });

        // 📤 Submit form
        document.getElementById('organizer-info-form').addEventListener('submit', async function(e) {
            e.preventDefault();

            const data = {
                bank_code: document.getElementById('bank_code').value,
                bank_account_number: document.getElementById('bank_account_number').value,
                bank_account_name: document.getElementById('bank_account_name').value,
            };

            alertBox.classList.add('hidden');

            try {
                const response = await fetch("{{ route('organizer.info.store') }}", {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (response.ok) {
                    alertBox.textContent = 'Informasi berhasil disimpan.';
                    alertBox.className = 'bg-green-100 text-green-800 p-4 rounded mb-4';
                    alertBox.classList.remove('hidden');

                    setTimeout(() => {
                        window.location.href = "{{ route('organizer.dashboard') }}";
                    }, 1500);
                } else {
                    alertBox.textContent = result.message || 'Terjadi kesalahan.';
                    alertBox.className = 'bg-red-100 text-red-800 p-4 rounded mb-4';
                    alertBox.classList.remove('hidden');
                }
            } catch (err) {
                alertBox.textContent = 'Gagal menghubungi server.';
                alertBox.className = 'bg-red-100 text-red-800 p-4 rounded mb-4';
                alertBox.classList.remove('hidden');
            }
        });
    </script>
</x-app-layout>