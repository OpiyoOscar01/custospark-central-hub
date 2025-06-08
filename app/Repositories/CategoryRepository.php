<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function getAll()
    {
        return $this->category->all();
    }

    public function create(array $data)
    {
        return $this->category->create($data);
    }

    public function findById($id)
    {
        return $this->category->findOrFail($id);
    }

    public function update($id, array $data)
    {
        $category = $this->category->findOrFail($id);
        $category->update($data);
        return $category;
    }

    public function delete($id)
    {
        $category = $this->category->findOrFail($id);
        $category->delete();
        return true;
    }
}
