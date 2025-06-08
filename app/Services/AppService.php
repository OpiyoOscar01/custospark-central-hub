<?php
// app/Services/AppService.php

namespace App\Services;

use App\Repositories\AppRepository;
use App\Models\App;

class AppService
{
    protected $appRepository;

    public function __construct(AppRepository $appRepository)
    {
        $this->appRepository = $appRepository;
    }

    public function createApp(array $data)
    {
        return $this->appRepository->create($data);
    }

    // App\Services\AppService
public function updateApp(App $app, array $data)
{
    return $this->appRepository->update($app, $data);
}


    public function deleteApp($id)
    {
        $app = $this->appRepository->findById($id);
        return $this->appRepository->delete($app);
    }

    public function getAllApps()
    {
        return $this->appRepository->getAll();
    }

    public function getAppById($id)
    {
        return $this->appRepository->findById($id);
    }
}
