<?php

namespace App\Services;

use App\Models\Document;
use App\Repositories\DocumentRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Str;

class DocumentService
{
    public function __construct(private DocumentRepository $documentRepository)
    {
    }

    /**
     * Get all documents for a given project.
     */
    public function getByProject(int $projectId): Collection
    {
        return $this->documentRepository->getByProject($projectId);
    }

    /**
     * Store document file and metadata.
     */
    public function createDocument(array $data): Document
    {

        /** @var UploadedFile $file */
        $file = $data['file'];
        
        // Generate a unique name to prevent conflicts
        $uniqueName = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('documents', $uniqueName, 'public'); // stored in storage/app/public/documents
        $fileData=[
            'project_id'   => $data['project_id'],
            'file_name'    => $file->getClientOriginalName(),
            'file_path'    => $path,
            'uploaded_by'  => $data['uploaded_by'],
        ];
        return $this->documentRepository->create($fileData);
    }

    /**
     * Download document file.
     */
    public function downloadDocument(Document $document): StreamedResponse
    {
        if (!Storage::disk('public')->exists($document->file_path)) {
            abort(404, 'File not found here.');
        }

        $filePath = Storage::disk('public')->path($document->file_path);
        return Storage::disk('public')->download($document->file_path, $document->file_name);
    }

    /**
     * Delete document file and database record.
     */
    public function deleteDocument(Document $document): bool
{
    try {
        // Delete file from storage if it exists
        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        // Delete document from the database
        return $this->documentRepository->delete($document);
    } catch (\Exception $e) {
        // Optional: log the error or handle failure
        Log::error("Failed to delete document: " . $e->getMessage());
        return false;
    }
}


    /**
     * (Optional) Get a public URL for preview/download links.
     */
    public function getPublicUrl(Document $document): ?string
    {
        return Storage::disk('public')->exists($document->file_path)
            ? asset('storage/' . $document->file_path)
            : null;
    }
}
