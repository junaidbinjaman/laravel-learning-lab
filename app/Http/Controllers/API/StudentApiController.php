<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StudentApiController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $students = Student::query()->get();

        return response()->json( [
            'status' => 'success',
            'data'   => $students
        ], 200 );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store( Request $request ) {
        // Validate
        $validator = Validator::make( $request->all(), [
            'name'   => 'required|min:4',
            'email'  => 'required|unique:students,email',
            'gender' => 'required'
        ] );

        if ( $validator->fails() ) {
            return response()->json( [
                'status'  => 'fail',
                'message' => $validator->messages()
            ] );
        }

        $data = $request->all();

        Student::query()->create( $data );

        return response()->json( [
            'status'  => 'success',
            'message' => 'Student created successfully'
        ], 201 );
    }

    /**
     * Display the specified resource.
     */
    public function show( string $id ) {
        $student = Student::query()->find( $id );

        if ( ! $student ) {
            return response()->json( [
                'status'  => 'fail',
                'message' => 'No student was found'
            ] );
        }

        return response()->json( [
            'status' => 'success',
            'data'   => $student
        ] );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( Request $request, string $id ) {
        //
        $validator = Validator::make( $request->all(), [
            'name'   => 'required|min:4',
            'email'  => [ 'required', Rule::unique( 'students', 'email' )->ignore( $id ) ],
            'gender' => 'required'
        ] );

        if ( $validator->fails() ) {
            return response()->json( [
                'status'  => 'fail',
                'message' => $validator->errors()
            ], 400 );
        }

        $student = Student::query()->find( $id );

        if ( ! $student ) {
            return response()->json( [
                'status'  => 'fail',
                'message' => 'There\'s no student available'
            ], 404 );
        }

        $student->name   = $request->name;
        $student->email  = $request->email;
        $student->gender = $request->gender;

        $student->save();

        return response()->json( [
            'status'  => 'success',
            'message' => 'The student data has been updated successfully'
        ] );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( string $id ) {
        $student = Student::query()->find( $id );

        if ( ! $student ) {
            return response()->json( [
                'status'  => 'fail',
                'message' => 'Student is not found'
            ], 404 );
        }

        $student->delete();

        return response()->json( [
            'status'  => 'success',
            'message' => 'Student data is deleted'
        ], 200 );
    }
}
