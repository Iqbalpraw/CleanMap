<x-layout>
    <div class="pagetitle">
        <h1>Tambah Laundry</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('laundry.index') }}">Data Laundry</a></li>
                <li class="breadcrumb-item active">Tambah Data</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Form Input Data Laundry</h5>

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form class="row g-3" method="POST" action="{{ route('laundry.store') }}" enctype="multipart/form-data">
                            @csrf
                            
                            <!-- Informasi Usaha -->
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nama Laundry</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                    id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="contact" class="form-label">Kontak Laundry</label>
                                <input type="text" class="form-control @error('contact') is-invalid @enderror" 
                                    id="contact" name="contact" value="{{ old('contact') }}" required>
                                @error('contact')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="address" class="form-label">Alamat</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" 
                                    id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Jenis Layanan -->
                            <div class="col-12">
                                <label class="form-label">Jenis Layanan Tersedia</label>
                                <div class="row">
                                    @php
                                        $services = [
                                            'cuci_reguler' => 'Cuci Reguler',
                                            'cuci_express' => 'Cuci Express',
                                            'setrika' => 'Setrika',
                                            'dry_clean' => 'Dry Clean',
                                            'cuci_karpet' => 'Cuci Karpet',
                                            'cuci_sepatu' => 'Cuci Sepatu'
                                        ];
                                    @endphp
                                    @foreach($services as $value => $label)
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" 
                                                name="services[]" value="{{ $value }}" id="{{ $value }}"
                                                {{ in_array($value, old('services', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="{{ $value }}">
                                                {{ $label }}
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @error('services')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Jam Operasional -->
                            <div class="col-md-6">
                                <label for="opening_hour" class="form-label">Jam Buka</label>
                                <input type="time" class="form-control @error('opening_hour') is-invalid @enderror" 
                                    id="opening_hour" name="opening_hour" value="{{ old('opening_hour') }}" required>
                                @error('opening_hour')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="closing_hour" class="form-label">Jam Tutup</label>
                                <input type="time" class="form-control @error('closing_hour') is-invalid @enderror" 
                                    id="closing_hour" name="closing_hour" value="{{ old('closing_hour') }}" required>
                                @error('closing_hour')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Informasi Pemilik -->
                            <div class="col-md-6">
                                <label for="owner_name" class="form-label">Nama Pemilik</label>
                                <input type="text" class="form-control @error('owner_name') is-invalid @enderror" 
                                    id="owner_name" name="owner_name" value="{{ old('owner_name') }}" required>
                                @error('owner_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="owner_contact" class="form-label">Kontak Pemilik</label>
                                <input type="text" class="form-control @error('owner_contact') is-invalid @enderror" 
                                    id="owner_contact" name="owner_contact" value="{{ old('owner_contact') }}" required>
                                @error('owner_contact')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Lokasi dan Foto -->
                            <div class="col-12">
                                <label class="form-label">Lokasi Laundry</label>
                                <div id="map"></div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control @error('latitude') is-invalid @enderror" 
                                            id="latitude" name="latitude" value="{{ old('latitude') }}" 
                                            placeholder="Latitude" readonly required>
                                        @error('latitude')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control @error('longitude') is-invalid @enderror" 
                                            id="longitude" name="longitude" value="{{ old('longitude') }}" 
                                            placeholder="Longitude" readonly required>
                                        @error('longitude')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="mt-2">
                                    <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                        id="location" name="location" value="{{ old('location') }}" 
                                        placeholder="Alamat lengkap" required>
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="photo" class="form-label">Foto Laundry</label>
                                <input type="file" class="form-control @error('photo') is-invalid @enderror" 
                                    id="photo" name="photo" accept="image/*">
                                @error('photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="description" class="form-label">Deskripsi</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                    id="description" name="description" rows="4">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('laundry.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi peta dengan koordinat default (misalnya pusat Indonesia)
            var map = L.map('map').setView([-0.2359617540096268, 100.61185123165329], 13);
            
            // Tambahkan tile layer (OpenStreetMap)
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);
            
            var marker;
            
            // Event handler untuk klik pada peta
            map.on('click', function(e) {
                var lat = e.latlng.lat;
                var lng = e.latlng.lng;
                
                // Hapus marker sebelumnya jika ada
                if (marker) {
                    map.removeLayer(marker);
                }
                
                // Tambahkan marker baru
                marker = L.marker([lat, lng]).addTo(map);
                
                // Update nilai input
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;
                
                // Reverse geocoding menggunakan Nominatim
                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('location').value = data.display_name;
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    </script>
</x-layout>