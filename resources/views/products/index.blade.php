@extends('layouts.layout')
@section('content')
    <div class="container-fluid">
        <div style="width: 100%" class="d-flex justify-content-end mb-2">
            <a class="btn btn-success" href="{{route('products.create')}}"><i class="fa fa-plus-circle"></i></a>
        </div>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Functions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{$product->name}}</td>
                    <td>
                        <img src="{{asset("storage/products/$product->image")}}" alt="" height="144px"></td>
                    <td>{{$product->title}}</td>
                    <td>{!! $product->description !!}</td>
                    <td class="d-flex flex-column justify-content-around">
                        <a href="{{route("products.edit", $product->id)}}" class="btn btn-info mb-1"><i class="fas fa-edit"></i></a>
                        <button type="submit" class="btn btn-danger delete-datas" data-toggle="modal" data-target="#ModalDelete" data-url="{{route('products.destroy', $product->id)}}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
