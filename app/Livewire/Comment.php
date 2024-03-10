<?php

namespace App\Livewire;

use App\Models\Comment as ModelsComment;
use App\Models\Photo;
use Livewire\Component;
use Yoeunes\Toastr\Facades\Toastr;

class Comment extends Component
{
    public $isi_komentar, $isi_komentar_edit, $edit_comment_id, $photo, $comment_id, $isi_komentar_reply;


    public function mount($id)
    {
        $this->photo = Photo::find($id);
    }

    public function render()
    {
        return view('livewire.comment', [
            'comments' => ModelsComment::where('photo_id', $this->photo->id)->with(['user','childrens'])->whereNull('comment_id')->latest()->get(),
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
            $this->isi_komentar = NULL;
            Toastr::success('Komentar Berhasil Ditambahkan', 'Success');
            return redirect()->back();
        }
    }
    public function selectReply($id){
        $this->comment_id = $id;
        $this->isi_komentar_reply = NULL;
    }

    public function reply(){
        $this->validate([
            'isi_komentar_reply' => 'required'
        ], [
            'isi_komentar_reply.required' => 'Komentar tidak boleh kosong'
        ]);
        $comment = ModelsComment::find($this->comment_id);
        $comment = ModelsComment::create([
            'isi_komentar' => $this->isi_komentar_reply,
            'photo_id' => $this->photo->id,
            'user_id' => auth()->user()->id,
            'comment_id' => $comment->comment_id ? $comment->comment_id : $comment->id
        ]);

        if ($comment) {
            $this->isi_komentar_reply = NULL;
            $this->comment_id = NULL;
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
        ],
        [
            'isi_komentar_edit.required' => 'Komentar tidak boleh kosong'
        ]);
        $comment = ModelsComment::find($this->edit_comment_id);
        $comment->isi_komentar = $this->isi_komentar_edit;
        $comment->save();
        
        if ($comment) {
            Toastr::success('Edit Komentar Berhasil', 'Success');
            $this->isi_komentar_edit = NULL;
            $this->edit_comment_id = NULL;
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