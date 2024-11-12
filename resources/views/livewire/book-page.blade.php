<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-light">{{ __('BUKU') }}</div>

                    <div class="card-body">
                        <a href="{{ route('book-page') }}" class="btn btn-primary">Buku</a>
                        <a href="{{ route('member-page') }}" class="btn btn-warning">Member</a>
                        <a href="{{ route('borrow-page') }}" class="btn btn-success">Pinjam</a>
                        <hr>
                        <button type="button" class="btn btn-primary" wire:click="showForm">
                            {{ $closeForm ? __('Buka Form') : __('Tutup Form') }}
                        </button>
                        <i wire:loading>Loading...</i>
                        <br>
                        @if ($closeForm == false)
                            <form wire:submit.prevent="{{ $formMenu === 'editBook' ? 'updateBook' : 'addBook' }}"
                                class="mt-2">
                                <div class="form-group mb-2">
                                    <label for="title">Judul</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        id="title" wire:model="title" placeholder="Judul Buku">
                                    @error('title')
                                        <small class="text-danger text-sm">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group mb-2">
                                    <label for="writer">Penulis</label>
                                    <input type="text" class="form-control @error('writer') is-invalid @enderror"
                                        id="writer" wire:model="writer" placeholder="Penulis Buku">
                                    @error('writer')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group mb-2">
                                    <label for="publisher">Penerbit</label>
                                    <input type="text" class="form-control @error('publisher') is-invalid @enderror"
                                        id="publisher" wire:model="publisher" placeholder="Penerbit Buku">
                                    @error('publisher')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group mb-2">
                                    <label for="year">Tahun Terbit</label>
                                    <input type="number" inputmode="numeric"
                                        class="form-control @error('year') is-invalid @enderror" id="year"
                                        wire:model="year" placeholder="Tahun Terbit">
                                    @error('year')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group mb-2">
                                    <label for="amount">Jumlah Buku</label>
                                    <input type="number" inputmode="numeric"
                                        class="form-control @error('amount') is-invalid @enderror" id="amount"
                                        wire:model="amount" placeholder="Jumlah Buku">
                                    @error('amount')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <button type="submit"
                                    class="btn btn-primary">{{ $formMenu === 'editBook' ? __('Update Buku') : __('Tambah Buku') }}</button>
                            </form>
                        @endif
                        <hr>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Judul</th>
                                    <th>Penulis</th>
                                    <th>Penerbit</th>
                                    <th>Tahun Terbit</th>
                                    <th>Jumlah</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($books as $book)
                                    <tr>
                                        <td>{{ $loop->iteration }}.</td>
                                        <td>{{ $book->title }}</td>
                                        <td>{{ $book->writer }}</td>
                                        <td>{{ $book->publisher }}</td>
                                        <td>{{ $book->year }}</td>
                                        <td>{{ $book->amount }}</td>
                                        <td>
                                            <button wire:click="editBook({{ $book->id }})" type="button"
                                                class="btn btn-sm btn-warning">Edit</button>
                                            <button wire:click="deleteBook({{ $book->id }})" type="button"
                                                wire:confirm="Apakah anda ingin menghapus buku {{ $book->title }} ini?"
                                                class="btn btn-sm btn-danger">Delete</button>
                                        </td>
                                    </tr>
                                @empty
                                    <p class="text-center">Data Buku Belum Ada.</p>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
