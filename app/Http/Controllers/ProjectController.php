<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\View\View;

final class ProjectController extends Controller
{
    public function index(): View
    {
        return view('projects.index', [
            'projects' => Project::query()->paginate(12),
        ]);
    }
}
