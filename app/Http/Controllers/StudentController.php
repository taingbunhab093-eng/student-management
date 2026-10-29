<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class StudentController extends Controller
{
    // --- Auth: Show Login/Register Page ---
    public function showLoginForm()
    {
        return view('student.register_login');
    }

    // --- Auth: Handle Registration ---
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors(['register_error' => $validator->errors()->first()])
                ->withInput();
        }

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Account created successfully! Please log in.');
    }

    // --- Auth: Handle Login ---
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('student.dashboard');
        }

        return back()->withErrors([
            'login_error' => 'Invalid email or password.',
        ])->onlyInput('email');
    }

    // --- Auth: Handle Logout ---
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out.');
    }

    // --- Directory / Dashboard Table ---
    public function dashboard(Request $request)
    {
        $query = Student::with('department');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('student_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('department', function ($dq) use ($search) {
                      $dq->where('dept_name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('dept_id')) {
            $query->where('dept_id', $request->dept_id);
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        // Limit each page to exactly 5 students
        $students = $query->latest('student_id')->paginate(5)->withQueryString();

        $totalStudents = Student::count();
        $totalDepartments = Department::count();

        $allStudents = Student::all();
        $avgYears = $allStudents->count() > 0
            ? number_format($allStudents->avg(function ($s) {
                return Carbon::parse($s->enrollment_date)->diffInDays(now()) / 365.25;
            }), 1)
            : 0;

        $departments = Department::all();

        return view('student.dashboard', compact('students', 'totalStudents', 'totalDepartments', 'avgYears', 'departments'));
    }

    // --- Show Registration Form ---
    public function create()
    {
        $departments = Department::all();
        return view('student.create', compact('departments'));
    }

    // --- Store New Student ---
    public function storeStudent(Request $request)
    {
        $validated = $request->validate([
            'student_name'    => 'required|string|max:255',
            'email'           => 'required|email|unique:students,email',
            'gender'          => 'required|in:Male,Female,Other',
            'enrollment_date' => 'required|date',
            'dept_id'         => 'required|exists:departments,dept_id',
            'description'     => 'nullable|string',
        ]);

        Student::create($validated);

        return redirect()->route('student.dashboard')->with('success', 'Student registered successfully!');
    }

    // --- Show Edit Form ---
    public function editStudent(int $id)
    {
        $student = Student::findOrFail($id);
        $departments = Department::all();
        return view('student.edit', compact('student', 'departments'));
    }

    // --- Update Student ---
    public function updateStudent(Request $request, int $id)
    {
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'student_name'    => 'required|string|max:255',
            'email'           => 'required|email|unique:students,email,' . $student->student_id . ',student_id',
            'gender'          => 'required|in:Male,Female,Other',
            'enrollment_date' => 'required|date',
            'dept_id'         => 'required|exists:departments,dept_id',
            'description'     => 'nullable|string',
        ]);

        $student->update($validated);

        return redirect()->route('student.dashboard')->with('success', 'Student record updated successfully!');
    }

    // --- Delete Student ---
    public function deleteStudent(int $id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('student.dashboard')->with('success', 'Student record deleted successfully!');
    }
}