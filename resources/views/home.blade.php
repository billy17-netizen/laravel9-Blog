@extends('main_layout.master')

@section('title','MyBlog | Home')

@section('content')


    <div class="colorlib-blog">
        <div class="container">
            <div class="row">
                <div class="col-md-8 posts-col">


                    @forelse($posts as $post)
                    <div class="block-21 d-flex animate-box post">
                        <a href="{{route('posts.show', $post)}}" class="blog-img" style="background-image: url({{asset('storage/'.$post->image->path)}});"></a>
                        <div class="text">
                            <h3 class="heading"><a href="{{route('posts.show', $post)}}">{{$post->title}}</a></h3>
                            <p class="excerpt">{{$post->excerpt}}</p>
                            <div class="meta">
                                <div><a class="date" href="#"><span class="icon-calendar"></span> {{$post->created_at->diffForHumans()}}</a></div>
                                <div><a class="author" href="#"><span class="icon-user2"></span> {{$post->author->name}}</a></div>
                                <div><a class="comments-count" href="{{route('posts.show', $post)}}"><span class="icon-chat"></span> {{$post->comments_count}}</a></div>
                            </div>
                        </div>
                    </div>
                    @empty
                        <p class="lead">There are no post to show.</p>
                    @endforelse

                    {{$posts->links()}}
                </div>

                <!-- SIDEBAR: start -->
                <div class="col-md-4 animate-box">
                    <div class="sidebar">
                        <div class="side">
                            <h3 class="sidebar-heading">Categories</h3>
                            <div class="block-24">
                                <ul>
                                    @foreach($Categories as $category)
                                        <li><a href="{{route('categories.show', $category)}}">{{$category->name}} <span>{{$category->posts_count}}</span></a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="side">
                            <h3 class="sidebar-heading">Recent Blog</h3>
                            @foreach($recent_posts as $recent_post)
                                <div class="f-blog">
                                    <a href="{{route('posts.show',$recent_post)}}" class="blog-img"style="background-image: url({{asset($recent_post->image ? 'storage/'. $recent_post->image->path : 'storage/placeholder/thumbnail_placeholder.svg'. '')}});">
                                    </a>
                                    <div class="desc">
                                        <p class="admin"><span>{{$recent_post->created_at->diffForHumans()}}</span></p>
                                        <h2><a href="{{route('posts.show',$recent_post)}}">{{Str::limit($recent_post->title,20)}}</a></h2>
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
                                    <li><a href="{{route('tag.show', $tag)}}">{{$tag->name}}</a></li>
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


