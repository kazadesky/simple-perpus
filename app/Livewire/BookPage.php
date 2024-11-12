<?php
namespace App\Livewire;

use App\Models\Book;
use Livewire\Component;

class BookPage extends Component
{
    public $formMenu;
    public $closeForm = true;
    public $title;
    public $writer;
    public $publisher;
    public $year;
    public $amount;
    public $bookId;

    public function showForm()
    {
        $this->closeForm = !$this->closeForm;
        if ($this->closeForm) {
            $this->reset();
        }
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'writer' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'year' => 'required|integer|digits:4', // Pastikan tahun terdiri dari 4 digit
            'amount' => 'required|integer|min:1', // Jumlah buku harus lebih dari 0
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Judul buku wajib diisi.',
            'writer.required' => 'Nama penulis wajib diisi.',
            'publisher.required' => 'Nama penerbit wajib diisi.',
            'year.required' => 'Tahun terbit wajib diisi.',
            'year.digits' => 'Tahun terbit harus terdiri dari 4 digit.',
            'amount.required' => 'Jumlah buku wajib diisi.',
            'amount.min' => 'Jumlah buku harus lebih dari 0.',
        ];
    }

    public function addBook()
    {
        // Validasi input menggunakan aturan yang ditentukan di rules()
        $this->validate();

        // Simpan buku
        Book::create([
            'title' => ucwords($this->title),
            'writer' => ucwords($this->writer),
            'publisher' => ucwords($this->publisher),
            'year' => $this->year,
            'amount' => $this->amount,
        ]);

        // Reset form
        $this->reset();
        $this->closeForm = true;
    }

    public function editBook(string $id)
    {
        $this->bookId = $id;
        $book = Book::findOrFail($id);
        $this->title = $book->title;
        $this->writer = $book->writer;
        $this->publisher = $book->publisher;
        $this->year = $book->year;
        $this->amount = $book->amount;
        $this->formMenu = 'editBook';
        $this->closeForm = false;
    }

    public function updateBook()
    {
        $this->validate();

        $book = Book::findOrFail($this->bookId);
        $book->update([
            'title' => ucwords($this->title),
            'writer' => ucwords($this->writer),
            'publisher' => ucwords($this->publisher),
            'year' => $this->year,
            'amount' => $this->amount,
        ]);

        $this->reset();
        $this->closeForm = true;
    }

    public function deleteBook(string $id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
    }

    public function render()
    {
        return view('livewire.book-page')->with([
            'books' => Book::orderBy('title', 'asc')->get(),
        ]);
    }
}
