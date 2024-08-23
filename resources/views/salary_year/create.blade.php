@extends('layouts.main')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Input Salary Data Per Year</h6>
                        </div>
                    </div>

                    <div class="card-body p-3 pb-2">
                        <hr class="horizontal dark my-2">
                        <form action="{{ route('salary-year.store') }}" method="post" class="salary-year-form">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <button type="submit" class="btn btn-success btn-sm px-4">Save</button>
                                </div>
                                <div class="col">
                                    {{-- <div>
                                        Toggle column:
                                        <a class="toggle-vis" data-column="7">Salary Grade</a> -
                                        <a class="toggle-vis" data-column="8">Ability</a> -
                                        <a class="toggle-vis" data-column="9">Fungtional Alw</a> -
                                        <a class="toggle-vis" data-column="10">Family Alw</a> -
                                        <a class="toggle-vis" data-column="11">Transport Alw</a> -
                                        <a class="toggle-vis" data-column="12">Telephone Alw</a> -
                                        <a class="toggle-vis" data-column="13">Skill All</a> -
                                        <a class="toggle-vis" data-column="14">Adjustment</a>
                                    </div><br> --}}
                                    <div class="table-responsive p-0">
                                        <table class="table align-items-center small-tbl dtTableFix3 compact stripe hover">
                                            <thead class="bg-thead">
                                                <tr>
                                                    <th rowspan="2" class="text-center"
                                                        style="background-color: #1A73E8;color: white;">#
                                                    </th>
                                                    <th colspan="6" class="text-center p-0">Employee Identity</th>
                                                    <th colspan="8" class="text-center p-0">Salary Components</th>
                                                    <th rowspan="2" class="text-center">Allocation</th>
                                                    <th rowspan="2" class="text-center">Year</th>
                                                </tr>
                                                <tr class="">
                                                    <th style="background-color: #1A73E8;color: white;">Emp Code</th>
                                                    <th style="background-color: #1A73E8;color: white;">Name</th>
                                                    <th>Status</th>
                                                    <th>Dept</th>
                                                    <th>Job</th>
                                                    <th>Grade</th>
                                                    <th>Salary Grade</th>
                                                    <th>Ability</th>
                                                    <th>Fungtional All</th>
                                                    <th>Family All</th>
                                                    <th>Transport All</th>
                                                    <th>Telephone All</th>
                                                    <th>Skill All</th>
                                                    <th>Adjustment</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($users as $key => $user)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td class="text-nowrap text-end">{{ $user->nik }}</td>
                                                        <td>{{ $user->name }}</td>
                                                        <td>{{ $user->status }}</td>
                                                        <td>{{ $user->dept }}</td>
                                                        <td>{{ $user->jabatan }}</td>
                                                        <td>{{ $user->grade ?? '-' }}</td>
                                                        <td class="text-end">
                                                            @if ($user->grade)
                                                                {{ number_format($user->rate_salary, 0, ',', '.') }}
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <input type="hidden" name="id_user[]"
                                                                value="{{ $user->id_user }}">
                                                            <input type="hidden" name="id_salary_grade[]"
                                                                value="{{ $user->id_salary_grade ?? '' }}">
                                                            <input type="hidden" name="rate_salary[]"
                                                                value="{{ $user->rate_salary ?? '' }}">

                                                            <div class="input-group input-group-outline">
                                                                <input type="text"
                                                                    class="form-control form-control-sm number-format"
                                                                    style="width: 120px" name="ability[]"
                                                                    oninput="formatCurrency(this)"
                                                                    value="{{ $user->ability ?? '' }}"
                                                                    placeholder="Enter the ability">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group input-group-outline">
                                                                <input type="text"
                                                                    class="form-control form-control-sm number-format"
                                                                    style="width: 120px" name="fungtional_alw[]"
                                                                    oninput="formatCurrency(this)"
                                                                    value="{{ $user->fungtional_alw ?? '' }}"
                                                                    placeholder="Enter the fungtional allowance">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group input-group-outline">
                                                                <input type="text"
                                                                    class="form-control form-control-sm number-format"
                                                                    style="width: 120px" name="family_alw[]"
                                                                    oninput="formatCurrency(this)"
                                                                    value="{{ $user->family_alw ?? '' }}"
                                                                    placeholder="Enter the family allowance">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group input-group-outline">
                                                                <input type="text"
                                                                    class="form-control form-control-sm number-format"
                                                                    style="width: 120px" name="transport_alw[]"
                                                                    oninput="formatCurrency(this)"
                                                                    value="{{ $user->transport_alw ?? '' }}"
                                                                    placeholder="Enter the transport allowance">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group input-group-outline">
                                                                <input type="text"
                                                                    class="form-control form-control-sm number-format"
                                                                    style="width: 120px" name="telephone_alw[]"
                                                                    oninput="formatCurrency(this)"
                                                                    value="{{ $user->telephone_alw ?? '' }}"
                                                                    placeholder="Enter the telephone allowance">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group input-group-outline">
                                                                <input type="text"
                                                                    class="form-control form-control-sm number-format"
                                                                    style="width: 120px" name="skill_alw[]"
                                                                    oninput="formatCurrency(this)"
                                                                    value="{{ $user->skill_alw ?? '' }}"
                                                                    placeholder="Enter the skill allowance">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group input-group-outline">
                                                                <input type="text"
                                                                    class="form-control form-control-sm number-format"
                                                                    style="width: 120px" name="adjustment[]"
                                                                    oninput="formatCurrency(this)"
                                                                    value="{{ $user->adjustment ?? '' }}"
                                                                    placeholder="Enter the adjustment">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group input-group-outline">
                                                                <select class="form-select form-select-sm allocation"
                                                                    name="allocation[]"
                                                                    style="min-height: 20px;width: 100% !important;padding: 0 0 0 0;"
                                                                    data-placeholder="Select allocation"
                                                                    multiple="multiple">
                                                                    <option value="A">A</option>
                                                                    <option value="B">B</option>
                                                                    <option value="C">C</option>
                                                                    <option value="D">D</option>
                                                                    <option value="E">E</option>
                                                                    <option value="F">F</option>
                                                                    <option value="Factory">Factory</option>
                                                                    <option value="GAE">GAE</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td class="text-end">
                                                            {{ $currentYear }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function formatCurrency(input) {
            // Remove any non-digit characters
            let value = input.value.replace(/[^0-9.]/g, '');
            // Format the number with commas
            input.value = new Intl.NumberFormat().format(value);
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil semua elemen input dan select dalam form
            let inputs = document.querySelectorAll('.salary-year-form input, .salary-year-form select');

            // Fungsi untuk menemukan indeks elemen dalam NodeList
            function findIndex(element) {
                return Array.prototype.indexOf.call(inputs, element);
            }

            // Fungsi untuk berpindah ke elemen berikutnya atau sebelumnya berdasarkan baris dan kolom
            function moveFocus(currentIndex, direction) {
                const cols = 8; // Jumlah kolom yang memiliki input
                const rows = 11;
                let newIndex;

                if (direction === 'ArrowDown') {
                    newIndex = currentIndex + rows;
                } else if (direction === 'ArrowUp') {
                    newIndex = currentIndex - rows;
                } else if (direction === 'ArrowRight') {
                    newIndex = currentIndex + 1;
                } else if (direction === 'ArrowLeft') {
                    newIndex = currentIndex - 1;
                }

                if (newIndex >= 0 && newIndex < inputs.length) {
                    inputs[newIndex].focus();
                }
            }

            // Tambahkan event listener pada setiap input dan select
            inputs.forEach(function(input) {
                input.addEventListener('keydown', function(e) {
                    const currentIndex = findIndex(e.target);
                    if (['ArrowDown', 'ArrowUp', 'ArrowRight', 'ArrowLeft'].includes(e.key)) {
                        e.preventDefault();
                        moveFocus(currentIndex, e.key);
                    }
                });
            });
        });
    </script>
@endsection
