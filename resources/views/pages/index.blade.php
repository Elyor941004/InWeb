@extends('layouts.layout')
@section('content')
    <div class="container-fluid">
        <div style="width: 100%" class="d-flex justify-content-end mb-2">
            <a class="btn btn-success" href="{{route('pages.create')}}"><i class="fa fa-plus-circle"></i></a>
        </div>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>Name</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Functions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($pages as $page)
                <tr>
                    <td>{{$page->name}}</td>
                    <td>{{$page->title}}</td>
                    <td>{!! $page->description !!}</td>
                    <td class="d-flex flex-column justify-content-around">
                        <a href="{{route("pages.edit", $page->id)}}" class="btn btn-info mb-1"><i class="fas fa-edit"></i></a>
                        <button type="submit" class="btn btn-danger delete-datas" data-toggle="modal" data-target="#ModalDelete" data-url="{{route('pages.destroy', $page->id)}}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
            {{$pages->links("pagination::bootstrap-4")}}
            </tbody>
        </table>
    </div>
@endsection
