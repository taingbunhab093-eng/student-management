<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-100 flex flex-col items-center min-h-screen py-10 px-4">

    <h1 class="text-3xl font-serif text-slate-800 mb-8 border-b-2 border-slate-300 pb-2 w-full max-w-lg text-left">Simple Student Management System</h1>

    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden border border-slate-200">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white text-center py-6 px-4">
            <h2 class="text-2xl font-bold flex items-center justify-center gap-2">
                <i class="fas fa-graduation-cap"></i> Student Registration
            </h2>
            <p class="text-xs text-indigo-100 mt-1">Complete the form below to register as a new student</p>
        </div>

        @if($errors->any())
            <div class="m-6 mb-0 p-3 bg-rose-50 text-rose-600 border border-rose-200 rounded-lg text-xs">
                <ul class="list-disc pl-4 space-y-1">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('student.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <!-- Personal Information -->
            <div>
                <h3 class="text-blue-600 font-semibold text-sm flex items-center gap-2 mb-3">
                    <i class="fas fa-user-circle"></i> Personal Information
                </h3>
                <div class="space-y-3">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 text-xs"><i class="fas fa-user"></i></span>
                        <input type="text" name="student_name" value="{{ old('student_name') }}" placeholder="Student Name" required class="w-full pl-9 pr-3 py-2 text-sm border rounded-lg border-slate-300 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 text-xs"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" required class="w-full pl-9 pr-3 py-2 text-sm border rounded-lg border-slate-300 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 text-xs"><i class="fas fa-venus-mars"></i></span>
                        <select name="gender" required class="w-full pl-9 pr-3 py-2 text-sm border rounded-lg border-slate-300 text-slate-600 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">Gender</option>
                            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Academic Information -->
            <div>
                <h3 class="text-blue-600 font-semibold text-sm flex items-center gap-2 mb-3">
                    <i class="fas fa-university"></i> Academic Information
                </h3>
                <div class="space-y-3">
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="text-xs text-slate-500 block mb-1">Enrollment Date</label>
                            <input type="date" id="enrollment_date" name="enrollment_date" value="{{ old('enrollment_date') }}" required onchange="calculateYears()" class="w-full px-3 py-2 text-sm border rounded-lg border-slate-300 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="text-xs text-slate-500 block mb-1">Years Enrolled</label>
                            <input type="text" id="years_enrolled" placeholder="Years Enrolled" readonly class="w-full px-3 py-2 text-sm border rounded-lg border-slate-200 bg-slate-50 text-slate-500">
                        </div>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 text-xs"><i class="fas fa-building"></i></span>
                        <select name="dept_id" required class="w-full pl-9 pr-3 py-2 text-sm border rounded-lg border-slate-300 text-slate-600 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">Department</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->dept_id }}" {{ old('dept_id') == $dept->dept_id ? 'selected' : '' }}>
                                    {{ $dept->dept_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Additional Information -->
            <div>
                <h3 class="text-blue-600 font-semibold text-sm flex items-center gap-2 mb-2">
                    <i class="fas fa-file-alt"></i> Additional Information
                </h3>
                <textarea name="description" rows="3" placeholder="Enter any additional information about the student" class="w-full p-3 text-sm border rounded-lg border-slate-300 focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description') }}</textarea>
            </div>

            <!-- Buttons -->
            <div class="flex items-center gap-2 pt-2">
                <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 rounded-lg text-sm flex items-center justify-center gap-2 transition">
                    <i class="fas fa-paper-plane"></i> Submit Registration
                </button>
                <button type="reset" class="px-4 py-2 border border-slate-300 text-slate-600 hover:bg-slate-100 rounded-lg text-sm flex items-center gap-1 transition">
                    <i class="fas fa-undo"></i> Reset Form
                </button>
                <a href="{{ route('student.dashboard') }}" class="px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white rounded-lg text-sm flex items-center gap-1 transition">
                    <i class="fas fa-list"></i> View Student List
                </a>
            </div>
        </form>
    </div>

    <script>
        function calculateYears() {
            const dateVal = document.getElementById('enrollment_date').value;
            if (dateVal) {
                const diffTime = Math.abs(new Date() - new Date(dateVal));
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                document.getElementById('years_enrolled').value = (diffDays / 365.25).toFixed(1) + ' yrs';
            }
        }
        window.addEventListener('DOMContentLoaded', calculateYears);
    </script>
</body>
</html>