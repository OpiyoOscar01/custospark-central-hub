<?php
namespace App\Services;

use App\Models\CompanyJob;
use App\Repositories\CompanyJobRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class CompanyJobService
{
    protected $jobRepository;

    public function __construct(CompanyJobRepository $jobRepository)
    {
        $this->jobRepository = $jobRepository;
    }

    public function getAllJobs(): LengthAwarePaginator
    {
        return $this->jobRepository->getAllJobs();
    }

    public function createJob(array $data): CompanyJob
    {
        $data['created_by'] = Auth::id();
        return $this->jobRepository->createJob($data);
    }

    public function updateJob(CompanyJob $job, array $data): CompanyJob
    {
        return $this->jobRepository->updateJob($job, $data);
    }

    public function deleteJob(CompanyJob $job): bool
    {
        return $this->jobRepository->deleteJob($job);
    }

    public function publishJob(CompanyJob $job): CompanyJob
    {
        return $this->jobRepository->updateJobStatus($job, 'published');
    }

    public function closeJob(CompanyJob $job): CompanyJob
    {
        return $this->jobRepository->updateJobStatus($job, 'closed');
    }

    public function getJobStats(): array
    {
        return $this->jobRepository->getJobStats();
    }
}
