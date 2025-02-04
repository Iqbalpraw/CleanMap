<x-layout>
    <div class="pagetitle">
        <h1>Galeri Foto - {{ $laundry->name }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('laundry.index') }}">Data Laundry</a></li>
                <li class="breadcrumb-item"><a href="{{ route('laundry.show', $laundry) }}">{{ $laundry->name }}</a></li>
                <li class="breadcrumb-item active">Galeri Foto</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="card-title mb-0">Galeri Foto</h5>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPhotoModal">
                                <i class="bi bi-plus"></i> Tambah Foto
                            </button>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="row g-4">
                            @forelse($photos as $photo)
                            <div class="col-md-4">
                                <div class="card">
                                    <img src="{{ asset($photo->photo) }}" 
                                         class="card-img-top" 
                                         alt="Gallery Photo"
                                         style="height: 200px; object-fit: cover; cursor: pointer;"
                                         onclick="showPhotoModal('{{ asset($photo->photo) }}', '{{ $photo->caption }}')"
                                    >
                                    <div class="card-body">
                                        <p class="card-text">{{ $photo->caption ?? 'No caption' }}</p>
                                        <div class="d-flex gap-2">
                                            <button type="button" 
                                                    class="btn btn-sm btn-warning"
                                                    onclick="editCaption('{{ $photo->id }}', '{{ $photo->caption }}')"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editCaptionModal">
                                                <i class="bi bi-pencil"></i> Edit Caption
                                            </button>
                                            <form action="{{ route('gallery.destroy', $photo) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-danger" 
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus foto ini?')">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12">
                                <div class="alert alert-info mb-0">
                                    Belum ada foto di galeri. Silakan tambahkan foto baru!
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Tambah Foto -->
    <div class="modal fade" id="addPhotoModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('gallery.store', $laundry) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Foto Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="photo" class="form-label">Pilih Foto</label>
                            <input type="file" class="form-control" id="photo" name="photo" accept="image/*" required>
                        </div>
                        <div class="mb-3">
                            <label for="caption" class="form-label">Caption</label>
                            <input type="text" class="form-control" id="caption" name="caption" placeholder="Tambahkan caption foto">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Caption -->
    <div class="modal fade" id="editCaptionModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editCaptionForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Caption</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_caption" class="form-label">Caption</label>
                            <input type="text" class="form-control" id="edit_caption" name="caption" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Preview Foto -->
    <div class="modal fade" id="photoPreviewModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Preview Foto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="" id="previewImage" class="img-fluid" style="max-height: 80vh;">
                    <p id="previewCaption" class="mt-2"></p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function showPhotoModal(photoUrl, caption) {
            const modal = new bootstrap.Modal(document.getElementById('photoPreviewModal'));
            document.getElementById('previewImage').src = photoUrl;
            document.getElementById('previewCaption').textContent = caption || 'No caption';
            modal.show();
        }

        function editCaption(photoId, caption) {
            const form = document.getElementById('editCaptionForm');
            form.action = `/gallery/${photoId}`;
            document.getElementById('edit_caption').value = caption || '';
        }
    </script>
    @endpush
</x-layout>