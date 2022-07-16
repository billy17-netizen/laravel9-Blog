@extends("admin_dashboard.layouts.app")

@section("style")
    <link href="{{asset('admin_dashboard_assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('admin_dashboard_assets/plugins/select2/css/select2-bootstrap4.css')}}" rel="stylesheet"/>
@endsection

@section("wrapper")
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Comments</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.index')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Comments</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="card">
                <div class="card-body p-4">
                    <h5 class="card-title">Add New Comment</h5>
                    <hr/>
                    <form action="{{route('admin.comments.update',$comment)}}" method="post" >
                        @csrf
                        @method('PUT')
                        <div class="form-body mt-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="border border-3 p-4 rounded">
                                        <div class="mb-3">
                                            <label for="inputProductDescription" class="form-label">Related Post</label>
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class=" rounded">
                                                        <div class="mb-3">
                                                            <select  name="post_id" required class="single-select">
                                                                @foreach($posts as $key => $post)
                                                                    <option {{$comment->post_id === $key ? 'selected' : ''}} value="{{$key}}">{{$post}}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('post_id')
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="inputProductDescription" class="form-label">Post
                                                    Comment</label>
                                                <textarea class="form-control" id="posts_comment"
                                                          rows="3" name="the_comment">{{old('the_comment', $comment->the_comment)}}</textarea>
                                                @error('the_comment')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>

                                            <button type="submit" class="btn btn-primary">Update Comment</button>
                                            <a class="btn btn-danger" onClick="event.preventDefault(); document.getElementById('comment_delete_form_{{$comment->id}}').submit()" href="#">Delete Comment</a>
                                        </div>
                                    </div>
                                </div>
                                <!--end row-->
                            </div>
                        </div>
                    </form>
                    <form id="comment_delete_form_{{$comment->id}}" action="{{route('admin.comments.destroy',$comment)}}" method="post">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end page wrapper -->
@endsection

@section("script")
    <script src="{{asset('admin_dashboard_assets/plugins/select2/js/select2.min.js')}}"></script>

    <script>
        $('.single-select').select2({
            theme: 'bootstrap4',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: Boolean($(this).data('allow-clear')),
        });

        setTimeout(function(){
            $('.general-message').fadeOut();
        },5000);

    </script>
@endsection
