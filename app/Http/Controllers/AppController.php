<?php
// app/Http/Controllers/AppController.php

namespace App\Http\Controllers;

use App\Http\Requests\AppRequest;
use App\Http\Requests\StoreAppRequest;
use App\Http\Requests\UpdateAppRequest;
use App\Models\App;
use App\Services\AppService;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class AppController extends Controller
{
    protected $appService;

    public function __construct(AppService $appService)
    {
        $this->appService = $appService;
    }

    //show app creation form
    public function create()
    {
        
        return view('central.apps.create');
    }
    //show app creation form
    public function edit($id)
    {
        $app = $this->appService->getAppById($id);
        if (!$app) {
            return abort(404,"App not found");
        } else {
            return view('central.apps.edit', compact('app'));
        }
    }
        // You can pass the app data to the view if needed
  

    // Create a new app
    public function store(StoreAppRequest $request)
    {
        $app = $this->appService->createApp($request->validated());
        return redirect()->route('apps.index')->with('success', 'App created successfully');
    }

    // Update an existing app
 // App\Http\Controllers\AppController
public function update(App $app, UpdateAppRequest $request)
{
    $this->appService->updateApp($app, $request->validated());
    return redirect()->route('apps.index')->with('success', 'App updated successfully');
}


    // Delete an app
    public function destroy($id)
    {
     $result=$this->appService->deleteApp($id);
        if (!$result) {
            return abort(404,"App not found");
        }
     return redirect()->route('apps.index')->with('success', 'App deleted successfully');

    }

    // Get all apps
    public function index()
    {
        $apps = $this->appService->getAllApps()->paginate(10);
      
        return view('central.apps.index', compact('apps'));
    }

    // Get a single app by ID
    public function show($id)
    {
        $app = $this->appService->getAppById($id);
        return view('central.apps.show', compact('app'));
    }

}
