# API Documentation

## Authentication

All API endpoints require authentication using Laravel Sanctum. Include your API token in the request headers:

```http
Authorization: Bearer your-api-token
```

## Available Endpoints

### Projects

#### List Projects
```http
GET /api/projects

Query Parameters:
- search: Search term
- status: Filter by status
- priority: Filter by priority
- client_id: Filter by client
- per_page: Items per page (default: 15)

Response:
{
    "data": [
        {
            "id": 1,
            "name": "Project Name",
            "description": "Project Description",
            "status": "in_progress",
            "priority": "high",
            "progress": 75,
            "client": {
                "id": 1,
                "name": "Client Name"
            }
        }
    ],
    "meta": {
        "current_page": 1,
        "total": 10,
        "per_page": 15
    }
}
```

#### Search Projects
```http
GET /api/projects/search

Query Parameters:
- search: Search term (required)
- status: Filter by status
- priority: Filter by priority
- per_page: Items per page (default: 15)
```

#### Create Project
```http
POST /api/projects

Request Body:
{
    "name": "Project Name",
    "description": "Project Description",
    "status": "pending|in_progress|completed|on_hold",
    "priority": "low|medium|high|urgent",
    "start_date": "YYYY-MM-DD",
    "end_date": "YYYY-MM-DD",
    "budget": 1000.00,
    "client_id": 1
}
```

#### Get Project
```http
GET /api/projects/{id}

Response:
{
    "data": {
        "id": 1,
        "name": "Project Name",
        "description": "Project Description",
        "status": "in_progress",
        "priority": "high",
        "start_date": "2024-03-01",
        "end_date": "2024-06-30",
        "budget": 10000.00,
        "progress": 75,
        "client": {
            "id": 1,
            "name": "Client Name"
        },
        "team_members": [],
        "tasks": []
    }
}
```

#### Update Project
```http
PUT /api/projects/{id}

Request Body:
{
    "name": "Updated Project Name",
    "status": "in_progress",
    "priority": "high"
}
```

#### Delete Project
```http
DELETE /api/projects/{id}
```

### Tasks

#### List Tasks
```http
GET /api/tasks

Query Parameters:
- project_id: Filter by project
- status: Filter by status
- priority: Filter by priority
- assigned_to: Filter by assignee
```

#### Create Task
```http
POST /api/tasks

Request Body:
{
    "project_id": 1,
    "title": "Task Title",
    "description": "Task Description",
    "status": "pending",
    "priority": "high",
    "due_date": "2024-04-01",
    "assigned_to": 1
}
```

### Time Logs

#### List Time Logs
```http
GET /api/time-logs

Query Parameters:
- task_id: Filter by task
- user_id: Filter by user
- start_date: Filter by start date
- end_date: Filter by end date
- is_billable: Filter billable entries
```

#### Create Time Log
```http
POST /api/time-logs

Request Body:
{
    "task_id": 1,
    "hours_worked": 2.5,
    "description": "Work description",
    "is_billable": true,
    "date_logged": "2024-03-19"
}
```

#### Start Timer
```http
POST /api/time-logs/start

Request Body:
{
    "task_id": 1
}
```

#### Stop Timer
```http
POST /api/time-logs/stop

Request Body:
{
    "task_id": 1,
    "description": "Work description"
}
```

### Client Portal

#### List Client Projects
```http
GET /api/client/projects

Response:
{
    "data": [
        {
            "id": 1,
            "name": "Project Name",
            "status": "in_progress",
            "progress": 75,
            "start_date": "2024-03-01",
            "end_date": "2024-06-30"
        }
    ]
}
```

#### Submit Feedback
```http
POST /api/client/feedbacks

Request Body:
{
    "project_id": 1,
    "content": "Feedback content",
    "type": "feedback|request|issue"
}
```

#### List Invoices
```http
GET /api/client/invoices

Response:
{
    "data": [
        {
            "id": 1,
            "invoice_number": "INV000001",
            "amount": 1000.00,
            "status": "pending",
            "due_date": "2024-04-01"
        }
    ]
}
```

## Error Handling

All endpoints return appropriate HTTP status codes:

- 200: Success
- 201: Created
- 400: Bad Request
- 401: Unauthorized
- 403: Forbidden
- 404: Not Found
- 422: Validation Error
- 500: Server Error

Error Response Format:
```json
{
    "message": "Error message",
    "errors": {
        "field": [
            "Error description"
        ]
    }
}
```