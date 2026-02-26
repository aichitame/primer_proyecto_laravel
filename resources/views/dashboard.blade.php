<h1>Dashboard</h1>

<p>
    <a href="{{ route ('quotes.index') }}">Ir a presupuestos</a>
</p>

<p>
    <a href="{{ route('products.index') }}">Ir a productos</a>
</p>

<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>
