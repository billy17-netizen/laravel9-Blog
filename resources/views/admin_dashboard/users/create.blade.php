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
                <div class="breadcrumb-title pe-3">Users</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.index')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Users</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="card">
                <div class="card-body p-4">
                    <h5 class="card-title">Add New User</h5>
                    <hr/>
                    <form action="{{route('admin.users.store')}}" method="post" enctype="multipart/form-data" >
                        @csrf
                        <div class="form-body mt-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="border border-3 p-4 rounded">
                                        <div class="mb-3">
                                            <label for="input_name" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="input_name" name="name" value="{{old('name')}}">
                                            @error('name')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="input_email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="input_email" name="email" value="{{old('email')}}">
                                            @error('email')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="input_password" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="input_password" name="password">
                                            @error('password')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="input_image" class="form-label">Image</label>
                                            <input type="file" class="form-control" id="input_image" name="image">
                                            @error('image')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="inputProductDescription" class="form-label">User Role</label>
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class=" rounded">
                                                        <div class="mb-3">
                                                            <select  name="role_id" required class="single-select">
                                                                @foreach($roles as $key => $role)
                                                                    <option value="{{$key}}">{{$role}}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('role_id')
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="submit" class="btn btn-primary">Add User</button>

                                        </div>
                                    </div>
                                </div>
                                <!--end row-->
                            </div>
                        </div>
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
