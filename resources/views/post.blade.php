@extends('main_layout.master')

@section('title','MyBlog | This is Single Post')

@section('content')
    <div class="colorlib-classes">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="row row-pb-lg">
                        <div class="col-md-12 animate-box">
                            <div class="classes class-single">
                                <div class="classes-img" style="background-image: url(blog_template/images/classes-1.jpg);">
                                </div>
                                <div class="desc desc2">
                                    <h3><a href="#">Developing Mobile Apps</a></h3>
                                    <p>When she reached the first hills of the Italic Mountains, she had a last view back on the skyline of her hometown Bookmarksgrove, the headline of Alphabet Village and the subline of her own road, the Line Lane. Pityful a rethoric question ran over her cheek, then she continued her way.</p>
                                    <p>The Big Oxmox advised her not to do so, because there were thousands of bad Commas, wild Question Marks and devious Semikoli, but the Little Blind Text didn’t listen. She packed her seven versalia, put her initial into the belt and made herself on the way.</p>
                                    <blockquote>
                                        The Big Oxmox advised her not to do so, because there were thousands of bad Commas, wild Question Marks and devious Semikoli, but the Little Blind Text didn’t listen. She packed her seven versalia, put her initial into the belt and made herself on the way.
                                    </blockquote>
                                    <h3>Some Features</h3>
                                    <p>The Big Oxmox advised her not to do so, because there were thousands of bad Commas, wild Question Marks and devious Semikoli, but the Little Blind Text didn’t listen. She packed her seven versalia, put her initial into the belt and made herself on the way.</p>

                                    <p>On her way she met a copy. The copy warned the Little Blind Text, that where it came from it would have been rewritten a thousand times and everything that was left from its origin would be the word "and" and the Little Blind Text should turn around and return to its own, safe country. But nothing the copy said could convince her and so it didn’t take long until a few insidious Copy Writers ambushed her, made her drunk with Longe and Parole and dragged her into their agency, where they abused her for their.</p>
                                    <p><a href="#" class="btn btn-primary btn-outline btn-lg">Live Preview</a> or <a href="#" class="btn btn-primary btn-lg">Download File</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row row-pb-lg animate-box">
                        <div class="col-md-12">
                            <h2 class="colorlib-heading-2">{{count($post->comments)}}Comment</h2>
                            @foreach($post->comments as $comment)
                            <div id="comment_{{$comment->id}}" class="review">
                                <div class="user-img" style="background-image: url({{$comment->user->image ? asset('storage/'.$comment->user->image->path. ''): asset('storage/usernotImage/placeholder_user.png')}});"></div>
                                <div class="desc">
                                    <h4>
                                        <span class="text-left">{{$comment->user->name}}</span>
                                        <span class="text-right">{{$comment->created_at->diffForHumans()}}</span>
                                    </h4>
                                    <p>{{$comment->the_comment}}</p>
                                    <p class="star">
                                        <span class="text-left"><a href="#" class="reply"><i class="icon-reply"></i></a></span>
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="row animate-box">
                        <div class="col-md-12">

                            @if(session()->has('success'))
                                <div class="alert alert-success">
                                    {{session('success')}}
                                </div>
                            @endif
                            @if(session()->has('error'))
                                <div class="alert alert-danger">
                                    {{session('error')}}
                                </div>
                            @endif
                                    <h2 class="colorlib-heading-2">Say something</h2>


                            <form method="post" action="{{route('posts.add-comment',$post)}}">
                                @csrf
                                <div class="row form-group">
                                    <div class="col-md-12">
                                        <!-- <label for="message">Message</label> -->
                                        <textarea name="the_comment" id="message" cols="30" rows="10" class="form-control" placeholder="Say something about us"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="Post Comment" class="btn btn-primary">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- SIDEBAR: start -->
                <div class="col-md-4 animate-box">
                    <div class="sidebar">
                        <div class="side">
                            <h3 class="sidebar-heading">Categories</h3>
                            <div class="block-24">
                                <ul>
                                    @foreach($Categories as $category)
                                        <li><a href="#">{{$category->name}} <span>{{$category->posts_count}}</span></a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="side">
                            <h3 class="sidebar-heading">Recent Blog</h3>
                            @foreach($recent_posts as $recent_post)
                                <div class="f-blog">
                                    <a href="{{route('posts.show',$recent_post)}}" class="blog-img"style="background-image: url({{asset('storage/'.$recent_post->image->path)}});">
                                    </a>
                                    <div class="desc">
                                        <p class="admin"><span{{$recent_post->created_at->diffForHumans()}}</span></p>
                                        <h2><a href="blog.html">{{Str::limit($recent_post->title,20)}}</a></h2>
                                        <p>{{$recent_post->excerpt}}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="side">
                            <h3 class="sidbar-heading">Tags</h3>
                            <div class="block-26">
                                <ul>
                                    @foreach($tags as $tag)
                                        <li><a href="#">{{$tag->name}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
