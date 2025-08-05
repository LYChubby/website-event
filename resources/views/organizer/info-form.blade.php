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
        const accountNumberInput = document.getElementById('bank_account_number');
        const accountNameInput = document.getElementById('bank_account_name');

        // 🔄 Ambil daftar bank saat halaman dimuat
        document.addEventListener('DOMContentLoaded', async () => {
            try {
                const res = await fetch(`{{ route('organizer.info.banks') }}`);
                const banks = await res.json();

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

        // ✨ Autofill nama rekening
        accountNumberInput.addEventListener('blur', async () => {
            const bankCode = bankSelect.value;
            const accountNumber = accountNumberInput.value;

            if (!bankCode || !accountNumber) return;

            try {
                const res = await fetch(`{{ route('organizer.info.verify') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        bank_code: bankCode,
                        account_number: accountNumber, // ✅ Sesuai dengan validator
                    }),
                });

                const result = await res.json();

                if (res.ok && result.account_holder_name) {
                    accountNameInput.value = result.account_holder_name;
                } else {
                    console.warn('Response error:', result);
                }
            } catch (err) {
                console.warn('Gagal verifikasi rekening:', err);
            }
        });

        // 📤 Submit form
        document.getElementById('organizer-info-form').addEventListener('submit', async function(e) {
            e.preventDefault();

            const data = {
                bank_code: bankSelect.value,
                bank_account_number: accountNumberInput.value,
                bank_account_name: accountNameInput.value,
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
                    alertBox.textContent = 'Informasi berhasil disimpan dan telah diverifikasi.';
                    alertBox.className = 'bg-green-100 text-green-800 p-4 rounded mb-4';
                    alertBox.classList.remove('hidden');

                    setTimeout(() => {
                        window.location.href = "{{ route('organizer.dashboard') }}";
                    }, 1500);
                } else {
                    let message = result.message || 'Terjadi kesalahan.';
                    if (result.expected_name) {
                        message += ` Nama yang sesuai: ${result.expected_name}`;
                    }

                    alertBox.textContent = message;
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