<?php

namespace App\Livewire;

use App\Models\Member;
use Livewire\Component;

class MemberPage extends Component
{
    public $formMenu;
    public $closeForm = true;
    public $name;
    public $nisn;
    public $memberId;

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
            'name' => 'required|string|max:255',
            'nisn' => 'required|string|min:4',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama member wajib diisi.',
            'name.max' => 'Panjang nama tidak lebih dari 255 karakter.',
            'nisn.required' => 'NISN wajib diisi.',
            'nisn.min' => 'Jumlah NISN tidak kurang dari 4.',
        ];
    }

    public function addMember()
    {
        // Validasi input menggunakan aturan yang ditentukan di rules()
        $this->validate();

        // Simpan buku
        Member::create([
            'name' => ucwords($this->name),
            'nisn' => $this->nisn,
        ]);

        // Reset form
        $this->reset();
        $this->closeForm = true;
    }

    public function editMember(string $id)
    {
        $this->memberId = $id;
        $member = Member::findOrFail($id);
        $this->name = $member->name;
        $this->nisn = $member->nisn;
        $this->formMenu = 'editMember';
        $this->closeForm = false;
    }

    public function updateMember()
    {
        $this->validate();

        $member = Member::findOrFail($this->memberId);
        $member->update([
            'name' => ucwords($this->name),
            'nisn' => $this->nisn,
        ]);

        $this->reset();
        $this->closeForm = true;
    }

    public function deleteMember(string $id)
    {
        $member = Member::findOrFail($id);
        $member->delete();
    }

    public function render()
    {
        return view('livewire.member-page')->with([
            'members' => Member::orderBy('name', 'asc')->get(),
        ]);
    }
}
