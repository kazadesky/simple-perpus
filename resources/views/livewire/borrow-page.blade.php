<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-light">{{ __('PINJAMAN BUKU') }}</div>

                    <div class="card-body">
                        <a href="{{ route('book-page') }}" class="btn btn-primary">Buku</a>
                        <a href ="{{ route('member-page') }}" class="btn btn-warning">Member</a>
                        <a href="{{ route('borrow-page') }}" class="btn btn-success">Pinjam</a>
                        <hr>
                        <button type="button" class="btn btn-primary" wire:click="showForm">
                            {{ $closeForm ? __('Buka Form') : __('Tutup Form') }}
                        </button>
                        <i wire:loading>Loading...</i>
                        <br>
                        @if (!$closeForm)
                            <div class="form-group d-flex align-items-center mt-2">
                                <input type="search" class="form-control" wire:model="search"
                                    placeholder="Masukkan NISN">
                                <button wire:click="searchNisn" type="button" class="btn btn-primary ms-1"
                                    style="white-space: nowrap;">Cari NISN</button>
                            </div>
                            @if ($memberId)
                                <form
                                    wire:submit.prevent="{{ $formMenu === 'editBorrow' ? 'updateBorrow' : 'addBorrow' }}">
                                    <input type="hidden" class="form-control" wire:model="memberId"
                                        value="{{ $memberId }}">
                                    <div class="form-group mt-3">
                                        <label for="name" class="mb-1">Nama Member</label>
                                        <input type="text" class="form-control" value="{{ $memberName }}" readonly>
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="bookId" class="mb-1">Daftar Buku</label>
                                        <select wire:model="bookId" id="bookId" class="form-select" size="-1">
                                            <option value="">--pilih buku--</option>
                                            @foreach ($books as $book)
                                                <option value="{{ $book->id }}">{{ $book->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mt-2 {{ $formMenu === 'editBorrow' ? '' : 'd-none' }}">
                                        <label for="loanDate" class="mb-1">Tanggal Pinjam</label>
                                        <input type="date" class="form-control" wire:model="loanDate">
                                    </div>
                                    <div class="form-group mt-2 {{ $formMenu === 'editBorrow' ? '' : 'd-none' }}">
                                        <label for="returnDate" class="mb-1">Tanggal Kembali</label>
                                        <input type="date" class="form-control" wire:model="returnDate">
                                    </div>
                                    <div class="form-group mt-2 {{ $formMenu === 'editBorrow' ? '' : 'd-none' }}">
                                        <label for="status" class="mb-1">Status</label>
                                        <select wire:model="status" id="status" class="form-select">
                                            <option value="">--pilih status--</option>
                                            @foreach ($statuses as $statusOption)
                                                <option value="{{ $statusOption }}">{{ $statusOption }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit"
                                        class="btn btn-success mt-2">{{ $formMenu === 'editBorrow' ? 'Perbarui' : 'Simpan' }}</button>
                                </form>
                            @endif
                        @endif
                        <hr>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Member</th>
                                    <th>Judul Buku</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($borrows as $borrow)
                                    <tr>
                                        <td>{{ $loop->iteration }}.</td>
                                        <td>{{ $borrow->member->name }}</td>
                                        <td>{{ $borrow->book->title }}</td>
                                        <td>{{ \Carbon\Carbon::parse($borrow->loan_date)->format('d M Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($borrow->return_date)->format('d M Y') }}</td>
                                        <td>{{ $borrow->status }}</td>
                                        <td>
                                            <button wire:click="editBorrow({{ $borrow->id }})" type="button"
                                                class="btn btn-sm btn-warning">Edit</button>
                                            <button wire:click="deleteBorrow({{ $borrow->id }})" type ="button"
                                                wire:confirm="Apakah anda ingin menghapus peminjaman atas nama {{ $borrow->member->name }} ini?"
                                                class="btn btn-sm btn-danger">Delete</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Data Pinjaman Buku Belum Ada.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
