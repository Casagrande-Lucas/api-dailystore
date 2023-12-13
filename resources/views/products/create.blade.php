@extends('layouts.navbar')

@section('content-head')
@endsection

@section('content-body')
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Criar Produto</div>

                    <div class="card-body">
                        @error('success')
                        <div class="alert alert-success" role="alert">
                            {{ $message }}
                        </div>
                        @enderror

                        @error('error')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                        @enderror

                        <form method="post" action="{{ route('products.store') }}">
                            @csrf

                            <div class="form-group">
                                <label for="name">Nome:</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>

                            <div class="form-group">
                                <label for="size">Tamanho:</label>
                                <input type="text" class="form-control" id="size" name="size" required>
                            </div>

                            <div class="form-group">
                                <label for="color">Cor:</label>
                                <input type="text" class="form-control" id="color" name="color" required>
                            </div>

                            <div class="form-group">
                                <label for="value">Valor:</label>
                                <input type="text" class="form-control" id="value" name="value" required>
                            </div>

                            <div class="form-group">
                                <label for="amount">Quantidade:</label>
                                <input type="number" class="form-control"
                                       id="amount" name="amount" required>
                            </div>

                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-success">Criar</button>
                                <a href="{{ route('products.index') }}" class="btn btn-secondary">Voltar</a>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
