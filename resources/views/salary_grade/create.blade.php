@extends('layouts.main')
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Input Data Gaji Per Grade</h6>
                        </div>
                    </div>

                    <div class="card-body p-3 pb-2">
                        <div class="row">
                            <div class="col">
                                <button type="button" class="btn btn-success btn-sm">Simpan</button>
                                <a type="button" href="{{ route('salarygrade.index') }}"
                                    class="btn btn-outline-secondary btn-sm">Kembali</a>
                            </div>
                        </div>
                        <div class="table-responsive p-0">
                            <table class="table table-sm align-items-center mb-0 dtTable small-tbl compact stripe">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Grade</th>
                                        {{-- <th>Status</th>
                                        <th>Dept</th>
                                        <th>Job</th> --}}
                                        <th>Salary Grade</th>
                                        <th>Year</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td> II-A1 </td>
                                        {{-- <td>Monthly</td>
                                        <td>BSKP</td>
                                        <td>Operator</td> --}}
                                        <td><input type="text" id="sal_grade" name="sal_grade" value=""
                                                placeholder="Besar gaji per grade"></td>
                                        <td>2024</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>II-A2</td>
                                        <td><input type="text" id="sal_grade" name="sal_grade" value=""
                                                placeholder="Besar gaji per grade"></td>
                                        <td>2024</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>II-A2</td>
                                        <td><input type="text" id="sal_grade" name="sal_grade" value=""
                                                placeholder="Besar gaji per grade"></td>
                                        <td>2024</td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>II-A3</td>
                                        <td><input type="text" id="sal_grade" name="sal_grade" value=""
                                                placeholder="Besar gaji per grade"></td>
                                        <td>2024</td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>II-A4</td>
                                        <td><input type="text" id="sal_grade" name="sal_grade" value=""
                                                placeholder="Besar gaji per grade"></td>
                                        <td>2024</td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td> II-B1 </td>
                                        <td><input type="text" id="sal_grade" name="sal_grade" value=""
                                                placeholder="Besar gaji per grade"></td>
                                        <td>2024</td>
                                    </tr>
                                    <tr>
                                        <td>7</td>
                                        <td>II-B2</td>
                                        <td><input type="text" id="sal_grade" name="sal_grade" value=""
                                                placeholder="Besar gaji per grade"></td>
                                        <td>2024</td>
                                    </tr>
                                    <tr>
                                        <td>8</td>
                                        <td>II-B3</td>
                                        <td><input type="text" id="sal_grade" name="sal_grade" value=""
                                                placeholder="Besar gaji per grade"></td>
                                        <td>2024</td>
                                    </tr>
                                    <tr>
                                        <td>9</td>
                                        <td>II-B4</td>
                                        <td><input type="text" id="sal_grade" name="sal_grade" value=""
                                                placeholder="Besar gaji per grade"></td>
                                        <td>2024</td>
                                    </tr>
                                    <tr>
                                        <td>10</td>
                                        <td>II-B5</td>
                                        <td><input type="text" id="sal_grade" name="sal_grade" value=""
                                                placeholder="Besar gaji per grade"></td>
                                        <td>2024</td>
                                    </tr>
                                    <tr>
                                        <td>11</td>
                                        <td>II-C1</td>
                                        <td><input type="text" id="sal_grade" name="sal_grade" value=""
                                                placeholder="Besar gaji per grade"></td>
                                        <td>2024</td>
                                    </tr>
                                    <tr>
                                        <td>12</td>
                                        <td>II-C2</td>
                                        <td><input type="text" id="sal_grade" name="sal_grade" value=""
                                                placeholder="Besar gaji per grade"></td>
                                        <td>2024</td>
                                    </tr>
                                    <tr>
                                        <td>13</td>
                                        <td>II-C3</td>
                                        <td><input type="text" id="sal_grade" name="sal_grade" value=""
                                                placeholder="Besar gaji per grade"></td>
                                        <td>2024</td>
                                    </tr>
                                    <tr>
                                        <td>14</td>
                                        <td>II-C4</td>
                                        <td><input type="text" id="sal_grade" name="sal_grade" value=""
                                                placeholder="Besar gaji per grade"></td>
                                        <td>2024</td>
                                    </tr>
                                    <tr>
                                        <td>15</td>
                                        <td>II-D1</td>
                                        <td><input type="text" id="sal_grade" name="sal_grade" value=""
                                                placeholder="Besar gaji per grade"></td>
                                        <td>2024</td>
                                    </tr>
                                    <tr>
                                        <td>16</td>
                                        <td>II-D2</td>
                                        <td><input type="text" id="sal_grade" name="sal_grade" value=""
                                                placeholder="Besar gaji per grade"></td>
                                        <td>2024</td>
                                    </tr>
                                    <tr>
                                        <td>17</td>
                                        <td>II-D3</td>
                                        <td><input type="text" id="sal_grade" name="sal_grade" value=""
                                                placeholder="Besar gaji per grade"></td>
                                        <td>2024</td>
                                    </tr>
                                    <tr>
                                        <td>18</td>
                                        <td>III-A</td>
                                        <td><input type="text" id="sal_grade" name="sal_grade" value=""
                                                placeholder="Besar gaji per grade"></td>
                                        <td>2024</td>
                                    </tr>
                                    <tr>
                                        <td>19</td>
                                        <td>III-A</td>
                                        <td><input type="text" id="sal_grade" name="sal_grade" value=""
                                                placeholder="Besar gaji per grade"></td>
                                        <td>2024</td>
                                    </tr>
                                    <tr>
                                        <td>20</td>
                                        <td>III-A1</td>
                                        <td><input type="text" id="sal_grade" name="sal_grade" value=""
                                                placeholder="Besar gaji per grade"></td>
                                        <td>2024</td>
                                    </tr>
                                    <tr>
                                        <td>21</td>
                                        <td>III-B</td>
                                        <td><input type="text" id="sal_grade" name="sal_grade" value=""
                                                placeholder="Besar gaji per grade"></td>
                                        <td>2024</td>
                                    </tr>
                                    <tr>
                                        <td>22</td>
                                        <td>III-C</td>
                                        <td><input type="text" id="sal_grade" name="sal_grade" value=""
                                                placeholder="Besar gaji per grade"></td>
                                        <td>2024</td>
                                    </tr>
                                    <tr>
                                        <td>23</td>
                                        <td>III-D</td>
                                        <td><input type="text" id="sal_grade" name="sal_grade" value=""
                                                placeholder="Besar gaji per grade"></td>
                                        <td>2024</td>
                                    </tr>
                                    <tr>
                                        <td>24</td>
                                        <td>IV-A</td>
                                        <td><input type="text" id="sal_grade" name="sal_grade" value=""
                                                placeholder="Besar gaji per grade"></td>
                                        <td>2024</td>
                                    </tr>
                                    <tr>
                                        <td>25</td>
                                        <td>V-A</td>
                                        <td><input type="text" id="sal_grade" name="sal_grade" value=""
                                                placeholder="Besar gaji per grade"></td>
                                        <td>2024</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
