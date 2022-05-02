<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Mail\WelcomeRegistered;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use App\Http\Middleware\checkPassword;




class StudentsController extends Controller
{
    use GeneralTrait;

    public function index()
    {
        $students = Student::selection()->get();
        //return response()->json($students);

        return $this -> returnData('students',$students);
    }

    public function getStudentById(Request $request)
    {

        $student = Student::selection()->find($request->id);
        Mail::to('bahaaeldin.abdelghany@gmail.com')->send(new WelcomeRegistered());
        if (!$student)
            return $this->returnError('001', 'هذا الطالب غير موجد');

        return $this->returnData('student', $student);
    }

    public function changePhone(Request $request)
    {
       //validation
        Student::where('id',$request -> id) -> update(['phone' =>$request ->  phone]);

        return $this -> returnSuccessMessage('تم تغيير الهاتف بنجاح');

    }

    public function destroyStudent(Request $request)
    {
       //validation
        Student::where('id',$request -> id) -> delete();

        return $this -> returnSuccessMessage('تم الحذف بنجاح');
    }
    
    public function createStudent(Request $request)
    {
        return Student::create([
            'name' => $request['name'],
            'phone' => $request['phone'],
        ]);
    }

    public function signUp(Request $request)
    {
        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            Mail::to('bahaaeldin.abdelghany@gmail.com')->send(new WelcomeRegistered()),
        ]);
        
    }

}
