<script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
</script>

<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>


<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="{{ asset('assets/js/material-dashboard.min.js?v=3.1.0') }}"></script>

<!-- Script Datatable -->
<script>
    $(document).ready(function() {
        $('.dtTable').DataTable({
            "lengthChange": true,
            "autoWidth": true,
            "initComplete": function(settings, json) {
                $(".dtTable").wrap(
                    "<div style='overflow:auto; width:100%;position:relative;'></div>");
            },
            "lengthMenu": [
                [10, 50, 100, 200, -1],
                [10, 50, 100, 200, "All"]
            ], // Customize the entries per page
            "pageLength": 100
        });
    })
</script>
<script>
    $(document).ready(function() {
        $('.dtTableFix5').DataTable({
            "lengthChange": true,
            "autoWidth": true,
            "initComplete": function(settings, json) {
                $(".dtTableFix5").wrap(
                    "<div style='overflow:auto; width:100%;position:relative;'></div>");
            },
            "fixedColumns": {
                leftColumns: 5,
            },
        });
    })
</script>
<script>
    $(document).ready(function() {
        $('.dtTableFix3').DataTable({
            "lengthChange": true,
            "autoWidth": true,
            "initComplete": function(settings, json) {
                $(".dtTableFix3").wrap(
                    "<div style='overflow:auto; width:100%;position:relative;'></div>");
            },
            "fixedColumns": {
                leftColumns: 3,
            },
            "searching": false,
            "lengthMenu": [
                [10, 50, 100, 200, -1],
                [10, 50, 100, 200, "All"]
            ], // Customize the entries per page
            "pageLength": -1
        });
    })
</script>
<script>
    $(document).ready(function() {
        $('.dtTableFix2').DataTable({
            "lengthChange": true,
            "autoWidth": true,
            "initComplete": function(settings, json) {
                $(".dtTableFix2").wrap(
                    "<div style='overflow:auto; width:100%;position:relative;'></div>");
            },
            "fixedColumns": {
                leftColumns: 2,
            },
        });
    })
</script>
<!-- Script Datatable -->
<script>
    var table = $('#dtTableinput').DataTable({
        columnDefs: [{
            orderable: false,
            targets: [1, 2, 3]
        }]
    });

    // $('button').on('click', function(e) {
    //     e.preventDefault();

    //     var data = table.$('input, select').serialize();

    //     alert(
    //         'The following data would have been submitted to the server: \n\n' +
    //         data.substr(0, 120) +
    //         '...'
    //     );
    // });
</script>

{{-- SCRIPT FORM VALIDATION --}}
<script>
    // fungsi untuk mereset elemen form
    function resetForm(formId) {
        var form = $('.' + formId);

        // Menghapus kelas is-invalid dan is-valid dari semua elemen dalam formulir
        form.find('.input-group').removeClass('is-invalid is-valid');
        form.find('.is-valid').removeClass('is-valid');
        form.find('.is-invalid').removeClass('is-invalid');

        // Menghapus pesan kesalahan yang ditambahkan oleh jQuery Validation
        form.find('.invalid-feedback').remove();

        // Menghapus nilai input
        form[0].reset();

        // Mereset status validasi
        form.validate().reset();
    }

    // fungsi memberikan rule dan pesan serta elemen pada form
    $(function() {
        // custom rules
        jQuery.validator.addMethod("letter", function(value, element) {
            return this.optional(element) || /^[A-Za-z.',-\s]+$/.test(value);
        }, "Inputan harus berupa huruf!");

        jQuery.validator.addMethod("alphanum", function(value, element) {
            return this.optional(element) || /^[a-z][a-z0-9\._]*$/.test(value);
        }, "Inputan harus berupa dan diawali huruf kecil, angka, underscore (_), atau titik (.) ");

        // variable untuk rule yg sama
        var req = "Data harus diisi!"
        var chose = "Data harus dipilih!"
        var element = {
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.input-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
                $(element).closest('.input-group').removeClass('is-valid').addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
                var parentInputGroup = $(element).closest('.input-group');
                if (parentInputGroup.find('.is-invalid').length == 0) {
                    parentInputGroup.removeClass('is-invalid').addClass('is-valid');
                }
            }
            // highlight: function(element, errorClass, validClass) {
            //     $(element).addClass('is-invalid');
            // },
            // unhighlight: function(element, errorClass, validClass) {
            //     $(element).removeClass('is-invalid');
            // }
        };

        // Validasi untuk data status
        $('.add_edit_status').each(function() {
            var form = $(this);
            form.validate({
                rules: {
                    name_status: {
                        required: true,
                    },
                },
                ...element
            })
        });

        // Validasi untuk data grade
        $('.add_edit_grade').each(function() {
            var form = $(this);
            form.validate({
                rules: {
                    name_grade: {
                        required: true,
                    },
                },
                ...element
            })
        });
        // Validasi untuk data dept
        $('.add_edit_dept').each(function() {
            var form = $(this);
            form.validate({
                rules: {
                    name_dept: {
                        required: true,
                    },
                },
                ...element
            })
        });
        // Validasi untuk data job
        $('.add_edit_job').each(function() {
            var form = $(this);
            form.validate({
                rules: {
                    name_job: {
                        required: true,
                    },
                },
                ...element
            })
        });
    });
</script>

<script>
    // fungsi memberikan rule dan pesan serta elemen pada form
    $(function() {
        // custom rules
        jQuery.validator.addMethod("letter", function(value, element) {
            return this.optional(element) || /^[A-Za-z.',-\s]+$/.test(value);
        }, "Input must alphabet!");

        // Menambahkan aturan validasi untuk input number
        jQuery.validator.addMethod("positiveNum", function(value, element) {
            return value > 0;
        }, "Please enter a positive number.");

        jQuery.validator.addMethod("validNum", function(value, element) {
            // Use regex to check if the input contains only numbers
            return /^[0-9]+$/.test(value);
        }, "Please enter a valid number");

        // variable untuk rule yg sama
        var element = {
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.input-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        };

        // Validasi untuk data status
        $('.salary-grade-form').each(function() {
            var form = $(this);
            form.validate({
                rules: {
                    @if (isset($grades))
                        @foreach ($grades as $grade)
                            "rate_salary[{{ $grade->id }}]": {
                                required: true,
                                positiveNum: true,
                                validNum: true
                            },
                        @endforeach
                    @endif
                },
                ...element
            })
        });
    });
</script>
