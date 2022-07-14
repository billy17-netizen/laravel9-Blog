@extends('main_layout.master')

@section('title','MyBlog | Contact Me')

@section('content')
    <div class="global-message global-message-success d-none"></div>
    <div class="colorlib-contact">
        <div class="container">
            <div class="row row-pb-md">
                <div class="col-md-12 animate-box">
                    <h2>Contact Information</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="contact-info-wrap-flex">
                                <div class="con-info">
                                    <p><span><i class="icon-location-2"></i></span> 198 West 21th Street, <br> Suite 721
                                        New York NY 10016</p>
                                </div>
                                <div class="con-info">
                                    <p><span><i class="icon-phone3"></i></span> <a href="tel://1234567920">+ 1235 2355
                                            98</a></p>
                                </div>
                                <div class="con-info">
                                    <p><span><i class="icon-paperplane"></i></span> <a href="mailto:info@yoursite.com">info@yoursite.com</a>
                                    </p>
                                </div>
                                <div class="con-info">
                                    <p><span><i class="icon-globe"></i></span> <a href="#">yourwebsite.com</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h2>Message Us</h2>
                </div>

                <div class="col-md-6">
                    <form onsubmit="return false" autocomplete="off" method="post">
                        @csrf
                        <div class="row form-group">
                            <div class="col-md-6">
                                <!-- <label for="fname">First Name</label> -->
                                <input type="text" id="fname" name="first_name" value="{{old('first_name')}}"
                                       class="form-control" placeholder="Your firstname" required>
                                <small class='error text-danger first_name'></small>
                            </div>
                            <div class="col-md-6">
                                <!-- <label for="lname">Last Name</label> -->
                                <input type="text" id="lname" name="last_name" value="{{old('last_name')}}"
                                       class="form-control" placeholder="Your lastname" required>
                                <small class='error text-danger last_name'></small>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <!-- <label for="email">Email</label> -->
                                <input type="text" id="email" name="email" value="{{old('email')}}" class="form-control"
                                       placeholder="Your email address" required>
                                <small class='error text-danger email'></small>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <!-- <label for="subject">Subject</label> -->
                                <input type="text" id="subject" name="subject" value="{{old('subject')}}"
                                       class="form-control" placeholder="Your subject of this message">
                                <small class='error text-danger subject'></small>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <!-- <label for="message">Message</label> -->
                                <textarea name="message" id="message" value="{{old('message')}}" cols="30" rows="10"
                                          class="form-control" placeholder="Say something about us" required></textarea>
                                <small class='error text-danger message'></small>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Send Message" class="btn btn-primary send-message-btn">
                        </div>
                    </form>

                    @if(session('success'))
                        <div class="global-message global-message-success">
                            {{ session('success') }}
                        </div>
                    @elseif(session('error'))
                        <div class="global-message global-message-error">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <div id="map" class="colorlib-map"></div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('custom_js')
    <script>
        // $('.send-message-btn').click(function (e) {
        //     e.preventDefault();
        //     const form = $(this).closest('form');
        //     const formData = form.serialize();
        //
        //     $.ajax({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         url: form.attr('action'),
        //         type: 'POST',
        //         data: formData,
        //         success: function (data) {
        //             // console.log(data.message);
        //             if (data.success) {
        //                 $('.global-message').removeClass('d-none');
        //                 $('.global-message').html(data.message);
        //                 $('.global-message').addClass('alert-info');
        //                 setTimeout(function () {
        //                     $('.global-message').hide()
        //                 }, 3000)
        //                 form.trigger('reset');
        //             } else {
        //                 for (const error in data.form) {
        //                     $("small." + error).text(data.errors[error]);
        //                 }
        //             }
        //         }
        //     });
        // });
        $(document).on("click", '.send-message-btn', (e) => {
            e.preventDefault();
            let $this = e.target;

            let csrf_token = $($this).parents("form").find("input[name='_token']").val()
            let first_name = $($this).parents("form").find("input[name='first_name']").val()
            let last_name = $($this).parents("form").find("input[name='last_name']").val()
            let email = $($this).parents("form").find("input[name='email']").val()
            let subject = $($this).parents("form").find("input[name='subject']").val()
            let message = $($this).parents("form").find("textarea[name='message']").val()
            let formData = new FormData();
            formData.append('_token', csrf_token);
            formData.append('first_name', first_name);
            formData.append('last_name', last_name);
            formData.append('email', email);
            formData.append('subject', subject);
            formData.append('message', message);
            $.ajax({
                url: "{{ route('contact.store') }}",
                data: formData,
                type: 'POST',
                dataType: 'JSON',
                processData:false,
                contentType: false,
                success: function(data){

                    if(data.success)
                    {
                        $(".global-message").addClass('alert , alert-info')
                        $(".global-message").fadeIn()
                        $(".global-message").text(data.message)
                        clearData($($this).parents("form"), ['first_name', 'last_name', 'email', 'subject', 'message']);
                        setTimeout(() => {
                            $(".global-message").fadeOut()
                        }, 5000);
                    }
                    else
                    {
                        for (const error in data.errors)
                        {
                            $("small."+error).text(data.errors[error]);
                        }
                    }
                }
            })
        })

    </script>
@endsection
