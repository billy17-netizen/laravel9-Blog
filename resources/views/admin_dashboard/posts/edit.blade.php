@extends("admin_dashboard.layouts.app")

@section("style")
    <link href="{{asset('admin_dashboard_assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('admin_dashboard_assets/plugins/select2/css/select2-bootstrap4.css')}}" rel="stylesheet"/>
    <link href="{{asset('admin_dashboard_assets/plugins/input-tags/css/tagsinput.css')}}" rel="stylesheet" />

    <script src="https://cdn.tiny.cloud/1/aupasg6zdvahhi9lmu92jxp6s8memctg1cwq6ok71og3qrlt/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
@endsection

@section("wrapper")
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Posts</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.index')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Posts</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="card">
                <div class="card-body p-4">
                    <h5 class="card-title">Edit Posts : {{$post->title}}</h5>
                    <hr/>
                    <form action="{{route('admin.posts.update',$post)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")
                        <div class="form-body mt-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="border border-3 p-4 rounded">
                                        <div class="mb-3">
                                            <label for="inputProductTitle" class="form-label">Post Title</label>
                                            <input type="text" value="{{old('title',$post->title)}}" name="title" required class="form-control" id="inputProductTitle"
                                                   placeholder="Enter Post title">
                                            @error('title')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror

                                        </div>
                                        <div class="mb-3">
                                            <label for="inputProductTitle" class="form-label">Post Slug</label>
                                            <input type="text" name="slug" required class="form-control" id="inputProductTitle"
                                                   placeholder="Enter Post Slug"  value="{{old('slug',$post->slug)}}">
                                            @error('slug')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="inputProductDescription" class="form-label">Post
                                                Excerpt</label>
                                            <textarea class="form-control" required name="excerpt"  id="inputProductDescription"
                                                      rows="3">{{old('excerpt',$post->excerpt)}}</textarea>
                                            @error('excerpt')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="inputProductDescription" class="form-label">Post
                                                Category</label>
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class=" rounded">
                                                        <div class="mb-3">
                                                            <select  name="category_id" required class="single-select">
                                                                @foreach($categories as $key => $category)
                                                                    <option {{$post->category_id === $key ? 'selected' : ''}} value="{{$key}}">{{$category}}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('category_id')
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <label class="form-label">Post Tags</label>
                                                <input type="text" value="{{$tags}}" class="form-control" name="tags" data-role="tagsinput">
                                            </div>
                                            <div class="mb-3">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <label for="inputProductDescription"   class="form-label">Post Thumbnail</label>
                                                                <input id="thumbnail"  name="thumbnail"  type="file">
                                                                @error('thumbnail')
                                                                <span class="text-danger">{{$message}}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 text-center">
                                                        <img style="width: 100%" src="/storage/{{$post->image ? $post->image->path : 'placeholder/thumbnail_placeholder.svg'}}" class="img-responsive" alt="Post Thumbnail">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="inputProductDescription" class="form-label">Post
                                                    Content</label>
                                                <textarea class="form-control" id="posts_content"
                                                          rows="3" name="body">{{old('body', str_replace('../../','../../../',$post->body))}}"</textarea>
                                                @error('body')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <div class="form-check form-switch">
                                                    <input {{$post->approved ? 'checked' : ''}} name="approved" class="form-check-input" type="checkbox" id="flexSwitchCheckChecked">
                                                    <label class="form-check-label {{$post->approved ? 'text-success' : 'text-warning'}}" for="flexSwitchCheckChecked">{{$post->approved ? 'Approved' : 'Not Approved'}}</label>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Update Post</button>
                                            <a href="#" class="btn btn-danger" onclick="event.preventDefault(); document.getElementById('delete_post_{{$post->id}}').submit()">Delete Post</a>
                                        </div>
                                    </div>
                                </div>
                                <!--end row-->
                            </div>
                        </div>
                    </form>
                    <form method="post" id="delete_post_{{$post->id}}" action="{{route('admin.posts.destroy',$post)}}">
                        @csrf
                        @method("DELETE")
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end page wrapper -->
@endsection

@section("script")
    <script src="{{asset('admin_dashboard_assets/plugins/select2/js/select2.min.js')}}"></script>
    <script src="{{asset('admin_dashboard_assets/plugins/input-tags/js/tagsinput.js')}}"></script>

    <script>
        $('.single-select').select2({
            theme: 'bootstrap4',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: Boolean($(this).data('allow-clear')),
        });
        $('.multiple-select').select2({
            theme: 'bootstrap4',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: Boolean($(this).data('allow-clear')),
        });

        tinymce.init({
            selector: '#posts_content',
            plugins: 'advlist autolink link image lists charmap print preview hr anchor pagebreak ',
            toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | link image | tinycomments | casechange permanentpen | bullist numlist outdent indent | ',
            toolbar_mode: 'floating',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
            height: 500,

            image_title: true,
            automatic_uploads: true,

            images_upload_handler : function (blobInfo, success, failure) {
                let formData = new FormData();
                let _token = $('input[name="_token"]').val();

                let xhr = new XMLHttpRequest();
                xhr.open('POST', '{{route('admin.upload_tinymce_image')}}');
                xhr.onload = () => {
                    if (xhr.status !== 200) {
                        failure('HTTP Error: ' + xhr.status);
                        return
                    }
                    let json = JSON.parse(xhr.responseText);
                    if (!json || typeof json.location !== 'string') {
                        failure('Invalid Json: ' + xhr.responseText);
                        return;
                    }
                    success(json.location);
                }
                formData.append('_token', _token);
                formData.append('file', blobInfo.blob(), blobInfo.filename());
                xhr.send(formData);
            },
        });

        setTimeout(function(){
            $('.general-message').fadeOut();
        },5000);

    </script>
@endsection
