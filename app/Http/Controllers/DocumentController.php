<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentRequest;
use App\Models\Document;
use App\Models\Project;
use App\Services\DocumentService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DocumentController extends Controller
{
    use AuthorizesRequests;
    public function __construct(private  DocumentService $documentService)
    {
            $this->documentService = $documentService;
    }
    protected function booted(): void
    {
        $this->authorizeResource(Document::class, 'document');
    }

    public function index(Project $project): View
    {
        $documents = $this->documentService->getByProject($project->id);
        return view('documents.index', compact('documents', 'project'));
    }

    public function create(Project $project): View
    {
        return view('documents.create', compact('project'));
    }

    public function store(DocumentRequest $request): RedirectResponse
    {
        $this->documentService->createDocument($request->validated());
        return redirect()->route('projects.show', $request->project_id)
            ->with('success', 'Document uploaded successfully.');
    }

    public function show(Document $document)
    {
        return $this->documentService->downloadDocument($document);
    }

    public function destroy(Document $document): RedirectResponse
    {
        $projectId = $document->project_id;
        $this->documentService->deleteDocument($document);
        return redirect()->route('projects.show', $projectId)
            ->with('success', 'Document deleted successfully.');
    }
}