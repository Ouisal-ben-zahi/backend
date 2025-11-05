<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Property;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     *  Afficher toutes les réservations
     */
    public function index()
    {
        // Récupère toutes les réservations avec les infos de la propriété
        $reservations = Reservation::with('property')->latest()->get();
        return response()->json($reservations);
    }

    /**
     * ➕ Créer une nouvelle réservation
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_id'  => 'required|exists:properties,id',
            'client_name'  => 'required|string|max:255',
            'client_email' => 'required|email|max:255',
            'client_phone' => 'required|string|max:30',
            'visit_date'   => 'required|date',
            'message'      => 'nullable|string',
            'status'       => 'nullable|in:pending,confirmed,cancelled,completed',
        ]);

        $reservation = Reservation::create($validated);

        return response()->json([
            'message' => 'Réservation créée avec succès ',
            'reservation' => $reservation->load('property'),
        ], 201);
    }

    /**
     *  Afficher une réservation spécifique
     */
    public function show($id)
    {
        $reservation = Reservation::with('property')->find($id);

        if (!$reservation) {
            return response()->json(['message' => 'Réservation introuvable '], 404);
        }

        return response()->json($reservation);
    }

    /**
     *  Mettre à jour une réservation existante
     */
    public function update(Request $request, $id)
    {
        $reservation = Reservation::find($id);

        if (!$reservation) {
            return response()->json(['message' => 'Réservation introuvable '], 404);
        }

        $validated = $request->validate([
            'client_name'  => 'sometimes|string|max:255',
            'client_email' => 'sometimes|email|max:255',
            'client_phone' => 'sometimes|string|max:30',
            'visit_date'   => 'sometimes|date',
            'message'      => 'nullable|string',
            'status'       => 'sometimes|in:pending,confirmed,cancelled,completed',
        ]);

        $reservation->update($validated);

        return response()->json([
            'message' => 'Réservation mise à jour avec succès ',
            'reservation' => $reservation->load('property'),
        ]);
    }

    /**
     *  Supprimer une réservation
     */
    public function destroy($id)
    {
        $reservation = Reservation::find($id);

        if (!$reservation) {
            return response()->json(['message' => 'Réservation introuvable '], 404);
        }

        $reservation->delete();

        return response()->json(['message' => 'Réservation supprimée avec succès ']);
    }
}
