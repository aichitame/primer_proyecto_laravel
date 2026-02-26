<h1>Crear producto</h1>

@if($errors->any())
<div style="border:1px solid red; padding:10px; margin:10px 0;">
    <strong>Errores:</strong>
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('products.store') }}">
@csrf

<p>
    <label>Nombre</label><br>
        <input type="text" name="name" value="{{ old('name') }}" required>
</p>

<p>
    <label>Precio</label><br>
        <input type="number" name="price" step="0.01" min="0" value="{{ old('price') }}" required>
</p>

<p>
    <label>IVA %</label><br>
        <input type="number" name="tax_rate" step="0.01" min="0" value="{{ old('tax_rate', 21)}}" required>
</p>

<p>
    <label>
        <input type="checkbox" name="active" value="1" {{ old('active', 1) ? 'checked' : '' }}>Activo
    </label>
</p>

<button type="submit">Guardar</button>
</form>

<p><a href="{{ route('products.index') }}">Volver</a></p>