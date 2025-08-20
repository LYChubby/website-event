<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Check-in Scanner</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.8/minified/html5-qrcode.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <header class="text-center mb-8">
            <h1 class="text-3xl font-bold text-blue-700 mb-2">Event Check-in System</h1>
            <p class="text-gray-600">Scan participant QR codes for event check-in</p>
        </header>

        <button onclick="window.location.href='/dashboard/organizer'"
            class="w-12 h-12 bg-black bg-opacity-20 rounded-xl flex items-center justify-center hover:bg-opacity-30 transition">
            <i class="fas fa-arrow-left text-white"></i>
        </button>

        <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Scanner Section -->
            <div class="md:flex">
                <div class="md:w-1/2 p-6">
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">QR Code Scanner</h2>
                        <div id="reader" class="w-full h-64 border-2 border-dashed border-blue-300 rounded-lg flex items-center justify-center bg-gray-50">
                            <div class="text-center text-gray-500">
                                <i class="fas fa-camera text-4xl mb-2"></i>
                                <p>Camera permission required</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex space-x-4 mb-6">
                        <button id="startScanner" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded flex items-center">
                            <i class="fas fa-play mr-2"></i> Start Scanner
                        </button>
                        <button id="stopScanner" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded flex items-center" disabled>
                            <i class="fas fa-stop mr-2"></i> Stop Scanner
                        </button>
                    </div>

                    <div class="text-sm text-gray-600">
                        <p class="mb-2"><i class="fas fa-info-circle mr-2"></i>Point the camera at a participant's QR code</p>
                        <p><i class="fas fa-lightbulb mr-2"></i>Ensure good lighting for better scanning</p>
                    </div>
                </div>

                <!-- Results Section -->
                <div class="md:w-1/2 bg-gray-50 p-6 border-l border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Check-in Status</h2>

                    <div id="statusMessage" class="hidden p-4 rounded-lg mb-6 text-center">
                        <i class="fas fa-check-circle text-4xl mb-2"></i>
                        <h3 class="text-xl font-semibold"></h3>
                        <p class="text-gray-700"></p>
                    </div>

                    <div id="transactionDetails" class="hidden bg-white p-4 rounded-lg shadow mb-6">
                        <h3 class="font-semibold text-lg border-b pb-2 mb-2">Transaction Information</h3>
                        <div class="grid grid-cols-2 gap-2">
                            <p class="text-gray-600">Invoice Number:</p>
                            <p id="invoiceNumber" class="font-medium"></p>

                            <p class="text-gray-600">Status:</p>
                            <p id="checkinStatus"></p>

                            <p class="text-gray-600">Checked in at:</p>
                            <p id="checkedInTime"></p>
                        </div>

                        <h4 class="font-semibold mt-4 mb-2">Detail Tiket:</h4>
                        <ul id="ticketList" class="text-sm text-gray-700 list-disc list-inside"></ul>
                    </div>

                    <div id="manualEntry" class="mt-8">
                        <h3 class="font-semibold text-lg mb-3">Manual Entry</h3>
                        <div class="flex">
                            <input type="text" id="manualInvoice" placeholder="Enter invoice number" class="flex-grow px-4 py-2 border rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <button id="manualCheckin" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-r-lg">
                                Check In
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Check-ins -->
        <div class="max-w-4xl mx-auto mt-8 bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Recent Check-ins</h2>
            <div id="recentCheckins" class="space-y-3">
                <div class="text-center text-gray-500 py-4">
                    <i class="fas fa-history text-3xl mb-2"></i>
                    <p>No recent check-ins</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startButton = document.getElementById('startScanner');
            const stopButton = document.getElementById('stopScanner');
            const statusMessage = document.getElementById('statusMessage');
            const transactionDetails = document.getElementById('transactionDetails');
            const manualCheckin = document.getElementById('manualCheckin');
            const recentCheckins = document.getElementById('recentCheckins');

            let html5QrcodeScanner;
            let isScanning = false;

            function initScanner() {
                html5QrcodeScanner = new Html5QrcodeScanner("reader", {
                    fps: 10,
                    qrbox: {
                        width: 250,
                        height: 250
                    },
                    supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_QR_CODE]
                }, false);
            }

            startButton.addEventListener('click', function() {
                if (isScanning) return;

                Html5Qrcode.getCameras().then(cameras => {
                    if (cameras && cameras.length) {
                        initScanner();
                        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
                        isScanning = true;
                        startButton.disabled = true;
                        stopButton.disabled = false;
                    } else {
                        showStatus('error', 'No camera found', 'Please ensure your device has a camera and permission.');
                    }
                }).catch(() => {
                    showStatus('error', 'Camera Error', 'Could not access camera. Please check permissions.');
                });
            });

            stopButton.addEventListener('click', function() {
                if (!isScanning) return;

                html5QrcodeScanner.clear().then(() => {
                    isScanning = false;
                    startButton.disabled = false;
                    stopButton.disabled = true;
                    document.querySelector('#reader').innerHTML =
                        '<div class="text-center text-gray-500"><i class="fas fa-camera text-4xl mb-2"></i><p>Camera permission required</p></div>';
                    initScanner();
                });
            });

            manualCheckin.addEventListener('click', function() {
                const invoiceNumber = document.getElementById('manualInvoice').value.trim();
                if (invoiceNumber) {
                    processCheckin(invoiceNumber);
                }
            });

            function onScanSuccess(decodedText) {
                html5QrcodeScanner.pause();
                processCheckin(decodedText);
                setTimeout(() => {
                    if (isScanning) html5QrcodeScanner.resume();
                }, 2000);
            }

            function onScanFailure(error) {
                // silent ignore
            }

            // === INI BAGIAN PENTING ===
            async function processCheckin(invoiceNumber) {
                showStatus('loading', 'Processing...', 'Checking in participants...');

                try {
                    const response = await fetch(`/organizer/checkin/${invoiceNumber}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });

                    const data = await response.json();

                    if (response.ok) {
                        showStatus('success', data.message, 'Check-in berhasil');

                        document.getElementById('invoiceNumber').textContent = invoiceNumber;

                        // Status check-in
                        document.getElementById('checkinStatus').innerHTML =
                            '<span class="text-green-600 font-semibold">Checked In</span>';

                        // Tampilkan waktu check-in (pakai dari response)
                        document.getElementById('checkedInTime').textContent = data.checked_in_at ?? '-';

                        // Tambahkan list jenis tiket
                        let ticketListHtml = '';
                        data.participants.forEach(p => {
                            ticketListHtml += `<li>${p.jumlah}x ${p.jenis_ticket}</li>`;
                        });
                        document.getElementById('ticketList').innerHTML = ticketListHtml;

                        transactionDetails.classList.remove('hidden');

                        // Recent checkin (hanya invoice + waktu)
                        addRecentCheckin(invoiceNumber, data.checked_in_at);
                    } else {
                        showStatus('error', data.error || 'Failed', 'Transaction not found or already checked in');
                        transactionDetails.classList.add('hidden');
                    }

                    document.getElementById('manualInvoice').value = '';
                } catch (err) {
                    showStatus('error', 'Server Error', err.message);
                    transactionDetails.classList.add('hidden');
                }
            }

            function showStatus(type, title, message) {
                statusMessage.classList.remove('hidden');
                statusMessage.classList.remove('bg-green-100', 'text-green-700', 'bg-red-100', 'text-red-700', 'bg-yellow-100', 'text-yellow-700', 'bg-blue-100', 'text-blue-700');

                const icon = statusMessage.querySelector('i');
                const titleEl = statusMessage.querySelector('h3');
                const messageEl = statusMessage.querySelector('p');

                titleEl.textContent = title;
                messageEl.textContent = message;

                if (type === 'success') {
                    statusMessage.classList.add('bg-green-100', 'text-green-700');
                    icon.className = 'fas fa-check-circle text-4xl mb-2';
                } else if (type === 'error') {
                    statusMessage.classList.add('bg-red-100', 'text-red-700');
                    icon.className = 'fas fa-times-circle text-4xl mb-2';
                } else if (type === 'warning') {
                    statusMessage.classList.add('bg-yellow-100', 'text-yellow-700');
                    icon.className = 'fas fa-exclamation-triangle text-4xl mb-2';
                } else {
                    statusMessage.classList.add('bg-blue-100', 'text-blue-700');
                    icon.className = 'fas fa-spinner fa-spin text-4xl mb-2';
                }
            }

            function addRecentCheckin(invoice, time) {
                if (recentCheckins.querySelector('.text-center')) {
                    recentCheckins.innerHTML = '';
                }

                const checkinEl = document.createElement('div');
                checkinEl.className = 'flex justify-between items-center p-3 bg-gray-50 rounded-lg';
                checkinEl.innerHTML = `
        <div>
            <div class="font-medium">${invoice}</div>
        </div>
        <div class="text-right">
            <div class="text-sm font-medium text-green-600">Checked In</div>
            <div class="text-xs text-gray-500">${time}</div>
        </div>
    `;

                recentCheckins.prepend(checkinEl);
                if (recentCheckins.children.length > 5) {
                    recentCheckins.removeChild(recentCheckins.lastChild);
                }
            }

            initScanner();
        });
    </script>

</body>

</html>