@extends('layouts.navbar')

@section('content-head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content-body')

    <div class="border rounded m-3 p-3">
        <div class="row">
            @can('products_crud_admin')
                <div class="col-1">
                    <a class="btn btn-success" href="{{ route('products.create') }}">Criar Produto</a>
                </div>
            @endcan

            <div class="col-3">
                <input type="text" class="form-control col-3" id="searchInput" placeholder="Pesquisar por Nome, Tamanho e Cor...">
            </div>
        </div>

        <div class="table-responsive">
            <table class="table" id="productTable">
                <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Tamanho</th>
                    <th scope="col">Cor</th>
                    @can('products_crud_admin')
                        <th scope="col">Valor</th>
                    @endcan
                    <th scope="col">Qtd</th>
                    @can('products_crud_admin')
                        <th scope="col">Total</th>
                    @endcan
                    <th scope="col">Ações</th>
                </tr>
                </thead>
                <tbody>
                @forelse($products->items() as $product)
                    <tr id="productRow_{{ $product->id }}">
                        <td id="name-column">{{ $product->name }}</td>
                        <td id="value-column">{{ $product->size }}</td>
                        <td id="value-column">{{ $product->color }}</td>
                        @can('products_crud_admin')
                            <td id="value-column">R$ {{ number_format($product->value, 2, ',', '.') }}</td>
                        @endcan
                        <td id="amount-column">{{ $product->amount }}</td>
                        @can('products_crud_admin')
                            <td id="total-column">
                                R$ {{ number_format(($product->amount * $product->value), 2, ',', '.') }}</td>
                        @endcan
                        <td>
                            <a id="btn-add-item" class="btn btn-success"
                               onclick="fastSetAmountButton('{{ $product->id }}', true)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-plus" viewBox="0 0 16 16">
                                    <path
                                        d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                                </svg>
                            </a>
                            <a id="btn-rm-item" class="btn btn-danger @if($product->amount <= 0) disabled @endif"
                               onclick="fastSetAmountButton('{{ $product->id }}', false)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-dash" viewBox="0 0 16 16">
                                    <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8"/>
                                </svg>
                            </a>
                            <a class="btn btn-primary" href="{{ route('products.edit', [$product->id]) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path
                                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd"
                                          d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                </svg>
                            </a>
                            @can('products_crud_admin')
                                <a class="btn btn-danger" onclick="inactiveProduct('{{ $product->id }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                         class="bi bi-trash3" viewBox="0 0 16 16">
                                        <path
                                            d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                                    </svg>
                                </a>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Sem Produtos Registrados</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        {{ $products->onEachSide(5)->links('vendor.pagination.bootstrap-5') }}
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>

        $(document).ready(function () {
            // Adicione um manipulador de evento para a barra de pesquisa
            $('#searchInput').on('input', function () {
                filterTable($(this).val().toLowerCase());
            });

            function filterTable(searchTerm) {
                $('#productTable tbody tr').each(function () {
                    var name = $(this).find('#name-column').text().toLowerCase();
                    var size = $(this).find('#value-column').text().toLowerCase();
                    var color = $(this).find('#value-column').text().toLowerCase();

                    // Oculte a linha se não atender aos critérios de pesquisa
                    if (name.indexOf(searchTerm) === -1 && size.indexOf(searchTerm) === -1 && color.indexOf(searchTerm) === -1) {
                        $(this).hide();
                    } else {
                        $(this).show();
                    }
                });
            }
        });

        function fastSetAmountButton(productId, isIncrement) {
            let token = document.head.querySelector('meta[name="csrf-token"]').content;

            $.ajax({
                type: 'POST',
                url: '{{ route('products.fast_set_amount') }}',
                data: {
                    _token: token,
                    isIncrement: isIncrement,
                    productId: productId
                },
                success: function (response) {
                    let productRow = $('#productRow_' + productId);
                    productRow.find('#amount-column').text(response.amount);
                    productRow.find('#total-column').text('R$ ' + response.total);

                    if (response.amount > 0) {
                        productRow.find('#btn-rm-item').removeClass('disabled');
                    } else {
                        productRow.find('#btn-rm-item').addClass('disabled');
                    }
                },
                error: function () {
                    alert('Erro: Não foi possível alterar a quantidade do Produto.')
                }
            });
        }

        function inactiveProduct(productId) {
            let token = document.head.querySelector('meta[name="csrf-token"]').content;

            $.ajax({
                type: 'POST',
                method: 'DELETE',
                url: '/products/' + productId,
                data: {
                    _token: token,
                    id: productId
                },
                success: function (response) {
                    if (response.reload) {
                        window.location.reload();
                    }
                },
                error: function () {
                    alert('Erro: Não foi possível desativar o Produto.')
                }
            });
        }
    </script>

@endsection
