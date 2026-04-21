@extends('layouts.app')
@section('page-title', 'Check Out Tool')
@section('content')
<div class="p-6 max-w-2xl">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-white">Check Out Tool</h1>
        <p class="text-sm text-slate-500 mt-1">Scan a barcode or search for a tool, then assign it to an employee</p>
    </div>

    @if($errors->has('barcode'))
    <div class="flex items-center gap-3 px-4 py-3 mb-5 bg-rose-500/10 border border-rose-500/20 rounded-xl text-rose-400 text-sm">
        <i class="fas fa-exclamation-circle"></i>
        {{ $errors->first('barcode') }}
    </div>
    @endif

    <form action="{{ route('borrows.store') }}" method="POST" class="space-y-5">
        @csrf
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-5">

            {{-- ── Tool: Scanner + Search ── --}}
            <div x-data="toolPicker()" x-init="init()">
                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">
                    Tool — Scan or Search <span class="text-rose-400">*</span>
                </label>

                {{-- Mode Tabs --}}
                <div class="flex gap-2 mb-3">
                    <button type="button" @click="mode = 'scan'" :class="mode === 'scan' ? 'bg-sky-500/15 text-sky-400 border-sky-500/30' : 'bg-slate-800/50 text-slate-500 border-slate-700 hover:text-slate-300'"
                            class="flex items-center gap-2 px-3 py-1.5 rounded-lg border text-xs font-medium transition-all">
                        <i class="fas fa-barcode"></i> Scan Barcode
                    </button>
                    <button type="button" @click="mode = 'search'" :class="mode === 'search' ? 'bg-sky-500/15 text-sky-400 border-sky-500/30' : 'bg-slate-800/50 text-slate-500 border-slate-700 hover:text-slate-300'"
                            class="flex items-center gap-2 px-3 py-1.5 rounded-lg border text-xs font-medium transition-all">
                        <i class="fas fa-search"></i> Search Tool
                    </button>
                </div>

                {{-- Scanner Input --}}
                <div x-show="mode === 'scan'" x-cloak>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-barcode text-sky-400"></i>
                        </div>
                        <input type="text" x-ref="scanInput"
                               x-model="scanValue"
                               @keydown.enter.prevent="matchScan()"
                               @input.debounce.400ms="matchScan()"
                               placeholder="Click here then scan barcode…"
                               autofocus
                               class="w-full pl-11 pr-4 py-3 rounded-xl bg-slate-800/50 border border-sky-500/30 text-slate-100 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition-colors font-mono tracking-wider placeholder-slate-600">
                    </div>
                    <p class="text-xs text-slate-600 mt-1.5"><i class="fas fa-info-circle mr-1"></i>Point your barcode scanner at the field above, or type the barcode number manually.</p>
                </div>

                {{-- Search Dropdown --}}
                <div x-show="mode === 'search'" x-cloak class="relative">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-search text-slate-500"></i>
                        </div>
                        <input type="text"
                               x-model="toolQuery"
                               @focus="toolDropOpen = true"
                               @click.away="toolDropOpen = false"
                               placeholder="Type tool name or barcode…"
                               class="w-full pl-11 pr-4 py-3 rounded-xl bg-slate-800/50 border border-slate-700 text-slate-100 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition-colors placeholder-slate-600">
                    </div>
                    <div x-show="toolDropOpen && filteredTools().length > 0" x-cloak
                         class="absolute z-20 mt-1 w-full max-h-56 overflow-y-auto bg-slate-800 border border-slate-700 rounded-xl shadow-2xl">
                        <template x-for="t in filteredTools()" :key="t.barcode">
                            <button type="button"
                                    @click="selectTool(t)"
                                    class="w-full flex items-center gap-3 px-4 py-3 text-left hover:bg-slate-700/60 transition-colors border-b border-slate-700/50 last:border-0">
                                <div class="w-8 h-8 rounded-lg bg-sky-500/10 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-toolbox text-sky-400 text-xs"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-slate-200 truncate" x-text="t.name"></p>
                                    <p class="text-xs text-slate-500"><span class="font-mono" x-text="t.barcode"></span></p>
                                </div>
                            </button>
                        </template>
                    </div>
                    <div x-show="toolDropOpen && toolQuery.length > 0 && filteredTools().length === 0" x-cloak
                         class="absolute z-20 mt-1 w-full bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-4 text-center text-slate-500 text-sm">
                        No matching tools found
                    </div>
                </div>

                {{-- Hidden real input --}}
                <input type="hidden" name="barcode" x-model="selectedBarcode" required>

                {{-- Selected tool display --}}
                <div x-show="selectedTool" x-cloak
                     class="flex items-center gap-3 mt-3 px-4 py-3 rounded-xl bg-emerald-500/8 border border-emerald-500/20">
                    <div class="w-9 h-9 rounded-lg bg-emerald-500/15 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-check text-emerald-400 text-sm"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-emerald-300" x-text="selectedTool ? selectedTool.name : ''"></p>
                        <p class="text-xs text-slate-500">Barcode: <span class="font-mono text-emerald-400" x-text="selectedBarcode"></span></p>
                    </div>
                    <button type="button" @click="clearTool()" class="text-slate-500 hover:text-rose-400 transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            {{-- ── Employee: Searchable ── --}}
            <div x-data="employeePicker()" x-init="init()">
                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">
                    Employee <span class="text-rose-400">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-user text-slate-500"></i>
                    </div>
                    <input type="text"
                           x-model="empQuery"
                           @focus="empDropOpen = true"
                           @click.away="empDropOpen = false"
                           placeholder="Search by name or department…"
                           class="w-full pl-11 pr-4 py-3 rounded-xl bg-slate-800/50 border border-slate-700 text-slate-100 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition-colors placeholder-slate-600">

                    <div x-show="empDropOpen && filteredEmployees().length > 0" x-cloak
                         class="absolute z-20 mt-1 w-full max-h-56 overflow-y-auto bg-slate-800 border border-slate-700 rounded-xl shadow-2xl">
                        <template x-for="e in filteredEmployees()" :key="e.id">
                            <button type="button"
                                    @click="selectEmployee(e)"
                                    class="w-full flex items-center gap-3 px-4 py-3 text-left hover:bg-slate-700/60 transition-colors border-b border-slate-700/50 last:border-0">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center flex-shrink-0 text-xs font-bold text-white"
                                     x-text="e.name.charAt(0).toUpperCase()"></div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-slate-200 truncate" x-text="e.name"></p>
                                    <p class="text-xs text-slate-500" x-text="e.department + ' — ' + e.role"></p>
                                </div>
                            </button>
                        </template>
                    </div>
                    <div x-show="empDropOpen && empQuery.length > 0 && filteredEmployees().length === 0" x-cloak
                         class="absolute z-20 mt-1 w-full bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-4 text-center text-slate-500 text-sm">
                        No matching employees found
                    </div>
                </div>

                <input type="hidden" name="employee_id" x-model="selectedEmployeeId" required>

                {{-- Selected employee display --}}
                <div x-show="selectedEmployee" x-cloak
                     class="flex items-center gap-3 mt-3 px-4 py-3 rounded-xl bg-violet-500/8 border border-violet-500/20">
                    <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center flex-shrink-0 text-xs font-bold text-white"
                         x-text="selectedEmployee ? selectedEmployee.name.charAt(0).toUpperCase() : ''"></div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-violet-300" x-text="selectedEmployee ? selectedEmployee.name : ''"></p>
                        <p class="text-xs text-slate-500" x-text="selectedEmployee ? (selectedEmployee.department + ' — ' + selectedEmployee.role) : ''"></p>
                    </div>
                    <button type="button" @click="clearEmployee()" class="text-slate-500 hover:text-rose-400 transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                @error('employee_id') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- ── Date ── --}}
            <div>
                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Check Out Date &amp; Time <span class="text-rose-400">*</span></label>
                <input type="datetime-local" name="check_out_date" required
                       value="{{ old('check_out_date', \Carbon\Carbon::now()->format('Y-m-d\TH:i')) }}"
                       class="w-full px-4 py-3 rounded-xl bg-slate-800/50 border border-slate-700 text-slate-100 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition-colors">
                @error('check_out_date') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="px-6 py-2.5 bg-sky-500 hover:bg-sky-400 text-white text-sm font-semibold rounded-xl transition-colors shadow-lg shadow-sky-500/20">
                Confirm Check Out
            </button>
            <a href="{{ route('borrows.index') }}" class="px-6 py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-300 text-sm font-medium rounded-xl transition-colors">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
function toolPicker() {
    return {
        mode: 'scan',
        scanValue: '',
        toolQuery: '',
        toolDropOpen: false,
        selectedBarcode: '{{ old("barcode", "") }}',
        selectedTool: null,
        tools: {!! json_encode($tools->map->only(['barcode', 'name'])) !!},

        init() {
            if (this.selectedBarcode) {
                this.selectedTool = this.tools.find(t => t.barcode == this.selectedBarcode) || null;
            }
            this.$nextTick(() => {
                if (this.$refs.scanInput) this.$refs.scanInput.focus();
            });
        },

        matchScan() {
            const val = this.scanValue.trim();
            if (!val) return;
            const found = this.tools.find(t => t.barcode == val);
            if (found) {
                this.selectTool(found);
                this.scanValue = '';
            }
        },

        filteredTools() {
            const q = this.toolQuery.toLowerCase().trim();
            if (!q) return this.tools.slice(0, 20);
            return this.tools.filter(t =>
                t.name.toLowerCase().includes(q) || t.barcode.toString().includes(q)
            ).slice(0, 20);
        },

        selectTool(t) {
            this.selectedTool = t;
            this.selectedBarcode = t.barcode;
            this.toolDropOpen = false;
            this.toolQuery = '';
        },

        clearTool() {
            this.selectedTool = null;
            this.selectedBarcode = '';
            this.scanValue = '';
            this.toolQuery = '';
        }
    };
}

function employeePicker() {
    return {
        empQuery: '',
        empDropOpen: false,
        selectedEmployeeId: '{{ old("employee_id", "") }}',
        selectedEmployee: null,
        employees: {!! json_encode($employees->map->only(['id', 'name', 'department', 'role'])) !!},

        init() {
            if (this.selectedEmployeeId) {
                this.selectedEmployee = this.employees.find(e => e.id == this.selectedEmployeeId) || null;
            }
        },

        filteredEmployees() {
            const q = this.empQuery.toLowerCase().trim();
            if (!q) return this.employees.slice(0, 20);
            return this.employees.filter(e =>
                e.name.toLowerCase().includes(q) || e.department.toLowerCase().includes(q) || e.role.toLowerCase().includes(q)
            ).slice(0, 20);
        },

        selectEmployee(e) {
            this.selectedEmployee = e;
            this.selectedEmployeeId = e.id;
            this.empDropOpen = false;
            this.empQuery = '';
        },

        clearEmployee() {
            this.selectedEmployee = null;
            this.selectedEmployeeId = '';
            this.empQuery = '';
        }
    };
}
</script>
@endsection
