<?php
// app/Http/Controllers/InscripcionController.php
namespace App\Http\Controllers;

use App\Imports\InscripcionesImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class InscripcionController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt',
        ]);

        // Importar el archivo
        Excel::import(new InscripcionesImport, $request->file('file'));

        return redirect()->route('inscripciones.index')->with('success', 'Inscripciones importadas exitosamente');
    }
}
