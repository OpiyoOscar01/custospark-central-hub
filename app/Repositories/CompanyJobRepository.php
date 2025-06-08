<?php
namespace App\Repositories;

use App\Models\CompanyJob;
use Illuminate\Pagination\LengthAwarePaginator;

class CompanyJobRepository
{
    public function getAllJobs(int $perPage = 10): LengthAwarePaginator
    {
        return CompanyJob::with(['creator', 'applications'])
            ->latest()
            ->paginate($perPage);
    }

    public function getPublishedJobs(int $perPage = 10): LengthAwarePaginator
    {
        return CompanyJob::published()
            ->with(['creator'])
            ->latest()
            ->paginate($perPage);
    }

    public function createJob(array $data): CompanyJob
    {
        return CompanyJob::create($data);
    }

    public function updateJob(CompanyJob $job, array $data): CompanyJob
    {
        $job->update($data);
        return $job;
    }

    public function deleteJob(CompanyJob $job): bool
    {
        return $job->delete();
    }

    public function updateJobStatus(CompanyJob $job, string $status): CompanyJob
    {
        $job->update(['status' => $status]);
        return $job;
    }

    public function getJobStats(): array
    {
        return [
            'total'        => CompanyJob::count(),
            'published'    => CompanyJob::where('status', 'published')->count(),
            'draft'        => CompanyJob::where('status', 'draft')->count(),
            'closed'       => CompanyJob::where('status', 'closed')->count(),
            'applications' => CompanyJob::sum('applications_count'),
        ];
    }
}
