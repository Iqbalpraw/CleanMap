<x-layout>
    <div class="pagetitle">
        <h1>Data Laundry</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Data Laundry</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Daftar Laundry</h5>
                            <a href="{{ route('laundry.create') }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-plus"></i> Tambah Data
                            </a>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Foto</th>
                                        <th>Nama Laundry</th>
                                        <th>Alamat</th>
                                        <th>Kontak</th>
                                        <th>Jam Operasional</th>
                                        <th>Layanan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($laundries as $index => $laundry)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            @if($laundry->photo)
                                                <img src="{{ asset($laundry->photo) }}" 
                                                     alt="Foto {{ $laundry->name }}"
                                                     class="img-thumbnail photo-preview"
                                                     style="width: 100px; height: 100px; object-fit: cover;"
                                                     onclick="showPhotoModal('{{ asset($laundry->photo) }}', '{{ $laundry->name }}')"
                                                >
                                            @else
                                                <span class="badge bg-secondary">No Photo</span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $laundry->name }}</strong>
                                            <br>
                                            <small class="text-muted">Owner: {{ $laundry->owner_name }}</small>
                                        </td>
                                        <td>{{ $laundry->address }}</td>
                                        <td>
                                            {{ $laundry->contact }}
                                            <br>
                                            <small class="text-muted">Owner: {{ $laundry->owner_contact }}</small>
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($laundry->opening_hour)->format('H:i') }} - 
                                            {{ \Carbon\Carbon::parse($laundry->closing_hour)->format('H:i') }}
                                        </td>
                                        <td>
                                            @foreach($laundry->services as $service)
                                                <span class="badge bg-info">
                                                    {{ str_replace('_', ' ', ucfirst($service)) }}
                                                </span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('laundry.show', $laundry->id) }}" 
                                                   class="btn btn-sm btn-info">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('laundry.edit', $laundry->id) }}" 
                                                   class="btn btn-sm btn-warning">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('laundry.destroy', $laundry->id) }}" 
                                                      method="POST" 
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal untuk preview foto -->
    <div class="modal fade" id="photoModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Preview Foto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="" id="modalPhoto" class="img-fluid" style="max-height: 80vh;">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk lokasi -->
    <div class="modal fade" id="locationModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Lokasi Laundry</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        let map;
        let marker;

        // Fungsi untuk menampilkan modal foto
        function showPhotoModal(photoUrl, laundryName) {
            const photoModal = new bootstrap.Modal(document.getElementById('photoModal'));
            document.getElementById('modalPhoto').src = photoUrl;
            document.querySelector('#photoModal .modal-title').textContent = 'Foto ' + laundryName;
            photoModal.show();
        }

        // Fungsi untuk menampilkan modal lokasi
        function showLocationModal(lat, lng, name) {
            const locationModal = new bootstrap.Modal(document.getElementById('locationModal'));
            locationModal.show();
            
            // Tunggu sebentar agar modal selesai ditampilkan sebelum menginisialisasi peta
            setTimeout(() => {
                if (!map) {
                    map = L.map('map');
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap contributors'
                    }).addTo(map);
                }

                // Reset view dan marker
                map.setView([lat, lng], 15);
                
                if (marker) {
                    map.removeLayer(marker);
                }
                
                marker = L.marker([lat, lng]).addTo(map)
                    .bindPopup(name)
                    .openPopup();

                // Trigger resize event agar peta ter-render dengan benar
                map.invalidateSize();
            }, 300);
        }

        // Event listener untuk modal lokasi
        document.getElementById('locationModal').addEventListener('shown.bs.modal', function () {
            if (map) {
                map.invalidateSize();
            }
        });

        // Event listener untuk membersihkan peta saat modal ditutup
        document.getElementById('locationModal').addEventListener('hidden.bs.modal', function () {
            if (marker) {
                map.removeLayer(marker);
                marker = null;
            }
        });
    </script>
    @endpush
</x-layout>