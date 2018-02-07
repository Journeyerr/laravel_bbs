<div class="reply-list">
    @foreach ($replies as $index => $reply)
        <div class=" media"  name="reply{{ $reply->id }}" id="reply{{ $reply->id }}">
            <div class="avatar pull-left">
                <a href="{{ route('users.show', [$reply->user_id]) }}">
                    <img class="media-object img-thumbnail" alt="{{ $reply->user->name }}" src="{{ $reply->user->avatar }}"  style="width:48px;height:48px;"/>
                </a>
            </div>

            <div class="infos">
                <div class="media-heading">
                    @if($reply->user_id == $topic->user_id)
                        <span style="color: red">楼主:</span>
                    @endif
                    <a href="{{ route('users.show', [$reply->user_id]) }}" title="{{ $reply->user->name }}">
                        {{ $reply->user->name }}
                    </a>
                    <span> •  </span>
                    <span class="meta" title="{{ $reply->created_at }}">{{ $reply->created_at->diffForHumans() }}</span>

                    @if( Auth::id() == $topic->user_id || $reply->user_id == Auth::id())
                        {{-- 回复删除按钮 --}}
                        <span class="meta pull-right">
                            <form action="{{ route('replies.destroy',$reply->id) }}" method="post">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-default btn-xs pull-left">
                                    <i class="glyphicon glyphicon-trash"></i>
                                </button>
                            </form>
                        </span>
                    @endif
                </div>
                <div class="reply-content">
                    {!! $reply->content !!}
                </div>
            </div>
        </div>
        <hr>
    @endforeach
</div>