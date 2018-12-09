<!-- @delete -->

@if($errors)
    <p class="alert alert-danger">
        @foreach($errors as $e)
            {{$e}}<br />
        @endforeach
    </p>
@endif

<label for="">Дата</label>
<input type="text" class="form-control" name="date" placeholder="Дата" value="{{ $task->date ?? date('Y-m-d H:i:s')}}"   />
<br />

<label for="">Заголовок</label>
<input type="text" class="form-control" name="title" placeholder="Заголовок" value="{{ $task->title ?? $_POST['title']}}"  />
<br />

<label for="">Тело</label>
<textarea class="form-control" name="body" placeholder="Тело" rows="5" >{{$task->body ?? $_POST['body']}}</textarea>
<br />

<label for="">Выполнена</label>
<select class="form-control" name="done">
    <option value="0" @if (isset($task->id) && !$task->done) selected @endif>Нет</option>
    <option value="1" @if (isset($task->id) && $task->done) selected @endif>Да</option>
</select>
<br />

<label for="">Родительская задача</label>
<select class="form-control" name="parent_id">
    <option value="0">-- без родительской задачи --</option>
    @include('partials.tasks', ['tasks' => $tasks])
</select>

<hr />

<input class="btn btn-success" type="submit" value="Сохранить" />