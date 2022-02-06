<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NoteRequest;
use App\Http\Resources\NoteResource;
use App\Models\Note;
use App\UseCases\Notes\NoteService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function __construct(
        private NoteService $service
    ) { }

    /**
     * Display a listing of the resource.
     *
     * @return NoteResource
     */
    public function index()
    {
        return NoteResource::collection(Note::where('user_id', Auth::id())->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  NoteRequest  $request
     * @return NoteResource
     */
    public function store(NoteRequest $request)
    {
        $note = $this->service->add(Auth::id(), $request);

        return new NoteResource($note);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Note  $note
     * @return Response
     */
    public function destroy(Note $note)
    {
        try {
            $this->service->remove(Auth::id(), $note->id);
        } catch (\DomainException $exception) {
            return \response(['error' => $exception->getMessage()]);
        }

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
