<?php

namespace App\Http\Controllers;

use App\Models\Employee;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class EmployeeController extends Controller
{
    //indexx
    public function index(Request $request)
    {
        $employees = DB::table('employees')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->paginate(5);
        return view('pages.employee.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.employee.create');

    }

//store
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:255',
            'joining_date' => 'nullable|date',
        ]);

        $data = $request->only(['name','email','phone','position']);
        // Map form 'joining_date' to DB column 'date_of_joining'
        if ($request->has('joining_date')) {
            $data['date_of_joining'] = $request->input('joining_date');
        }
        Employee::create($data);
        return redirect()->route('employee.index');
    }

    //show
    public function show(Employee $employee)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        return view('pages.employee.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:255',
            'joining_date' => 'nullable|date',
        ]);

        $data = $request->only(['name','email','phone','position']);
        // Map form 'joining_date' to DB column 'date_of_joining'
        if ($request->has('joining_date')) {
            $data['date_of_joining'] = $request->input('joining_date');
        }
        $employee->update($data);
        return redirect()->route('employee.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employee.index');
    }
}
