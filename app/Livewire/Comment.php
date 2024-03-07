<?php

namespace App\Livewire;

use App\Models\Comment as ModelsComment;
use App\Models\Photo;
use Livewire\Component;
use Yoeunes\Toastr\Facades\Toastr;

class Comment extends Component
{
    public $isi_komentar, $isi_komentar_edit, $edit_comment_id, $photo;


    public function mount($id)
    {
        $this->photo = Photo::find($id);
    }

    public function render()
    {
        return view('livewire.comment', [
            'comments' => ModelsComment::where('photo_id', $this->photo->id)->with('user')->latest()->get(),
            'total_comments' => ModelsComment::where('photo_id', $this->photo->id)->count()
        ]);
    }

    public function store()
    {
        $this->validate([
            'isi_komentar' => 'required'
        ], [
            'isi_komentar.required' => 'Komentar tidak boleh kosong'
        ]);
        $comment = ModelsComment::create([
            'isi_komentar' => $this->isi_komentar,
            'photo_id' => $this->photo->id,
            'user_id' => auth()->user()->id
        ]);

        if ($comment) {
            $this->isi_komentar = '';
            Toastr::success('Komentar Berhasil Ditambahkan', 'Success');
            return redirect()->back();
        }
    }

    public function selectEdit($id)
    {
        $comment = ModelsComment::find($id);
        $this->edit_comment_id = $comment->id;
        $this->isi_komentar_edit = $comment->isi_komentar;
    }

    public function update()
    {
        $this->validate([
            'isi_komentar_edit' => 'required'
        ]);
        $comment = ModelsComment::find($this->edit_comment_id);
        $comment->isi_komentar = $this->isi_komentar_edit;
        $comment->save();
        $this->edit_comment_id = null;
        $this->isi_komentar_edit = '';

        if ($comment) {
            Toastr::success('Edit Komentar Berhasil', 'Success');
            return redirect()->back();
        }
    }
    public function delete($id)
    {
        $commentDelete =  ModelsComment::where('id', $id)->delete();

        if ($commentDelete) {
            Toastr::success('Komentar Berhasil Dihapus', 'Success');
            return redirect()->back();
        }
    }
}