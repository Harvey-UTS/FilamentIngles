<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\InscripcionesImport;

class InscripcionesImportController extends Controller
{
    public function importar(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xlsx|max:2048',
        ]);

        try {
            // Procesar el archivo
            Excel::import(new InscripcionesImport, $request->file('file'));
            return redirect()->back()->with('success', 'Inscripciones importadas correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['file' => 'Error al procesar el archivo: ' . $e->getMessage()]);
        }
    }
}
