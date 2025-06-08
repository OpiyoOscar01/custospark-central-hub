<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">API Documentation</h1>

        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h2 class="text-2xl font-semibold mb-4">Authentication</h2>
            <p class="mb-4">All API endpoints require authentication using Laravel Sanctum. Include your API token in the request headers:</p>
            <pre class="bg-gray-100 p-4 rounded"><code>Authorization: Bearer your-api-token</code></pre>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h2 class="text-2xl font-semibold mb-4">Projects</h2>

            <div class="mb-6">
                <h3 class="text-xl font-semibold mb-2">List Projects</h3>
                <p class="mb-2"><span class="font-semibold">GET</span> /api/projects</p>
                <p class="mb-2">Query Parameters:</p>
                <ul class="list-disc list-inside mb-2">
                    <li>search: Search term</li>
                    <li>status: Filter by status</li>
                    <li>priority: Filter by priority</li>
                    <li>client_id: Filter by client</li>
                    <li>per_page: Items per page (default: 15)</li>
                </ul>
            </div>

            <div class="mb-6">
                <h3 class="text-xl font-semibold mb-2">Search Projects</h3>
                <p class="mb-2"><span class="font-semibold">GET</span> /api/projects/search</p>
                <p class="mb-2">Query Parameters:</p>
                <ul class="list-disc list-inside mb-2">
                    <li>search: Search term (required)</li>
                    <li>status: Filter by status</li>
                    <li>priority: Filter by priority</li>
                    <li>per_page: Items per page (default: 15)</li>
                </ul>
            </div>

            <div class="mb-6">
                <h3 class="text-xl font-semibold mb-2">Create Project</h3>
                <p class="mb-2"><span class="font-semibold">POST</span> /api/projects</p>
                <p class="mb-2">Request Body:</p>
                <pre class="bg-gray-100 p-4 rounded"><code>{
    "name": "Project Name",
    "description": "Project Description",
    "status": "pending|in_progress|completed|on_hold",
    "priority": "low|medium|high|urgent",
    "start_date": "YYYY-MM-DD",
    "end_date": "YYYY-MM-DD",
    "budget": 1000.00,
    "client_id": 1,
    "documents": [file1, file2] // Optional
}</code></pre>
            </div>

            <div class="mb-6">
                <h3 class="text-xl font-semibold mb-2">Get Project</h3>
                <p class="mb-2"><span class="font-semibold">GET</span> /api/projects/{id}</p>
            </div>

            <div class="mb-6">
                <h3 class="text-xl font-semibold mb-2">Update Project</h3>
                <p class="mb-2"><span class="font-semibold">PUT</span> /api/projects/{id}</p>
                <p class="mb-2">Request Body: Same as Create Project (all fields optional)</p>
            </div>

            <div class="mb-6">
                <h3 class="text-xl font-semibold mb-2">Delete Project</h3>
                <p class="mb-2"><span class="font-semibold">DELETE</span> /api/projects/{id}</p>
            </div>

            <div class="mb-6">
                <h3 class="text-xl font-semibold mb-2">List Project Documents</h3>
                <p class="mb-2"><span class="font-semibold">GET</span> /api/projects/{id}/documents</p>
            </div>
        </div>
    </div>
</body>
</html>