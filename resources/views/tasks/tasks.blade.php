@if (count($tasks) > 0)
    <ul class="list-unstyled">
        @foreach ($tasks as $task)

                    <div>
                        @if(Auth::id() == $task->user_id)
                        {{-- Task削除ボタンのフォーム --}}
                        {{!! Form::open(['route' => ['tasks.destroy',$task->id],'method' => 'delete']) !!}}
                                {!! Form::submit('削除', ['class' => 'btn btn-danger btn-sm']) !!}
                         {!! Form::close() !!} 
                        @endif
                </div>
                <div>
                        {{-- 投稿内容 --}}
                        <p class="mb-0">{!! nl2br(e($task->content)) !!}</p>
                </div>
            </li>
        @endforeach
    </ul>
    {{-- ページネーションのリンク --}}
    {{ $tasks->links() }}
@endif