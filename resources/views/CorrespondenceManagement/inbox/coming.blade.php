@extends('new')

@section('content')
<div class="container" dir="rtl">

    {{-- Header --}}
    <div class="d-flex justify-content-between mb-3">
        <h4>اسناد</h4>

        <div>
            <button class="btn btn-outline-primary me-2"
                data-bs-toggle="collapse"
                data-bs-target="#searchBox">
                🔍 سرچ
            </button>

            <a href="{{ route('documents.create') }}"
               class="btn btn-success">
                ➕ اضافه کول
            </a>
        </div>
    </div>

    {{-- Search --}}
    <div class="collapse mb-3" id="searchBox">
        <div class="card card-body">
            <form method="GET">
                <div class="row">

                    <div class="col-md-3">
                        <input type="text" name="document_no"
                            placeholder="د سند شمېره"
                            class="form-control">
                    </div>

                    <div class="col-md-3">
                        <input type="text" name="subject"
                            placeholder="موضوع"
                            class="form-control">
                    </div>

                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">حالت</option>
                            <option>pending</option>
                            <option>completed</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <button class="btn btn-primary w-100">
                            لټون
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>#</th>
                <th>شمېره</th>
                <th>موضوع</th>
                <th>لیږونکی</th>
                <th>ترلاسه کوونکی</th>
                <th>حالت</th>
                <th>Deadline</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
   
    <tr>
        <td>#</td>
          <td>#</td>
            <td>#</td>
              <td>#</td>
                <td>#</td>
                  <td>#</td>
                    <td>#</td>
                      <td>#</td>
       
        <td>
            <a href="#"
               class="btn btn-warning btn-sm">✏</a>
        </td>
    </tr>
</tbody>
    </table>

  

</div>
@endsection