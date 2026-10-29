<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Directory</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-100 flex flex-col items-center py-10 min-h-screen px-4">

    <!-- Top Bar with Logout -->
    <div class="w-full max-w-5xl flex justify-between items-center mb-4">
        <span class="text-sm text-slate-600">Logged in as: <strong>{{ Auth::user()->name ?? 'User' }}</strong></span>
        <form action="{{ route('student.logout') }}" method="POST">
            @csrf
            <button type="submit" class="text-xs bg-rose-50 hover:bg-rose-100 text-rose-600 px-3 py-1.5 rounded-lg border border-rose-200 transition">
                <i class="fas fa-sign-out-alt mr-1"></i> Logout
            </button>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-xl w-full max-w-5xl overflow-hidden border border-slate-200">
        <!-- Top Stats Banner -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white p-6">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold flex items-center justify-center gap-2">
                    <i class="fas fa-graduation-cap"></i> Student Directory
                </h2>
                <p class="text-xs text-indigo-100 mt-1">Browse and manage all registered students</p>
            </div>

            <div class="flex justify-center gap-4 flex-wrap">
                <div class="bg-white/10 rounded-xl px-6 py-3 text-center border border-white/20 w-36">
                    <p class="text-2xl font-extrabold">{{ $totalStudents }}</p>
                    <p class="text-[11px] text-indigo-200 uppercase font-semibold">Total Students</p>
                </div>
                <div class="bg-white/10 rounded-xl px-6 py-3 text-center border border-white/20 w-36">
                    <p class="text-2xl font-extrabold">{{ $totalDepartments }}</p>
                    <p class="text-[11px] text-indigo-200 uppercase font-semibold">Departments</p>
                </div>
                <div class="bg-white/10 rounded-xl px-6 py-3 text-center border border-white/20 w-36">
                    <p class="text-2xl font-extrabold">{{ $avgYears }} yrs</p>
                    <p class="text-[11px] text-indigo-200 uppercase font-semibold">Avg. Enrollment</p>
                </div>
            </div>
        </div>

        <div class="p-6">
            @if(session('success'))
                <div class="mb-4 p-3 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-lg text-xs flex items-center">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                </div>
            @endif

            <!-- Search and Filter Form -->
            <form method="GET" action="{{ route('student.dashboard') }}" class="mb-6 space-y-3">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 text-sm"><i class="fas fa-search"></i></span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search students by name, email, or department..." class="w-full pl-9 pr-4 py-2 border rounded-lg border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div class="flex items-center gap-3">
                    <select name="dept_id" onchange="this.form.submit()" class="border rounded-lg px-3 py-1.5 text-xs text-slate-600 focus:outline-none">
                        <option value="">All Departments</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->dept_id }}" {{ request('dept_id') == $dept->dept_id ? 'selected' : '' }}>
                                {{ $dept->dept_name }}
                            </option>
                        @endforeach
                    </select>

                    <select name="gender" onchange="this.form.submit()" class="border rounded-lg px-3 py-1.5 text-xs text-slate-600 focus:outline-none">
                        <option value="">All Genders</option>
                        <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>

                    @if(request('search') || request('dept_id') || request('gender'))
                        <a href="{{ route('student.dashboard') }}" class="text-xs text-slate-400 hover:text-slate-600 underline">Clear filters</a>
                    @endif
                </div>
            </form>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-slate-500 font-semibold border-b">
                            <th class="py-3 px-3">ID</th>
                            <th class="py-3 px-3">Student</th>
                            <th class="py-3 px-3">Contact</th>
                            <th class="py-3 px-3">Enrollment</th>
                            <th class="py-3 px-3">Department</th>
                            <th class="py-3 px-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($students as $st)
                            <tr class="hover:bg-slate-50">
                                <td class="py-3 px-3 font-semibold text-slate-700">{{ $st->student_id }}</td>
                                <td class="py-3 px-3">
                                    <div class="font-bold text-slate-800">{{ $st->student_name }}</div>
                                    <div class="text-slate-400 text-[11px]">{{ $st->gender }}</div>
                                </td>
                                <td class="py-3 px-3">
                                    <div class="text-indigo-600"><i class="fas fa-envelope mr-1 text-[10px]"></i>{{ $st->email }}</div>
                                    <div class="text-slate-400 text-[11px]"><i class="fas fa-sticky-note mr-1 text-[10px]"></i>{{ $st->description ?? 'N/A' }}</div>
                                </td>
                                <td class="py-3 px-3">
                                    <div class="text-slate-700 font-medium"><i class="far fa-calendar-alt text-sky-500 mr-1"></i>{{ \Carbon\Carbon::parse($st->enrollment_date)->format('M d, Y') }}</div>
                                    <div class="text-slate-400 text-[11px]"><i class="fas fa-clock text-sky-400 mr-1"></i>{{ $st->years_enrolled }} years</div>
                                </td>
                                <td class="py-3 px-3">
                                    <span class="inline-flex items-center gap-1 bg-sky-100 text-sky-700 px-2 py-0.5 rounded text-[11px] font-medium">
                                        <i class="fas fa-building text-[9px]"></i> {{ $st->department->dept_name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('student.edit', $st->student_id) }}" class="text-emerald-500 hover:text-emerald-700 p-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('student.delete', $st->student_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this student?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-400 hover:text-rose-600 p-1">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-slate-400">No students found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Custom Pagination to match screenshot design -->
            <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs">
                <div class="text-slate-500">
                    Showing <span class="font-medium text-slate-700">{{ $students->firstItem() ?? 0 }}</span> to 
                    <span class="font-medium text-slate-700">{{ $students->lastItem() ?? 0 }}</span> of 
                    <span class="font-medium text-slate-700">{{ $students->total() }}</span> entries
                </div>

                <div class="inline-flex items-center gap-1">
                    {{-- Previous Button --}}
                    @if ($students->onFirstPage())
                        <span class="px-3 py-1.5 text-slate-400 bg-slate-50 rounded-lg cursor-not-allowed">Previous</span>
                    @else
                        <a href="{{ $students->previousPageUrl() }}" class="px-3 py-1.5 text-indigo-600 hover:bg-indigo-50 rounded-lg transition font-medium">Previous</a>
                    @endif

                    {{-- Page Numbers --}}
                    @foreach ($students->getUrlRange(1, $students->lastPage()) as $page => $url)
                        @if ($page == $students->currentPage())
                            <span class="w-7 h-7 flex items-center justify-center rounded-lg bg-indigo-600 text-white font-semibold">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="w-7 h-7 flex items-center justify-center rounded-lg text-slate-600 hover:bg-slate-100 transition">{{ $page }}</a>
                        @endif
                    @endforeach

                    {{-- Next Button --}}
                    @if ($students->hasMorePages())
                        <a href="{{ $students->nextPageUrl() }}" class="px-3 py-1.5 text-indigo-600 hover:bg-indigo-50 rounded-lg transition font-medium">Next</a>
                    @else
                        <span class="px-3 py-1.5 text-slate-400 bg-slate-50 rounded-lg cursor-not-allowed">Next</span>
                    @endif
                </div>
            </div>

            <!-- Button linking to Registration Form -->
            <div class="mt-6 flex justify-center">
                <a href="{{ route('student.create') }}" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 rounded-xl text-center text-sm flex items-center justify-center gap-2 transition">
                    <i class="fas fa-user-plus"></i> Back to Student Form
                </a>
            </div>
        </div>
    </div>

</body>
</html>