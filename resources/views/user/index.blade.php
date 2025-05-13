@extends('layouts.main')
<!-- Toastr -->
<link href="{{('https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css')}}" rel="stylesheet"/>
<script src="{{('https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js')}}"></script>
@section('content')
    {{-- Bagian  Isi Konten --}}
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Employees Data</h6>
                    </div>
                </div>

                <div class="card-body p-3 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table table-striped table-hover dtTable2 align-items-center small_tbl compact">
                            <thead class="bg-thead">
                                <tr>
                                    <th>No</th>
                                    <th>Emp Code</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Grade</th>
                                    <th>Dept</th>
                                    <th>Job</th>
                                    <th>Sex</th>
                                    <th>Ttl</th>
                                    <th>Start</th>
                                    <th>Education</th>
                                    <th>Religion</th>
                                    <th>Domisili</th>
                                    <th>Email</th>
                                    <th>No Ktp</th>
                                    <th>No Telpon</th>
                                    <th>Kis</th>
                                    <th>Kpj</th>
                                    <th>Active</th>
                                    <th>BPJS</th>
                                    <th>Jamsostek</th>
                                    <th>SPSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $key => $user)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $user->nik }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->status }}</td>
                                        <td>{{ $user->grade ?? '-' }}</td>
                                        <td>{{ $user->dept }}</td>
                                        <td>{{ $user->jabatan }}</td>
                                        <td>{{ $user->sex }}</td>
                                        <td>{{ $user->ttl }}</td>
                                        <td>{{ $user->start }}</td>
                                        <td>{{ $user->pendidikan }}</td>
                                        <td>{{ $user->agama }}</td>
                                        <td>{{ $user->domisili }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->no_ktp }}</td>
                                        <td>{{ $user->no_telpon }}</td>
                                        <td>{{ $user->kis }}</td>
                                        <td>{{ $user->kpj }}</td>
                                        <td>{{ $user->active }}</td>
                                        <form id="user-form-{{ $user->id }}">
                                            @csrf
                                            @method('PUT')

                                            <td>
                                                <input type="hidden" name="is_bpjs" value="0">
                                                <input type="checkbox" name="is_bpjs" value="1"
                                                    {{ $user->is_bpjs ? 'checked' : '' }} class="checkbox-update"
                                                    data-user-id="{{ $user->id }}">
                                            </td>

                                            <td>
                                                <input type="hidden" name="is_jamsostek" value="0">
                                                <input type="checkbox" name="is_jamsostek" value="1"
                                                    {{ $user->is_jamsostek ? 'checked' : '' }} class="checkbox-update"
                                                    data-user-id="{{ $user->id }}">
                                            </td>

                                            <td>
                                                <input type="hidden" name="is_union" value="0">
                                                <input type="checkbox" name="is_union" value="1"
                                                    {{ $user->is_union ? 'checked' : '' }} class="checkbox-update"
                                                    data-user-id="{{ $user->id }}">
                                            </td>
                                        </form>


                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- /Bagian  Isi Konten --}}
@endsection
<script src="{{('https://code.jquery.com/jquery-3.6.0.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $('.checkbox-update').on('change', function() {
            const userId = $(this).data('user-id');
            const form = $('#user-form-' + userId);
            const url = "{{ route('user.update', ['user' => 'USER_ID']) }}".replace('USER_ID', userId);
            // Serialize the form data
            const formData = form.serialize();

            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-HTTP-Method-Override': 'PUT'
                },
                success: function(response) {
                    console.log('Updated successfully');
                   toastr.success('User updated successfully');
                },
                error: function(xhr) {
                    console.error('Update failed', xhr.responseText);
                    toastr.error('Failed to update user');
                    // Optionally show an error message
                }
            });
        });
    });
</script>
