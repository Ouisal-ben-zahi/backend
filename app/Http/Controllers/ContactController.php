<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        // Validation et nettoyage pour éviter XSS et injections
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'sujet' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
        ]);

        // Échapper les caractères spéciaux pour éviter XSS
        $validated = array_map(fn($value) => htmlspecialchars($value, ENT_QUOTES, 'UTF-8'), $validated);

        // Insertion sécurisée (Eloquent protège contre l’injection SQL)
        Contact::create($validated);

        return response()->json(['message' => 'Message envoyé avec succès !']);
    }
}
