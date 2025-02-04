<x-layout>
    <div class="pagetitle">
        <h1>Detail Laundry - {{ $laundry->name }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('laundry.index') }}">Data Laundry</a></li>
                <li class="breadcrumb-item active">Detail Laundry</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <!-- Kolom Kiri - Foto dan Peta -->
            <div class="col-lg-5">
                <!-- Card Foto Utama -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Foto Laundry</h5>
                        <div class="main-photo mb-3">
                            @if($laundry->photo)
                                <img src="{{ asset($laundry->photo) }}" 
                                     alt="{{ $laundry->name }}" 
                                     class="img-fluid rounded">
                            @else
                                <div class="text-center p-4 bg-light rounded">
                                    <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                    <p class="mt-2">No Photo Available</p>
                                </div>
                            @endif
                        </div>

                        <!-- Ganti bagian additional photos di show.blade.php dengan ini -->
                        <div class="additional-photos mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6>Galeri Foto</h6>
                                <a href="{{ route('gallery.index', $laundry) }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-images"></i> Lihat Semua Foto
                                </a>
                            </div>
                            <div class="row g-2">
                                @foreach($laundry->gallery()->latest()->take(3)->get() as $photo)
                                <div class="col-4">
                                    <img src="{{ asset($photo->photo) }}" 
                                        alt="Gallery Photo" 
                                        class="img-thumbnail"
                                        style="width: 100%; height: 100px; object-fit: cover;">
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Peta -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Lokasi Laundry</h5>
                        <div id="map" style="height: 300px;"></div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan - Informasi Detail -->
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Informasi Laundry</h5>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="fw-bold">Nama Laundry</label>
                                <p>{{ $laundry->name }}</p>
                            </div>

                            <div class="col-md-6">
                                <label class="fw-bold">Kontak Laundry</label>
                                <p>{{ $laundry->contact }}</p>
                            </div>

                            <div class="col-12">
                                <label class="fw-bold">Alamat</label>
                                <p>{{ $laundry->address }}</p>
                            </div>

                            <div class="col-md-6">
                                <label class="fw-bold">Jam Operasional</label>
                                <p>{{ \Carbon\Carbon::parse($laundry->opening_hour)->format('H:i') }} - 
                                   {{ \Carbon\Carbon::parse($laundry->closing_hour)->format('H:i') }}</p>
                            </div>

                            <div class="col-12">
                                <label class="fw-bold">Layanan Tersedia</label>
                                <div>
                                    @foreach($laundry->services as $service)
                                        <span class="badge bg-info me-1">
                                            {{ str_replace('_', ' ', ucfirst($service)) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="fw-bold">Nama Pemilik</label>
                                <p>{{ $laundry->owner_name }}</p>
                            </div>

                            <div class="col-md-6">
                                <label class="fw-bold">Kontak Pemilik</label>
                                <p>{{ $laundry->owner_contact }}</p>
                            </div>

                            <div class="col-12">
                                <label class="fw-bold">Deskripsi</label>
                                <p>{{ $laundry->description ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('laundry.edit', $laundry->id) }}" class="btn btn-warning me-2">
                                <i class="bi bi-pencil"></i> Edit Data
                            </a>
                            <form action="{{ route('laundry.destroy', $laundry->id) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-trash"></i> Hapus Data
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded',function() {
            // Get coordinates from laundry data
            const latitude = {{ $laundry->latitude }};
            const longitude = {{ $laundry->longitude }};
            
            // Initialize map
            const map = L.map('map').setView([latitude, longitude], 15);
            

            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 19
            }).addTo(map);

            // Add marker with popup
            L.marker([latitude, longitude])
                .addTo(map)
                .bindPopup(`
                    <strong>${{$laundry->name}}</strong><br>
                    {{$laundry->address}}<br>
                    <small>Lat: ${latitude}, Long: ${longitude}</small>
                `)
                .openPopup();

            // Trigger a map resize after initialization to ensure proper display
            setTimeout(() => {
                map.invalidateSize();
            }, 100);
        });    
    </script>
</x-layout>