@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-{{$articles->count() > 0 ? '6' : '9'}}">
            <div class="card">
                <div class="card-header">Add Article</div>
                <div class="card-body"> 
                    <form id="aricle_form" action="{{ route('article.store') }}" method="POST">
                        {{csrf_field()}}
                        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                            <label for="title">Title:</label>
                            <input type="text" class="form-control" id="title" placeholder="Enter title" name="title" value="{{old('title')}}" >
                            <span class="text-danger">{{ $errors->first('title') }}</span>
                            <input type="hidden" name="id" id="id">
                        </div>
                        <div class="form-group{{$errors->has('body') ? 'has-error' : '' }}">
                            <label for="body">Body:</label>
                            <textarea class="form-control" rows="5" id="body" name="body" value="{{old('body')}}" ></textarea>
                            <span class="text-danger">{{ $errors->first('body') }}</span>
                        </div>
                        <button type="submit" class="btn btn-success">Add</button>
                    </form>              
                </div>
            </div>
        </div>
        @if($articles->count() > 0)
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">List Article</div>
                <div class="card-body">
                  @if(count($articles) > 0)
                        <table class="table small table-bordered">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>author </th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($articles as $article)
                                <tr>
                                    <td>{{$article->title}}</td>
                                    <td>{{$article->user->name}}</td>
                                    <td>{{date('d-m-Y H:i:s', strtotime($article->created_at))}}</td>
                                    <td>
                                        <a class="btn btn-primary edit" data-tr="{{ $article }}">Edit</a>
                                        <a class="btn btn-danger" onclick="$('#deleteForm{{$article->id}}').submit();">Delete</a>
                                        <form id='deleteForm{{$article->id}}' action="{{route('article.destroy', $article->id)}}" method="POST">
                                            {{csrf_field()}}{{method_field("DELETE")}}
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
<script>
$(".edit").click(function(){
    var article = $(this).data('tr');
    $('#id').val(article.id);
    $('#title').val(article.title);
    $('#body').val(article.body);
    $("#demo").collapse('toggle');
});
    
toastr.options = {
  "closeButton": false,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-top-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}
@if(Session::has('success'))
    toastr.success("{{ Session::get('success') }}");
@endif
</script>
@endsection