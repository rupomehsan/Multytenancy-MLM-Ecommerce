@extends('tenant.admin.layouts.app')

@section('header_css')
    <link href="{{ asset('tenant/admin/assets') }}/plugins/dropify/dropify.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('tenant/admin/assets') }}/plugins/select2/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('tenant/admin/assets') }}/css/tagsinput.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <style>
        .select2-selection {
            height: 34px !important;
            border: 1px solid #ced4da !important;
        }

        .select2 {
            width: 100% !important;
        }

        .bootstrap-tagsinput .badge {
            margin: 2px 2px !important;
        }

        .video-preview-container {
            border: 1px solid #e3e3e3;
            border-radius: 4px;
            padding: 10px;
            background: #f8f9fa;
        }

        .video-preview-container iframe,
        .video-preview-container video {
            max-width: 100%;
            border-radius: 4px;
        }

        .video-instructions {
            font-size: 12px;
            color: #6c757d;
            margin-top: 5px;
        }

        .video-instructions code {
            background: #e9ecef;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 11px;
        }
    </style>
@endsection

@section('page_title')
    Video Gallery
@endsection
@section('page_heading')
    Edit Video Gallery
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title mb-3">Update Form</h4>
                        <a href="{{ route('ViewAllVideoGallery') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>


                    <form class="needs-validation" method="POST" action="{{ route('UpdateVideoGallery') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="video_gallery_id" value="{{ $data->id }}">
                        <div class="row">
                            <div class="col-lg-12">

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="title">Title <span class="text-danger">*</span></label>
                                            <input type="text" id="title" name="title" class="form-control"
                                                value="{{ $data->title }}" placeholder="Enter Product Title Here" required>
                                            <div class="invalid-feedback" style="display: block;">
                                                @error('title')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select name="status" id="status" class="form-control custom-select">
                                                <option value="active" {{ $data->status == 'active' ? 'selected' : '' }}>
                                                    Active</option>
                                                <option value="inactive"
                                                    {{ $data->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>



                                        <div class="form-group">
                                            <label for="source">Video Source <span class="text-danger">*</span></label>
                                            <textarea id="source" name="source" class="form-control" cols="7" rows="6" placeholder="Paste YouTube/Vimeo URL or embed code here" required>{{ $data->source }}</textarea>
                                            <div class="video-instructions">
                                                <strong>Instructions:</strong><br>
                                                • Paste YouTube URL: <code>https://www.youtube.com/watch?v=VIDEO_ID</code> (auto-converts)<br>
                                                • Paste Vimeo URL: <code>https://vimeo.com/VIDEO_ID</code> (auto-converts)<br>
                                                • Or paste iframe embed code directly<br>
                                                • URL will be automatically converted to embed code
                                            </div>
                                            <div class="invalid-feedback" style="display: block;">
                                                @error('source')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>


                                        <!-- Video Preview -->
                                        <div class="form-group">
                                            <label>Current Video Preview</label>
                                            <div class="video-preview-container">
                                                <div class="embed-responsive embed-responsive-16by9" id="videoPreview">
                                                    @if($data->source)
                                                        {!! $data->source !!}
                                                    @else
                                                        <p class="text-muted text-center py-4">No video source available</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                {{-- <div class="form-group">
                                    <label for="description">Full Description</label>
                                    <textarea id="description" name="description" class="form-control">{!! $data->description !!}</textarea>
                                    <div class="invalid-feedback" style="display: block;">
                                        @error('short_description')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div> --}}

                                {{-- <div class="row">

                                    <div class="col-lg-9">
                                        <div class="form-group">
                                            <label for="tags">Tags (for search result)</label>
                                            <input type="text" name="tags" value="{{$data->tags}}" class="form-control" data-role="tagsinput">
                                            <div class="invalid-feedback" style="display: block;">
                                                @error('tags')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select name="status" class="form-control" id="status" required>
                                                <option value="">Select One</option>
                                                <option value="1" @if ($data->status == 1) selected @endif>Active</option>
                                                <option value="0" @if ($data->status == 0) selected @endif>Inactive</option>
                                            </select>
                                            <div class="invalid-feedback" style="display: block;">
                                                @error('status')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                </div> --}}


                            </div>
                        </div>


                        <div class="form-group text-center pt-3">
                            <a href="{{ route('ViewAllVideoGallery') }}" style="width: 130px;"
                                class="btn btn-danger d-inline-block text-white m-2" type="submit"><i
                                    class="mdi mdi-cancel"></i> Cancel</a>
                            <button class="btn btn-primary m-2" style="width: 130px;" type="submit"><i
                                    class="fas fa-save"></i> Update</button>
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
    <script src="{{ asset('tenant/admin/assets') }}/plugins/select2/select2.min.js"></script>
    <script src="{{ asset('tenant/admin/assets') }}/js/tagsinput.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('[data-toggle="select2"]').select2();

            // Function to convert video URL to embed code
            function convertToEmbedCode(input) {
                var trimmedInput = input.trim();
                
                // If already an iframe or video tag, return as is
                if (trimmedInput.includes('<iframe') || trimmedInput.includes('<video')) {
                    return trimmedInput;
                }
                
                // YouTube formats
                // https://www.youtube.com/watch?v=VIDEO_ID
                // https://youtu.be/VIDEO_ID
                // https://m.youtube.com/watch?v=VIDEO_ID
                var youtubeRegex = /(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/watch\?v=|youtu\.be\/|m\.youtube\.com\/watch\?v=)([a-zA-Z0-9_-]{11})/;
                var youtubeMatch = trimmedInput.match(youtubeRegex);
                
                if (youtubeMatch) {
                    var videoId = youtubeMatch[1];
                    return '<iframe width="100%" height="100%" src="https://www.youtube.com/embed/' + videoId + '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                }
                
                // Vimeo formats
                // https://vimeo.com/VIDEO_ID
                var vimeoRegex = /(?:https?:\/\/)?(?:www\.)?vimeo\.com\/(\d+)/;
                var vimeoMatch = trimmedInput.match(vimeoRegex);
                
                if (vimeoMatch) {
                    var videoId = vimeoMatch[1];
                    return '<iframe width="100%" height="100%" src="https://player.vimeo.com/video/' + videoId + '" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>';
                }
                
                // If no match, return original
                return trimmedInput;
            }

            // Initialize preview with existing content
            var initialSource = $('#source').val().trim();
            if (initialSource) {
                var embedCode = convertToEmbedCode(initialSource);
                var cleanedCode = embedCode.replace(/width="[^"]*"/gi, 'width="100%"')
                                           .replace(/height="[^"]*"/gi, 'height="100%"');
                $('#videoPreview').html(cleanedCode);
            }

            // Real-time video preview with auto-conversion
            $('#source').on('input paste keyup', function() {
                var videoInput = $(this).val().trim();
                var previewContainer = $('#videoPreview');
                
                if (videoInput) {
                    var embedCode = convertToEmbedCode(videoInput);
                    
                    // If conversion happened, update the textarea
                    if (embedCode !== videoInput && !videoInput.includes('<iframe')) {
                        $(this).val(embedCode);
                    }
                    
                    // Clean up the iframe attributes for better display
                    var cleanedCode = embedCode.replace(/width="[^"]*"/gi, 'width="100%"')
                                               .replace(/height="[^"]*"/gi, 'height="100%"');
                    previewContainer.html(cleanedCode);
                } else {
                    previewContainer.html('<p class="text-muted text-center py-4">No video source available</p>');
                }
            });

            // Also trigger on blur for better UX
            $('#source').on('blur', function() {
                $(this).trigger('keyup');
            });

            // Validate and convert on form submit
            $('form').on('submit', function(e) {
                var videoSource = $('#source').val().trim();
                
                if (videoSource) {
                    var embedCode = convertToEmbedCode(videoSource);
                    $('#source').val(embedCode);
                    
                    // Final validation
                    if (!embedCode.includes('iframe') && !embedCode.includes('video')) {
                        e.preventDefault();
                        alert('Please enter a valid video URL or embed code.\n\nSupported formats:\n• YouTube: https://www.youtube.com/watch?v=VIDEO_ID\n• Vimeo: https://vimeo.com/VIDEO_ID\n• Embed code: <iframe>...</iframe>');
                        $('#source').focus();
                        return false;
                    }
                }
            });

            @if ($data->image && file_exists(public_path($data->image)))
                $(".dropify-preview").eq(0).css("display", "block");
                $(".dropify-clear").eq(0).css("display", "block");
                $(".dropify-filename-inner").eq(0).html("{{ $data->image }}");
                $("span.dropify-render").eq(0).html("<img src='{{ url($data->image) }}'>");
            @endif
        });
    </script>
@endsection
