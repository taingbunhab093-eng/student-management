<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-100 flex flex-col items-center min-h-screen py-10 px-4">

    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden border border-slate-200">
        <div class="bg-gradient-to-r from-emerald-600 to-teal-700 text-white text-center py-6 px-4">
            <h2 class="text-2xl font-bold flex items-center justify-center gap-2">
                <i class="fas fa-user-edit"></i> Edit Student #{{ $student->student_id }}
            </h2>
            <p class="text-xs text-emerald-100 mt-1">Update student record details</p>
        </div>

        <form action="{{ route('student.update', $student->student_id) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Personal Information -->
            <div>
                <h3 class="text-emerald-700 font-semibold text-sm flex items-center gap-2 mb-3">
                    <i class="fas fa-user-circle"></i> Personal Information
                </h3>
                <div class="space-y-3">
                    <input type="text" name="student_name" value="{{ old('student_name', $student->student_name) }}" placeholder="Student Name" required class="w-full px-3 py-2 text-sm border rounded-lg border-slate-300 focus:ring-2 focus:ring-emerald-500">
                    <input type="email" name="email" value="{{ old('email', $student->email) }}" placeholder="Email Address" required class="w-full px-3 py-2 text-sm border rounded-lg border-slate-300 focus:ring-2 focus:ring-emerald-500">
                    <select name="gender" required class="w-full px-3 py-2 text-sm border rounded-lg border-slate-300 text-slate-600">
                        <option value="Male" {{ old('gender', $student->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender', $student->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ old('gender', $student->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
            </div>

            <!-- Academic Information -->
            <div>
                <h3 class="text-emerald-700 font-semibold text-sm flex items-center gap-2 mb-3">
                    <i class="fas fa-university"></i> Academic Information
                </h3>
                <div class="space-y-3">
                    <div>
                        <label class="text-xs text-slate-500 block mb-1">Enrollment Date</label>
                        <input type="date" name="enrollment_date" value="{{ old('enrollment_date', $student->enrollment_date) }}" required class="w-full px-3 py-2 text-sm border rounded-lg border-slate-300">
                    </div>
                    <div>
                        <label class="text-xs text-slate-500 block mb-1">Department</label>
                        <select name="dept_id" required class="w-full px-3 py-2 text-sm border rounded-lg border-slate-300 text-slate-600">
                            @foreach($departments as $dept)
                                <option value="{{ $dept->dept_id }}" {{ old('dept_id', $student->dept_id) == $dept->dept_id ? 'selected' : '' }}>
                                    {{ $dept->dept_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Additional Information -->
            <div>
                <h3 class="text-emerald-700 font-semibold text-sm flex items-center gap-2 mb-2">
                    <i class="fas fa-file-alt"></i> Additional Information
                </h3>
                <textarea name="description" rows="3" class="w-full p-3 text-sm border rounded-lg border-slate-300">{{ old('description', $student->description) }}</textarea>
            </div>

            <div class="flex items-center gap-2 pt-2">
                <button type="submit" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 rounded-lg text-sm transition">
                    Update Student
                </button>
                <a href="{{ route('student.dashboard') }}" class="px-4 py-2 border border-slate-300 text-slate-600 hover:bg-slate-100 rounded-lg text-sm transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>

</body>
</html>