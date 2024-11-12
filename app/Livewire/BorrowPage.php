<?php

namespace App\Livewire;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\Member;
use Livewire\Component;

class BorrowPage extends Component
{
    public $formMenu;
    public $closeForm = true;
    public $memberId;
    public $memberName;
    public $bookId;
    public $loanDate;
    public $returnDate;
    public $status;
    public $borrowId;
    public $search;

    public function showForm()
    {
        $this->closeForm = !$this->closeForm;
        if ($this->closeForm) {
            $this->reset();
        }
    }

    public function searchNisn()
    {
        $searchMember = Member::where("nisn", $this->search)->first();
        if ($searchMember) {
            $this->memberId = $searchMember->id;
            $this->memberName = $searchMember->name;
        } else {
            $this->memberId = null;
            $this->memberName = null;
        }
    }

    public function rules()
    {
        return [
            'memberId' => 'required|exists:members,id',
            'bookId' => 'required|exists:books,id',
            'loanDate' => 'nullable|date',
            'returnDate' => 'nullable|date|after_or_equal:loanDate',
            'status' => 'nullable|in:Borrowed,Returned',
        ];
    }

    public function messages()
    {
        return [
            'memberId.required' => 'ID anggota wajib diisi.',
            'memberId.exists' => 'ID anggota tidak valid.',
            'bookId.required' => 'ID buku wajib diisi.',
            'bookId.exists' => 'ID buku tidak valid.',
            // 'loanDate.required' => 'Tanggal pinjam wajib diisi.',
            'loanDate.date' => 'Tanggal pinjam harus berupa tanggal yang valid.',
            // 'returnDate.required' => 'Tanggal kembali wajib diisi.',
            'returnDate.date' => 'Tanggal kembali harus berupa tanggal yang valid.',
            'returnDate.after_or_equal' => 'Tanggal kembali harus setelah atau sama dengan tanggal pinjam.',
            // 'status.required' => 'Status wajib diisi.',
            'status.in' => 'Status harus berupa Borrowed atau Returned.',
        ];
    }

    public function addBorrow()
    {
        $this->validate();

        Borrow::create([
            'member_id' => $this->memberId,
            'book_id' => $this->bookId,
            'loan_date' => now(),
            'return_date' => now()->addWeek(),
        ]);

        $this->reset();
        $this->closeForm = true;
    }

    public function editBorrow(string $id)
    {
        $this->borrowId = $id;
        $borrow = Borrow::with('member')->findOrFail($id);

        $this->memberId = $borrow->member_id;
        $this->memberName = $borrow->member->name;
        $this->bookId = $borrow->book_id;
        $this->loanDate = $borrow->loan_date;
        $this->returnDate = $borrow->return_date;
        $this->status = $borrow->status;
        $this->formMenu = 'editBorrow';
        $this->closeForm = false;
    }

    public function updateBorrow()
    {
        $this->validate();

        $borrow = Borrow::findOrFail($this->borrowId);
        $borrow->update([
            'member _id' => $this->memberId,
            'book_id' => $this->bookId,
            'loan_date' => $this->loanDate,
            'return_date' => $this->returnDate,
            'status' => $this->status,
        ]);

        session()->flash('message', 'Peminjaman berhasil diperbarui!');
        $this->reset();
        $this->closeForm = true;
    }

    public function deleteBorrow(string $id)
    {
        $borrow = Borrow::findOrFail($id);
        $borrow->delete();
        session()->flash('message', 'Peminjaman berhasil dihapus!'); // Umpan balik
    }

    public $statuses = ['Borrowed', 'Returned'];

    public function render()
    {
        return view('livewire.borrow-page')->with([
            'borrows' => Borrow::with('member', 'book')->orderBy('loan_date', 'asc')->get(),
            'members' => Member::orderBy('name', 'asc')->get(),
            'books' => Book::orderBy('title', 'asc')->get(),
            'statuses' => $this->statuses,
        ]);
    }
}
