<?php

namespace App\Repositories;

use App\Models\Document;
use Illuminate\Database\Eloquent\Collection;

class DocumentRepository
{
    public function getByProject(int $projectId): Collection
    {
        return Document::where('project_id', $projectId)
            ->with(['uploader'])
            ->latest()
            ->get();
    }

    public function create(array $data): Document
    {
        return Document::create($data);
    }

    public function update(Document $document, array $data): Document
    {
        $document->update($data);
        return $document;
    }

    public function delete(Document $document): bool
    {
        return $document->delete();
    }
}