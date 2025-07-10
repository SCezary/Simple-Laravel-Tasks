<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Contracts\Support\Renderable;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index(): Renderable
    {
        // I left it here as it is only for home page. In normal project I would move it to the Repository or Model. Depends on methodology.
        $aggregations = Task::query()
            ->selectRaw('status, COUNT(*) as task_count')
            ->groupBy('status')
            ->pluck('task_count', 'status')
            ->toArray();

        return view('home', [
            'aggregations' => $aggregations
        ]);
    }
}
