<section id="component-footer">
<footer class="footer bg-light">
    <div
    class="container-fluid d-flex flex-md-row flex-column justify-content-between align-items-md-center gap-1 container-p-x py-3"
    >
    <div>
        <a
        href="{{ route('dashboard.index') }}"
        class="footer-text fw-bolder"
        >Vetly</a>
    </div>
    <form action="{{ route('dashboard.logout') }}" method="POST" style="display:inline;">
    @csrf
        <button type="submit" class="btn btn-sm btn-outline-danger">
            <i class="bx bx-log-out-circle"></i> Logout
        </button>
    </form>
    </div>
</footer>
</section>