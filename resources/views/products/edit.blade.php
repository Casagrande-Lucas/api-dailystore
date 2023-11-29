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
                        @if(session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="post" action="{{ route('products.update', $product->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="name">Nome do Produto:</label>
                                <input type="text" class="form-control" id="name" name="name"
                                       value="{{ $product->name }}" required>
                            </div>

                            <div class="form-group">
                                <label for="value">Valor do Produto:</label>
                                <input type="text" class="form-control" id="value" name="value"
                                       value="{{ $product->value }}" required>
                            </div>

                            <div class="form-group">
                                <label for="amount">Quantidade do Produto:</label>
                                <input type="number" class="form-control @error('amount') is-invalid @enderror"
                                       id="amount" name="amount"
                                       value="{{ $product->amount }}" required>

                                @error('amount')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
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
