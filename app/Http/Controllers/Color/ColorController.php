<?php

namespace App\Http\Controllers\Color;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ColorController extends Controller
{
    // Renk listeleme
    public function index()
    {
        $colors = Color::latest()->get();
        return Inertia::render('colors/index', [
            'colors' => $colors,
        ]);
    }

    // Renk oluşturma formu
    public function create()
    {
        // Tüm renkleri veya gerekli bilgileri dönebilirsiniz
        $colors = Color::all();
        return Inertia::render('colors/create', [
            'colors' => $colors,
        ]);
    }

    // Renk kaydetme
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'hex_code' => 'required|string|max:7|regex:/^#[A-Fa-f0-9]{6}$/',
        ]);

        Color::create([
            'name' => $validated['name'],
            'hex_code' => $validated['hex_code'],
        ]);

        return back()->with('status', 'Renk başarıyla eklendi!');
    }

    public function destroy(Color $color)
    {
        $color->delete();
        return back()->with('status', 'Renk silindi!');
    }
}
