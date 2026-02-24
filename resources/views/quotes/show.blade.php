<h1>Presupuesto #{{ $quote->id }}</h1>

<p>Estado: {{ $quote->status }}</p>

<p>
    Subtotal: {{ $quote->subtotal }} <br>
    Descuento: {{ $quote->discount_total }} <br>
    IVA: {{ $quote->tax_total }} <br>
    Total: {{ $quote->total }}
</p>

<hr>

<h2>Líneas</h2>

@if($quote->lines->isEmpty())
<p>No hay líneas todavía.</p>
@else
<table border="1" cellpadding="6">
<thead>
    <tr>
            <th>Producto</th>
            <th>Qty</th>
            <th>Unit</th>
            <th>Desc %</th>
            <th>IVA %</th>
            <th>Total línea</th>
            <th>Acciones</th>
    </tr>
</thead>
<tbody>
@foreach($quote->lines as $line)
<tr>
    <td>{{ $line->product?->name }}</td>
    <td>
        <form method="POST" action="{{ route('quotes.lines.update', [$quote, $line]) }}">
        @csrf
        @method('PATCH')
        <input type="number" name="qty" min="1" value="{{ $line->qty }}" style="width: 70px;">
        <input type="number" name="discount_rate" min="0" step="0.01" value="{{ $line->discount_rate }}" style="width:90px;">
        <button type="submit">Actualizar</button>
        </form>
    </td>
    <td>{{ $line->unit_price }}</td>
    <td>{{ $line->discount_rate }}</td>
    <td>{{ $line->tax_rate }}</td>
    <td>{{ $line->total }}</td>
    <td>
        <form method="POST" action="{{ route('quotes.lines.destroy', [$quote, $line]) }}">
        @csrf
        @method('DELETE')
        <button type="submit">Borrar</button>
        </form>
    </td>
</tr>
@endforeach
</tbody>
</table>
@endif

<hr>

@if($errors->any())
<div style="border:1px sold red; padding:10px; margin:10px 0;">
    <strong>Errores:</strong>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if ($errors->any())
<div style="border:1px solid red; padding:10px; margin:10px 0;">
<strong>Errores:</strong>
<ul>
    @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
</ul>
</div>
@endif

<h2>Añadir línea</h2>

<form method="POST" action="{{ route('quotes.lines.store', $quote) }}">
    @csrf
    <label>Producto ID:</label>
    <input type="number" name="product_id" required>

    <label>Qty:</label>
    <input type="number" name="qty" min="1" value="1" required>

    <label>Desc %:</label>
    <input type="number" name="discount_rate" min="0" step="0.01">

    <button type="submit">Añadir</button>
</form>

<p><a href="{{ route('quotes.index') }}">Volver a presupuestos</a></p>