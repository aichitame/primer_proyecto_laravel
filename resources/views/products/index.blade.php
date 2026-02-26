<h1>Productos</h1>

@if(session('success'))
<p style="border:1px solid green; padding:10px;">{{ session('success') }}</p>
@endif

<ul>
@foreach ($products as $product)
    <li>
        {{ $product->name }} - {{ $product->price }} (IVA {{ $product->tax_rate }}%) - {{ $product->active ? 'activo' : 'inactivo' }}
        <a href="{{ route('products.edit', $product) }}">Editar</a>

        <form method="POST" action="{{ route('products.destroy', $product) }}" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit">Desactivar</button>
        </form>
    </li>
@endforeach
</ul>

<p><a href="{{ route('products.create') }}">Crear producto</a></p>

<p><a href="{{ route('dashboard') }}">Volver al dashboard</a></p>