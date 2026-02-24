<h1>Presupuestos</h1>

<form method="POST" action="{{ route('quotes.store') }}">
@csrf
<button type="submit">Crear presupuesto</button>
</form>

<hr>
<ul>
@foreach($quotes as $quote)
<li>
    <a href="{{ route('quotes.show', $quote) }}">
    Quote #{{ $quote->id }} - {{ $quote->status }} - Total: {{ $quote->total }}
    </a>
</li>
@endforeach
</ul>

<p><a href="{{ route('dashboard') }}">Volver al dashboard</a></p>