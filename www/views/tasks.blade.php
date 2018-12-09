@extends('layout')
@section('content')
    @include('nav')
    <p>
        <br />
        <a class="btn btn-primary" href="/tasks/create/">+ Новая задача</a>
    </p>
    @if (count($tasks))
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">
                        <a href="/tasks/?s={{ $sort == 'ASC' ? 'd' : 'a' }}">
                            Дата <i class="fas fa-sort-{{ $sort == 'ASC' ? 'up' : 'down' }}"></i>
                        </a>
                    </th>
                    <th scope="col">Заголовок</th>
                    <th scope="col">Тело</th>
                    <th scope="col">Выполнена</th>
                    <th scope="col">Родительская задача</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr @if ($task->done) class="done" @endif>
                        <td>{{$task->id}}</td>
                        <td>{{$task->date}}</td>
                        <td>{{$task->title}}</td>
                        <td>{{$task->body}}</td>
                        <td>{{$task->done ? 'Да' : 'Нет'}}</td>
                        <td>{{$task->parent_id ? '#' . "{$task->parent_id} ({$task->parent()->title})" : ''}}</td>
                        <td>
                            <form method="post" onsubmit="return confirm('Удалить?');" action="/tasks/{{$task->id}}/" class="inline-block">
                                <input type="hidden" name="_method" value="delete" />
                                <a class="btn clear" href="/tasks/{{$task->id}}/edit/" title="Редактировать">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <button type="submit" class="btn clear" title="Удалить">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </form>
                            @if (!$task->done)
                                <form method="post" onsubmit="return confirm('Пометить как выполненную?');" action="/tasks/{{$task->id}}/" class="inline-block">
                                    <input type="hidden" name="_method" value="put" />
                                    <input type="hidden" name="done" value="1" />
                                    <button type="submit" class="btn clear" title="Пометить как выполненную">
                                        <i class="far fa-check-square"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach    
            </tbody>
        </table>
    @endif
@endsection