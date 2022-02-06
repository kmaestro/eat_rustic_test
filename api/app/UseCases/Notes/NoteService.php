<?php

namespace App\UseCases\Notes;

use App\Http\Requests\NoteRequest;
use App\Models\Note;
use App\Models\User;

class NoteService
{
    public function add($userId, NoteRequest $request): Note
    {
        $user = $this->getUser($userId);

        $note = Note::create(
            [
                'user_id' => $user->id,
                'title' => $request['title'],
                'description' => $request['description']
            ]
        );

        return $note;
    }

    public function remove($userId, $nodeId): void
    {
        $node = $this->getNote($nodeId);
        if (!$node->hasInUser($userId)) {
            throw new \DomainException('This user cannot delete this note.');
        }
        $node->delete();
    }

    private function getNote($id): Note
    {
        return Note::findOrFail($id);
    }

    private function getUser($userId): User
    {
        return User::findOrFail($userId);
    }
}

