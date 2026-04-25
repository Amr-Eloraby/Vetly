<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vaccination;
use App\Http\Requests\VaccinationRequest;

class VaccinationController extends Controller
{
    // Vaccination
    public function createVaccination()
    {
        return view('dashboard.vaccination.create');
    }
    
    // store Vaccination
    public function storeNewVaccination(VaccinationRequest $request)
    {
        $validatedData = $request->validated();

        Vaccination::create($validatedData);

        return redirect()->route('vaccination.create')->with('success-create-new-vaccination', 'Vaccination created successfully!');
    }

    // show Vaccination
    public function showVaccination()
    {
        $vaccinations = Vaccination::paginate(15);
        return view('dashboard.vaccination.show', compact('vaccinations'));
    }
    // edit Vaccination
    public function editVaccination($id)
    {
        $vaccination = Vaccination::findOrFail($id);
        return view('dashboard.vaccination.edit', compact('vaccination'));
    }

    // update Vaccination
    public function updateVaccination(VaccinationRequest $request, $id)
    {
        $vaccination = Vaccination::findOrFail($id);
        $validatedData = $request->validated();
        $vaccination->update($validatedData);
        return redirect()->route('vaccination.show')->with('success-update-vaccination', 'Vaccination updated successfully!');
    }

    // delete Vaccination
    public function deleteVaccination($id)
    {
        $vaccination = Vaccination::findOrFail($id);
        $vaccination->delete();
        return redirect()->route('vaccination.show')->with('success-delete-vaccination', 'Vaccination deleted successfully!');
    }
}
