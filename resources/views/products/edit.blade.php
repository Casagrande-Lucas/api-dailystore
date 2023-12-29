@extends('layouts.navbar')

@section('content-head')
@endsection

@section('content-body')
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Editar Produto</div>

                    <div class="card-body">
                        @error('success')
                        <div class="alert alert-success" role="alert">
                            {{ $message }}
                        </div>
                        @enderror

                        @error('error')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror

                        <form method="post" action="{{ route('products.update', $product->id) }}">
                            @csrf
                            @method('PUT')

                            @can('products_crud_admin')
                            <div class="form-group">
                                <label for="name">Nome do Produto:</label>
                                <input type="text" class="form-control" id="name" name="name"
                                       value="{{ $product->name }}" required>
                            </div>
                            @else
                                <div class="form-group">
                                    <label for="name">Nome do Produto:</label>
                                    <input type="text" class="form-control" id="name" disabled
                                           value="{{ $product->name }}">
                                </div>
                            @endcan

                            @can('products_crud_admin')
                                <div class="form-group">
                                    <label for="size">Tamanho do Produto:</label>
                                    <input type="text" class="form-control" id="size" name="size"
                                           value="{{ $product->size }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="color">Cor do Produto:</label>
                                    <input type="text" class="form-control" id="color" name="color"
                                           value="{{ $product->color }}" required>
                                </div>


                                <div class="form-group">
                                    <label for="value">Valor do Produto:</label>
                                    <input type="text" class="form-control" id="value" name="value"
                                           value="{{ number_format($product->value, 2, ',', '.')  }}" required>
                                </div>
                            @endcan

                            <div class="form-group">
                                <label for="amount">Quantidade do Produto:</label>
                                <input type="number" class="form-control"
                                       id="amount" name="amount"
                                       value="{{ $product->amount }}" required>
                            </div>

                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-success">Atualizar</button>
                                <a href="{{ route('products.index') }}" class="btn btn-secondary">Voltar</a>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
