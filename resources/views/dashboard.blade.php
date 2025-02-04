<x-layout>
    {{-- Styles --}}
    <style>
        .custom-popup .leaflet-popup-content {
            width: 300px !important;
        }
        .laundry-popup img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 4px;
            margin-bottom: 10px;
        }
        .service-badge {
            display: inline-block;
            padding: 2px 8px;
            margin: 2px;
            background-color: #e3f2fd;
            border-radius: 12px;
            font-size: 0.8em;
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <!-- Statistics Cards -->
            <div class="col-xxl-4 col-md-6">
                <div class="card info-card sales-card">
                    <div class="card-body">
                        <h5 class="card-title">Total Laundry</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-shop"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $laundries ? count($laundries) : 0 }}</h6>
                                <span class="text-muted small pt-2">Registered Laundries</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Map Section -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Laundry Locations</h5>
                        <div id="map" style="height: 500px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Scripts --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize the map
            const map = L.map('map').setView([-0.2359617540096268, 100.61185123165329], 14);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Add markers for each laundry
            const laundries = @json($laundries);
            const bounds = [];

            laundries.forEach(function(laundry) {
                const coord = [laundry.latitude, laundry.longitude];
                bounds.push(coord);

                // Create popup content
                const popupContent = `
                    <div class="laundry-popup">
                        ${laundry.photo ? 
                            `<img src="${laundry.photo}" alt="${laundry.name}">` :
                            `<div class="text-center p-3 bg-light">
                                <i class="bi bi-image" style="font-size: 2rem;"></i>
                                <p class="mb-0">No Photo Available</p>
                            </div>`
                        }
                        <h5 class="mb-2">${laundry.name}</h5>
                        <p class="mb-1"><i class="bi bi-geo-alt"></i> ${laundry.address}</p>
                        <p class="mb-1"><i class="bi bi-telephone"></i> ${laundry.contact}</p>
                        <p class="mb-1"><i class="bi bi-clock"></i> ${laundry.opening_hour} - ${laundry.closing_hour}</p>
                        <div class="mt-2">
                            <p class="mb-1"><strong>Layanan:</strong></p>
                            <div>
                                ${laundry.services.map(service => 
                                    `<span class="service-badge">${service.replace('_', ' ').toUpperCase()}</span>`
                                ).join('')}
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="/laundry/${laundry.id}" class="btn btn-sm btn-primary">
                                <i class="bi bi-info-circle"></i> Detail
                            </a>
                        </div>
                    </div>
                `;

                // Add marker with custom popup
                L.marker(coord)
                    .bindPopup(popupContent, {
                        className: 'custom-popup',
                        maxWidth: 300
                    })
                    .addTo(map);
            });

            // Fit map to show all markers if there are any
            if (bounds.length > 0) {
                map.fitBounds(bounds);
            }
        });
    </script>
</x-layout>
