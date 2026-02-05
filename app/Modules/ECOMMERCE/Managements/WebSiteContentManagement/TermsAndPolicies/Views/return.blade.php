@extends('tenant.admin.layouts.app')

@section('header_css')
    <link href="{{ asset('tenant/admin/assets') }}/plugins/dropify/dropify.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endsection

@section('page_title')
    Return Policy
@endsection
@section('page_heading')
    Update Return Policy
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Return Policy Update Form</h4>

                    <form class="needs-validation" method="POST" action="{{ route('UpdateReturnPolicy') }}"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="return_policy_bg">Banner Background Image (1920px X 400px)</label>
                                    <input type="file" name="return_policy_bg" class="dropify" data-height="250"
                                        data-max-file-size="2M" accept="image/*" />
                                    <div class="invalid-feedback" style="display: block;">
                                        @error('return_policy_bg')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-9 border-left">
                                <div class="form-group">
                                    <label for="return">Write Return Policies Here :</label>
                                    <textarea id="return" name="return" class="form-control">{!! $data->return_policy !!}</textarea>
                                    <div class="invalid-feedback" style="display: block;">
                                        @error('return')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group text-center pt-3">
                            <button class="btn btn-primary" type="submit">Update Return Policy</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('footer_js')
    <script src="{{ asset('tenant/admin/assets') }}/plugins/dropify/dropify.min.js"></script>
    <script src="{{ asset('tenant/admin/assets') }}/pages/fileuploads-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script type="text/javascript">
        $('#return').summernote({
            placeholder: 'Write Return Policy Here',
            tabsize: 2,
            height: 350
        });

        // Preview existing background image
        @if ($data && $data->return_policy_bg && file_exists(public_path($data->return_policy_bg)))
            $(".dropify-preview").eq(0).css("display", "block");
            $(".dropify-clear").eq(0).css("display", "block");
            $(".dropify-filename-inner").eq(0).html("{{ $data->return_policy_bg }}");
            $("span.dropify-render").eq(0).html(
                "<img src='{{ url($data->return_policy_bg) }}' style='max-height: 250px; object-fit: contain;'>");
        @endif
    </script>
@endsection
