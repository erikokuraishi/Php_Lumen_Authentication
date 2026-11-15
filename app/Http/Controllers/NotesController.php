<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotesController extends Controller
{
    // Cari catatan milik user yang sedang login
    private function findOwned($id)
    {
        return Note::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();
    }

    // GET /notes
    public function index()
    {
        $notes = Note::where('user_id', Auth::id())
            ->orderBy('id', 'DESC')
            ->get();

        return response()->json($notes, 200);
    }

    // POST /notes
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'   => 'required|string|max:100',
            'content' => 'required|string',
        ]);

        $note = Note::create([
            'title'   => $request->input('title'),
            'content' => $request->input('content'),
            'user_id' => Auth::id(),
        ]);

        return response()->json($note, 201);
    }

    // GET /note/{id}
    public function show($id)
    {
        $note = $this->findOwned($id);

        if (!$note) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json($note, 200);
    }

    // PUT /note/{id}
    public function update(Request $request, $id)
    {
        $note = $this->findOwned($id);

        if (!$note) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $this->validate($request, [
            'title'   => 'required|string|max:100',
            'content' => 'required|string',
        ]);

        $note->update($request->only(['title', 'content']));

        return response()->json($note, 200);
    }

    // DELETE /note/{id}
    public function destroy($id)
    {
        $note = $this->findOwned($id);

        if (!$note) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $note->delete();

        return response()->json(['message' => 'Deleted'], 200);
    }
}