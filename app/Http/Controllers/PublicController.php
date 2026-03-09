<?php
namespace App\Http\Controllers;
use App\Models\Formation;

class PublicController extends Controller {
    public function index() {
        return view('welcome', ['formations' => Formation::latest()->take(3)->get()]);
    }
    public function formations() {
        return view('formations.public', ['formations' => Formation::all()]);
    }
}
