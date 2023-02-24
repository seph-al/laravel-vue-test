<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TopicController extends Controller
{
    public function index(){
        return Inertia::render('Topics/Index', [
            'topics' => Topic::all()
        ]);
    }
}
