<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function index()
    {
        $persons = Person::all();
        $cities = City::all();
        return view('person', compact('persons', 'cities'));
    }
    public function store(Request $request)
    {
        $person = new Person();
        $person->name = $request->name;
        $person->city_id = $request->city_id;
        $person->save();
        return redirect()->route('persons')->with('success', 'Person added successfully');
    }
}
