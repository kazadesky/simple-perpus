<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-light">{{ __('MEMBER') }}</div>

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
                            <form wire:submit.prevent="{{ $formMenu === 'editMember' ? 'updateMember' : 'addMember' }}"
                                class="mt-2">
                                <div class="form-group mb-2">
                                    <label for="name">Nama Member</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" wire:model="name" placeholder="Judul Buku">
                                    @error('name')
                                        <small class="text-danger text-sm">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group mb-2">
                                    <label for="nisn">NISN</label>
                                    <input type="number" inputmode="numeric"
                                        class="form-control @error('nisn') is-invalid @enderror" id="nisn"
                                        wire:model="nisn" placeholder="Tahun Terbit">
                                    @error('nisn')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <button type="submit"
                                    class="btn btn-primary">{{ $formMenu === 'editMember' ? __('Update Member') : __('Tambah Member') }}</button>
                            </form>
                        @endif
                        <hr>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Member</th>
                                    <th>NISN</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($members as $member)
                                    <tr>
                                        <td>{{ $loop->iteration }}.</td>
                                        <td>{{ $member->name }}</td>
                                        <td>{{ $member->nisn }}</td>
                                        <td>
                                            <button wire:click="editMember({{ $member->id }})" type="button"
                                                class="btn btn-sm btn-warning">Edit</button>
                                            <button wire:click="deleteMember({{ $member->id }})" type="button"
                                                wire:confirm="Apakah anda ingin menghapus member {{ $member->name }} ini?"
                                                class="btn btn-sm btn-danger">Delete</button>
                                        </td>
                                    </tr>
                                @empty
                                    <p class="text-center">Data Member Belum Ada.</p>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
