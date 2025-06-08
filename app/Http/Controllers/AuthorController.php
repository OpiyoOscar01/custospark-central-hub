<?php
namespace App\Http\Controllers;

use App\Http\Requests\AuthorRequest;
use App\Services\AuthorService;
use Illuminate\Http\JsonResponse;

class AuthorController extends Controller
{
    protected $authorService;

    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    public function index(): JsonResponse
    {
        $authors = $this->authorService->getAllAuthors();
        return response()->json($authors, 200);
    }

    public function store(AuthorRequest $request): JsonResponse
    {
        $author = $this->authorService->createAuthor($request->validated());
        return response()->json($author, 201);
    }

    public function show($id): JsonResponse
    {
        $author = $this->authorService->getAuthorById($id);
        return response()->json($author, 200);
    }

    public function update(AuthorRequest $request, $id): JsonResponse
    {
        $author = $this->authorService->updateAuthor($id, $request->validated());
        return response()->json($author, 200);
    }

    public function destroy($id): JsonResponse
    {
        $this->authorService->deleteAuthor($id);
        return response()->json(['message' => 'Author deleted successfully'], 200);
    }
}
