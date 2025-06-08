<?php
// app/Repositories/AppRepository.php

namespace App\Repositories;

use App\Models\App;

class AppRepository
{
    protected $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function create(array $data)
    {
        return $this->app->create($data);
    }

    public function update(App $app, array $data)
    {
        $app->update($data);
        return $app;
    }

    public function delete(App $app)
    {
        return $app->delete();
    }

    public function getAll()
{
    return App::query(); // or App::where(...), etc.
}


    public function findById($id)
    {
        return $this->app->find($id);
    }
}
