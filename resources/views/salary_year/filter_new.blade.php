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

                    <form action="{{ route('salary-year.create-new') }}" method="POST">
                        @csrf
                        <div class="card-body p-3 pb-2">
                            <div class="row">
                                <div class="col-auto">
                                    <select name="id_status" class="form-select form-select-sm" id="select-data">
                                        <option value="">- Pilih Status -</option>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status->id }}"
                                                @if ($status->id == $selectedStatus) selected @endif>{{ $status->name_status }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <a type="button" href="{{ route('salary-year') }}"
                                        class="btn btn-outline-secondary btn-sm mb-2">Cancel</a>
                                    <button class="btn btn-primary btn-sm mb-2">Submit</button>
                                </div>
                            </div>
                        </div>
                        <div id="data-container" class="mx-3 my-3"></div>
                    </form>
                </div>
            </div>
        </div>

        <script src="{{ asset('assets/libs/jquery/jquery.js') }}"></script>
        <script>
            $(document).ready(function(){
                // Handle "Select All" checkbox
                $('#data-container').on('change', '#checkboxAll', function(){
                    $('.checkboxItem').prop('checked', $(this).prop('checked'));
                });

                // Handle change event on the select element
                $('#select-data').change(function(){
                    var selectedValue = $(this).val();
                    $.ajax({
                        url: "{{ route('salary-year.get-emp') }}",
                        type: "GET",
                        data: { id_status: selectedValue },
                        dataType: "json",
                        success: function(data){
                            var content = '<table class="table table-data" id="data-table" style="width: 100%">';
                            if (data.length > 0) {
                                content += `
                                    <thead class="bg-success text-light">
                                        <tr>
                                            <th><input type="checkbox" id="checkboxAll"></th>
                                            <th>NIK</th>
                                            <th>Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                `;
                            }
                            $.each(data, function(index, item){
                                content += `
                                    <tr>
                                        <td><input type="checkbox" class="checkboxItem" value="${item.id}" name="id[]"></td>
                                        <td>${item.nik}</td>
                                        <td>${item.name}</td>
                                    </tr>
                                `;
                            });
                            content += '</tbody></table>';
                            $('#data-container').html(content);

                            // Initialize DataTable
                            $('#data-table').DataTable();
                        }
                    });
                });
            });
        </script>
    @endsection
