<?php
namespace App\Http\Controllers;

use App\Http\Requests\JobRequest;
use App\Models\CompanyJob;
use App\Services\CompanyJobService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CompanyJobController extends Controller
{
    protected $jobService;

    public function __construct(CompanyJobService $jobService)
    {
        $this->jobService = $jobService;
    }

    public function index(): View
    {
        $jobs = $this->jobService->getAllJobs();
        $stats = $this->jobService->getJobStats();

        return view('jobs.index', compact('jobs', 'stats'));
    }
    public function jobListings(): View
    {
        $jobs = CompanyJob::published()->paginate(10);
        $departments = CompanyJob::distinct('department')->pluck('department');
        $locations = CompanyJob::distinct('location')->pluck('location');
        return view('jobs.job_listing', compact('jobs','departments','locations'));
    }
    public function create(): View
    {
        return view('jobs.create');
    }

    public function store(JobRequest $request): RedirectResponse
    {
        $this->jobService->createJob($request->validated());

        return redirect()->route('jobs.index')
            ->with('success', 'CompanyJob posting created successfully.');
    }

    public function show(CompanyJob $job): View
    {
        $applications = $job->applications()
            ->with(['applicant', 'reviewer'])
            ->latest()
            ->paginate(10);

        return view('jobs.show', compact('job', 'applications'));
    }

    public function edit(CompanyJob $job): View
    {
        return view('jobs.edit-form', compact('job'));
    }

    public function update(JobRequest $request, CompanyJob $job): RedirectResponse
    {
        $this->jobService->updateJob($job, $request->validated());

        return redirect()->route('jobs.index')
            ->with('success', 'CompanyJob posting updated successfully.');
    }

    public function destroy(CompanyJob $job): RedirectResponse
    {
        $this->jobService->deleteJob($job);

        return redirect()->route('jobs.index')
            ->with('success', 'CompanyJob posting deleted successfully.');
    }

    public function publish(CompanyJob $job): RedirectResponse
    {
        $this->jobService->publishJob($job);

        return back()->with('success', 'CompanyJob posting published successfully.');
    }

    public function close(CompanyJob $job): RedirectResponse
    {
        $this->jobService->closeJob($job);

        return back()->with('success', 'CompanyJob posting closed successfully.');
    }
}
