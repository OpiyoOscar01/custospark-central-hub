<?php

namespace App\Repositories;

use App\Models\Author;

class AuthorRepository
{
    protected $author;

    public function __construct(Author $author)
    {
        $this->author = $author;
    }

    public function getAll()
    {
        return $this->author->all();
    }

    public function create(array $data)
    {
        return $this->author->create($data);
    }

    public function findById($id)
    {
        return $this->author->findOrFail($id);
    }

    public function update($id, array $data)
    {
        $author = $this->author->findOrFail($id);
        $author->update($data);
        return $author;
    }

    public function delete($id)
    {
        $author = $this->author->findOrFail($id);
        $author->delete();
        return true;
    }
}

