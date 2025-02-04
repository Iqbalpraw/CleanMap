<x-layout>
    <div class="pagetitle">
        <h1>Edit Laundry - {{ $laundry->name }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('laundry.index') }}">Data Laundry</a></li>
                <li class="breadcrumb-item active">Edit Laundry</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <!-- Left Column - Map -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Lokasi Laundry</h5>
                        <div id="map" style="height: 400px;"></div>
                        <div class="mt-3">
                            <div class="alert alert-info">
                                <small>Klik pada peta untuk memilih lokasi atau isi koordinat secara manual</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Form -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Form Edit Laundry</h5>

                        <form action="{{ route('laundry.update', $laundry->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">Nama Laundry</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name', $laundry->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Alamat</label>
                                    <textarea name="address" class="form-control @error('address') is-invalid @enderror" 
                                              rows="3" required>{{ old('address', $laundry->address) }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Kontak Laundry</label>
                                    <input type="text" name="contact" class="form-control @error('contact') is-invalid @enderror" 
                                           value="{{ old('contact', $laundry->contact) }}" required>
                                    @error('contact')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Jam Operasional</label>
                                    <div class="input-group">
                                        <input type="time" name="opening_hour" 
                                               class="form-control @error('opening_hour') is-invalid @enderror" 
                                               value="{{ old('opening_hour', $laundry->opening_hour->format('H:i')) }}" required>
                                        <span class="input-group-text">-</span>
                                        <input type="time" name="closing_hour" 
                                               class="form-control @error('closing_hour') is-invalid @enderror" 
                                               value="{{ old('closing_hour', $laundry->closing_hour->format('H:i')) }}" required>
                                    </div>
                                    @error('opening_hour')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @error('closing_hour')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Layanan</label>
                                    <div class="row g-2">
                                        @php
                                            $availableServices = ['cuci_basah', 'cuci_kering', 'setrika', 'cuci_setrika', 'karpet', 'sepatu'];
                                        @endphp
                                        @foreach($availableServices as $service)
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="services[]" 
                                                           value="{{ $service }}" id="{{ $service }}"
                                                           {{ in_array($service, old('services', $laundry->services)) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="{{ $service }}">
                                                        {{ str_replace('_', ' ', ucfirst($service)) }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('services')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Nama Pemilik</label>
                                    <input type="text" name="owner_name" class="form-control @error('owner_name') is-invalid @enderror" 
                                           value="{{ old('owner_name', $laundry->owner_name) }}" required>
                                    @error('owner_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Kontak Pemilik</label>
                                    <input type="text" name="owner_contact" class="form-control @error('owner_contact') is-invalid @enderror" 
                                           value="{{ old('owner_contact', $laundry->owner_contact) }}" required>
                                    @error('owner_contact')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                              rows="3">{{ old('description', $laundry->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Latitude</label>
                                    <input type="text" name="latitude" id="latitude" 
                                           class="form-control @error('latitude') is-invalid @enderror"
                                           value="{{ old('latitude', $laundry->latitude) }}" required>
                                    @error('latitude')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Longitude</label>
                                    <input type="text" name="longitude" id="longitude" 
                                           class="form-control @error('longitude') is-invalid @enderror"
                                           value="{{ old('longitude', $laundry->longitude) }}" required>
                                    @error('longitude')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Location</label>
                                    <input type="text" name="location" id="location" 
                                           class="form-control @error('location') is-invalid @enderror"
                                           value="{{ old('location', $laundry->location) }}" required>
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Foto Laundry</label>
                                    @if($laundry->photo)
                                        <div class="mb-2">
                                            <img src="{{ asset($laundry->photo) }}" alt="Current Photo" class="img-thumbnail" style="height: 100px;">
                                        </div>
                                    @endif
                                    <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror">
                                    <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto</small>
                                    @error('photo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    <a href="{{ route('laundry.index') }}" class="btn btn-secondary">Batal</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const latitude = {{ $laundry->latitude }};
            const longitude = {{ $laundry->longitude }};
            
            const map = L.map('map').setView([latitude, longitude], 15);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 19
            }).addTo(map);

            let marker = L.marker([latitude, longitude], {
                draggable: true
            }).addTo(map);

            // Function to update location based on coordinates
            function updateLocation(lat, lng) {
                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                    .then(response => response.json())
                    .then(data => {
                        const address = data.address;
                        const location = [
                            address.village || address.suburb || address.town || address.city || '',
                            address.district || '',
                            address.city || address.town || '',
                            address.state || ''
                        ].filter(Boolean).join(', ');
                        document.getElementById('location').value = location;
                    })
                    .catch(error => console.error('Error:', error));
            }

            // Update location when marker is dragged
            marker.on('dragend', function(event) {
                const position = event.target.getLatLng();
                document.getElementById('latitude').value = position.lat;
                document.getElementById('longitude').value = position.lng;
                updateLocation(position.lat, position.lng);
            });

            // Allow clicking on map to move marker and update location
            map.on('click', function(event) {
                const position = event.latlng;
                marker.setLatLng(position);
                document.getElementById('latitude').value = position.lat;
                document.getElementById('longitude').value = position.lng;
                updateLocation(position.lat, position.lng);
            });

            // Resize map when card is fully visible
            setTimeout(() => {
                map.invalidateSize();
            }, 100);

            // Initial location update
            updateLocation(latitude, longitude);
        });
    </script>
</x-layout>