<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
//use App\Http\Controllers\query;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // the eloquent function to displays data
            //$student = Student::all()->paginate(3); // Mengambil semua isi tabel
            //$student =Student::Paginate(3)->sortBy($id_student, 'asc');
            $student = Student::where([
                ['name', '!=', Null],
                [function ($query) use ($request){
                    if (($term = $request->term)){
                        $query->orWhere('name', 'Like', '%' . $term . '%')->get();
                    }
                }]
            ])
                ->orderBy('id_student', 'asc')
                ->simplePaginate(3);

            //$student = Student::orderBy('id_student', 'asc')->simplePaginate(3);
            
            return view('student.index', ['student'=> $student])
                ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        return view('student.create');

    }

    public function store(Request $request)
    {
        //melakukan validasi data
            $request->validate([
                'Nim' => 'required',
                'Name' => 'required',
                'Date_Of_Birth' => 'required',
                'Class' => 'required',
                'Major' => 'required',
                'Address' => 'required',
    ]);

    // eloquent function to add data
    Student::create($request->all());

    // if the data is added successfully, will return to the main page
    return redirect()->route('student.index')
        ->with('success', 'Student Successfully Added');
    }

    public function show($nim)
    {
        // displays detailed data by finding / by Student Nim
            $Student = Student::where('nim', $nim)->first();
            return view('student.detail', compact('Student'));
    }

    public function edit($nim)
    {
        // displays detail data by finding based on Student Nim for editing
            $Student = Student::where('nim', $nim)->first();
            return view('student.edit', compact('Student'));
    }

    public function update(Request $request, $nim)
    {
    //validate the data
    $request->validate([
    'Nim' => 'required',
    'Name' => 'required',
    'Date_Of_Birth' => 'required',
    'Class' => 'required',
    'Major' => 'required',
    'Address' => 'required',
    ]);

    //Eloquent function to update the data
    Student::where('nim', $nim)
    ->update([
    'nim'=>$request->Nim,
    'name'=>$request->Name,
    'date_of_birth' => $request->Date_Of_Birth,
    'class'=>$request->Class,
    'major'=>$request->Major,
    'address' => $request->Address,
    ]);

    //if the data successfully updated, will return to main page
    return redirect()->route('student.index')
    ->with('success', 'Student Successfully Updated');
    }

    public function destroy($nim)
    {
        //Eloquent function to delete the data
        Student::where('nim', $nim)->delete();
        return redirect()->route('student.index')
        -> with('success', 'Student Successfully Deleted');
    }
    public function search()
    {
        $student = Student::query();
        if (request('term')) {
            $student->where('name', 'Like', '%' . request('term') . '%');
        }

        return $student->orderBy('id', 'asc')->paginate(3);
    }
};
