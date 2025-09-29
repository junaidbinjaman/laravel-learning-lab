<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Students\StoreStudentRequest;
use App\Http\Requests\Api\Students\UpdateStudentRequest;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $students = Student::query()->get();

        return response()->json([
            'status' => 'success',
            'data' => $students
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request)
    {
        //
        $data = $request->validated();

        Student::query()->create($data);

        return response()->json([
            "status" => "success",
            "message" => "Student created successfully"
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $student = Student::query()
            ->find($id);

        if ($student) {
            return response()->json([
                'status' => 'success',
                'data' => $student
            ]);
        }

        return response()->json([
            'status' => 'failed',
            'message' => 'No student found.'
        ], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreStudentRequest $request, string $id)
    {
        //
        $data = $request->validated();

        $student = Student::query()
            ->find($id);

        if (!$student) {
            return response()->json([
                'status' => 'fail',
                'message' => 'No student found'
            ], 404);
        }

        $student->name = $request->name;
        $student->email = $request->email;
        $student->gender = $request->gender;
        $student->save();

        return response()->json([
            'status' => 'success',
            'message' => 'student data updated successfully',
            'data' => $student
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $student = Student::query()
            ->find($id);

        if (!$student) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Student not found'
            ], 404);
        }

        $student->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Student deleted successfully'
        ]);
    }
}
