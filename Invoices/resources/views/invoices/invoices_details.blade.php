@extends('layouts.master')
@section('css')
    <!---Internal  Prism css-->
    <link href="{{ URL::asset('assets/plugins/prism/prism.css') }}" rel="stylesheet">
    <!---Internal Input tags css-->
    <link href="{{ URL::asset('assets/plugins/inputtags/inputtags.css') }}" rel="stylesheet">
    <!--- Custom-scroll -->
    <link href="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">قائمة الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    تفاصيل الفاتورة</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session()->has('Delete'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-lg-12 col-md-12">

            <div class="col-xl-12">
                <!-- div -->
                <div class="card mg-b-20" id="tabs-style2">
                    <div class="card-body">
                        <div class="text-wrap">
                            <div class="example">
                                <div class="panel panel-primary tabs-style-2">
                                    <div class=" tab-menu-heading">
                                        <div class="tabs-menu1">
                                            <!-- Tabs -->
                                            <ul class="nav panel-tabs main-nav-line">
                                                <li><a href="#tab4" class="nav-link active" data-toggle="tab">معلومات
                                                        الفاتورة</a>
                                                </li>
                                                <li><a href="#tab5" class="nav-link" data-toggle="tab">حالات الدفع</a>
                                                </li>
                                                <li><a href="#tab6" class="nav-link" data-toggle="tab">مرفقات الفاتورة</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="panel-body tabs-menu-body main-content-body-right border">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab4">
                                                <div class="table-responsive">
                                                    <table id="example2" class="table key-buttons text-md-nowrap"
                                                        data-page-length="50">
                                                        <thead>
                                                            <tr>
                                                                <th class="border-bottom-0">#</th>
                                                                <th class="border-bottom-0">رقم الفاتورة</th>
                                                                <th class="border-bottom-0">تاريخ القاتورة</th>
                                                                <th class="border-bottom-0">تاريخ الاستحقاق</th>
                                                                <th class="border-bottom-0">المنتج</th>
                                                                <th class="border-bottom-0">القسم</th>
                                                                <th class="border-bottom-0">الخصم</th>
                                                                <th class="border-bottom-0">نسبة الضريبة</th>
                                                                <th class="border-bottom-0">قيمة الضريبة</th>
                                                                <th class="border-bottom-0">الاجمالي</th>
                                                                <th class="border-bottom-0">الحالة</th>
                                                                <th class="border-bottom-0">ملاحظات</th>
                                                                {{-- <th class="border-bottom-0">العمليات</th> --}}
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $i = 1;
                                                            @endphp
                                                            <tr>
                                                                <td>{{ $i }}</td>
                                                                <td>{{ $invoice->invoice_number }} </td>
                                                                <td>{{ $invoice->invoice_Date }}</td>
                                                                <td>{{ $invoice->Due_date }}</td>
                                                                <td>{{ $invoice->product }}</td>
                                                                <td>{{ $invoice->category->name }}
                                                                </td>
                                                                <td>{{ $invoice->Discount }}</td>
                                                                <td>{{ $invoice->Rate_VAT }}</td>
                                                                <td>{{ $invoice->Value_VAT }}</td>
                                                                <td>{{ $invoice->Total }}</td>
                                                                <td>
                                                                    @if ($invoice->Value_Status == 1)
                                                                        <span
                                                                            class="text-success">{{ $invoice->Status }}</span>
                                                                    @elseif($invoice->Value_Status == 2)
                                                                        <span
                                                                            class="text-danger">{{ $invoice->Status }}</span>
                                                                    @else
                                                                        <span
                                                                            class="text-warning">{{ $invoice->Status }}</span>
                                                                    @endif

                                                                </td>

                                                                <td>{{ $invoice->note }}</td>

                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="tab5">
                                                <div class="table-responsive">
                                                    <table id="example2" class="table key-buttons text-md-nowrap"
                                                        data-page-length="50">
                                                        <thead>

                                                            <tr class="text-dark">
                                                                <th>#</th>
                                                                <th>رقم الفاتورة</th>
                                                                <th>نوع المنتج</th>
                                                                <th>القسم</th>
                                                                <th>حالة الدفع</th>
                                                                <th>تاريخ الدفع </th>
                                                                <th>ملاحظات</th>
                                                                <th>تاريخ الاضافة </th>
                                                                <th>المستخدم</th>
                                                                {{-- <th>العمليات</th> --}}
                                                            </tr>

                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $i = 0;
                                                            @endphp
                                                            @foreach ($invoices_details as $invoice_detail)
                                                                @php
                                                                    $i++;
                                                                @endphp
                                                                <tr>
                                                                    <td>{{ $i }}</td>
                                                                    <td>{{ $invoice_detail->invoice_number }} </td>
                                                                    <td>{{ $invoice_detail->product }}</td>
                                                                    <td>{{ $invoice->category->name }}
                                                                    </td>
                                                                    @if ($invoice_detail->Value_Status == 1)
                                                                        <td><span
                                                                                class="badge badge-pill badge-success">{{ $invoice_detail->Status }}</span>
                                                                        </td>
                                                                    @elseif($invoice_detail->Value_Status == 2)
                                                                        <td><span
                                                                                class="badge badge-pill badge-danger">{{ $invoice_detail->Status }}</span>
                                                                        </td>
                                                                    @else
                                                                        <td><span
                                                                                class="badge badge-pill badge-warning">{{ $invoice_detail->Status }}</span>
                                                                        </td>
                                                                    @endif
                                                                    <td>{{ $invoice_detail->Payment_Date }}</td>
                                                                    <td>{{ $invoice_detail->note }}</td>
                                                                    <td>{{ $invoice_detail->created_at }}</td>
                                                                    <td>{{ $invoice_detail->user }}</td>
                                                                    {{-- <td>
                                                                        <div class="dropdown">
                                                                            <button aria-expanded="false"
                                                                                aria-haspopup="true"
                                                                                class="btn ripple btn-primary btn-sm"
                                                                                data-toggle="dropdown"
                                                                                type="button">العمليات<i
                                                                                    class="fas fa-caret-down ml-1"></i></button>
                                                                            <div class="dropdown-menu tx-13">

                                                                                <a class="dropdown-item"
                                                                                    href=" {{ route('invoice_details.edit', $invoice->id) }}">تعديل
                                                                                    الفاتورة</a>

                                                                            </div>
                                                                        </div>

                                                                    </td> --}}
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="tab6">
                                                <div class="card-body">
                                                    <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                                                    <h5 class="card-title">اضافة مرفقات</h5>
                                                    <form method="post" action="{{ route('invoice_attachments.store') }}"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input"
                                                                id="customFile" name="file_name" required>
                                                            <input type="hidden" id="customFile" name="invoice_number"
                                                                value="{{ $invoice->invoice_number }}">
                                                            <input type="hidden" id="invoice_id" name="invoice_id"
                                                                value="{{ $invoice->id }}">
                                                            <label class="custom-file-label" for="customFile">حدد
                                                                المرفق</label>
                                                        </div><br><br>
                                                        <button type="submit" class="btn btn-primary btn-sm "
                                                            name="uploadedFile">تاكيد</button>
                                                    </form>
                                                </div>

                                                <br>
                                                <div class="table-responsive">
                                                    <table id="example2" class="table key-buttons text-md-nowrap"
                                                        data-page-length="50">
                                                        <thead>
                                                            <tr class="text-dark">
                                                                <th scope="col">م</th>
                                                                <th scope="col">اسم الملف</th>
                                                                <th scope="col">قام بالاضافة</th>
                                                                <th scope="col">تاريخ الاضافة</th>
                                                                <th scope="col">العمليات</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $i = 0;
                                                            @endphp
                                                            @foreach ($invoices_attachments as $invoice_attachment)
                                                                @php
                                                                    $i++;
                                                                @endphp
                                                                <tr>
                                                                    <td>{{ $i }}</td>
                                                                    <td>{{ $invoice_attachment->file_name }} </td>
                                                                    <td>{{ $invoice_attachment->Created_by }}</td>
                                                                    <td>{{ $invoice_attachment->created_at }}</td>
                                                                    <td colspan="2">
                                                                        <a class="btn btn-outline-success btn-sm"
                                                                            href="{{ route('view_file', ['invoice_number' => $invoice->invoice_number, 'file_name' => $invoice_attachment->file_name]) }}"
                                                                            role="button" target="_blank"><i
                                                                                class="fas fa-eye"></i>&nbsp;
                                                                            عرض</a>

                                                                        <a class="btn btn-outline-info btn-sm"
                                                                            href="{{ route('download', ['invoice_number' => $invoice->invoice_number, 'file_name' => $invoice_attachment->file_name]) }}"
                                                                            role="button"><i
                                                                                class="fas fa-download"></i>&nbsp;
                                                                            تحميل</a>

                                                                        <button class="btn btn-outline-danger btn-sm"
                                                                            data-toggle="modal"
                                                                            data-file_name="{{ $invoice_attachment->file_name }}"
                                                                            data-invoice_number="{{ $invoice_attachment->invoice_number }}"
                                                                            data-id_file="{{ $invoice_attachment->id }}"
                                                                            data-target="#delete_file">حذف</button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /div -->
            </div>
            <!-- /div -->
            <!-- /row -->
            <!-- delete -->
            <div class="modal fade" id="delete_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">حذف المرفق</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('delete_file') }}" method="post">
                            @csrf
                            <div class="modal-body">
                                <p class="text-center">
                                <h6 style="color:red"> هل انت متاكد من عملية حذف المرفق ؟</h6>
                                </p>

                                <input type="hidden" name="id_file" id="id_file" value="">
                                <input type="hidden" name="file_name" id="file_name" value="">
                                <input type="hidden" name="invoice_number" id="invoice_number" value="">

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                                <button type="submit" class="btn btn-danger">تاكيد</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Internal Jquery.mCustomScrollbar js-->
    <script src="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <!-- Internal Input tags js-->
    <script src="{{ URL::asset('assets/plugins/inputtags/inputtags.js') }}"></script>
    <!--- Tabs JS-->
    <script src="{{ URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js') }}"></script>
    <script src="{{ URL::asset('assets/js/tabs.js') }}"></script>
    <!--Internal  Clipboard js-->
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.js') }}"></script>
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!-- Internal Prism js-->
    <script src="{{ URL::asset('assets/plugins/prism/prism.js') }}"></script>
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
    <script>
        $('#delete_file').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id_file = button.data('id_file')
            var file_name = button.data('file_name')
            var invoice_number = button.data('invoice_number')
            var modal = $(this)

            modal.find('.modal-body #id_file').val(id_file);
            modal.find('.modal-body #file_name').val(file_name);
            modal.find('.modal-body #invoice_number').val(invoice_number);
        })
    </script>
    <script>
        //the name of the file appear on select
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>
@endsection
